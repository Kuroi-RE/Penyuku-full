<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class PenyuKitaController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::published()->with('user')->withCount(['likes', 'comments']);

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->has('category') && $request->category != '' && $request->category != 'all') {
            $query->where('category', $request->category);
        }

        // Get articles with pagination
        $articles = $query->latest()->paginate(9);

        // Get all categories
        $categories = Article::published()
            ->select('category')
            ->distinct()
            ->pluck('category');

        return view('penyukita.index', compact('articles', 'categories'));
    }
}
