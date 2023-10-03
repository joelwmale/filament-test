<?php

namespace App\Models;

use Illuminate\Support\Facades\Bus;
use App\Services\CommonMark\CommonMark;
use Illuminate\Database\Eloquent\Model;
use Spatie\ResponseCache\Facades\ResponseCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FAQ extends Model
{
    use HasFactory;

    protected $table = 'faqs';
    protected $guarded = [];

    public static function booted()
    {
        static::saved(function (FAQ $faq) {
            static::withoutEvents(function () use ($faq) {
                $html = CommonMark::convertToHtml($faq->content, highlightCode: true);

                // find any twitter handles and convert them to links
                $html = preg_replace('/@([a-zA-Z0-9_]+)/', '<a href="https://twitter.com/$1">@$1</a>', $html);

                $faq->update(['answer' => $html]);
            });

            Bus::chain([
                fn () => ResponseCache::clear(),
            ])->dispatch();
        });
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Relationships
     */
    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(Location::class, 'faq_locations', 'faq_id', 'location_id')->withTimestamps();
    }
}
