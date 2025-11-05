<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource (Admin Panel)
     */
    public function index()
    {
        $articles = Article::with('user')
            ->where('user_id', Auth::id())
            ->withCount(['likes', 'comments'])
            ->latest()
            ->paginate(10);

        return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ['Kegiatan', 'Edukasi', 'Berita', 'Panduan', 'Penelitian'];
        return view('articles.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'category' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published'
        ]);

        $validated['user_id'] = Auth::id();
        $validated['slug'] = Str::slug($validated['title']);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('articles', 'public');
        }

        Article::create($validated);

        return redirect()->route('articles.index')->with('success', 'Artikel berhasil dibuat!');
    }

    /**
     * Display the specified resource (Detail Page).
     */
    public function show(Article $article)
    {
        // Increment views
        $article->incrementViews();

        // Load relationships
        $article->load(['user', 'comments.user', 'likes']);
        $article->loadCount(['likes', 'comments']);

        // Check if current user liked the article
        $isLiked = Auth::check() && $article->isLikedBy(Auth::user());

        // Related articles
        $relatedArticles = Article::published()
            ->where('category', $article->category)
            ->where('id', '!=', $article->id)
            ->withCount(['likes', 'comments'])
            ->limit(3)
            ->get();

        return view('articles.show', compact('article', 'isLiked', 'relatedArticles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        // Authorization check
        if ($article->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $categories = ['Kegiatan', 'Edukasi', 'Berita', 'Panduan', 'Penelitian'];
        return view('articles.edit', compact('article', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        // Authorization check
        if ($article->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'category' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published'
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            $validated['image'] = $request->file('image')->store('articles', 'public');
        }

        $article->update($validated);

        return redirect()->route('articles.index')->with('success', 'Artikel berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        // Authorization check
        if ($article->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete image if exists
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }

        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Artikel berhasil dihapus!');
    }

    /**
     * Toggle like on article
     */
    public function toggleLike(Article $article)
    {
        $user = Auth::user();
        $like = $article->likes()->where('user_id', $user->id)->first();

        if ($like) {
            $like->delete();
            $isLiked = false;
        } else {
            $article->likes()->create(['user_id' => $user->id]);
            $isLiked = true;
        }

        return response()->json([
            'success' => true,
            'isLiked' => $isLiked,
            'likesCount' => $article->likes()->count()
        ]);
    }

    /**
     * Store comment on article
     */
    public function storeComment(Request $request, Article $article)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $comment = $article->comments()->create([
            'user_id' => Auth::id(),
            'content' => $validated['content']
        ]);

        $comment->load('user');

        return response()->json([
            'success' => true,
            'comment' => $comment
        ]);
    }

    /**
     * Delete comment
     */
    public function destroyComment($commentId)
    {
        $comment = \App\Models\ArticleComment::findOrFail($commentId);

        // Authorization check
        if ($comment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $comment->delete();

        return response()->json(['success' => true]);
    }
}
