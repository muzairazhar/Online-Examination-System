<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class exam_attempt extends Model
{
    use HasFactory;
    public $table="exam_attempt";
    protected $fillable=[
        'exam_id',
        'user_id'
    
    ];


    public function user(){
        return $this->hasMany(user::class,'id','user_id');
    }

    
    public function exam(){
        return $this->hasMany(exam::class,'id','exam_id');
    }
    

}
