<?php

namespace App\Models;
use App\Models\answer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;

class question extends Model
{
    use HasFactory;
    protected $fillable=[
        'questions',
        'explanation'
    ];

    public function answer(){
        return $this->hasMany(answer::class,'question_id','id');
    }
}
