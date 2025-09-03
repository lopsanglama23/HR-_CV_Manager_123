@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
	<h1 class="text-2xl font-bold mb-4">New Candidate</h1>
	@if ($errors->any())
		<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif
	<form method="post" action="{{ route('candidates.store') }}" enctype="multipart/form-data" class="space-y-3">
		@csrf
		<div>
			<label for="name" class="block text-sm font-medium text-gray-700">Name</label>
			<input id="name" class="border p-2 w-full" name="name" placeholder="Name" value="{{ old('name') }}"/>
			@error('name')
				<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
			@enderror
		</div>
		<div>
			<label for="phone" class="block text-sm font-medium text-gray-700">Phone *</label>
			<input id="phone" type="tel" class="border p-2 w-full" name="phone" placeholder="Phone" value="{{ old('phone') }}"  />
			@error('phone')
				<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
			@enderror
		</div>
		<div>
			<label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
			<input id="email" type="email" class="border p-2 w-full" name="email" placeholder="Email" value="{{ old('email') }}"  />
			@error('email')
				<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
			@enderror
		</div>
		<div>
			<label for="technology" class="block text-sm font-medium text-gray-700">Technology *</label>
			<input id="technology" class="border p-2 w-full" name="technology" placeholder="Technology" value="{{ old('technology') }}"  />
			@error('technology')
				<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
			@enderror
		</div>
		<div>
			<label for="level" class="block text-sm font-medium text-gray-700">Level *</label>
			<select id="level" name="level" class="border p-2 w-full" >
				<option value="">Select Level</option>
				<option value="junior" {{ old('level') == 'junior' ? 'selected' : '' }}>Junior</option>
				<option value="mid" {{ old('level') == 'mid' ? 'selected' : '' }}>Mid</option>
				<option value="senior" {{ old('level') == 'senior' ? 'selected' : '' }}>Senior</option>
			</select>
			@error('level')
				<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
			@enderror
		</div>
		<div>
			<label for="salary_expectation" class="block text-sm font-medium text-gray-700">Salary Expectation *</label>
			<input id="salary_expectation" type="number" class="border p-2 w-full" name="salary_expectation" placeholder="Salary Expectation" value="{{ old('salary_expectation') }}"  />
			@error('salary_expectation')
				<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
			@enderror
		</div>
		<div>
			<label for="experience_years" class="block text-sm font-medium text-gray-700">Experience (years) *</label>
			<input id="experience_years" type="number" class="border p-2 w-full" name="experience_years" placeholder="Experience (years)" value="{{ old('experience_years') }}"  />
			@error('experience_years')
				<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
			@enderror
		</div>
		<div>
			<label for="references" class="block text-sm font-medium text-gray-700">References</label>
			<textarea id="references" class="border p-2 w-full" name="references" placeholder="References">{{ old('references') }}</textarea>
			@error('references')
				<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
			@enderror
		</div>
		<div>
			<label for="cv" class="block text-sm font-medium text-gray-700">CV</label>
			<input id="cv" type="file" name="cv" class="border p-2 w-full" />
			@error('cv')
				<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
			@enderror
		</div>
		<button class="bg-green-600 text-white px-4 py-2">Create</button>
	</form>
</div>
@endsection


