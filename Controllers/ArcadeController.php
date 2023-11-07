<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class ArcadeController extends Controller
{
    public function index(Request $request){
        // if this is the first question
        if(session('game_running') == false){
            session(['game_running' => true]);
            session(['lives' => 3]);
            session(['score' => 0]);
            session(['answer' => '']);

            $questions = Question::All();
            $arr = range(1,count($questions));
            session(['avail_qs'=>$arr]);

            $question = app('App\Http\Controllers\QuestionController')->give();
            session(['question'=>$question]);

            return view('arcade',[
                'score'=>session('score'),
                'lives'=>session('lives'),
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
                $lives = session('lives');

                if(sizeof($errors) == 0){ // correct answer
                    $score = $score + 1;
                    session(['score'=>$score]);

                    $question = app('App\Http\Controllers\QuestionController')->give();
                    session(['question'=>$question]);

                    if($question == 'EOF'){ // beat arcade mode
                        return view('arcadeover',[
                            'message'=>'You beat arcade mode!',
                            'score'=>session('score')
                        ]);
                    }else{ // display next question
                        return view('arcade',[
                            'score'=>session('score'),
                            'lives'=>session('lives'),
                            'message'=>'',
                            'question'=>$question
                        ]);
                    }
                }else{ // wrong answer
                    $lives = $lives - 1;
                    session(['lives'=>$lives]);

                    if($lives > 0){ // still alive
                        $question = app('App\Http\Controllers\QuestionController')->give();
                        session(['question'=>$question]);

                        return view('arcade',[
                            'score'=>session('score'),
                            'lives'=>session('lives'),
                            'message'=>'',
                            'question'=>$question
                        ]);
                    }else{ // game over
                        return view('arcadeover',[
                            'message'=>'Game Over, you ran out of lives!',
                            'score'=>session('score')
                        ]);
                    }
                }
            }else{
                $message = '';
                if($valid == 'empty') $message = 'Please do not submit empty string';
                else if($valid == 'different') $message = 'Too far from original string';

                return view('arcade',[
                    'score'=>session('score'),
                    'lives'=>session('lives'),
                    'question'=>session('question'),
                    'message'=>$message
                ]);
            }
        }
    }
}