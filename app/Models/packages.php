<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class packages extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'exam_id',
        'price',
        'exapire'
    ];

    protected $appends=['is_paid'];
    public $ispaid=false;

    public function getExamIdAttribute($value){
        $examids=json_decode($value);
        $result =Exam::whereIn('id', $examids)->get();
       $coutpaid= paymentdetails::where('user_id',auth()->user()->id)->whereIn('exam_id',$examids)->count();
       if($coutpaid > 0){
        $this->ispaid=true;
       }
        return $result;
    }

public function getIsPaidAttribute(){
    return $this->ispaid;
}

}
