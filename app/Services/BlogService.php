<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Facades\Cache;

class BlogService
{
    /**
     * Get paginated published posts with optional filters
     */
    public function getPosts($categorySlug = null, $search = null, $perPage = 9)
    {
        $query = Post::with(['category', 'tags', 'user'])
                    ->published()
                    ->latest('published_at');

        if ($categorySlug) {
            $query->byCategory($categorySlug);
        }

        if ($search) {
            $query->search($search);
        }

        return $query->paginate($perPage);
    }

    /**
     * Get published post by slug
     */
    public function getPostBySlug($slug)
    {
        $post = Post::with(['category', 'tags', 'user'])
                   ->where('slug', $slug)
                   ->published()
                   ->firstOrFail();

        // Increment views
        $post->incrementViews();

        return $post;
    }

    /**
     * Get all categories with post count
     */
    public function getCategories()
    {
        return Cache::remember('blog_categories', 60 * 60, function () {
            return Category::withCount(['posts' => function ($query) {
                $query->published();
            }])
            ->having('posts_count', '>', 0)
            ->orderBy('name')
            ->get();
        });
    }

    /**
     * Get all tags with post count
     */
    public function getTags()
    {
        return Cache::remember('blog_tags', 60 * 60, function () {
            return Tag::withCount(['posts' => function ($query) {
                $query->published();
            }])
            ->having('posts_count', '>', 0)
            ->orderBy('name')
            ->get();
        });
    }

    /**
     * Get posts by category slug
     */
    public function getPostByCategory($categorySlug, $perPage = 9)
    {
        return Post::with(['category', 'tags', 'user'])
                  ->published()
                  ->byCategory($categorySlug)
                  ->latest('published_at')
                  ->paginate($perPage);
    }

    /**
     * Get posts by tag slug
     */
    public function getPostByTag($tagSlug, $perPage = 9)
    {
        return Post::with(['category', 'tags', 'user'])
                  ->published()
                  ->byTag($tagSlug)
                  ->latest('published_at')
                  ->paginate($perPage);
    }

    /**
     * Search posts
     */
    public function getPostBySearch($search, $perPage = 9)
    {
        return Post::with(['category', 'tags', 'user'])
                  ->published()
                  ->search($search)
                  ->latest('published_at')
                  ->paginate($perPage);
    }

    /**
     * Get recent posts
     */
    public function getRecentPosts($limit = 5)
    {
        return Cache::remember("recent_posts_{$limit}", 60 * 30, function () use ($limit) {
            return Post::with(['category', 'user'])
                      ->recent($limit)
                      ->get();
        });
    }

    /**
     * Get related posts for a given post
     */
    public function getRelatedPosts(Post $post, $limit = 3)
    {
        return $post->getRelatedPosts($limit);
    }

    /**
     * Get featured posts (most viewed)
     */
    public function getFeaturedPosts($limit = 5)
    {
        return Cache::remember("featured_posts_{$limit}", 60 * 60, function () use ($limit) {
            return Post::with(['category', 'user'])
                      ->published()
                      ->orderBy('views', 'desc')
                      ->limit($limit)
                      ->get();
        });
    }

    /**
     * Get blog statistics
     */
    public function getBlogStats()
    {
        return Cache::remember('blog_stats', 60 * 60, function () {
            return [
                'total_posts' => Post::published()->count(),
                'total_categories' => Category::withCount(['posts' => function ($query) {
                    $query->published();
                }])->having('posts_count', '>', 0)->count(),
                'total_tags' => Tag::withCount(['posts' => function ($query) {
                    $query->published();
                }])->having('posts_count', '>', 0)->count(),
                'total_views' => Post::published()->sum('views'),
            ];
        });
    }

    /**
     * Clear blog cache
     */
    public function clearCache()
    {
        Cache::forget('blog_categories');
        Cache::forget('blog_tags');
        Cache::forget('blog_stats');
        
        // Clear recent and featured posts cache
        for ($i = 1; $i <= 10; $i++) {
            Cache::forget("recent_posts_{$i}");
            Cache::forget("featured_posts_{$i}");
        }
    }
}