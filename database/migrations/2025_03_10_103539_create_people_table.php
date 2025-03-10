<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::create('people', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('email')->nullable()->unique();
			$table->string('phone')->unique();
			$table->string('facebook_link')->nullable();
			$table->string('image')->nullable();
			$table->string('address')->nullable();
			$table->enum('status', ['Fraud', 'Legit']);
			$table->string('description')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::dropIfExists('people');
	}
};
