<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TagController extends Controller
{
    /**
     * Display list of tags in admin
     */
    public function index(Request $request)
    {
        $query = Tag::withCount('posts')
            ->orderBy('name', 'asc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        $tags = $query->paginate($request->get('per_page', 15));

        return view('pages.admin.tags.index', compact('tags'));
    }

    /**
     * Display form to create new tag
     */
    public function create()
    {
        return view('pages.admin.tags.create');
    }

    /**
     * Save new tag
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:tags,name',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only(['name']);
        $data['slug'] = Str::slug($data['name']);

        Tag::create($data);

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag criada com sucesso!');
    }

    /**
     * Display specific tag
     */
    public function show($id)
    {
        $tag = Tag::withCount('posts')->findOrFail($id);
        $posts = $tag->posts()->with('user', 'category')->latest()->paginate(5);
        
        return view('pages.admin.tags.show', compact('tag', 'posts'));
    }

    /**
     * Display form to edit tag
     */
    public function edit($id)
    {
        $tag = Tag::findOrFail($id);
        
        return view('pages.admin.tags.edit', compact('tag'));
    }

    /**
     * Update tag
     */
    public function update(Request $request, $id)
    {
        $tag = Tag::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:tags,name,' . $id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only(['name']);
        
        // Update slug if name changed
        if ($data['name'] !== $tag->name) {
            $data['slug'] = Str::slug($data['name']);
        }

        $tag->update($data);

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag atualizada com sucesso!');
    }

    /**
     * Delete tag
     */
    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        
        // Tag can be deleted even if it has posts (will just detach from posts)
        $tag->delete();

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag excluída com sucesso!');
    }
} 