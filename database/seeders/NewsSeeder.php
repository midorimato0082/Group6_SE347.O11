<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('news')->insert([
            [
                'title' => 'Du Lịch Tháng 3: Khám Phá Du Lịch Mùa Hoa Nở',
                'slug' => 'du-lich-thang-3-kham-pha-du-li',
                'desc' => 'Tháng 3, tuy chưa phải là thời điểm du lịch “hot” nhất vì mọi người vẫn đang bận quay cuồng với học tập, công việc sau kì nghỉ tết vừa qua. Nhưng nếu bỏ qua việc tận hưởng một chuyến đi trong mùa hoa nở này thì quả thật lãng phí. Hãy cùng Review Travel kể tên những địa điểm nên trải nghiệm trong tháng 3 này nhé.',
                'content' => '<p>Tọa lạc tại vị trí đắc địa, Garden Hostel Đà Lạt cách vườn hoa Đà Lạt chỉ chưa đầy 600 m. Chùa Tàu Thiên Vương Cổ Sát chỉ cách khoảng 1.3 km, Chợ Đà Lạt cách khoảng 2km.</p>',
                'images' => 'sample1.jpg|sample.jpg',
                'tags' => 'phú quốc',
                'admin_id' => 1,
                'created_at' => now()
            ],
            [
                'title' => 'Du Khách Lên Tiếng “Tố” Homestay Đà Lạt “Nhà Mây” Lừa Đảo, Ăn Chặn!',
                'slug' => 'du-khach-len-tieng-“to”-homest',
                'desc' => 'Cứ tưởng rằng những loạt bài “bóc phốt” các homestay Đà Lạt đã kết thúc. Thế nhưng hôm nay, mình lại đọc được một bài review của khách hàng về Mây’s House Đà Lạt. Mình Xin phép được dùng từ “lên án” vì khách hàng tỏ ra rất bức xúc trước kiểu làm dịch vụ “chặt chém”, “Treo đầu dê bán thịt chó” tại đây. Hãy cùng dõi theo sự việc khách hàng tố homestay Đà Lạt lừa đảo như thế nào các bạn nhé!',
                'content' => '<p>Tọa lạc tại vị trí đắc địa, Garden Hostel Đà Lạt cách vườn hoa Đà Lạt chỉ chưa đầy 600 m. Chùa Tàu Thiên Vương Cổ Sát chỉ cách khoảng 1.3 km, Chợ Đà Lạt cách khoảng 2km.</p>',
                'images' => 'sample1.jpeg|sample.jpeg',
                'tags' => 'homestay đà lạt',
                'admin_id' => 1,
                'created_at' => now()
            ],
        ]);
    }
}
