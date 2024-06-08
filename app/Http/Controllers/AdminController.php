<?php

namespace App\Http\Controllers;

use App\Imports\qnaimport;
use App\Exports\exportstudent;
use App\Models\answer;
use App\Models\exam;
use App\Models\exam_answer;
use App\Models\exam_attempt;
use App\Models\packages;
use App\Models\paymentdetails;
use App\Models\qnaexam;
use App\Models\question;
use App\Models\Subject;
use App\Models\User;
use Facade\Ignition\Support\Packagist\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL as FacadesURL;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\Console\Question\Question as QuestionQuestion;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;


class AdminController extends Controller
{
  // add-subject
  public function addsubject(Request $request)
  {
    try {
      Subject::insert([
        'subject' => $request->subject
      ]);
      session()->flash('success', 'Subject added Successfully'); // Set flash message

      return  response()->json(['success' => true, 'msg' => 'Subject added Successfully']);
    } catch (\Exception $e) {
      return response()->json(['success' => true, 'msg' => $e->getMessage()]);
    }
  }

  // edit subject
  public function editsubject(Request $request)
  {
    try {
      $subject = Subject::find($request->id);
      $subject->subject = $request->subject;
      $subject->save();
      session()->flash('success', 'Subject Update Successfully'); // Set flash message

      return  response()->json(['success' => true, 'msg' => 'Subject Update Successfully']);
    } catch (\Exception $e) {
      return response()->json(['success' => true, 'msg' => $e->getMessage()]);
    }
  }

  // delete-subject
  public function deletesubject(Request $request)
  {
    try {
      $subject = Subject::where('id', $request->id)->delete();
      session()->flash('success', 'Subject deleted Successfully'); // Set flash message

      $exam = Exam::where('subject_id', $request->id)->first();

      if ($exam) {
          // Store the exam ID
          $examId = $exam->id;
  
          // Delete the exam
          $exam->delete();
        }


        // packages::where('exam_id',$examId)->delete();
        qnaexam::where('exam_id',$examId)->delete();


        $packages = packages::whereJsonContains('exam_ids', $examId)->get();

        foreach ($packages as $package) {
            // Remove the exam ID from the array
            $updatedExamIds = array_filter($package->exam_ids, function($id) use ($examId) {
                return $id != $examId;
            });

            // Update the package with the new exam IDs
            $package->exam_ids = $updatedExamIds;
            $package->save();
        }
  
          // Delete related data in other tables using the exam ID
          // Example for deleting related data in another table
          // Replace 'RelatedModel' with your actual model name
          // RelatedModel::where('exam_id', $examId)->delete();
                // qnaexam::where('exam_id')
      session()->flash('success', 'Subject deleted Successfully'); // Set flash message


      return  response()->json(['success' => true, 'msg' => 'Subject Deleted Successfully']);
    } catch (\Exception $e) {
      return response()->json(['success' => true, 'msg' => $e->getMessage()]);
    }
  }

  // exam-dashboard-load
  public function examdashboard()
  {
    $attemtdata=exam_answer::where('attempt_id',1)->with('question','answer')->get();

    $exams = exam::with('subjects')->get();
    $subjects = Subject::all();
    return  view('admin.exam-dashboard', ["subjects" => $subjects, "exams" => $exams,'data'=>$attemtdata]);
  }

  public function addexam(Request $request)
  {
    $prices=null;
    if(isset($request->pkr)){
      $prices=json_encode(['PKR'=>$request->pkr]);

    }
    
    try {
      $unique_id=uniqid('exid');
      exam::insert([
        "exam_name" => $request->exam_name,
        "subject_id" => $request->subject_id,
        "date" => $request->date,
        "time" => $request->time,
        "attempt" => $request->attempt,
        "enterance_id" => $unique_id,
        "plan"=>$request->plan,
        "prices"=>$prices*100
      ]);
      session()->flash('success', 'Exam added Successfully'); // Set flash message

      return  response()->json(['success' => true, 'msg' => 'Exam Added Successfully']);
    } catch (\Exception $e) {
      return response()->json(['success' => true, 'msg' => $e->getMessage()]);
    }
  }

  public function getexamdetail($id)
  {
    try {
      $exam = exam::where('id', $id)->get();
      return  response()->json(['success' => true, 'data' => $exam]);
    } catch (\Exception $e) {
      return response()->json(['success' => true, 'msg' => $e->getMessage()]);
    }
  }

