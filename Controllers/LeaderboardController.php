<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leaderboard;

class LeaderboardController extends Controller
{
    public function index()
    {
        $leaderboard = Leaderboard::orderBy('Score', 'desc')
            ->take(10) // Fetch only the top 10 scores
            ->get();

        return view('leaderboard', compact('leaderboard'));
    }

    public function saveScore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:1|max:5',
            'score' => 'required|integer',
        ]);

        Leaderboard::create([
            'Name' => $request->input('name'),
            'Score' => $request->input('score'),
        ]);

        return redirect()->route('home');
    }
}
