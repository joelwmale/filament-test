<?php

namespace App\Models;

use Spatie\Tags\Tag;
use Spatie\Tags\HasTags;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Bus;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Actions\ConvertPostTextToHtmlAction;
use Spatie\ResponseCache\Facades\ResponseCache;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BlogPost extends Model
{
    use HasFactory;

    // use InteractsWithMedia;
    use HasTags;

    // public const PATH = 'blog-posts';

    public const STATUS_DRAFT = 'draft';

    public const STATUS_PUBLISHED = 'published';

    protected $guarded = [];
    protected $casts = [
        'published_at' => 'date',
    ];

    public static function booted()
    {
        static::creating(function (BlogPost $blogPost) {
            $blogPost->preview_secret = Str::random(10);
        });

        static::saved(function (BlogPost $blogPost) {
            static::withoutEvents(function () use ($blogPost) {
                (new ConvertPostTextToHtmlAction())->execute($blogPost);

                if ($blogPost->status == self::STATUS_PUBLISHED && ! $blogPost->published_at) {
                    $blogPost->update([
                        'published_at' => now(),
                    ]);
                }
            });

            Bus::chain([
                fn () => ResponseCache::clear(),
            ])->dispatch();
        });
    }

    /**
     * Attributes
     */
    public function getEmojiAttribute(): string
    {
        if ($this->external_url) {
            return '🔗';
        }

        $emojis = [
            '🚀',
            '🔥',
        ];

        return $emojis[array_rand($emojis)];
    }

    // public function getImageUrlAttribute()
    // {
    //     $media = $this->getMedia(self::PATH)->first();

    //     if (! empty($media)) {
    //         return $media->getFullUrl();
    //     }

    //     return null;
    // }

    public function getPublishedAttribute(): bool
    {
        return $this->status === self::STATUS_PUBLISHED;
    }

    public function getTimeToReadAttribute(): int
    {
        $wordCount = str_word_count(strip_tags($this->content));

        return round($wordCount / 200) > 1 ? round($wordCount / 200) : 1;
    }

    public function previewUrl(): Attribute
    {
        return new Attribute(function () {
            return route('blog.show', $this) . "?preview_secret={$this->preview_secret}";
        });
    }

    public function adminPreviewUrl(): string
    {
        return $this->published ? $this->url : $this->preview_url;
    }

    public function url(): Attribute
    {
        return new Attribute(function () {
            return route('blog.show', $this);
        });
    }

    /**
     * Functions
     */
    public function ogImageBaseUrl(): string
    {
        return route('blog.ogImage', $this);
    }

    public function toTweet(): string
    {
        $tags = $this->tags
            ->map(fn (Tag $tag) => $tag->name)
            ->map(fn (string $tagName) => '#' . str_replace(' ', '', $tagName))
            ->implode(' ');

        return $this->emoji . ' ' . $this->title
            . PHP_EOL . PHP_EOL . $this->url
            . PHP_EOL . PHP_EOL . $tags;
    }

    /**
     * Scopes
     */
    public function scopePublished($query)
    {
        return $query->where('status', self::STATUS_PUBLISHED);
    }

    /**
     * Relationships
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'blog_post_categories', 'blog_post_id', 'category_id')->withTimestamps();
    }
}