  public function updateexam(Request $request)
  {
    $prices=null;
    if(isset($request->pkr)){
      $prices=json_encode(['PKR'=>$request->pkr]);
      // $prices*100;

    }

    try {
      $exam = exam::find($request->id);
      $exam->exam_name = $request->exam_name;
      $exam->subject_id = $request->subject_id;
      $exam->attempt = $request->attempt;
      $exam->date = $request->date;
      $exam->time = $request->time;
      $exam->plan=$request->plan;
      $exam->prices=$prices;
      $exam->save();
      session()->flash('success', 'Exam Updated  Successfully'); // Set flash message

      return  response()->json(['success' => true, 'msg' => 'Exam Update Successfully']);
    } catch (\Exception $e) {
      return response()->json(['success' => true, 'msg' => $e->getMessage()]);
    }
  }
  public function deleteexam(Request $request)
  {
    try {
       $exam = Exam::where('id', $request->delete_exam_id)->first();

      if ($exam) {
          // Store the exam ID
          $examId = $exam->id;
  
          // Delete the exam
          $exam->delete();
          session()->flash('success', 'Exam Deleted Successfully'); // Set flash message

        }


        // packages::where('exam_id',$examId)->delete();
        qnaexam::where('exam_id',$examId)->delete();

        $packages = packages::whereJsonContains('exam_id', $examId)->get();

        foreach ($packages as $package) {
            // Remove the exam ID from the array
            $updatedExamIds = array_filter($package->exam_id, function($id) use ($examId) {
                return $id != $examId;
            });

            // Update the package with the new exam IDs
            $package->exam_id = $updatedExamIds;
            $package->save();
        }

      return  response()->json(['success' => true, 'msg' => 'Exam Deleted Successfully']);


      // return  response()->json(['success' => true, 'msg' => 'Exam Update Successfully']);
    } catch (\Exception $e) {
      return response()->json(['success' => true, 'msg' => $e->getMessage()]);
    }
  }

  // q & A dashboard load
  public function qnadashboard()
  {
    $questions = question::with('answer')->get();
    return view('admin.qnadashboard', compact('questions'));
  }
  // add Q & A

  public function addqna(Request $request)
  {
    try {
      $explanation=null;
      if(isset($request->explanation)){
        $explanation=$request->explanation;

      }
      $questionid = question::insertGetId([
        'questions' => $request->question,
        'explanation'=>$explanation
      ]);
      session()->flash('success', 'Q&A Added  Successfully'); // Set flash message

      foreach ($request->answer as $answer) {
        $iscorrect = 0;
        if ($request->is_correct == $answer) {
          $iscorrect = 1;
        }
        answer::insert([
          'question_id' => $questionid,
          'answer' => $answer,
          'is_correct' => $iscorrect
        ]);
      }
      session()->flash('success', 'Q&A Added  Successfully'); // Set flash message

      return  response()->json(['success' => true, 'msg' => 'Successfully']);
    } catch (\Exception $e) {
      return response()->json(['success' => true, 'msg' => $e->getMessage()]);
    }
  }

  public function getqnadetails(Request $request)
  {
    $qna = question::where('id', $request->qid)->with('answer')->get();
    return response()->json(['data', $qna]);
  }

  public function deleteans(Request $request)
  {
    answer::where('id', $request->id)->delete();
    session()->flash('success', 'Q&A Deleted  Successfully'); // Set flash message

    return response()->json(['success' => true, 'msg' => 'answer dleted successfully']);
  }

  public function updateqna(Request $request)
  {
    try {
      $explanation=null;
      if(isset($request->explanation)){
             $explanation=$request->explanation;

      }
      question::where('id', $request->question_id)->update([
        'questions' => $request->question,
        'explanation'=>$explanation
      ]);
      // old answer-update
      if (isset($request->answer)) {
        foreach ($request->answer as $key => $value) {
          $iscorrect = 0;
          if ($request->is_correct == $value) {
            $iscorrect = 1;
          }
          answer::where('id', $key)->update([
            'question_id' => $request->question_id,
            'answer' => $value,
            'is_correct' => $iscorrect
          ]);
        }

        // new answer added
        if (isset($request->new_answer)) {
          foreach ($request->new_answer as $answer) {
            $iscorrect = 0;
            if ($request->is_correct == $answer) {
              $iscorrect = 1;
            }
            answer::insert([
              'question_id' => $request->question_id,
              'answer' => $answer,
              'is_correct' => $iscorrect
            ]);
          }
        }
      }

      session()->flash('success', 'Q&A Updated  Successfully'); // Set flash message

      // return  response()->json($request->all());
      return response()->json(['success' => true, 'data' => $request->all()]);

    } catch (\Exception $e) {
      return response()->json(['success' => false, 'msg' => $e->getMessage()]);
    }
    // return response()->json($request->all());
  }

  public function deleteqna(Request $request)
  {
    // session()->flash('success', 'Q&A Deleted  Successfully'); // Set flash message

    question::where('id', $request->delete_qna_id)->delete();
    session()->flash('success', 'Q&A Updated  Successfully'); // Set flash message
    answer::where('question_id', $request->id)->delete();
    return response()->json(['success' => true, 'Success' => "Q&A Deleted Successfully!"]);
  }

