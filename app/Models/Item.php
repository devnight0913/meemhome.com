<?php

namespace App\Models;

use App\Traits\HasImage;
use App\Traits\HasSalesChannels;
use App\Traits\HasStatus;
use App\Traits\HasUuid;
use DateInterval;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Item extends Model
{
    use HasFactory;
    use HasImage;
    use HasUuid;
    use HasStatus;
    use HasSalesChannels;
    use SoftDeletes;

    const LIMIT = 45;
    const SIMILAR_ITEMS_CACHE_KEY = "similar_items";
    const DISCOUNT_ITEMS_CACHE_KEY = "discount_items";
    const LATEST_ITEMS_CACHE_KEY = "latest_items";
    const RANDOM_ITEMS_CACHE_KEY = "random_items";
    const CACHE_TTL = 60 * 60 * 24;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image_path',
        'name',
        'description',
        'price',
        'cost',
        'discount',
        'status',
        'in_stock',
        'category_id',
        'track_stock',
        'continue_selling_when_out_of_stock',
        'sku',
        'barcode',
        'code',
        'serial_number',
        'warranty_period',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'continue_selling_when_out_of_stock' => 'boolean',
        'track_stock' => 'boolean',
        'pos' => 'boolean',
        'website' => 'boolean',
        'android_app' => 'boolean',
        'ios_app' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'image_url',
        'sm_thumbnail_image_url',
        'thumbnail_image_url',
        'base_price',
        'view_original_price',
        'view_price',
        'has_discount',
        'is_new',
        'url',
        'page_title',
        'page_description',
        'page_keywords',
        'category_name',
        'search_name',
        'is_active',
        'is_drafted',
        'status',
        'avg_rating',
        'sum_rating',
    ];
    /**
     * Get the comments for the blog post.
     */
    public function additional_images()
    {
        return $this->hasMany(Image::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class)->withTrashed();
    }

    public function order_details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }


    /**
     * check if item has discount.
     *
     * @return bool
     */
    public function getHasDiscountAttribute(): bool
    {
        return $this->discount > 0;
    }

    /**
     * check if item is popular
     *
     * @return bool
     */
    public function getIsPopularAttribute(): bool
    {
        return $this->order_details()->count() > 2;
    }


    /**
     * get item base price.
     *
     * @return float
     */
    public function getBasePriceAttribute(): float
    {
        return $this->has_discount ?
            $this->price - ($this->discount / 100) * $this->price
            : $this->price;
    }


    /**
     * get item view price.
     *
     * @return string
     */
    public function getViewPriceAttribute(): string
    {
        return $this->base_price > 0 ? usd_money_format($this->base_price) : '';
    }
    /**
     * get item view price.
     *
     * @return string
     */
    public function getViewOriginalPriceAttribute(): string
    {
        return usd_money_format($this->price);
    }


    public function getUrlAttribute(): string
    {
        return route('item.show', $this->id);
    }

    public function getCategoryNameAttribute(): string
    {
        return $this->category->name;
    }

    public function getPageTitleAttribute()
    {
        if (!is_null($this->meta_title)) return $this->meta_title;
        return html_entity_decode(strip_tags(Str::limit($this->name, 69)));
    }

    public function getPageDescriptionAttribute()
    {
        if (!is_null($this->meta_description)) return $this->meta_description;
        return html_entity_decode(strip_tags(Str::limit($this->description, 319)));
    }

    public function getPageKeywordsAttribute()
    {
        if (!is_null($this->keywords)) return $this->keywords;
        return Str::limit(str_replace(' ', ', ', $this->name), 159);
    }

    /**
     * get isNew.
     *
     * @return bool
     */
    public function getIsNewAttribute(): bool
    {
        return $this->created_at >= today()->subDays(5);
    }

    /**
     * get cache key.
     *
     * @return string
     */
    public function getCacheKeyAttribute(): string
    {
        return "item-{$this->id}";
    }

    /**
     *
     * @return string
     */
    public function getWarrantyPeriodViewAttribute(): string
    {
        $sum = $this->warranty_period;

        // $start_date = new DateTime();
        // $end_date = (new $start_date)->add(new DateInterval("P{$days}D"));
        // $dd = date_diff($start_date, $end_date);
        // return $dd->y . " years " . $dd->m . " months " . $dd->d . " days";

        $years = floor($sum / 365);
        $months = floor(($sum - ($years * 365)) / 30.5);
        $days = ($sum - ($years * 365) - ($months * 30.5));

        $periodArray = [];
        if ($years > 0) {
            $periodArray['years'] = $years == 1 ? "{$years} Year" : "{$years} Years";
        }

        if ($months > 0) {
            $periodArray['months'] = $months == 1 ? "{$months} Month" : "{$months} Months";
        }

        if ($days > 0) {
            $periodArray['days'] = $days == 1 ? "{$days} Day" : "{$days} Days";
        }
        return implode(', ', $periodArray);
    }



    /**
     * get search name.
     *
     * @return string
     */
    public function getSearchNameAttribute(): string
    {
        $searchName = "{$this->name} {$this->category->name}";

        if ($this->has_discount) {
            $searchName = "{$searchName} Discount";
        }
        if ($this->is_new) {
            $searchName = "{$searchName} New";
        }
        if ($this->is_popular) {
            $searchName = "{$searchName} popular";
        }
        if ($this->sku) {
            $searchName = "{$searchName} {$this->sku}";
        }
        if ($this->barcode) {
            $searchName = "{$searchName} {$this->barcode}";
        }
        if ($this->code) {
            $searchName = "{$searchName} {$this->code}";
        }
        return $searchName;
    }

    public function getDateModifiedAttribute(): string|false
    {
        return gmdate('Y-m-d\TH:i:s\Z', strtotime($this->updated_at));
    }


    public function getAvailableAttribute(): bool
    {
        if (!$this->is_active || !$this->category->is_active) return false;
        if ($this->continue_selling_when_out_of_stock) return true;
        return !$this->in_stock <= 0;
    }

    /**
     *
     * @return mix
     */
    public function getAvgRatingAttribute()
    {
        $avg = $this->reviews()->avg('rating') ?? 0;
        return  round($avg, 0, PHP_ROUND_HALF_UP);
    }

    /**
     *
     * @return mix
     */
    public function getSumRatingAttribute()
    {
        return $this->reviews()->count();
    }
}
