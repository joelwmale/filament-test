<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Services\CommonMark\CommonMark;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ad extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public static function getForCurrentPage(): ?self
    {
        return Ad::getForPage(request()->path());
    }

    public static function booted()
    {
        static::saved(function (Ad $ad) {
            static::withoutEvents(function () use ($ad) {
                $ad->update(['html' => CommonMark::convertToHtml($ad->text, false)]);
            });
        });
    }

    public static function getForPage(string $url = ''): ?self
    {
        return static::getPageSpecificAd($url) ?? static::getSiteWideAd();
    }

    public static function getPageSpecificAd(string $url): ?self
    {
        return static::current()
            ->where('display_on_url', $url)
            ->first();
    }

    public static function getSiteWideAd(): ?self
    {
        return static::current()
            ->where(function (Builder $query) {
                $query
                    ->orWhereNull('display_on_url');
            })
            ->first();
    }

    public function scopeCurrent(Builder $query)
    {
        $now = now()->format('Y-m-d');

        $query
            ->where('active', true)
            ->where(function (Builder $query) {
                $query
                    ->orWhereNull('starts_at')
                    ->orWhereNull('ends_at');
            })->orWhere(function (Builder $query) use ($now) {
                $query
                    ->whereDate('starts_at', '<=', $now)
                    ->whereDate('ends_at', '>=', $now);
            });
    }

    public function getFormattedTextAttribute()
    {
        return CommonMark::convertToHtml($this->text);
    }

    public function getExcerptAttribute()
    {
        return Str::limit($this->text);
    }
}
