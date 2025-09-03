<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void
	{
		Schema::create('assessments', function (Blueprint $table) {
			$table->id();
			$table->foreignId('candidate_id')->constrained()->cascadeOnDelete();
			$table->string('title');
			$table->text('remarks')->nullable();
			$table->string('attachment_path')->nullable(); // uploaded test or artifact
			$table->unsignedTinyInteger('score')->nullable(); // 0-100
			$table->timestamps();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('assessments');
	}
};


