<?php

namespace App\Http\Controllers;

use App\Models\People;
use Illuminate\Http\Request;

class PublicController extends Controller {
	public function checkFraudOrLegit(Request $request) {
		// Validate input data
		$request->validate([
			'data' => 'required|string', // Ensure there's data and it's a string
		]);

		// Retrieve all matching records using LIKE for partial matching
		$people = People::where('phone', 'LIKE', '%' . $request->data . '%') // Match partial phone number
			->orWhere('email', 'LIKE', '%' . $request->data . '%') // Match partial email
			->orWhere('url', 'LIKE', '%' . $request->data . '%') // Match partial Facebook link
			->get(); // Get all matching records

		// If no people found
		if ($people->isEmpty()) {
			return response()->json(['status' => 'Data not found'], 404);
		}

		// Return all matching people
		return response()->json(['status' => 'found', 'data' => $people]);
	}
}
