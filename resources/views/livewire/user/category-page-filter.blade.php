<div class="col mt-4 page-content-right me-5">
    <h4 class="mb-4 fw-bold">
        <i class="fa-solid fa-filter"></i>
        Bộ lọc tìm kiếm
    </h4>

    {{-- Lọc vùng miền --}}
    <h6 class="fw-bold">Miền</h6>
    @foreach ($regions as $region)
        <div class="form-check mx-3 mb-2" wire:key="row-{{ $region->name }}">
            <input wire:model.live="regionFilter" class="form-check-input shadow-none" type="checkbox" id="check-filter-page"
                value="{{ $region->name }}">
            <label class="form-check-label" for="check-filter-page">
                {{ $region->name }}
            </label>
        </div>
    @endforeach

    <div class="border-bottom border-black mt-3"></div>

    {{-- Lọc tỉnh thành --}}
    <h6 class="fw-bold mt-3">Tỉnh thành</h6>
    <div class="scroll-panel filter-provinces">
        @foreach ($provinces as $province)
            <div class="form-check mx-3 mb-2" wire:key="row-{{ $province->name }}">
                <input wire:model.live="provinceFilter" class="form-check-input shadow-none" type="checkbox"
                    id="check-filter-page" value="{{ $province->name }}">
                <label class="form-check-label" for="check-filter-page">
                    {{ $province->name }}
                </label>
            </div>
        @endforeach
    </div>

    <div class="border-bottom border-black mt-3"></div>

    {{-- Lọc quận huyện --}}
    <h6 class="fw-bold mt-3">Quận huyện</h6>
    <div class="scroll-panel filter-districts">
        @foreach ($districts as $district)
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
        <div class="text-center mt-3">
            @if ($errors->any())
                <p class="error">
                    <strong>Vui lòng nhập khoảng giá phù hợp.</strong>
                </p>
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
            <input wire:model.live="starFilter" type="radio" value="{{ $star }}" id="{{ $star }}-star">
            <label for="{{ $star }}-star"><i class="fa fa-star fa-2x me-2"></i></label>
        @endfor
    </div>

    <div class="border-bottom border-black mt-3"></div>

    {{-- Nút clear lọc --}}
    <div class="d-flex mt-3 justify-content-center">
        <button wire:click="removeFilter" class="btn btn-sm btn-orange w-100 mx-3">Xóa tất cả</button>
    </div>
</div>
