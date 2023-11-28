<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Xác nhận địa chỉ email')
                ->greeting('Xin chào ' . $notifiable->first_name . ',')
                ->line('Để hoàn tất bước thiết lập tài khoản và bắt đầu sử dụng Review Travel,')
                ->line('Vui lòng nhấn vào nút bên dưới để xác nhận địa chỉ email của bạn nhé.')
                ->action('Xác nhận email', $url)
                ->line('Nếu bạn không đăng ký tài khoản, bạn có thể bỏ qua email này.');
        });
    }
}
