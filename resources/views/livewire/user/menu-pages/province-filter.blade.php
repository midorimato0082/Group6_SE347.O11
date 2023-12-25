<div class="col mt-4 page-content-right me-5">
    <h4 class="mb-4 fw-bold">
        <i class="fa-solid fa-filter"></i>
        Bộ lọc tìm kiếm
    </h4>

    {{-- Lọc danh mục --}}
    <h6 class="fw-bold">Danh mục</h6>
    @foreach ($this->categories as $category)
        <div class="form-check mx-3 mb-2" wire:key="row-{{ $category->name }}">
            <input wire:model.live="categoryFilter" class="form-check-input shadow-none" type="checkbox"
                id="check-filter-page" value="{{ $category->name }}">
            <label class="form-check-label" for="check-filter-page">
                {{ $category->name }}
            </label>
        </div>
    @endforeach

    <div class="border-bottom border-black mt-3"></div>

    {{-- Lọc quận huyện --}}
    <h6 class="fw-bold mt-3">Quận huyện</h6>
    <div class="scroll-panel filter-districts">
        @foreach ($this->districts as $district)
            <div class="form-check mx-3 mb-2" wire:key="row-{{ $district->name }}">
                <input wire:model.live="districtFilter" class="form-check-input shadow-none" type="checkbox"
                    id="check-filter-page" value="{{ $district->name }}">
                <label class="form-check-label" for="check-filter-page">
                    {{ $district->name }}
                </label>
            </div>
        @endforeach
    </div>

    <div class="border-bottom border-black mt-3"></div>

    {{-- Lọc khoảng giá --}}
    <h6 class="fw-bold mt-3">Khoảng giá</h6>
    <form wire:submit="filterPrice">
        <div class="d-flex mx-3">
            <input wire:model="minPrice" type="number" class="form-control form-control-sm shadow-none"
                placeholder="₫ Từ" min="0">
            <span class="mx-3">-</span>
            <input wire:model="maxPrice" type="number" class="form-control form-control-sm shadow-none"
                placeholder="₫ Đến" min="0">
        </div>
        <div class="text-center mt-2">
            @if ($errors->any())
                <strong class="error">Vui lòng nhập khoảng giá phù hợp.</strong>
            @endif
        </div>

        <div class="d-flex mt-3 justify-content-center">
            <button type="submit" class="btn btn-sm btn-orange w-100 mx-3">Áp dụng</button>
        </div>
    </form>

    <div class="border-bottom border-black mt-3"></div>

    {{-- Lọc sao --}}
    <h6 class="fw-bold mt-3">Đánh giá địa điểm</h6>
    <div class="rating ms-3">
        @for ($star = 5; $star > 0; $star--)
            <input wire:model.live="starFilter" type="radio" value="{{ $star }}"
                id="{{ $star }}-star">
            <label for="{{ $star }}-star"><i class="fa fa-star fa-2x me-2"></i></label>
        @endfor
    </div>

    <div class="border-bottom border-black mt-3"></div>

    {{-- Nút clear lọc --}}
    <div class="d-flex mt-3 justify-content-center">
        <button wire:click="removeFilter" class="btn btn-sm btn-orange w-100 mx-3">Xóa tất cả</button>
    </div>
</div>