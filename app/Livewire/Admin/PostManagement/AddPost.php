<?php

namespace App\Livewire\Admin\PostManagement;

use App\Models\Category;
use App\Models\Place;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;

class AddPost extends Component
{
    use WithFileUploads;

    public $title, $desc, $content, $tags, $categoryId, $isActive = true, $images;

    public $placeIds = [];

    public $fileId;

    public function mount() {
        $this->categoryId = $this->categories[0]->id ?? null;
    }

    #[Layout('admin.managements')]
    #[Title('Thêm bài viết')]
    public function render()
    {
        return view('livewire.admin.post-management.add-post');
    }

    #[Computed]
    public function categories()
    {
        return Category::where('is_active', true)->get(['id', 'name']);
    }

    #[Computed]
    public function places()
    {
        return Place::where('category_id', $this->categoryId)->where('is_active', true)->get(['name', 'id']);
    }

    protected function rules(): array
    {
        return [
            'title' => 'required|max:100|unique:posts'
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
            ['images' => $this->images],
            ['images.*' => 'image|mimes:jpg,jpeg,png|max:1024'],
            [
                'images.*.image' => 'File được chọn phải là ảnh .jpg, .jpeg hoặc .png.',
                'images.*.mimes' => 'Ảnh được chọn phải có đuôi là .jpg, .jpeg hoặc .png.',
                'images.*.max' => 'Kích thước ảnh phải nhỏ hơn 1 MB'
            ]
        );

        if ($validator->fails()) {
            $this->reset('images');
            $this->fileId++;
        }

        $validator->validate();
    }

    #[On('get-tags')]
    public function setTag($tags)
    {
        $this->tags = $tags;
    }

    public function removeImage($key)
    {
        array_splice($this->images, $key, 1);
        $this->images ?: $this->fileId++;
    }

    public function updatedCategoryId($value)
    {
        $places = Category::find($value)->is_place ? Place::where('category_id', $this->categoryId)->where('is_active', true)->pluck('name', 'id') : null;
        $this->dispatch('set-places', places: $places);  
    }

    #[On('get-places')]
    public function setPlace($places)
    {
        $this->placeIds = $places;
    }

    #[On('new-place')]
    public function getNewPlace($place)
    {
        $this->categoryId = $place;
        $this->updatedCategoryId($this->categoryId);
    }

    public function clear()
    {
        $this->clearValidation();
        $this->reset();
        $this->mount();
        $this->updatedCategoryId($this->categoryId);
        $this->fileId++;
    }

    public function save()
    {
        $this->authorize('create', Post::class);

        $this->validate();

        $post = $this->createPost();

        $this->reset();

        $this->dispatch('alert-success', message: 'Thêm bài viết mới thành công.');

        return $this->redirectRoute('edit.post', $post);
    }

    private function createPost()
    {
        $post = Post::create([
            'title' => Str::title($this->title),
            'slug' => Str::slug(Str::limit($this->title, 30)),
            'desc' => $this->desc,
            'content' => $this->content,
            'tags' => $this->tags,
            'category_id' => $this->categoryId,
            'admin_id' => Auth::user()->id,
            'is_active' => $this->isActive
        ]);

        if (is_array($this->images)) {
            foreach ($this->images as $image) {
                PostImage::create([
                    'name' => basename($image->store('posts', 'images')),
                    'post_id' => $post->id
                ]);
            }
        }

        if($this->placeIds) {
            foreach ($this->placeIds as $id) {
                Review::create([
                    'post_id' => $post->id,
                    'place_id' => $id
                ]);
            }
        }

        return $post;
    }
}
