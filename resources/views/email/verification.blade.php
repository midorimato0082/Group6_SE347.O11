<table width="100%">
    <tbody>
        <tr>
            <td><h1 style="font-size: 40px">Review Travel</h1></td>
        </tr>
        <tr>
            <td><h2 style="font-size: 24px">Bạn đã gần hoàn thành rồi!</h2></td>
        </tr>
        <tr>
            <td><p>Xin chào {{ $firstname }},</p></td>
        </tr>
        <tr>
            <td style="border-bottom: 1px solid #e5e5e5">
                <p>Để hoàn tất bước thiết lập tài khoản và bắt đầu sử dụng Review Travel,<br>
                    hãy xác nhận rằng chúng tôi đã nhận được đúng email của bạn.
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <a href="{{ route('verify', $code) }}" style="background-color: #f68a39; color: white; display:inline-block; font-family: sans-serif; font-size: 14px; line-height: 40px; text-align: center; text-decoration: none; cursor: pointer; border-radius: 5px; margin-top: 20px; padding: 0 10px">
                    Xác minh email của bạn
                </a>
            </td>
        </tr>
    </tbody>
</table>
