<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::redirect('/','/home');
Route::get('/home',[App\Http\Controllers\HomeController::class,'index']);
Route::get('/leaderboard',[App\Http\Controllers\LeaderboardController::class,'index']);
Route::get('/arcade',[App\Http\Controllers\ArcadeController::class,'index']);
Route::get('/roundselectdifficulty', function(){
    return view('roundselectdifficulty');
});

// Route::get('/dif-{difficulty}',[App\Http\Controllers\RoundController::class],'initialize');

Route::get('/dif-{difficulty}', function($difficulty){
    if($difficulty == 'easy') session(['difficulty'=>'easy']);
    else if($difficulty == 'medium') session(['difficulty'=>'medium']);
    else if($difficulty == 'hard') session(['difficulty'=>'hard']);
    return redirect('/round');
});

Route::get('/round',[App\Http\Controllers\RoundController::class],'index');

Route::get('/shoot/{stig}', function($stig){
    $tex = "text=" . str_replace(" ","%20",$stig);
    // echo $tex;
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://textgears-textgears-v1.p.rapidapi.com/grammar",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $tex,
        CURLOPT_HTTPHEADER => [
            "X-RapidAPI-Host: textgears-textgears-v1.p.rapidapi.com",
            "X-RapidAPI-Key: 9661f917d5msh3cff398cdf2070bp1ad725jsn4f60755ac5bc",
            "content-type: application/x-www-form-urlencoded"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        // echo $response;
        $bruh = json_decode($response);
        $goofs = sizeof($bruh->response->errors);
        if($goofs == 0) echo "no errors";
        else{
            for($i=0;$i<$goofs;$i++){
                // encode is to convert to normal string
                echo "Error:";
                $dude = json_encode($bruh->response->errors[$i]);
                echo $dude;
                echo "</br>";
            }
        }
    }
});
