# Accessible Resources for Laravel

This Laravel package allows you to control user access to various resources (like Product, Category, etc.) using a polymorphic relation, with smart caching and a global query macro.

---

## 🚀 Features

- Polymorphic many-to-many access: users can access multiple models like products, categories, etc.
- Global macro `withAccessibleTo()` for filtering data
- Smart daily cache for performance
- Central config file to define models and admin role

---

## 📦 Installation

1. Clone or download this package inside your Laravel project, e.g. under `packages/accessible-resources`.

2. Add this to your project's `composer.json`:

```json
"repositories": [
  {
    "type": "path",
    "url": "packages/accessible-resources"
  }
],
```

3. Require the package:

```bash
composer require nikan2010/accessible-resources:@dev
```

---

## ⚙️ Configuration

Publish the config and migration:

```bash
php artisan vendor:publish --tag=accessible-resources
php artisan migrate
```

Edit `config/accessible-resources.php` to define your models:

```php
'resources' => [
    'product' => \App\Models\Product::class,
    'category' => \App\Models\Category::class,
],

'admin_role' => 'admin',
```

---

## 🧩 Usage

### 1. Add Trait to User model:

```php
use AccessibleResources\Traits\HasAccessibleResources;

class User extends Authenticatable
{
    use HasAccessibleResources;
}
```

### 2. Assign Access to Resource

```php
$user->accessibleResources(\App\Models\Product::class)->attach($productId);
```

---

### 3. Use Macro in Queries

```php
$orders = Order::query()->withAccessibleTo(
    auth()->user(),
    'product', // relation name
    'product', // key from config file
    'product_id' // optional foreign key for belongsTo
)->get();
```

---

## 💡 Cache

Access is cached for 1 day per resource type. You can clear it manually:

```php
$user->clearCachedAccessibleResourceIds(\App\Models\Product::class);
```

---

## 📃 License

MIT – Free to use and modify.
