<?php

namespace App\Livewire\User;

use App\Models\PostLike;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LikePost extends Component
{
    public $post, $likeCount, $dislikeCount, $isLike;

    public function mount()
    {
        $this->likeCount = $this->post->like_count;
        $this->dislikeCount = $this->post->dislike_count;
    }

    public function render()
    {
        $this->isLike = PostLike::where('user_id', Auth::user()->id)->where('post_id', $this->post->id)->value('is_like') ?? null;
        return view('livewire.user.like-post');
    }

    public function like()
    {
        $postLike = Auth::user()->postlikes->where('pivot.post_id', $this->post->id)->first()->pivot ?? null;

        if($postLike) {
            if ($this->isLike) {
                $postLike->delete();
                $this->likeCount--;
            } else {
                $postLike->update(['is_like' => true]);
                $this->likeCount++;
                $this->dislikeCount--;
            }
        } else {
            PostLike::create([
                'user_id' => Auth::user()->id,
                'post_id' => $this->post->id,
                'is_like' => true
            ]);

            $this->likeCount++;
        }
    }

    public function dislike()
    {
        $postLike = Auth::user()->postlikes->where('pivot.post_id', $this->post->id)->first()->pivot ?? null;

        if ($postLike) {
            if ($this->isLike) {
                $postLike->update(['is_like' => false]);
                $this->likeCount--;
                $this->dislikeCount++;
            } else {
                $postLike->delete();
                $this->dislikeCount--;
            }
        } else {
            PostLike::create([
                'user_id' => Auth::user()->id,
                'post_id' => $this->post->id,
                'is_like' => false
            ]);

            $this->dislikeCount++;
        }
    }
}
