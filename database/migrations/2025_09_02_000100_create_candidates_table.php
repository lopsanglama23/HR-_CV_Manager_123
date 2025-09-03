<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('candidates', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('phone')->nullable();
			$table->string('email')->nullable();
			$table->string('technology')->nullable(); // Dot Net, React, DevOps, QA etc
			$table->enum('level', ['junior', 'mid', 'senior'])->nullable();
			$table->decimal('salary_expectation', 12, 2)->nullable();
			$table->decimal('experience_years', 5, 2)->nullable();
			$table->text('references')->nullable();
			$table->string('cv_path')->nullable(); // stored file path
			$table->enum('status', [
				'shortlisted',
				'first_interview',
				'second_interview',
				'third_interview',
				'hired',
				'rejected',
				'blacklisted',
			])->default('shortlisted');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('candidates');
	}
};


