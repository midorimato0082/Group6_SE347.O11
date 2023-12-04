<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('review_images')->insert([
            [
                'name' => 'S9beahJAwwommaAI2TPkcnzFjjG9XRFYZOrALCQK.jpg',
                'review_id' => 1
            ],
            [
                'name' => '3Evfz6TUZDAKNRhfRmIjbwrQgU2FekHr0VsnhsK3.jpg',
                'review_id' => 1
            ],
            [
                'name' => 'Zr7NZgDTm8rH3X8X1kxysKk2JiBb9LAAyKNDDxb5.jpg',
                'review_id' => 1
            ],
            [
                'name' => 'kFf2KwZ0CGY7xHioWx9WByrxoe09QT7knTAWdxMd.jpg',
                'review_id' => 2
            ],
            [
                'name' => 'YojXlvaZ6ag6GX41EC5tTmFRf2bhRsjpQH02EqVk.jpg',
                'review_id' => 2
            ],
            [
                'name' => '6EAU8BocGlCCzjaAcPAgdvVtGzMQjlVhDQJJtmoF.jpg',
                'review_id' => 2
            ],
            [
                'name' => '0ahy92osEYg7dagT9BedZ53OKEIu60XKf9UyuyRJ.jpg',
                'review_id' => 3
            ],
            [
                'name' => 'FcsdlDgxfIOmV1VnCIY0veJxpgcHlnTBKbSdKWgE.jpg',
                'review_id' => 3
            ],
            [
                'name' => 'moSohuXtT03I8XusEpBfMeuxoaMyabrUiirzIrVW.jpg',
                'review_id' => 3
            ],
            [
                'name' => 'J92rCSloI4jgBD7OaGONv9TRHZcFZD30CxiWzX1Y.jpg',
                'review_id' => 4
            ],
            [
                'name' => 'ZaZH63bf7cRhs3qf1GT5zQVvLhqnE5ihgZNgbezP.jpg',
                'review_id' => 4
            ],
            [
                'name' => 'YKHndaWZCdZOLEILerHLq3mSggcRgyxMrnufYDxG.jpg',
                'review_id' => 5
            ],
            [
                'name' => 'YKHndaWZCdZOLEILerHLq3mSggcRgyxMrnufYDxG.jpg',
                'review_id' => 5
            ],
            [
                'name' => 'YKHndaWZCdZOLEILerHLq3mSggcRgyxMrnufYDxG.jpg',
                'review_id' => 5
            ],
            [
                'name' => '3AduUTPkO7vyGzDla08ZdGKgHejwTN45w3Hjd3ul.jpg',
                'review_id' => 6
            ],
            [
                'name' => 'of1OMj9FO8tgCPMSZU9xL077Llq85wBKWGrlwnUG.jpg',
                'review_id' => 7
            ],
            [
                'name' => 'P5Fmg0SJWW6N9JHnUydw0BcZQp5sQoUsT4nrE4H5.jpg',
                'review_id' => 7
            ],
        ]);
    }
}
