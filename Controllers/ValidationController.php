<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ValidationController extends Controller
{
    public function isvalid($answer){
        // $answer = session('answer');
        $valid = 'valid';
        $q = session('question');
        if(strlen($answer) < 1) $valid = 'empty';
        else if(levenshtein(strtolower($answer),strtolower($q)) > strlen($q)/4) $valid = 'different';

        return $valid;
    }
}
