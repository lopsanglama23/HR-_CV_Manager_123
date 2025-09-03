<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Candidate extends Model
{
	use HasFactory;

	protected $fillable = [
		'name',
		'phone',
		'email',
		'technology',
		'level',
		'salary_expectation',
		'experience_years',
		'references',
		'cv_path',
		'status',
	];

	public function assessments(): HasMany
	{
		return $this->hasMany(Assessment::class);
	}

	public function interviews(): HasMany
	{
		return $this->hasMany(Interview::class);
	}

	public function offers(): HasMany
	{
		return $this->hasMany(OfferLetter::class);
	}

	public function assignments(): HasMany
	{
		return $this->hasMany(Assignment::class);
	}
}


