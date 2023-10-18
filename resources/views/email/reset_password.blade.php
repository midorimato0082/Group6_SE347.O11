<table width="100%">
    <tbody>
        <tr>
            <td align="center"><h1 style="font-size: 40px">Review Travel</h1></td>
        </tr>
        <tr>
            <td align="center"><p>Xin chào {{ $firstname }}, có phải bạn muốn đặt lại mật khẩu?</p></td>
        </tr>
        <tr>
            <td align="center" style="border-bottom: 1px solid #e5e5e5">
                <p>Có người (hy vọng là bạn) đã yêu cầu chúng tôi đặt lại mật khẩu cho tài khoản Review Travel của bạn. <br>
                    Vui lòng nhấp vào nút bên dưới để làm điều đó. <br>
                    Nếu không yêu cầu đặt lại mật khẩu, bạn có thể bỏ qua email này!
                </p>
            </td>
        </tr>
        <tr>
            <td align="center">
                <a href="{{ route('viewreset', [$email, $code]) }}" style="background-color: #f68a39; color: white; display:inline-block; font-family: sans-serif; font-size: 14px; line-height: 40px; text-align: center; text-decoration: none; cursor: pointer; border-radius: 5px; margin-top: 20px; padding: 0 10px">
                    Đặt lại mật khẩu của bạn
                </a>
            </td>
        </tr>
    </tbody>
</table>
