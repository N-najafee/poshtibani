<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $guarded=[];

    function tickets(){
        return $this->hasMany(Ticket::class,'subject_id','id');
    }

    function getIsActiveAttribute($value){
        return $value ? "فعال" : "غیرفعال";
    }
}
