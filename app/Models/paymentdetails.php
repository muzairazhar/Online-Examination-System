<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class paymentdetails extends Model
{
    use HasFactory;

    protected $fillable=[
        'exam_id',
        'user_id',
        'payment_details'
    ];

    public $table="exam_payments";
    public $primarykey="id";


    public function examname(){
        return $this->hasMany(exam::class,'id','exam_id');

    }


    public function username(){
        return $this->hasMany(User::class,'id','user_id');
        
    }
}
