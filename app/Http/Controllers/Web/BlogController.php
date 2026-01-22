<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Services\BlogService;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    protected $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }

    /**
     * Display blog posts listing with filters
     */
    public function index(Request $request)
    {
        $categorySlug = $request->get('category');
        $search = $request->get('search');
        
        $posts = $this->blogService->getPosts($categorySlug, $search);
        $categories = $this->blogService->getCategories();
        $recentPosts = $this->blogService->getRecentPosts(3);
        $featuredPosts = $this->blogService->getFeaturedPosts(3);

        // Get current category if filtering
        $currentCategory = null;
        if ($categorySlug) {
            $currentCategory = Category::where('slug', $categorySlug)->first();
        }

        // Append query parameters to pagination links
        $posts->appends($request->query());

        $title = 'Blog';
        if ($currentCategory) {
            $title = $currentCategory->name . ' - Blog';
        } elseif ($search) {
            $title = 'Search: ' . $search . ' - Blog';
        }

        return view('pages.blog', compact(
            'posts', 
            'categories', 
            'recentPosts', 
            'featuredPosts', 
            'currentCategory',
            'search',
            'title'
        ));
    }

    /**
     * Display individual blog post
     */
    public function show(Request $request, $slug)
    {
        try {
            $post = $this->blogService->getPostBySlug($slug);
            $categories = $this->blogService->getCategories();
            $relatedPosts = $this->blogService->getRelatedPosts($post, 3);
            $recentPosts = $this->blogService->getRecentPosts(5);

            // SEO Meta data
            $metaTitle = $post->meta_title ?: $post->title . ' - Pxp3 Blog';
            $metaDescription = $post->meta_description ?: $post->excerpt;

            return view('pages.blog-post', compact(
                'post', 
                'categories', 
                'relatedPosts',
                'recentPosts',
                'metaTitle',
                'metaDescription'
            ));

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404, 'Post not found');
        }
    }

    /**
     * Display posts by category
     */
    public function category(Request $request, $categorySlug)
    {
        try {
            $category = Category::where('slug', $categorySlug)->firstOrFail();
            $posts = $this->blogService->getPostByCategory($categorySlug);
            $categories = $this->blogService->getCategories();

            return view('pages.blog', compact(
                'posts', 
                'categories', 
                'category'
            ))->with('title', $category->name . ' - Blog');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404, 'Category not found');
        }
    }

    /**
     * Display posts by tag
     */
    public function tag(Request $request, $tagSlug)
    {
        try {
            $tag = Tag::where('slug', $tagSlug)->firstOrFail();
            $posts = $this->blogService->getPostByTag($tagSlug);
            $categories = $this->blogService->getCategories();

            return view('pages.blog', compact(
                'posts', 
                'categories', 
                'tag'
            ))->with('title', $tag->name . ' - Blog');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404, 'Tag not found');
        }
    }

    /**
     * Search posts
     */
    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:2|max:100'
        ]);

        $search = $request->get('q');
        $posts = $this->blogService->getPostBySearch($search);
        $categories = $this->blogService->getCategories();

        return view('pages.blog', compact(
            'posts', 
            'categories', 
            'search'
        ))->with('title', 'Search: ' . $search . ' - Blog');
    }
}
