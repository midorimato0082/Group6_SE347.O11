<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
                'slug' => Str::slug(Str::limit('Du Lịch Tháng 3: Khám Phá Du Lịch Mùa Hoa Nở', 30)),
                'desc' => 'Tháng 3, tuy chưa phải là thời điểm du lịch “hot” nhất vì mọi người vẫn đang bận quay cuồng với học tập, công việc sau kì nghỉ tết vừa qua. Nhưng nếu bỏ qua việc tận hưởng một chuyến đi trong mùa hoa nở này thì quả thật lãng phí. Hãy cùng Review Travel kể tên những địa điểm nên trải nghiệm trong tháng 3 này nhé.',
                'content' => '<p>Tọa lạc tại vị trí đắc địa, Garden Hostel Đà Lạt cách vườn hoa Đà Lạt chỉ chưa đầy 600 m. Chùa Tàu Thiên Vương Cổ Sát chỉ cách khoảng 1.3 km, Chợ Đà Lạt cách khoảng 2km.</p>',
                'images' => '15586853791.jpg | du-lich-sapa-thang-315.jpg',
                'tags' => 'phú quốc',
                'admin_id' => 1,
                'created_at' => '2023-10-27 12:45:19',
                'view_count' => 5
            ],
            [
                'title' => 'Du Khách Lên Tiếng “Tố” Homestay Đà Lạt “Nhà Mây” Lừa Đảo, Ăn Chặn!',
                'slug' => Str::slug(Str::limit('Du Khách Lên Tiếng “Tố” Homestay Đà Lạt “Nhà Mây” Lừa Đảo, Ăn Chặn!', 30)),
                'desc' => 'Cứ tưởng rằng những loạt bài “bóc phốt” các homestay Đà Lạt đã kết thúc. Thế nhưng hôm nay, mình lại đọc được một bài review của khách hàng về Mây’s House Đà Lạt. Mình Xin phép được dùng từ “lên án” vì khách hàng tỏ ra rất bức xúc trước kiểu làm dịch vụ “chặt chém”, “Treo đầu dê bán thịt chó” tại đây. Hãy cùng dõi theo sự việc khách hàng tố homestay Đà Lạt lừa đảo như thế nào các bạn nhé!',
                'content' => '<p>Tọa lạc tại vị trí đắc địa, Garden Hostel Đà Lạt cách vườn hoa Đà Lạt chỉ chưa đầy 600 m. Chùa Tàu Thiên Vương Cổ Sát chỉ cách khoảng 1.3 km, Chợ Đà Lạt cách khoảng 2km.</p>',
                'images' => '46486058_1503208826478853_7346061498428424192_n58.jpg | 16027828092.jpg',
                'tags' => 'homestay đà lạt',
                'admin_id' => 2,
                'created_at' => '2023-10-29 12:45:19',
                'view_count' => 5
            ],
            [
                'title' => 'Một Số Lưu Ý Khi Chọn Ở Homestay Đà Lạt! Đừng Để Bị Lừa!',
                'slug' => Str::slug(Str::limit('Một Số Lưu Ý Khi Chọn Ở Homestay Đà Lạt! Đừng Để Bị Lừa!', 30)),
                'desc' => 'Tiếp nối câu chuyện về những homestay Đà Lạt, mình sẽ đưa ra cho các bạn một số lưu ý cụ thể khi chọn ở những homestay trên mảnh đất phố “núi” này. Tránh tình trạng bị lừa đảo, hụt hẫng, hay xa cách về địa lý,…. Bên cạnh đó là những lý giải vì sao nhiều homestay Đà Lạt lại xảy ra tình trạng như vậy! Sau đây, các bạn hãy cùng mình tham khảo một số lưu ý khi chọn một homestay ở Đà Lạt nhé!',
                'content' => '<p>Tọa lạc tại vị trí đắc địa, Garden Hostel Đà Lạt cách vườn hoa Đà Lạt chỉ chưa đầy 600 m. Chùa Tàu Thiên Vương Cổ Sát chỉ cách khoảng 1.3 km, Chợ Đà Lạt cách khoảng 2km.</p>',
                'images' => '16607891697.jpg | 16607899223.jpg',
                'tags' => 'đà lạt chặt chém',
                'admin_id' => 1,
                'created_at' => '2023-11-1 12:45:19',
                'view_count' => 5
            ],
            [
                'title' => 'Flamingo Đại Lải Resort: Thực Hư Về Chất Lượng Dịch Vụ!',
                'slug' => Str::slug(Str::limit('Flamingo Đại Lải Resort: Thực Hư Về Chất Lượng Dịch Vụ!', 30)),
                'desc' => 'Sắp tới, mình và nhóm bạn dự định sẽ đi nghỉ dưỡng tại một Villa hoặc một homestay nào đó quanh khu vực ngoại thành Hà Nội. Lẽ tất yếu, vì lý do công việc nên chúng mình không có thời gian đi xa. Sau khi thống nhất, chúng mình quyết định sẽ đi Flamingo Đại Lải, một khu resort 5 sao được quảng cáo khá “hot” trong mùa hè năm nay. Tuy vậy, sau khi tìm hiểu và đọc những review của khách hàng thì chúng mình có hơi “lăn tăn” về địa điểm nghỉ dưỡng này.',
                'content' => '<p>Tọa lạc tại vị trí đắc địa, Garden Hostel Đà Lạt cách vườn hoa Đà Lạt chỉ chưa đầy 600 m. Chùa Tàu Thiên Vương Cổ Sát chỉ cách khoảng 1.3 km, Chợ Đà Lạt cách khoảng 2km.</p>',
                'images' => '16027615240.jpg | 16027828092.jpg',
                'tags' => 'đà lạt resort',
                'admin_id' => 7,
                'created_at' => '2023-11-3 12:45:19',
                'view_count' => 5
            ],
            [
                'title' => 'Chia Sẻ Kinh Nghiệm Chụp Ảnh “Sống Ảo” Bằng Điện Thoại Khi Đi Du Lịch',
                'slug' => Str::slug(Str::limit('Chia Sẻ Kinh Nghiệm Chụp Ảnh “Sống Ảo” Bằng Điện Thoại Khi Đi Du Lịch', 30)),
                'desc' => 'Bạn có tin rằng chỉ bằng một chiếc smartphone, bạn hoàn toàn có thể “tung hoành” hết cỡ trong mỗi chuyến đi du lịch.',
                'content' => '<p>Tọa lạc tại vị trí đắc địa, Garden Hostel Đà Lạt cách vườn hoa Đà Lạt chỉ chưa đầy 600 m. Chùa Tàu Thiên Vương Cổ Sát chỉ cách khoảng 1.3 km, Chợ Đà Lạt cách khoảng 2km.</p>',
                'images' => '25011963_1738810346427337_2012105063354335232_n26.jpg | caracat161.jpg',
                'tags' => 'du lịch, cẩm nang',
                'admin_id' => 5,
                'created_at' => '2023-11-3 14:45:19',
                'view_count' => 5
            ],
            [
                'title' => 'Villa De Pomelo – Khu Vườn Hơi “Có Mùi”',
                'slug' => Str::slug(Str::limit('Villa De Pomelo – Khu Vườn Hơi “Có Mùi”', 30)),
                'desc' => 'Villa De Pomelo được biết tới là một căn Villa có khuôn viên rộng toạ lạc tại huyện Thạch Thất, cách trung tâm Hà Nội khoảng 30km. Nhiều du khách khi tới đây nhận xét về phòng sạch sẽ, chủ nhà thân thiện, không khí thoáng mát trong lành.',
                'content' => '<p>Tọa lạc tại vị trí đắc địa, Garden Hostel Đà Lạt cách vườn hoa Đà Lạt chỉ chưa đầy 600 m. Chùa Tàu Thiên Vương Cổ Sát chỉ cách khoảng 1.3 km, Chợ Đà Lạt cách khoảng 2km.</p>',
                'images' => '64287257_868433896871219_5191371359162204160_o94.jpg | cui-homestay-da-lat-vietliketravel-68026.jpg',
                'tags' => 'villa de pomelo, gần hà nội',
                'admin_id' => 2,
                'created_at' => now(),
                'view_count' => 5
            ],
        ]);
    }
}
