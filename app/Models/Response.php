<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Response extends Model
{
    use HasFactory , SoftDeletes;
    protected $table='responses';
    protected $guarded=[];
    protected $with=[
        'user:id,name',
    ];

    function user(){
        return $this->belongsTo(User::class,"user_id","id");
    }
    function ticket(){
        return $this->belongsTo(Ticket::class,"ticket_id","id");
    }
}
