@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
	<h1 class="text-2xl font-bold mb-4">Edit Candidate</h1>
	<form method="post" action="{{ route('candidates.update',$candidate) }}" enctype="multipart/form-data" class="space-y-3">
		@csrf
		@method('PUT')
		<input class="border p-2 w-full" name="name" value="{{ $candidate->name }}"/>
		<input class="border p-2 w-full" name="phone" value="{{ $candidate->phone }}" />
		<input class="border p-2 w-full" name="email" value="{{ $candidate->email }}" />
		<input class="border p-2 w-full" name="technology" value="{{ $candidate->technology }}" />
		<select name="level" class="border p-2 w-full">
			@foreach(['junior','mid','senior'] as $lvl)
				<option value="{{ $lvl }}" @selected($candidate->level===$lvl)>{{ ucfirst($lvl) }}</option>
			@endforeach
		</select>
		<input class="border p-2 w-full" name="salary_expectation" value="{{ $candidate->salary_expectation }}" />
		<input class="border p-2 w-full" name="experience_years" value="{{ $candidate->experience_years }}" />
		<textarea class="border p-2 w-full" name="references">{{ $candidate->references }}</textarea>
		<select name="status" class="border p-2 w-full">
			@foreach(['shortlisted','first_interview','second_interview','third_interview','hired','rejected','blacklisted'] as $s)
				<option value="{{ $s }}" @selected($candidate->status===$s)>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
			@endforeach
		</select>
		<input type="file" name="cv" class="border p-2 w-full" />
		<button class="bg-blue-600 text-white px-4 py-2">Save</button>
	</form>
</div>
@endsection


