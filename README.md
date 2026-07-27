این فایل `README.md` نهایی و فارسی‌سازی شده برای پروژه شماست. تمام بخش‌ها با برندینگ **آرتا پیامک** بازنویسی شده است.

آن را کپی کرده و جایگزین محتوای قبلی فایل `README.md` کنید:


# کیت توسعه نرم‌افزار آرتا پیامک (ArtaPayamak Laravel SDK)

پکیج رسمی لاراول برای اتصال آسان و سریع به درگاه پیامکی و صوتی **آرتا پیامک**. این ابزار به شما کمک می‌کند تا به راحتی پیامک‌های معمولی، پیامک‌های الگویی (Pattern) و کدهای تایید صوتی (Voice OTP) را ارسال کنید.

## نصب

برای نصب پکیج، دستور زیر را در ترمینال پروژه خود اجرا کنید:

```bash
composer require artapayamak/laravel-sdk
```

### نصب در لاراول بدون Auto-Discovery

اگر از قابلیت کشف خودکار (Auto-Discovery) استفاده نمی‌کنید، کلاس‌های زیر را به آرایه `providers` و `aliases` در فایل `config/app.php` اضافه کنید:

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

### انتشار فایل تنظیمات

برای شخصی‌سازی تنظیمات، فایل پیکربندی را منتشر کنید:

```bash
php artisan vendor:publish --provider="Ippanel\IppanelServiceProvider" --tag="config"
```

این دستور فایل `config/ippanel.php` را در پروژه شما ایجاد می‌کند.

## پیکربندی

مقادیر زیر را در فایل `.env` پروژه خود قرار دهید:

```env
# کلید API آرتا پیامک
IPPANEL_API_KEY=your-api-key

# URL پایه (اختیاری)
IPPANEL_BASE_URL=https://ippanel.com/api/v1
```

## راهنمای استفاده

### ارسال پیامک ساده (Webservice)

```php
use Ippanel\Client;

public function sendSMS(Client $ippanel)
{
    $response = $ippanel->sendWebservice(
        'پیام تست از طرف آرتا پیامک', 
        '+981000xxxx', // شماره فرستنده
        ['+989123456789'] // شماره گیرندگان
    );

    if ($response->isSuccessful()) {
        $data = $response->getData();
        // پیام با موفقیت ارسال شد
    } else {
        $error = $response->getMessage();
    }
}
```

### ارسال پیامک الگویی (Pattern)

```php
use Ippanel\Client;

public function sendPattern(Client $ippanel)
{
    $response = $ippanel->sendPattern(
        'pattern-code',  // کد الگو
        '+981000xxxx',   // شماره فرستنده
        '+989123456789', // شماره گیرنده
        ['name' => 'کاربر گرامی', 'code' => '12345'] // پارامترهای الگو
    );

    if ($response->isSuccessful()) {
        // الگو با موفقیت ارسال شد
    }
}
```

### ارسال کد تایید صوتی (Voice OTP)

```php
use Ippanel\Client;

public function sendVoiceOTP(Client $ippanel)
{
    $response = $ippanel->sendVOTP(
        12345, // کد تایید
        '+989123456789' // شماره گیرنده
    );

    if ($response->isSuccessful()) {
        // تماس صوتی با موفقیت انجام شد
    }
}
```

## ساختار پاسخ (Response)

هر متد یک شیء `SendResponse` برمی‌گرداند که شامل متدهای زیر است:
ساختار پاسخ (Response)
هر فراخوانی API یک شیء SendResponse برمی‌گرداند که شامل متدهای زیر است:


- `isSuccessful()`: وضعیت موفقیت درخواست (Boolean).
- `getData()`: بازگرداندن داده‌های پاسخ.
- `getMeta()`: بازگرداندن اطلاعات فراداده (Meta) پاسخ.
- `getMessage()`: بازگرداندن متن پیام خطا یا موفقیت.
- `getMessageCode()`: بازگرداندن کد اختصاصی پیام.
- `getMessageParameters()`: بازگرداندن پارامترهای مرتبط با پیام.

## پشتیبانی

برای گزارش مشکلات یا دریافت راهنمایی بیشتر به [سایت آرتا پیامک](https://artapayamak.com) مراجعه کنید.

## مجوز (License)

این پروژه تحت مجوز **MIT** منتشر شده است.
