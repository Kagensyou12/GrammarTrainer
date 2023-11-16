<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = fopen('sentence_question_bank.csv', 'r');

        while (($data = fgetcsv($file)) !== false) {
            DB::table('questions')->insert([
                'Question' => $data[0],
                'Difficulty' => $data[1]
            ]);
        }

        fclose($file);
        // DB::table('questions')->insert([
        //     ['Question'=>'In the beningging', 'Difficulty'=>1],
        //     ['Question'=>'To who it may concern', 'Difficulty'=>3]
        // ]);
    }
}
