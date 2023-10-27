<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_review')->insert([
            [
                'title' => 'Garden Hostel Đà Lạt - Khu Vườn Dành Cho Những Người Yêu Sự An Tĩnh',
                'slug' => Str::slug('Garden Hostel Đà Lạt - Khu Vườn Dành Cho Những Người Yêu Sự An Tĩnh'),
                'desc' => 'Trút bỏ hết những mệt mỏi của cuộc sống thường ngày, cùng Homestay Review ghé thăm Đà Lạt Garden Hostel với rất nhiều điều thú vị!',
                'content' => '<p>Tọa lạc tại vị trí đắc địa, Garden Hostel Đà Lạt cách vườn hoa Đà Lạt chỉ chưa đầy 600 m. Chùa Tàu Thiên Vương Cổ Sát chỉ cách khoảng 1.3 km, Chợ Đà Lạt cách khoảng 2km.</p>',
                'images' => 'sample1.jpeg',
                'tags' => 'poshtel việt nam,du lịch đà lạt,đà lạt poshtel',
                'category_id' => 1,
                'location_id' => 1,
                'admin_id' => 1,
                'created_at' => now()
            ],
            [
                'title' => 'HOMESTAY MIỀN BẮC Hali Home Ninh Bình Không Ai Nỡ Lòng Rời Xa',
                'slug' => Str::slug('HOMESTAY MIỀN BẮC Hali Home Ninh Bình Không Ai Nỡ Lòng Rời Xa'),
                'desc' => 'Sở hữu vẻ đẹp non nước hữu tình, trong trẻo, bình yên mà lại ngay sát Hà Nội nên Ninh Bình tường là điểm đến của các tín đồ du lịch suốt bốn mùa. Hãy đến Hali Home Ninh Bình để chuyến đi “chạy trốn” thành thị của mình được trọn vẹn và đáng nhớ hơn bạn nhé!',
                'content' => '<p>Tọa lạc tại vị trí đắc địa, Garden Hostel Đà Lạt cách vườn hoa Đà Lạt chỉ chưa đầy 600 m. Chùa Tàu Thiên Vương Cổ Sát chỉ cách khoảng 1.3 km, Chợ Đà Lạt cách khoảng 2km.</p>',
                'images' => 'sample2.jpeg',
                'tags' => 'du lịch ninh bình,hali home ninh bình,homestay ninh bình',
                'category_id' => 1,
                'location_id' => 2,
                'admin_id' => 1,
                'created_at' => now()
            ],
        ]);
    }
}
