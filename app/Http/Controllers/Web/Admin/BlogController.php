<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display list of blog posts in admin
     */
    public function index(Request $request)
    {
        $query = Post::with(['category', 'tags', 'user'])
            ->orderBy('created_at', 'desc');

        // Apply filters
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('status')) {
            $status = $request->status;
            if ($status === 'published') {
                $query->where('published', true);
            } elseif ($status === 'draft') {
                $query->where('published', false);
            } elseif ($status === 'scheduled') {
                $query->where('published', true)
                      ->where('published_at', '>', now());
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $posts = $query->paginate($request->get('per_page', 10));
        $categories = Category::all();

        return view('pages.admin.blog.index', compact('posts', 'categories'));
    }

    /**
     * Display form to create new post
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        
        return view('pages.admin.blog.create', compact('categories', 'tags'));
    }

    /**
     * Save new post
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'cover_image' => 'nullable|image|max:10000',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'status' => 'required|in:draft,published,scheduled',
            'published_at' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only([
            'title', 'excerpt', 'content', 'category_id', 
            'meta_title', 'meta_description', 'published_at'
        ]);

        // Convert status to published field
        $status = $request->input('status');
        $data['published'] = ($status === 'published');
        
        // Handle published_at based on status
        if ($status === 'published' && !$data['published_at']) {
            $data['published_at'] = now();
        } elseif ($status === 'draft') {
            $data['published_at'] = null;
        }

        // Generate slug
        $data['slug'] = Str::slug($data['title']);
        $data['user_id'] = Auth::id();

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')
                ->store('blog/covers', 'public');
        }

        $post = Post::create($data);

        // Attach tags
        if ($request->has('tags')) {
            $post->tags()->sync($request->tags);
        }

        return redirect()->route('admin.blog.index')
            ->with('success', 'Post created successfully!');
    }

    /**
     * Display specific post
     */
    public function show($id)
    {
        $post = Post::with(['category', 'tags', 'user'])->findOrFail($id);
        
        return view('pages.admin.blog.show', compact('post'));
    }

    /**
     * Display form to edit post
     */
    public function edit($id)
    {
        $post = Post::with(['category', 'tags'])->findOrFail($id);
        $categories = Category::all();
        $tags = Tag::all();
        
        return view('pages.admin.blog.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update post
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'cover_image' => 'nullable|image|max:10000',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'status' => 'required|in:draft,published,scheduled',
            'published_at' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only([
            'title', 'excerpt', 'content', 'category_id', 
            'meta_title', 'meta_description', 'published_at'
        ]);

        // Convert status to published field
        $status = $request->input('status');
        $data['published'] = ($status === 'published');
        
        // Handle published_at based on status
        if ($status === 'published' && !$data['published_at']) {
            $data['published_at'] = now();
        } elseif ($status === 'draft') {
            $data['published_at'] = null;
        }

        // Update slug if title changed
        if ($data['title'] !== $post->title) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            // Delete old image
            if ($post->cover_image) {
                Storage::disk('public')->delete($post->cover_image);
            }
            
            $data['cover_image'] = $request->file('cover_image')
                ->store('blog/covers', 'public');
        }

        $post->update($data);

        // Update tags
        if ($request->has('tags')) {
            $post->tags()->sync($request->tags);
        } else {
            $post->tags()->detach();
        }

        return redirect()->route('admin.blog.index')
            ->with('success', 'Post updated successfully!');
    }

    /**
     * Delete post
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        
        // Delete cover image
        if ($post->cover_image) {
            Storage::disk('public')->delete($post->cover_image);
        }
        
        $post->delete();

        return redirect()->route('admin.blog.index')
            ->with('success', 'Post deleted successfully!');
    }
} 