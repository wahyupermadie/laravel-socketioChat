<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chatroom extends Model
{
    protected $table='chatroom';
    protected $fillable = ['user1','user2'];
}
