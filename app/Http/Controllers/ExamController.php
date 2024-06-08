<?php

namespace App\Http\Controllers;

use App\Models\exam;
use App\Models\exam_answer;
use App\Models\exam_attempt;
use App\Models\qnaexam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function loadexamdashboard($id){
       $qnaexam= exam::where('enterance_id',$id)->with(['getqnaexam','getpaidinfo'])->get();
       $qnaexam[0]['exam_name'];
      //  return $qnaexam;

        
       if(count($qnaexam)>0 ){
        if($qnaexam[0]['date']==date('Y-m-d')){
          $attempt_count = exam_attempt::where([
            'exam_id' => $qnaexam[0]['id'],
            'user_id' => auth()->user()->id
        ])->count();
          if($attempt_count>=$qnaexam[0]['attempt']){
            return view('student.exam-dashboard',['success'=>false,'msg'=>'Your exam attemption has been completed '.$qnaexam[0]['date'],'exam'=>$qnaexam]); 
          }
          else if(count($qnaexam[0]['getqnaexam'])>0){
                   
       



               $qna= qnaexam::where('exam_id',$qnaexam[0]['id'])->with('question','answer')->inRandomOrder()->get();
              //  return $qna;
               return view('student.exam-dashboard',['success'=>true,'exam'=>$qnaexam,'qna'=>$qna]); 

              }else{
                return view('student.exam-dashboard',['success'=>false,'msg'=>'This exam is not avalaible for now '.$qnaexam[0]['date'],'exam'=>$qnaexam]); 
              }

        }else if($qnaexam[0]['date'] > date('Y-m-d')){
             return view('student.exam-dashboard',['success'=>false,'msg'=>'This exam will be start on '. $qnaexam[0]['date'],'exam'=>$qnaexam]);
        }else{
            return view('student.exam-dashboard',['success'=>false,'msg'=>'This exam has been expired on'.$qnaexam[0]['date'],'exam'=>$qnaexam]); 
        }  
            
       }
       else{
        return view('404');
       }
    }


    public function examsubmit(Request $request){

// return $request->all();

      $attempt_id=exam_attempt::insertGetId([
        'exam_id'=>$request->exam_id,
        'user_id'=>Auth::user()->id
      ]);

      $qcount=count($request->q);
         if($qcount>0){
          for($i=0; $i<$qcount; $i++){
           exam_answer::insert([
                  'attempt_id'=>$attempt_id,
                  'question_id'=>$request->q[$i],
                  'answer_id'=>request()->input('ans_'.($i+1))

            ]);
          }
         }
          
     return  view('thank-you');


    }

    public function resultdashboard(){
      $attempts=exam_attempt::where('user_id',auth()->user()->id)->with('exam')->orderBy('updated_at')->get();

      return view('student.result',compact('attempts'));

    }


    public function reviewqna(Request $request){
         
      try{
            
        $attemptdata= exam_answer::where('attempt_id',$request->attempt_id)->with(['question','answer'])->get();

        return response()->json(['success'=>true,'data'=>$attemptdata]);

      }catch(\Exception $e){
        return response()->json(['success'=>false,'msg'=>$e->getmessage()]);
      }


    }
}
