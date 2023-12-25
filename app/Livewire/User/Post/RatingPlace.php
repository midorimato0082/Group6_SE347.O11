<?php

namespace App\Livewire\User\Post;

use App\Models\Place;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class RatingPlace extends Component
{
    public $place, $star, $rated = false;

    public function mount()
    {
        $this->star = Rating::where('user_id', Auth::user()->id)->where('place_id', $this->place->id)->first()->star ?? null;
    }

    public function render()
    {
        return view('livewire.user.post.rating-place');
    }

    #[On('save-rating')]
    public function save()
    {
        $rating = Auth::user()->places->where('pivot.place_id', $this->place->id)->first()->pivot ?? null;

        if ($rating)
            $rating->update(['star' => $this->star]);
        else
        if ($this->star) {
            Rating::create([
                'user_id' => Auth::user()->id, 'place_id' => $this->place->id, 'star' => $this->star
            ]);
        }

        $this->rated = true;
        $this->place = Place::find($this->place->id);
    }

    #[On('reset-rating')]
    public function resetRating()
    {
        $this->reset('rated');
    }
}
