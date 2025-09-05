<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assessment extends Model
{
	use HasFactory;

	protected $fillable = [
		'candidate_id',
		'title',
		'type',
		'remarks',
		'attachment_path',
		'score',
	];

	public function candidate(): BelongsTo
	{
		return $this->belongsTo(Candidate::class);
	}
}


