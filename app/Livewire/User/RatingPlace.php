<?php

namespace App\Livewire\User;

use App\Models\Rating;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class RatingPlace extends Component
{
    public $place, $star, $rated = false;

    public function render()
    {
        $this->star = Rating::where('user_id', Auth::user()->id)->where('place_id', $this->place->id)->first()->star ?? null;

        return view('livewire.user.rating-place');
    }

    #[On('save-rating')]
    public function save()
    {
        $rating = Auth::user()->places->where('pivot.place_id', $this->place->id)->first()->pivot ?? null;

        if ($rating)
            $rating->update(['star' => $this->star]);
        else
            Rating::create([
                'user_id' => Auth::user()->id, 'place_id' => $this->place->id, 'star' => $this->star
            ]);

        $this->rated = true;
        $this->reset('star');
    }

    #[On('reset-rating')]
    public function resetRating() {
        $this->reset('rated');
    }
}
