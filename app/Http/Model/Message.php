<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'message';
    protected $primaryKey = 'mess_id';
    public $timestamps = false;
    protected $guarded = [];
}
