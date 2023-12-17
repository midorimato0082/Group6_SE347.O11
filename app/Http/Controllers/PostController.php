<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Post;
use App\Models\Province;
use App\Models\Region;

class PostController extends Controller
{
    public function showPost($slug)
    {
        $post = Post::where('slug', $slug)->count()->first();
        empty($post) && abort(404);

        $places = $post->places;

        $districts = District::whereIn('id', $places->pluck('district_id'))->distinct()->get(['name', 'slug', 'province_id']);
        $provinces = Province::whereIn('id', $districts->pluck('province_id'))->distinct()->get(['name', 'slug', 'region_id']);
        $regions = Region::whereIn('id', $provinces->pluck('region_id'))->distinct()->get(['name', 'slug']);

        $this->countView($post);

        return view('user.post', compact('post', 'places', 'regions', 'provinces', 'districts'))->with('title', $post->title);
    }

    private function countView(Post $post)
    {
        $key = 'viewed_posts.' . $post->id;

        $timeViewed = session($key);

        if (!$timeViewed)
            $this->incrementView($post);
        else {
            // Đã xem hết hạn sau một giờ.
            $throttleTime = 3600;

            if (($timeViewed + $throttleTime) < time())
                $this->incrementView($post);
        }
    }

    private function incrementView(Post $post)
    {
        $post->increment('view_count');
        session(['viewed_posts.' . $post->id => time()]);
    }
}
