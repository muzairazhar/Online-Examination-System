<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\exam_attempt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class exam extends Model
{
      use HasFactory;
      protected   $fillable = [
            'exam_name',
            'subject_id',
            'date',
            'time',
            'attempt',
            'plan',
            'prices'

      ];
      

      // protected $appends = ['attempt_counter'];
      // public $count = 0;

      public function getpaidinfo(){
    return $this->hasMany(paymentdetails::class,'exam_id','id');  
    
    }

      public function subjects()
{
            return $this->hasMany(Subject::class, 'id', 'subject_id');
      }

       public function getqnaexam()
      {
            return $this->hasMany(qnaexam::class, 'exam_id', 'id');
      }
      // get the user who created this exam
      // public function getIdAttribute($value)
      // {

      //       $attempt_count = exam_attempt::where(['exam_id' => $value, 'user_id' => auth()->user()->id])->count();
      //        $this->count = $attempt_count;
      //       return $value;
      // }



      // public function getAttemptCounterAttribute()
      // {
      //       return $this->count;
      // }







      // Define the attributes that should be appended when the model is serialized
    protected $appends = ['attempt_counter','check_in_exits_package','is_package_exam','package','is_paid'];

    public $package_exits='';
    public $is_package_exam=false;
    public $examid='';
    public $ispaid=false;

    // Define additional properties or attributes
    public $count = 0;




    public function getIdAttribute($value)
    {
        // Retrieve the attempt count for the given exam and user
        $attempt_count = exam_attempt::where([
            'exam_id' => $value,
            'user_id' => auth()->user()->id
        ])->count();

        // Assign the attempt count to the 'count' property
        $this->count = $attempt_count;
        $check_attempt_exam=exam_attempt::where('exam_id',$value)->count();
              
      $temp_exits=  DB::select('SELECT * FROM `packages` WHERE JSON_CONTAINS(exam_id,?)',[$value]);
              if(count($temp_exits)>0){
                $this->package_exits=true;
                $this->is_package_exam=true;
              }else{
                $this->package_exits=false;
                if($check_attempt_exam>0){
                    $this->package_exits=true;
                
                }

              }

              $is_paid = paymentdetails::where('exam_id', $value)
              ->where('user_id', auth()->user()->id)
              ->count();
     
              if($is_paid>0){

                return $this->ispaid=true;
              }
              $this->examid=$value;

        return $value;
    }

    // Define the accessor method for the 'attempt_counter' attribute
    public function getAttemptCounterAttribute()
    {
    
        return $this->count;
    }

public function getCheckInExitsPackageAttribute() {
    return $this->package_exits;
}


public function getIsPackageExamAttribute() {
  return $this->is_package_exam;
}


public function getPackageAttribute() {
  $packagedata=DB::select('SELECT * FROM `packages` WHERE JSON_CONTAINS(exam_id,?)',[$this->examid]);
  return $packagedata;
}



public function getIsPaidAttribute(){
  return $this->ispaid;
}

 
}
