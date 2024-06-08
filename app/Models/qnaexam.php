<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class qnaexam extends Model
{
    use HasFactory;
    public $table="qna_exams";
    protected $fillable=[
        'exam_id',
        'question_id'
    ];

    public function question(){
        return $this->hasMany(question::class,'id','question_id');
    }

    
public function answer(){
    return $this->hasMany(answer::class,'question_id','question_id');
   
}
}