  public function importqna(Request $request)
  {

    try {

      Excel::import(new qnaimport, $request->file('file'));
      session()->flash('success', 'Q&A Imported  Successfully'); // Set flash message

      return response()->json(['success' => true, 'Success' => "Q&A Import Successfully!"]);
    } catch (\Exception $e) {
      return response()->json(['success' => false, 'msg' => $e->getMessage()]);
    }
  }


  // Student Dashboard
  public function studentdashboard()
  {
    $students = User::where('is_admin', 0)->get();
    return view('admin.studentdashboard', compact('students'));
  }

  // add admin-students
  public function addstudent(Request $request)
  {
    try {

      $password = Str::random(8);
      User::insert([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($password)
      ]);
      $url = URL::to('/');
      $data['url'] = $url;
      $data['name'] = $request->name;
      $data['email'] = $request->email;
      $data['password'] = $password;
      $data['title'] = "Student Registration on OES";
      Mail::send('registrationmail',['data'=>$data],function($message) use ($data){
          $message->to($data['email'])->subject($data['title']);
      }); 
      session()->flash('success', 'Student added Successfully'); // Set flash message

      return response()->json(['success' => true, 'Success' => "Student Added Successfully!"]);

    } catch (\Exception $e) {
      return response()->json(['success' => false, 'msg' => $e->getMessage()]);
    }
  }

  // edit admin-students
  public function editstudent(Request $request){
    try {

      // echo $request->id;

             $user=User::find($request->id);

             $user->name=$request->name;
             $user->email=$request->email;
             $user->save();


      $url= URL::to('/');
      $data['url'] = $url;
      $data['name'] = $request->name;
      $data['email'] = $request->email;
      // $data['password'] = $password;
      $data['title'] = "Updated Student Profile on OES";
      Mail::send('updateprofilemail',['data'=>$data],function($message) use ($data){
          $message->to($data['email'])->subject($data['title']);
      }); 

      session()->flash('success', 'Student Updated Successfully'); // Set flash message

      return response()->json(['success' => true, 'Success' => "Student Updated Successfully!"]);

    } catch (\Exception $e) {
      return response()->json(['success' => false, 'msg' => $e->getMessage()]);
    }
  }

  // delete-admin-student
  public function deletestudent(Request $request){
    try{
      User::where('id',$request->id)->delete();
      paymentdetails::where('user_id',$request->id)->delete();
      // exam_attempt::where('user_id',$request->id)->delete();
      session()->flash('success', 'Student Deleted Successfully'); // Set flash message

      return response()->json(['success' => true, 'Success' => "Student Deleted Successfully!"]);
    }catch(\Exception $e) {
      return response()->json(['success' => false, 'msg' => $e->getMessage()]);
    }


  }

  // Get Questions
  public function getquestion(Request $request){
try {
  $questions=question::all();
if(count($questions)>0){
$data=[];
$counter =0;
    foreach ($questions as $question ) {
     $qnaexam= qnaexam::where(['exam_id'=>$request->exam_id,'question_id'=>$question->id])->get();
     if(count($qnaexam)==0){
      $data[$counter]['id']=$question->id;
      $data[$counter]['questions']=$question->questions;
      $counter++;

     }
    }
    return response()->json(['success' => true, 'Success' => "Question Data!",'data'=>$data]);

}else{
  return response()->json(['success' => false, 'msg' => "Questions Not Found!"]);

}

} catch(\Exception $e) {
  return response()->json(['success' => false, 'msg' => $e->getMessage()]);
}
  }

