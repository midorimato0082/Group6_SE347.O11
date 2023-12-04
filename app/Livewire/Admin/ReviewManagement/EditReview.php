<?php

namespace App\Livewire\Admin\ReviewManagement;

use App\Models\Category;
use App\Models\Location;
use App\Models\Review;
use App\Models\ReviewImages;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;

class EditReview extends Component
{
    use WithFileUploads;

    public Review $review;
    public $title, $desc, $content, $tags, $category_id, $location_id, $is_active;
    public $oldImages, $newImages, $deletedImages;
    public $fileId;

    public function mount()
    {
        $this->fill(
            $this->review->only('title', 'desc', 'content', 'category_id', 'tags', 'location_id', 'is_active'),
        ); 
        $this->is_active = 1 ? true : false;
        $this->oldImages = ReviewImages::where('review_id', $this->review->id)->get();
    }

    #[Layout('admin.managements')]
    #[Title('Cập nhật bài viết')]
    public function render()
    {
        $categories = Category::all('id', 'name');
        $locations = Location::all('id', 'name');

        return view('livewire.admin.review-management.edit-review', ['categories' => $categories, 'locations' => $locations]);
    }

    protected function rules(): array
    {
        return [
            'title' => ['required', 'max:100', Rule::unique('reviews')->ignore($this->review->id)]
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

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
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
        $this->newImages ? : $this->fileId++;
    }

    public function restoreOldImages() {
        $this->oldImages->push(last($this->deletedImages));
    }

    public function clear()
    {
        $this->clearValidation();
        $this->reset('deletedImages', 'newImages');
        $this->mount();
        $this->fileId++;
        $this->dispatch('clear-content');
        $this->dispatch('clear-tags', tags: $this->tags);
    }

    public function update()
    {
        $this->authorize('update', $this->review);

        $this->validate();

        $this->updateReview();

        $this->reset('deletedImages', 'newImages');

        $this->dispatch('alert-success', message: 'Cập nhật bài viết mới thành công.');
    }

    private function updateReview()
    {
        if (is_array($this->newImages)) {
            foreach ($this->newImages as $image) {
                ReviewImages::create([
                    'name' => basename($image->store('reviews', 'images')),
                    'review_id' => $this->review->id
                ]);
            }
        } elseif (is_array($this->deletedImages)) {
            foreach ($this->deletedImages as $image) {
                Storage::disk('images')->delete('reviews/' . $image->name);
                $image->delete();
            }  
        }

        $this->review->update([
            'title' => Str::title($this->title),
            'slug' => Str::slug(Str::limit($this->title, 30)),
            'desc' => $this->desc,
            'content' => $this->content,
            'tags' => $this->tags,
            'category_id' => $this->category_id,
            'location_id' => $this->location_id,
            'is_active' => $this->is_active 
        ]);
    }
}
