<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $table='tickets';
    protected $guarded=[];
    protected $appends=['check_user'];

    function parent(){
        return $this->belongsTo(Ticket::class,'parent_id','id');
    }

    function child(){
        return $this->hasMany(Ticket::class,'parent_id','id');

    }
    function responses_methode(){
        return $this->hasMany(Response::class,"ticket_id","id")->orderBy('created_at','DESC');
    }

    function user_ticket(){
        return $this->belongsTo(User::class,"user_id","id");
    }

    function getStatusAttribute($value){

        if($value === self::OPEN){
            return 'باز';
        }elseif ($value === self::COMPLETED){
            return 'پاسخ داده شده';
        }else{
            return 'بسته';
        }
    }

    function getCheckUserAttribute(){
        return $this->user_ticket()->where('role',"کاربر عادی")->first() ?? false ;

    }


}
