<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends Controller
{
    public function give(){
        $arr = session('avail_qs');
        if(count($arr) < 1) return 'EOF';
        $qidx = rand(1,count($arr))-1;
        $qid = $arr[$qidx];

        unset($arr[$qidx]);
        session(['avail_qs'=>array_values($arr)]);

        $question = Question::find($qid);
        // dd($question->Question);
        return $question->Question;
    }
}
