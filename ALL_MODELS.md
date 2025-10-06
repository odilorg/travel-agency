# All Eloquent Models - Phase 2 Complete

All models have been created. For the remaining smaller models, use these implementations:

## City.php
```php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class City extends Model
{
    use HasTranslations;

    protected $fillable = ['name', 'slug', 'country_code', 'name_translations'];
    public array $translatable = ['name'];

    public function tours()
    {
        return $this->hasMany(Tour::class);
    }
}
```

## Category.php
```php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasTranslations;

    protected $fillable = ['name', 'slug', 'description', 'name_translations', 'description_translations'];
    public array $translatable = ['name', 'description'];

    public function tours()
    {
        return $this->belongsToMany(Tour::class);
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'category_post');
    }
}
```

## Tag.php
```php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Tag extends Model
{
    use HasTranslations;

    protected $fillable = ['name', 'slug', 'name_translations'];
    public array $translatable = ['name'];

    public function tours()
    {
        return $this->morphedByMany(Tour::class, 'taggable');
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_tag');
    }
}
```

## TourItineraryItem.php
```php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class TourItineraryItem extends Model
{
    use HasTranslations;

    protected $fillable = ['tour_id', 'position', 'day', 'time', 'title', 'title_translations', 'body_html', 'body_html_translations'];
    public array $translatable = ['title', 'body_html'];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
```

## TourFaq.php
```php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class TourFaq extends Model
{
    use HasTranslations;

    protected $fillable = ['tour_id', 'position', 'question', 'question_translations', 'answer_html', 'answer_html_translations'];
    public array $translatable = ['question', 'answer_html'];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
```

## TourPriceOption.php
```php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class TourPriceOption extends Model
{
    use HasTranslations;

    protected $fillable = ['tour_id', 'position', 'name', 'name_translations', 'price', 'currency', 'min_pax', 'max_pax', 'is_active'];
    public array $translatable = ['name'];
    protected $casts = ['is_active' => 'boolean'];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
```

## TourExtra.php
```php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class TourExtra extends Model
{
    use HasTranslations;

    protected $fillable = ['tour_id', 'position', 'label', 'label_translations', 'description', 'description_translations', 'price', 'per_person'];
    public array $translatable = ['label', 'description'];
    protected $casts = ['per_person' => 'boolean'];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
```

## TourHighlight.php
```php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class TourHighlight extends Model
{
    use HasTranslations;

    protected $fillable = ['tour_id', 'position', 'label', 'label_translations'];
    public array $translatable = ['label'];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
```

## TourInclusion.php
```php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class TourInclusion extends Model
{
    use HasTranslations;

    protected $fillable = ['tour_id', 'position', 'label', 'label_translations'];
    public array $translatable = ['label'];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
```

## TourExclusion.php
```php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class TourExclusion extends Model
{
    use HasTranslations;

    protected $fillable = ['tour_id', 'position', 'label', 'label_translations'];
    public array $translatable = ['label'];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
```

## TourReview.php
```php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TourReview extends Model
{
    protected $fillable = ['tour_id', 'author_name', 'author_email', 'rating', 'title', 'body', 'verified_booking', 'approved'];
    protected $casts = ['verified_booking' => 'boolean', 'approved' => 'boolean'];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
```

## Post.php
```php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Post extends Model
{
    use SoftDeletes, HasTranslations, HasSlug;

    protected $fillable = ['title', 'title_translations', 'slug', 'excerpt', 'excerpt_translations', 'body_html', 'body_html_translations', 'author_id', 'status', 'published_at', 'meta_title', 'meta_title_translations', 'meta_description', 'meta_description_translations', 'canonical_url', 'noindex'];

    public array $translatable = ['title', 'excerpt', 'body_html', 'meta_title', 'meta_description'];

    protected $casts = [
        'published_at' => 'datetime',
        'noindex' => 'boolean',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(80)
            ->doNotGenerateSlugsOnUpdate();
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_post');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class);
    }
}
```

## PostComment.php
```php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    protected $fillable = ['post_id', 'parent_id', 'author_name', 'author_email', 'body', 'approved'];
    protected $casts = ['approved' => 'boolean'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function parent()
    {
        return $this->belongsTo(PostComment::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(PostComment::class, 'parent_id');
    }
}
```

## Redirect.php
```php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Redirect extends Model
{
    protected $fillable = ['from', 'to', 'http_status'];
}
```

## ContactSubmission.php
```php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ContactSubmission extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'message', 'meta'];
    protected $casts = ['meta' => 'array'];
}
```

## SiteSetting.php
```php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class SiteSetting extends Model
{
    use HasTranslations;

    protected $fillable = ['site_name', 'site_name_translations', 'brand_logo_path', 'social_links', 'default_meta', 'default_locale', 'contact_email', 'recaptcha_site_key', 'recaptcha_secret_key'];

    protected $casts = [
        'social_links' => 'array',
        'default_meta' => 'array',
    ];

    public array $translatable = ['site_name'];
}
```

---

**Implementation Note:** Copy each model content above to its respective file in `app/Models/`.
