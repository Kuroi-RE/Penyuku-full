<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    /**
     * Display user profile
     */
    public function show(User $user)
    {
        // Load user dengan posts
        $user->load(['posts' => function($query) {
            $query->withCount(['likes', 'comments'])
                ->with(['likes', 'comments.user'])
                ->latest();
        }]);

        // Hitung statistik
        $stats = [
            'total_posts' => $user->posts->count(),
            'total_likes' => $user->posts->sum('likes_count'),
            'total_comments' => $user->posts->sum('comments_count'),
        ];

        return view('profile.show', compact('user', 'stats'));
    }
}