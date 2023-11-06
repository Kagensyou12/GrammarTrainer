<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class ArcadeController extends Controller
{
    public function index(){
        // if this is the first question
        if(session('game_running') == false){
            session(['game_running' => true]);
            session(['lives' => 3]);
            session(['score' => 0]);
            session(['answer' => '']);

            $question = Question::All()->random(1);
            $question = $question[0]->Question;
            session(['question'=>$question]);

            return view('arcade',[
                'score'=>session('score'),
                'lives'=>session('lives'),
                'question'=>$question
            ]);
        }
        // if this is next questions
        else{
            $answer = session('answer');
            // validate answer
            $valid = true;
            if(strlen($answer) < 1) $valid = false;
            // more conditions as needed

            if($valid == false){ // just return the current page, DO NOT ADVANCE
                return view('arcade',[
                    'score'=>session('score'),
                    'lives'=>session('lives'),
                    'question'=>session('question')
                ]);
            }else{ // safe to proceed
                $errors = app('App\Http\Controllers\APIController')->judge();
                $score = session('score');
                $lives = session('lives');

                if(sizeof($errors) == 0){ // correct answer
                    $score = $score + 1;
                    session(['score'=>$score]);

                    $question = Question::All()->random(1);
                    $question = $question[0]->Question;
                    session(['question'=>$question]);

                    return view('arcade',[
                        'score'=>session('score'),
                        'lives'=>session('lives'),
                        'question'=>$question
                    ]);
                }else{ // wrong answer
                    $lives = $lives - 1;
                    session(['lives'=>$lives]);

                    if($lives > 0){ // still alive
                        $question = Question::All()->random(1);
                        $question = $question[0]->Question;
                        session(['question'=>$question]);

                        return view('arcade',[
                            'score'=>session('score'),
                            'lives'=>session('lives'),
                            'question'=>$question
                        ]);
                    }else{ // game over
                        return view('arcadeover',[
                            'score'=>session('score')
                        ]);
                    }
                }
            }
        }
    }
}
