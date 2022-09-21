<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;
    protected $table='responses';
    protected $guarded=[];

    function user_response(){
        return $this->belongsTo(User::class,"user_id","id");
    }
    function ticket(){
        return $this->belongsTo(Ticket::class,"ticket_id","id");
    }
}
