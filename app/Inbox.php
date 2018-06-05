<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    protected $table='inbox';
    protected $fillable = ['sender','receiver','id_chatroom','messages'];
}
