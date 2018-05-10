<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    protected $table='inbox';
    public function sender()
		{
			return $this->belongsTo('App\User','sender');
		}
}
