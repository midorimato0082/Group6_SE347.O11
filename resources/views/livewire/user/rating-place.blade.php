<div class="row d-flex text-start align-items-center mt-3 ms-3">
    <div class="col-sm-5 col-md-4 col-lg-4 col-xl-3">
        <i class="fa-solid fa-location-dot me-1"></i>
        {{ $place->name }}
    </div>
    @if ($rated)
        <div class="col-sm-4 col-md-4 col-lg-4 col-xl-3 result-rating">
            <p class="mb-0" data-bs-toggle="tooltip" title="{{ $place->starTooltip }}" data-bs-placement="left">
                {!! str_repeat('<i class="fa fa-star star-color fa-lg"></i>', $place->star) !!}
            </p>
        </div>
        <div class="col result-rating">
            {{ $place->users->count() }} đánh giá
        </div>
    @else
        <div class="col rating">
            @for ($i = 5; $i > 0; $i--)
                <input wire:model="star" type="radio" value="{{ $i }}"
                    id="{{ $place->id }}-star-{{ $i }}">
                <label for="{{ $place->id }}-star-{{ $i }}">
                    <i class="fa fa-star fa-lg me-2"></i>
                </label>
            @endfor
        </div>
    @endif
</div>
