<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class RoundController extends Controller
{
    public function index(Request $request){
        // if this is the first round
        if(session('game_running') == false){
            session(['game_running' => true]);
            session(['round' => 1]);
            session(['score' => 0]);
            session(['answer' => '']);

            $questions = Question::where('Difficulty','=',strval(session('difficulty')))->get();
            $arr = range(1,count($questions));
            session(['avail_qs'=>$arr]);

            $question = app('App\Http\Controllers\QuestionController')->give();
            session(['question'=>$question]);

            return view('round',[
                'score'=>session('score'),
                'round'=>session('round'),
                'difficulty'=>session('difficulty'),
                'question'=>$question,
                'message'=>''
            ]);
        }
        // if this is next questions
        else{
            $answer = $request->input('user_input'); // Get the user's input
            session(['answer' => $answer]);// Store it in the session

            // validate answer
            $valid = app('App\Http\Controllers\ValidationController')->isvalid($answer);

            if($valid == 'valid'){ // valid answer
                $errors = app('App\Http\Controllers\APIController')->judge();
                $score = session('score');
                $round = session('round');

                if(sizeof($errors) == 0){ // correct answer
                    $score = $score + 1;
                    session(['score'=>$score]);
                }

                $round = $round + 1;
                session(['round'=>$round]);
                if($round > 10){ // gameover
                    return view('roundover',[
                        'score'=>session('score')
                    ]);
                }else{ // continue
                    $question = app('App\Http\Controllers\QuestionController')->give();
                    session(['question'=>$question]);

                    return view('round',[
                        'score'=>session('score'),
                        'round'=>session('round'),
                        'difficulty'=>session('difficulty'),
                        'question'=>$question,
                        'message'=>''
                    ]);
                }
            }else{ // invalid answer
                $message = '';
                if($valid == 'empty') $message = 'Please do not submit empty string';
                else if($valid == 'different') $message = 'Too far from original string';

                return view('round',[
                    'score'=>session('score'),
                    'round'=>session('round'),
                    'difficulty'=>session('difficulty'),
                    'question'=>session('question'),
                    'message'=>$message
                ]);
            }
        }
    }
}
