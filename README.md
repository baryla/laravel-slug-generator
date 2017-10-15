# Laravel Slug Generator
A little helper to generate a unique slug from the database

## How to use it

```php
use App\Helpers\Slug;

...

$slug = new Slug;
return $slug->generate(Product::class, $title);
```
