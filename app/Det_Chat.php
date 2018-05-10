<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Det_Chat extends Model
{
    protected $table = 'det_chatroom';
    protected $fillable = [
        'id_chatroom', 'message', 'id_user',
    ];
    public function user()
	{
	  return $this->belongsTo(User::class);
	}
}
