<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Outbox extends Model
{
	protected $table='outbox';
	protected $fillable = ['sender','receiver','id_chatroom','messages'];
}
