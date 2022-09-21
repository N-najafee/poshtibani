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

    function responses_methode(){
        return $this->hasMany(Response::class,"ticket_id","id");
    }

    function user_ticket(){
        return $this->belongsTo(User::class,"user_id","id");
    }

    function getCheckUserAttribute(){
        return $this->user_ticket()->where('role',"کاربر عادی")->first() ?? false ;

    }

}
