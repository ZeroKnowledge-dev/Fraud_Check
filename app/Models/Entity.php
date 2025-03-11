<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entity extends Model {
	protected $fillable = [
		'name',
		'email',
		'phone',
		'url',
		'images',
		'address',
		'is_fraud',
		'category',
		'description',
		'type',
	];
}
