<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Interview extends Model
{
	use HasFactory;

	protected $fillable = [
		'candidate_id',
		'round',
		'scheduled_at',
		'interviewer_name',
		'interviewer_email',
		'remarks',
		'result',
	];

	protected $casts = [
		'scheduled_at' => 'datetime',
	];

	public function candidate(): BelongsTo
	{
		return $this->belongsTo(Candidate::class);
	}
}


