<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'cover_image',
        'meta_title',
        'meta_description',
        'user_id',
        'category_id',
        'published',
        'published_at',
        'views'
    ];

    protected $casts = [
        'published' => 'boolean',
        'published_at' => 'datetime',
        'views' => 'integer',
    ];

    protected $dates = [
        'published_at',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('published', true)
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    public function scopeByCategory($query, $categorySlug)
    {
        return $query->whereHas('category', function ($q) use ($categorySlug) {
            $q->where('slug', $categorySlug);
        });
    }

    public function scopeByTag($query, $tagSlug)
    {
        return $query->whereHas('tags', function ($q) use ($tagSlug) {
            $q->where('slug', $tagSlug);
        });
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('excerpt', 'like', "%{$search}%")
              ->orWhere('content', 'like', "%{$search}%");
        });
    }

    public function scopeRecent($query, $limit = 5)
    {
        return $query->published()
                    ->latest('published_at')
                    ->limit($limit);
    }

    // Mutators
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    // Accessors
    public function getExcerptAttribute($value)
    {
        return $value ?: Str::limit(strip_tags($this->content), 150);
    }

    public function getReadingTimeAttribute()
    {
        $wordCount = str_word_count(strip_tags($this->content));
        return ceil($wordCount / 200); // Assuming 200 words per minute
    }

    public function getCoverImageUrlAttribute()
    {
        return $this->cover_image 
            ? asset('storage/' . $this->cover_image)
            : asset('img/webp/abstract7.webp');
    }

    // Helper methods
    public function incrementViews()
    {
        $this->increment('views');
    }

    public function getRelatedPosts($limit = 3)
    {
        return self::published()
                   ->where('category_id', $this->category_id)
                   ->where('id', '!=', $this->id)
                   ->latest('published_at')
                   ->limit($limit)
                   ->get();
    }

    public function isPublished()
    {
        return $this->published && 
               $this->published_at && 
               $this->published_at <= now();
    }
}
