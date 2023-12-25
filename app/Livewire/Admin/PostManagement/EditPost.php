<?php

namespace App\Livewire\Admin\PostManagement;

use App\Models\Category;
use App\Models\Place;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\Review;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;

class EditPost extends Component
{
    use WithFileUploads;

    public Post $post;
    public $title, $desc, $content, $tags, $category_id, $is_active;
    public $newImages, $deletedImages;
    public $placeIds = [];
    public $fileId;

    public function mount()
    {
        $this->fill(
            $this->post->only('title', 'desc', 'content', 'category_id', 'tags', 'is_active'),
        );

        $this->placeIds = $this->post->places->pluck('id');
    }

    #[Layout('admin.managements')]
    #[Title('Cập nhật bài viết')]
    public function render()
    {
        return view('livewire.admin.post-management.edit-post');
    }

    #[Computed]
    public function places()
    {
        return Place::where('category_id', $this->category_id)->where('is_active', true)->get(['name', 'id']);
    }

    #[Computed]
    public function categories()
    {
        return Category::where('is_active', true)->get(['id', 'name']);
    }

    #[Computed]
    public function oldImages()
    {
        return PostImage::where('post_id', $this->post->id)->get();
    }

    protected function rules(): array
    {
        return [
            'title' => ['required', 'max:100', Rule::unique('posts')->ignore($this->post->id)]
        ];
    }

    protected function messages(): array
    {
        return [
            'title.required' => 'Bạn cần nhập tiêu đề.',
            'title.max' => 'Tiêu đề quá dài, tối đa chỉ 100 ký tự.',
            'title.unique' => 'Tiêu đề bài viết này đã tồn tại'
        ];
    }

    public function updatedTitle()
    {
        $this->validate();
    }

    public function updatedImages()
    {
        $validator = Validator::make(
            ['newImages' => $this->newImages],
            ['newImages.*' => 'image|mimes:jpg,jpeg,png|max:1024'],
            [
                'newImages.*.image' => 'File được chọn phải là ảnh .jpg, .jpeg hoặc .png.',
                'newImages.*.mimes' => 'Ảnh được chọn phải có đuôi là .jpg, .jpeg hoặc .png.',
                'newImages.*.max' => 'Kích thước ảnh phải nhỏ hơn 1 MB'
            ]
        );

        if ($validator->fails()) {
            $this->reset('newImages');
            $this->fileId++;
        }

        $validator->validate();
    }

    #[On('get-tags')]
    public function setTag($tags)
    {
        $this->tags = $tags;
    }

    public function removeOldImage($key)
    {
        $this->deletedImages[] = $this->oldImages[$key];
        $this->oldImages->pull($key);
    }

    public function removeNewImage($key)
    {
        array_splice($this->newImages, $key, 1);
        $this->newImages ?: $this->fileId++;
    }

    public function restoreOldImages()
    {
        $this->oldImages->push(last($this->deletedImages));
    }

    public function updatedCategoryId($value)
    {
        $places = Category::find($value)->is_place ? Place::where('category_id', $value)->where('is_active', true)->pluck('name', 'id') : null;
        $this->dispatch('set-places', places: $places);
    }

    #[On('get-places')]
    public function setPlace($places)
    {
        $this->placeIds = $places;
    }

    public function clear()
    {
        $this->clearValidation();
        $this->reset('deletedImages', 'newImages');
        $this->mount();
        $this->fileId++;
        $this->dispatch('clear-content');
        $this->dispatch('clear-tags', tags: $this->tags);
        $this->updatedCategoryId($this->category_id);
        $this->dispatch('clear-places', places: $this->placeIds);
    }

    public function update()
    {
        $this->authorize('update', $this->post);

        $this->validate();

        $this->updatePost();

        $this->reset('deletedImages', 'newImages');

        $this->dispatch('alert-success', message: 'Cập nhật bài viết mới thành công.');
    }

    private function updatePost()
    {
        if (is_array($this->newImages)) {
            foreach ($this->newImages as $image) {
                PostImage::create([
                    'name' => basename($image->store('posts', 'images')),
                    'post_id' => $this->post->id
                ]);
            }
        } elseif (is_array($this->deletedImages)) {
            foreach ($this->deletedImages as $image) {
                Storage::disk('images')->delete('posts/' . $image->name);
                $image->delete();
            }
        }

        if ($this->placeIds) {
            if ($this->post->places->pluck('id'))
                foreach ($this->post->places->pluck('id') as $oldId)
                    if (!in_array($oldId, $this->placeIds))
                        $this->post->places->where('pivot.place_id', $oldId)->first()->pivot->delete();

            foreach ($this->placeIds as $id)
                Review::firstOrCreate([
                    'post_id' => $this->post->id,
                    'place_id' => $id
                ]);
        } else
            foreach ($this->post->places as $review)
                $review->pivot->delete();

        $this->post->update([
            'title' => Str::title($this->title),
            'slug' => Str::slug(Str::limit($this->title, 30)),
            'desc' => $this->desc,
            'content' => $this->content,
            'tags' => $this->tags,
            'category_id' => $this->category_id,
            'is_active' => $this->is_active
        ]);
    }
}
