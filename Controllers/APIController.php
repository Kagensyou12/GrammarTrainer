<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class APIController extends Controller
{   
    public function judge(){ // returns array of errors, still in json
        $tex = "text=" . str_replace(" ","%20",session('answer'));  
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
        // dd($response);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            // echo $response;
            $bruh = json_decode($response);
            return $bruh->response->errors;
            // $goofs = sizeof($bruh->response->errors);
            // if($goofs == 0) echo "no errors";
            // else{
            //     for($i=0;$i<$goofs;$i++){
            //         // encode is to convert to normal string
            //         echo "Error:";
            //         $dude = json_encode($bruh->response->errors[$i]);
            //         echo $dude;
            //         echo "</br>";
            //     }
            // }
        }
    }
}