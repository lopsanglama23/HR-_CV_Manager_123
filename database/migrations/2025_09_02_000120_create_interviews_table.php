<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void
	{
		Schema::create('interviews', function (Blueprint $table) {
			$table->id();
			$table->foreignId('candidate_id')->constrained()->cascadeOnDelete();
			$table->enum('round', ['first', 'second', 'third']);
			$table->dateTime('scheduled_at');
			$table->string('interviewer_name')->nullable(); // simple string for now
			$table->string('interviewer_email')->nullable();
			$table->text('remarks')->nullable();
			$table->enum('result', ['pending', 'pass', 'fail'])->default('pending');
			$table->timestamps();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('interviews');
	}
};


