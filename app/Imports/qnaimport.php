<?php

namespace App\Imports;

use App\Models\question;
use App\Models\answer;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;

class qnaimport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {   
        //  Log::info('Attempting to recreate log file...');
        // Your code here
        log::info($row);
        if ($row[0]!=="question") {
           $qid= question::insertGetId([
                "questions" =>$row[0]
            ]);

            for($i=1; $i <count($row)-1 ; $i++ ){
                if($row[$i]!=null){
                $iscorrect=0;
                if($row[7]==$row[$i]){
                    $iscorrect=1;
                }
              
               answer::insert([
                'question_id'=>$qid,
                'answer' =>$row[$i],
                'is_correct'=>$iscorrect
               ]);
                }
            }
        }
        // Log::info('Log file recreated successfully.');
        // return new question([
            //
       
    }
}