  public function addquestion(Request $request){
try{
if(isset($request->questions_ids)){
  foreach($request->questions_ids as $qid){
           qnaexam::insert([
            'exam_id'=>$request->exam_id,
            'question_id'=>$qid
           ]);
  }

}
session()->flash('success', 'Questions Added  Successfully'); // Set flash message


}catch(\Exception $e) {
      return response()->json(['success' => false, 'msg' => $e->getMessage()]);
    }
  }


public function getexamquestion(Request $request){
  try{
        $data= qnaexam::where('exam_id',$request->exam_id)->with('question')->get();
         return response()->json(['success' => true, 'Success' => "Question Details!",'data'=>$data]);


  }catch(\Exception $e) {
      return response()->json(['success' => false, 'msg' => $e->getMessage()]);
    }
}


// deleteexamquestion

public function deleteexamquestion(Request $request){
try{
qnaexam::where('id',$request->id)->delete();
return response()->json(['success' => true, 'Success' => "Question Deleted Successfully"]);

}catch(\Exception $e) {
      return response()->json(['success' => false, 'msg' => $e->getMessage()]);
    }
}



public function loadmarks(){

  $data=exam::with('getqnaexam')->get();
  return view('admin.marksdashboard',compact('data'));
}


public function updatemarks(Request $request){


  try{

exam::where('id',$request->exam_id)->update([
  'marks'=>$request->marks,
  'pass_marks'=>$request->pass_marks
]);

session()->flash('success', 'Marks Updated  Successfully'); // Set flash message

return response()->json(['success' => true, 'Success' => $request->all()]);


    
    }catch(\Exception $e) {
          return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }

}

public function reviewexam(){
$attempt=exam_attempt::with(['user','exam'])->orderBy('id')->get();
return view('admin.reviewexam',compact('attempt'));  
}

public function reviewqna(Request $request){

  try{
    $attemtdata=exam_answer::where('attempt_id',$request->attempt_id)->with('question','answer')->get();

return response()->json(['success' => true, 'data'=>$attemtdata]);

  }catch(\Exception $e){
    
    return response()->json(['success' => false, 'msg' => $e->getMessage()]);

  }



}


public function approvedqna(Request $request){
  try{
$attempt_id=$request->attempt_id;
$examdata=exam_attempt::where('id',$attempt_id)->with(['user','exam'])->get();


$marks=$examdata[0]['exam'][0]['marks'];

$attemptdata=exam_answer::where('attempt_id',$attempt_id)->with('answer')->get();

$totalmarks=0;

if(count($attemptdata)>0){
foreach ($attemptdata as $data) {
if($data->answer->is_correct==1){
$totalmarks+=$marks;
}
}
}

exam_attempt::where('id',$attempt_id)->update([
  'status'=>1,
  'marks'=>$totalmarks
]);




$url = URL::to('/');
$data['url'] = $url . '/results';
$data['name'] = isset($examdata[0]['user'][0]['name']) ? $examdata[0]['user'][0]['name'] : '';
$data['email'] = isset($examdata[0]['user'][0]['email']) ? $examdata[0]['user'][0]['email'] : '';
$data['exam_name'] = isset($examdata[0]['exam'][0]['exam_name']) ? $examdata[0]['exam'][0]['exam_name'] : '';
$data['title'] = $data['exam_name'] . ' Result';

try {
  Mail::send('resultmail', ['data' => $data], function ($message) use ($data) {
    $message->to($data['email'])->subject($data['title']);
  });
  return response()->json(['success'=>true,'msg'=>'Approved Successfully','data'=>$examdata[0]['user'][0]['name']]);

} catch (\Exception $e) {
  echo 'Email sending failed: ' . $e->getMessage(); // Error message
}


  }catch(\Exception $e){
    
    return response()->json(['success' => false, 'msg' => $e->getMessage()]);

  }
}

public function exportstudents(){

  session()->flash('success', 'Student Successfully Exported'); // Set flash message

  // Excel::ex
  
  return Excel::download(new exportstudent,'students.xlsx');
  
  }


  public function loadpackages(){
    $exams = exam::where('plan',0)->get();
    $packages = packages::orderBy('created_at','DESC')->get();
    // packages::orderBy();

    return view('admin.packages-dashboard',compact(['exams','packages']));
  }

public function addpackage(Request $request){
  $examids=[];
 
  foreach($request->exam as $exam){
     $examids[]=(int)$exam;
    // return $examids;
  }
  $price=json_encode(['PKR'=>$request->pricepkr]);
  packages::insert([
    'name'=>$request->package_name,
    'exam_id'=>json_encode($examids),
    'price'=>$price,
    'exapire'=>$request->expire
  ]);
  return redirect()->back()->with('success','Package Added Successfully');
}

public function deletepkg (Request $request){
  try{
packages::where('id',$request->id)->delete();
session()->flash('success', 'Package Deleted  Successfully'); // Set flash message


    return response()->json(['success'=>true,'msg'=>'Package deleted successfully']);

  }catch(\Exception $e){
  return response()->json(['success'=>false,'msg'=>$e->getmessage()]);
  }

}

public function editpackage(Request $request){
  $examids=[];
 
  foreach($request->exam as $exam){
     $examids[]=(int)$exam;
  }
  $price=json_encode(['PKR'=>$request->pricepkr]);
  packages::where('id',$request->package_id)->update([
    'name'=>$request->package_name,
    'exam_id'=>json_encode($examids),
    'price'=>$price,
    'exapire'=>$request->expire
  ]);
  return redirect()->back()->with('success','Package Update Successfully');
}


public function paymentdetails(){

 $paymentdetails= paymentdetails::with(['examname','username'])->orderBy('id','DESC')->get();
 return view ('admin.paymentdetails',compact('paymentdetails'));

}

}
