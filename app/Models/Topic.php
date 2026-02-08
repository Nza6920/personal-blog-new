<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;

class Topic extends Model implements Feedable, Sitemapable
{
    use HasFactory;
    use Traits\HashIdHelper;

    protected $fillable = ['title', 'body', 'body_type', 'is_published'];

    protected $casts = [
        'created_at' => 'datetime',
        'is_published' => 'boolean',
        'updated_at' => 'datetime',
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function toFeedItem(): FeedItem
    {
        return FeedItem::create()
            ->id((string) $this->id)
            ->title($this->title)
            ->summary(make_excerpt(clean($this->body), 200))
            ->updated($this->updated_at ?? $this->created_at)
            ->link(route('topics.show', $this))
            ->authorName((string) optional($this->user)->name);
    }

    public static function getFeedItems()
    {
        return static::query()
            ->published()
            ->with('user')
            ->latest('id')
            ->limit(20)
            ->get();
    }

    public function toSitemapTag(): Url|string|array
    {
        return Url::create(route('topics.show', $this))
            ->setLastModificationDate($this->updated_at ?? $this->created_at);
    }
}
