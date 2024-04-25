<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function class(){
        return $this->belongsTo(StuClass::class,'class_id','id');
    }

    public function attendance(){
        return $this->hasMany(attendance::class,'stu_id','id');
    }



   
}
