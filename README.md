# 🎯 پکیج Accessible Resources برای لاراول

این پکیج به شما اجازه می‌دهد دسترسی کاربران به منابع مختلف (مثل محصولات، دسته‌بندی‌ها و ...) را با استفاده از رابطه‌ی چندشکلی (polymorphic) و کش هوشمند مدیریت کنید.

---

## ✅ امکانات

- پشتیبانی از چند مدل مختلف به‌صورت polymorphic (مثل Product, Category و ...)
- ماکروی `withAccessibleTo()` برای فیلتر کردن داده‌ها در همه مدل‌ها
- کش هوشمند برای افزایش کارایی
- فایل تنظیمات برای تعریف مدل‌ها و نقش ادمین

---

## 🔧 نصب پکیج

۱. پکیج را داخل پوشه‌ی `packages/accessible-resources` در پروژه لاراول خود قرار دهید.

۲. فایل `composer.json` پروژه‌تان را ویرایش کرده و این قسمت را اضافه کنید:

```json
"repositories": [
  {
    "type": "path",
    "url": "packages/accessible-resources"
  }
],
```

۳. نصب پکیج با composer:

```bash
composer require nikan2010/accessible-resources:@dev
```

---

## ⚙️ پیکربندی

برای انتشار فایل‌های تنظیمات و مهاجرت (migration):

```bash
php artisan vendor:publish --tag=accessible-resources
php artisan migrate
```

سپس فایل `config/accessible-resources.php` را ویرایش کنید:

```php
'resources' => [
    'product' => \App\Models\Product::class,
    'category' => \App\Models\Category::class,
],

'admin_role' => 'admin',
```

---

## 🧩 استفاده

### ۱. افزودن Trait به مدل User

```php
use AccessibleResources\Traits\HasAccessibleResources;

class User extends Authenticatable
{
    use HasAccessibleResources;
}
```

### ۲. اختصاص دسترسی

```php
$user->accessibleResources(\App\Models\Product::class)->attach($productId);
```

---

### ۳. استفاده از ماکرو در کوئری‌ها

```php
$orders = Order::query()->withAccessibleTo(
    auth()->user(),
    'product', // نام رابطه
    'product', // کلید تعریف‌شده در فایل config
    'product_id' // (اختیاری) برای روابط belongsTo
)->get();
```

---

## 📦 کش هوشمند

دسترسی کاربر برای هر منبع تا ۱ روز کش می‌شود. برای پاک‌سازی دستی کش:

```php
$user->clearCachedAccessibleResourceIds(\App\Models\Product::class);
```

---

## 📃 مجوز استفاده

کد این پکیج آزاد است (MIT License) و می‌توانید آزادانه در پروژه‌های شخصی و تجاری استفاده کنید.
