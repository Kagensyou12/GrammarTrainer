<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leaderboard;

class LeaderboardController extends Controller
{
    public function index(){
        // get top 10 scores in global leaderboard table
        $payload = Leaderboard::All();
        return view('leaderboard',['parcel' => $payload]);
    }
}
