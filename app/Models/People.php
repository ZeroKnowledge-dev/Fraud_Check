<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class People extends Model {
	protected $fillable = [
		'email',
		'phone',
		'url',
		'image',
		'address',
		'status',
		'description',
	];
}
