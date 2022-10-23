<?php

namespace App\Models;

use App\Http\Consts\Ticketconsts;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tickets';
    protected $guarded = [];


    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }


    public function responses()
    {
        return $this->hasMany(Response::class, "ticket_id", "id")->orderBy('created_at', 'DESC');
    }

    public function HasMoreResponse(){
     return count($this->responses->slice(2))>0 ?? 0;
    }

    public function getStatusAttribute($value)
    {

        if ($value === Ticketconsts::OPEN) {
            return 'باز';
        } elseif ($value === Ticketconsts::COMPLETED) {
            return 'پاسخ داده شده';
        } else {
            return 'بسته';
        }
    }


}
