# کیت توسعه نرم‌افزار (SDK) لاراول آرتا پیامک

این پکیج رسمی لاراول برای یکپارچه‌سازی آسان و سریع با سرویس پیامکی آرتا پیامک طراحی شده است. با استفاده از این SDK می‌توانید تمامی قابلیت‌های پنل پیامکی خود را در پروژه‌های لاراول مدیریت کنید.

## نصب و راه‌اندازی

برای نصب این پکیج، کافی است دستور زیر را در ترمینال پروژه خود اجرا کنید:

```bash
composer require ippanelcom/laravel-sdk
```

### استفاده در لاراول بدون Auto-discovery
اگر پروژه شما از قابلیت کشف خودکار (Auto-discovery) استفاده نمی‌کند، سرویس‌دهنده (Provider) را به فایل `config/app.php` اضافه کنید:

```php
'providers' => [
    // ...
    Ippanel\IppanelServiceProvider::class,
],

'aliases' => [
    // ...
    'IPPanel' => Ippanel\Facades\IPPanel::class,
],
```

### انتشار تنظیمات (Publishing)
برای دسترسی به فایل تنظیمات پکیج، دستور زیر را اجرا کنید تا فایل `config/ippanel.php` در پروژه شما ایجاد شود:

```bash
php artisan vendor:publish --provider="Ippanel\IppanelServiceProvider" --tag="config"
```

## پیکربندی (Configuration)
اطلاعات کاربری (API Key) خود را در فایل `.env` پروژه قرار دهید:

```env
IPPANEL_API_KEY=your-api-key
```

در صورت نیاز به تغییر آدرس پایه (Base URL) به صورت سفارشی، می‌توانید آن را نیز اضافه کنید:

```env
IPPANEL_BASE_URL=https://custom-url.com/v1/api
```

## راهنمای استفاده

### ۱. ارسال پیامک ساده (Webservice)
برای ارسال پیامک‌های عادی (مانند اطلاع‌رسانی یا تبلیغاتی) از این متد استفاده کنید:

```php
use Ippanel\Client;

public function sendSMS(Client $ippanel)
{
    $response = $ippanel->sendWebservice(
        'متن پیام شما', 
        '+981000xxxx', // شماره فرستنده
        ['+989123456789', '+989987654321'] // شماره گیرندگان
    );

    if ($response->isSuccessful()) {
        // پیام با موفقیت ارسال شد
        $data = $response->getData();
    } else {
        // مدیریت خطا
        $error = $response->getMessage();
    }
}
```

### ۲. ارسال پیامک از طریق الگو (Pattern)
برای ارسال پیامک‌های احراز هویت (OTP) یا اطلاع‌رسانی‌های سیستمی که از پیش در پنل تعریف شده‌اند:

```php
use Ippanel\Client;

public function sendPattern(Client $ippanel)
{
    $response = $ippanel->sendPattern(
        'pattern-code',  // کد الگوی ثبت شده در پنل
        '+981000xxxx',   // شماره فرستنده
        '+989123456789', // شماره گیرنده
        ['name' => 'فرید', 'code' => '12345'] // پارامترهای الگو
    );

    if ($response->isSuccessful()) {
        $data = $response->getData();
    } else {
        // خطای ارسال
    }
}
```

### ۳. ارسال پیامک صوتی (Voice OTP)
برای ارسال رمز یکبار مصرف به صورت تماس صوتی:

```php
use Ippanel\Client;

public function sendVoiceOTP(Client $ippanel)
{
    $response = $ippanel->sendVOTP(
        12345, // کد OTP
        '+989123456789' // شماره مقصد
    );

    if ($response->isSuccessful()) {
        $data = $response->getData();
    } else {
        // خطای ارسال
    }
}
```

## ساختار پاسخ‌ها (Response Structure)
هر فراخوانی به API، یک آبجکت از نوع `SendResponse` بازمی‌گرداند که متدهای زیر را برای بررسی پاسخ در اختیار شما می‌گذارد:

- `isSuccessful()`: بازگشت مقدار `true` در صورت موفقیت‌آمیز بودن درخواست.
- `getData()`: دسترسی به داده‌های دریافتی از سرور.
- `getMeta()`: دریافت اطلاعات جانبی و متادیتای پاسخ.
- `getMessage()`: دریافت متن پیام پاسخ.
- `getMessageCode()`: کد وضعیت پیام.
- `getMessageParameters()`: پارامترهای مرتبط با پیام.

## لایسنس
این پکیج تحت لایسنس **MIT** منتشر شده است.
