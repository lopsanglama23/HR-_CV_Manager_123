<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void
	{
		Schema::create('offer_letters', function (Blueprint $table) {
			$table->id();
			$table->foreignId('candidate_id')->constrained()->cascadeOnDelete();
			$table->string('title');
			$table->longText('body_markdown'); // editable template snapshot used for this candidate
			$table->string('generated_pdf_path')->nullable();
			$table->timestamps();
		});

		Schema::create('offer_templates', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->longText('body_markdown');
			$table->timestamps();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('offer_letters');
		Schema::dropIfExists('offer_templates');
	}
};


