<?php

namespace App\Livewire\Admin\ReviewManagement;

use App\Models\Category;
use App\Models\Location;
use App\Models\Review;
use App\Models\ReviewImages;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;

class AddReview extends Component
{
    use WithFileUploads;

    public $title, $desc, $content, $tags, $categoryId, $locationId, $isActive = true, $images;
    public $fileId;

    #[Layout('admin.managements')]
    #[Title('Thêm bài viết')]
    public function render()
    {
        $categories = Category::all('id', 'name');
        $locations = Location::all('id', 'name');

        $this->categoryId = $categories->first()->id;
        $this->locationId = $locations->first()->id;

        return view('livewire.admin.review-management.add-review', [
            'categories' => $categories,
            'locations' => $locations,
        ]);
    }

    protected function rules(): array
    {
        return [
            'title' => 'required|max:100|unique:reviews'
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
        $this->images ? : $this->fileId++;
    }

    public function clear()
    {
        $this->clearValidation();
        $this->reset();
        $this->fileId++;
    }

    public function save()
    {
        $this->authorize('create', Review::class);

        $this->validate();

        $review = $this->createReview();

        $this->reset();

        $this->dispatch('alert-success', message: 'Thêm bài viết mới thành công.');

        return $this->redirectRoute('edit.review', $review);
    }

    private function createReview()
    {
        $review = Review::create([
            'title' => Str::title($this->title),
            'slug' => Str::slug(Str::limit($this->title, 30)),
            'desc' => $this->desc,
            'content' => $this->content,
            'tags' => $this->tags,
            'category_id' => $this->categoryId,
            'location_id' => $this->locationId,
            'admin_id' => Auth::user()->id,
            'is_active' => $this->isActive
        ]);

        if (is_array($this->images)) {
            foreach ($this->images as $image) {
                ReviewImages::create([
                    'name' => basename($image->store('reviews', 'images')),
                    'review_id' => $review->id
                ]);
            }
        }

        return $review;
    }

    // Viết đè method trong WithFileUploads để clean các ảnh trong storage/app/livewire-tmp
    // protected function cleanupOldUploads()
    // {
    //     $storage = Storage::disk('local');

    //     foreach ($storage->allFiles('livewire-tmp') as $filePathName) {
    //         $oldTmp = now()->subSeconds(60)->timestamp;
    //         if ($oldTmp > $storage->lastModified($filePathName)) {
    //             $storage->delete($filePathName);
    //         }
    //     }
    // }
}
