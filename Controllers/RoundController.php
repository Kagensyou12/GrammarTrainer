<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoundController extends Controller
{
    public function index(){
        if(session('game_running') == false){
            session(['game_running' => true]);
            session(['round' => 1]);
            session(['score' => 0]);
            session(['answer' => '']);

            $question = Question::where('Difficulty','=','1')->random(1);
            $question = $question[0]->Question;
            session(['question'=>$question]);

            return view('arcade',[
                'score'=>session('score'),
                'lives'=>session('lives'),
                'question'=>$question
            ]);
        }
    }
}
