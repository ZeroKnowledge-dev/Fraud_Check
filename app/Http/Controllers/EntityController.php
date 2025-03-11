<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EntityController extends Controller {

	// ReportController.php
	public function index($validity, $type) {
		return Inertia::render('Report', [
			'validity' => $validity,
			'type'     => $type,
		]);
	}

	public function createEntity(Request $request) {
		$validatedData = $request->validate([
			'name'        => 'required|string',
			'email'       => 'nullable|email',
			'phone'       => 'nullable|string|unique:entities,phone',
			'url'         => 'nullable|string|unique:entities,url',
			'address'     => 'nullable|string',
			'description' => 'required|string',
			'type'        => 'required|string',
			'is_fraud'    => 'required|boolean',
			'images'      => 'nullable|array',
			'images.*'    => 'nullable|string', // Validate each image URL
		]);

		// Handle multiple image uploads
		$imagePaths = [];
		if ($request->hasFile('images')) {
			foreach ($request->file('images') as $image) {
				$imagePaths[] = $image->store('images', 'public');
			}
		}

		$entity = Entity::create([
			'name'        => $validatedData['name'],
			'email'       => $validatedData['email'] ?? null,
			'phone'       => $validatedData['phone'] ?? null,
			'url'         => $validatedData['url'] ?? null,
			'address'     => $validatedData['address'] ?? null,
			'description' => $validatedData['description'],
			'images'      => json_encode($imagePaths), // Store images properly
			'type'        => $request->type, // 'person' or 'company'
			'is_fraud'    => $request->is_fraud, // true = Fraud, false = Valid
		]);

		return response()->json(['status' => 'success', 'data' => $entity]);
	}

	public function increaseVerifyCount(Request $request) {
		$entity               = Entity::find($request->id);
		$entity->verify_count = $entity->verify_count + 1;
		$entity->save();
		return response()->json(['status' => 'success', 'data' => $entity]);
	}

	public function decreaseVerifyCount(Request $request) {
		$entity               = Entity::find($request->id);
		$entity->verify_count = $entity->verify_count - 1;
		$entity->save();
		return response()->json(['status' => 'success', 'data' => $entity]);
	}

}
