<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OfferLetter extends Model
{
	use HasFactory;

	protected $fillable = [
		'candidate_id',
		'title',
		'body_markdown',
		'generated_pdf_path',
	];

	public function candidate(): BelongsTo
	{
		return $this->belongsTo(Candidate::class);
	}
}


