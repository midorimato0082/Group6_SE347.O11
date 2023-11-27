<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reviews')->insert([
            [
                'title' => 'Garden Hostel Đà Lạt - Khu Vườn Dành Cho Những Người Yêu Sự An Tĩnh',
                'slug' => Str::slug(Str::limit('Garden Hostel Đà Lạt - Khu Vườn Dành Cho Những Người Yêu Sự An Tĩnh', 30)),
                'desc' => 'Trút bỏ hết những mệt mỏi của cuộc sống thường ngày, cùng Homestay Review ghé thăm Đà Lạt Garden Hostel với rất nhiều điều thú vị!',
                'content' => '<p>Tọa lạc tại vị trí đắc địa, Garden Hostel Đà Lạt cách vườn hoa Đà Lạt chỉ chưa đầy 600 m. Chùa Tàu Thiên Vương Cổ Sát chỉ cách khoảng 1.3 km, Chợ Đà Lạt cách khoảng 2km.</p>',
                'images' => '11860_1529899208_dscf0558-1024x7688.jpg | 11860_1530090193_dscf0554-1024x76856.jpg | 4415614_1803161445006282322430.jpg | da-lat-garden-hostel-phong-salem-phong-doi-2-giuong-don-nha-tam-chung1216.jpg | da-quy-phong-doi-nha-tam-chung152.jpg | lay-on-phong-don-nha-tam-chung1-1024x68366.jpg',
                'tags' => 'poshtel việt nam, du lịch đà lạt, đà lạt poshtel',
                'category_id' => 1,
                'location_id' => 1,
                'admin_id' => 1,
                'created_at' => '2023-10-28 14:45:19',
                'view_count' => 5,
                'like_count' => 1,
                'dislike_count' => 0,
                'comment_count' => 2
            ],
            [
                'title' => 'Homestay miền bắc Hali Home Ninh Bình Không Ai Nỡ Lòng Rời Xa',
                'slug' => Str::slug(Str::limit('Homestay miền bắc Hali Home Ninh Bình Không Ai Nỡ Lòng Rời Xa', 30)),
                'desc' => 'Sở hữu vẻ đẹp non nước hữu tình, trong trẻo, bình yên mà lại ngay sát Hà Nội nên Ninh Bình tường là điểm đến của các tín đồ du lịch suốt bốn mùa. Hãy đến Hali Home Ninh Bình để chuyến đi “chạy trốn” thành thị của mình được trọn vẹn và đáng nhớ hơn bạn nhé!',
                'content' => '<p>Tọa lạc tại vị trí đắc địa, Garden Hostel Đà Lạt cách vườn hoa Đà Lạt chỉ chưa đầy 600 m. Chùa Tàu Thiên Vương Cổ Sát chỉ cách khoảng 1.3 km, Chợ Đà Lạt cách khoảng 2km.</p>',
                'images' => '25.png | 129.png | 0170.png | 0251.png | 0387.png | 1176.png',
                'tags' => 'du lịch ninh bình, hali home ninh bình, homestay ninh bình',
                'category_id' => 1,
                'location_id' => 2,
                'admin_id' => 1,
                'created_at' => '2023-10-29 12:45:19',
                'view_count' => 5,
                'like_count' => 0,
                'dislike_count' => 1,
                'comment_count' => 2
            ],
            [
                'title' => 'Review Chi Tiết Top 5 Homestay Ninh Bình Giá Rẻ, Gần Các Khu Du Lịch',
                'slug' => Str::slug(Str::limit('Review Chi Tiết Top 5 Homestay Ninh Bình Giá Rẻ, Gần Các Khu Du Lịch', 30)),
                'desc' => 'Mùa hè này bạn quyết định “khám phá” Ninh Bình. Vừa gần Hà Nội (chỉ cách khoảng 100km, đi cao tốc tầm 1,5 tiếng là tới nơi). Giá homestay, khách sạn, nhà hàng tại đây hợp lý, ít bị “chặt chém”. Tuy có hơi nóng nhưng không khí tại đây trong lành, dễ chịu. Phù hợp cho những chuyến du lịch ngắn ngày. Thế nhưng bạn đang băn khoăn không biết nên ở đâu khi tới Ninh Bình. Đừng lo! Sau đây homestay.review sẽ review lại chi tiết top 5 homestay Ninh Bình giá rẻ, lại gần các khu du lịch nữa nhé!',
                'content' => '<p>Tọa lạc tại vị trí đắc địa, Garden Hostel Đà Lạt cách vườn hoa Đà Lạt chỉ chưa đầy 600 m. Chùa Tàu Thiên Vương Cổ Sát chỉ cách khoảng 1.3 km, Chợ Đà Lạt cách khoảng 2km.</p>',
                'images' => '44654957_1486261288173607_1176964254788485120_o29.jpg | 46486058_1503208826478853_7346061498428424192_n16.jpg | 16027615277.jpg | 16027828026.jpg | 16027834163.jpg | 16028288382.jpg | 16607891651.jpg | 16607899226.jpg',
                'tags' => 'homestay ninh bình giá rẻ',
                'category_id' => 1,
                'location_id' => 2,
                'admin_id' => 2,
                'created_at' => '2023-11-1 15:45:19',
                'view_count' => 10,
                'like_count' => 0,
                'dislike_count' => 0,
                'comment_count' => 0
            ],
            [
                'title' => 'Tuyệt Chiêu Du Lịch Bến Tre Ngon Bổ Rẻ Từ A Đến Z',
                'slug' => Str::slug(Str::limit('Tuyệt Chiêu Du Lịch Bến Tre Ngon Bổ Rẻ Từ A Đến Z', 30)),
                'desc' => 'Du lịch Bến Tre cần chuẩn bị những gì, đi vào thời điểm nào, đi bằng phương tiện gì, ăn gì ngon và rẻ, chơi ở đâu,… luôn là những vấn đề được du khách tìm hiểu kỹ lưỡng khi muốn tới khám phá xứ Dừa. Homestay Review bật mí cho bạn những tuyệt chiêu du lịch Bến Tre từ A đến Z để bạn có một chuyến đi đầy trải nghiệm thú vị và thật hạnh phúc nhé. Chắc chắn bạn sẽ không hối hận vì đã lựa chọn xứ Dừa để du lịch.',
                'content' => '<p>Tọa lạc tại vị trí đắc địa, Garden Hostel Đà Lạt cách vườn hoa Đà Lạt chỉ chưa đầy 600 m. Chùa Tàu Thiên Vương Cổ Sát chỉ cách khoảng 1.3 km, Chợ Đà Lạt cách khoảng 2km.</p>',
                'images' => 'Ban-se-duoc-hoa-minh-vao-doi-song-cua-nguoi-dan-voi-nhung-trai-nghiem-thu-vi-khi-du-lich-Ben-Tre11.jpg | Buc-tranh-thien-nhien-muon-mau-va-tho-mong-tai-noi-day81.jpg | Ca-loc-nuong-–-mon-kho-ma-bo-qua-khi-buoc-toi-du-lich-Ben-Tre70.jpg | Chuoi-dap-ngon-kho-cuong-tai-Ben-Tre99.jpg | Du-lich-Ben-Tre-ban-se-duoc-hoa-minh-trong-nhung-buc-tranh-da-mau81.jpg | San-chim-Vam-Ho-nhu-mot-buc-tranh-thien-nhien-hien-hoa-song-dong77.jpg | Trai-nghiem-kho-quen-tai-khu-du-lich-sinh-thai-con-Thoi-Son21.jpg',
                'tags' => null,
                'category_id' => 4,
                'location_id' => 4,
                'admin_id' => 2,
                'created_at' => '2023-11-1 18:45:19',
                'view_count' => 2,
                'like_count' => 0,
                'dislike_count' => 0,
                'comment_count' => 0
            ],
            [
                'title' => 'Ở Nifty Heaven Homestay Ngắm Trọn Cảnh Đà Lạt Từ Trên Cao!',
                'slug' => Str::slug(Str::limit('Ở Nifty Heaven Homestay Ngắm Trọn Cảnh Đà Lạt Từ Trên Cao!', 30)),
                'desc' => 'Du lịch Đà Lạt đừng quên ghé Nifty Heaven Homestay để trải nghiệm cảm giác ngắm cảnh trọn vẹn từ trên cao. Khám phá căn homestay thú vị này cùng Homestay Review bạn nhé!',
                'content' => '<p>Tọa lạc tại vị trí đắc địa, Garden Hostel Đà Lạt cách vườn hoa Đà Lạt chỉ chưa đầy 600 m. Chùa Tàu Thiên Vương Cổ Sát chỉ cách khoảng 1.3 km, Chợ Đà Lạt cách khoảng 2km.</p>',
                'images' => '2-18075-1024x15369.jpeg | 3-18079-1024x153649.jpeg | 17-18083-1024x153688.jpeg | 18-18084-1024x153681.jpeg',
                'tags' => 'homestay nguyên căn đà lạt, nifty heaven đà lạt',
                'category_id' => 1,
                'location_id' => 2,
                'admin_id' => 3,
                'created_at' => '2023-11-3 12:45:19',
                'view_count' => 1,
                'like_count' => 0,
                'dislike_count' => 0,
                'comment_count' => 0
            ],
            [
                'title' => 'Nơi Nghỉ Chân Chất Lượng Khi Du Lịch Kon Tum',
                'slug' => Str::slug(Str::limit('Nơi Nghỉ Chân Chất Lượng Khi Du Lịch Kon Tum', 30)),
                'desc' => 'Kon Tum là một điểm đến hấp dẫn khách du lịch bởi những cảnh quan hùng vỹ cùng nền văn hóa dân tộc đặc sắc và những người dân thân thiện, chất phác. Dưới đây là 5 khách sạn của thành phố Kon Tum được đánh giá tốt nhất trên Booking.com cho du khách tham khảo.',
                'content' => '<p>Tọa lạc tại vị trí đắc địa, Garden Hostel Đà Lạt cách vườn hoa Đà Lạt chỉ chưa đầy 600 m. Chùa Tàu Thiên Vương Cổ Sát chỉ cách khoảng 1.3 km, Chợ Đà Lạt cách khoảng 2km.</p>',
                'images' => 'San-chim-Vam-Ho-nhu-mot-buc-tranh-thien-nhien-hien-hoa-song-dong77.jpg | Trai-nghiem-kho-quen-tai-khu-du-lich-sinh-thai-con-Thoi-Son26.jpg',
                'tags' => 'du lịch kom tum',
                'category_id' => 2,
                'location_id' => 4,
                'admin_id' => 3,
                'created_at' => '2023-11-4 12:45:19',
                'view_count' => 4,
                'like_count' => 0,
                'dislike_count' => 0,
                'comment_count' => 0
            ],
            [
                'title' => 'Top Những Khách Sạn Không Gian Đẹp Gần Biển Và Chất Lượng Phục Vụ Tốt Tại Nha Trang',
                'slug' => Str::slug(Str::limit('Top Những Khách Sạn Không Gian Đẹp Gần Biển Và Chất Lượng Phục Vụ Tốt Tại Nha Trang', 30)),
                'desc' => 'Cùng tham khảo danh sách một số khách sạn background đẹp và chất lượng phục vụ đáp ứng đầy đủ nhu cầu khách hàng tại Nha Trang nhé!',
                'content' => '<p>Tọa lạc tại vị trí đắc địa, Garden Hostel Đà Lạt cách vườn hoa Đà Lạt chỉ chưa đầy 600 m. Chùa Tàu Thiên Vương Cổ Sát chỉ cách khoảng 1.3 km, Chợ Đà Lạt cách khoảng 2km.</p>',
                'images' => 'Boton-Blue-Hotel-Nha-Trang-991.jpg',
                'tags' => 'nha trang, hotel nha trang',
                'category_id' => 2,
                'location_id' => 5,
                'admin_id' => 4,
                'created_at' => now(),
                'view_count' => 5,
                'like_count' => 0,
                'dislike_count' => 0,
                'comment_count' => 0
            ],
        ]);
    }
}
