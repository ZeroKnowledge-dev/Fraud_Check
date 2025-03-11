<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::create('entities', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('email')->nullable()->unique();
			$table->string('phone')->nullable()->unique();
			$table->string('url')->nullable()->unique();
			$table->json('images')->nullable();
			$table->string('address')->nullable();
			$table->string('description');
			$table->boolean('is_fraud'); // 1 = Fraud, 0 = Valid
			$table->enum('type', ['person', 'company']);
			$table->string('category')->nullable();
			$table->integer('verify_count')->default(0);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::dropIfExists('entities');
	}
};
