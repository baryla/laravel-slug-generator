# Laravel Slug Generator
A little helper to generate a unique slug from the database

## How to use it

If you want to generate a new unique slug:

```php
use App\Helpers\Slug;

...

$title = "Some title";
$slug = new Slug;
return $slug->generate(Product::class, $title);
```

You can also pass a 3rd param to check against an object such as a Product.

```php
use App\Helpers\Slug;
use App\Product;

...

$title = "Some title";
$product = Product::find(1);
$slug = new Slug;
return $slug->generate(Product::class, $title, $product);
```

What this will do is check whether the slug is already taken and if it is taken, check whether the slug from the **$product** object is the same as the slug we want to generate, and if it is the same, there's no need to generate a new one.

If you have any questions/feedback send me an email to adrianrbarylski@gmail.com
