<?php

namespace Database\Seeders;

use App\Models\Place;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Seeder;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $places = Place::all();
        $users = User::whereRelation('role', 'name', 'User')->get();

        for ($i = 0; $i <= 30; $i++)
            Rating::firstOrCreate(
                [
                    'user_id' => $users->random()->id,
                    'place_id' => $places->random()->id
                ],
                [
                    'star' => rand(1, 5)
                ]
            );
    }
}
