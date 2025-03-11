<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use Inertia\Inertia;

class SearchController extends Controller {
	// SearchController.php
	public function index($validity, $type) {
		$data = Entity::where('is_fraud', '=', $validity)->where('type', '=', $type)->get();
		return Inertia::render('Search', [
			'validity' => $validity,
			'type'     => $type,
			'data'     => $data,
		]);
	}
}
