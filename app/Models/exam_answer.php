<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class exam_answer extends Model
{
    use HasFactory;

    public $table="exams_answer";
    protected $fillable=[
        'attempt_id',
        'question_id',
        'answer_id'
    ];



    public function question(){
     return  $this->hasOne(question::class,'id','question_id');
    }

    
    public function answer(){
        return  $this->hasOne(answer::class,'id','answer_id');
       }
}
