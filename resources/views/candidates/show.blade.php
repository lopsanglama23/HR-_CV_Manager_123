@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 space-y-6">
	@if(session('status'))
		<div class="bg-green-100 border p-2">{{ session('status') }}</div>
	@endif

	<div class="flex items-center justify-between">
		<h1 class="text-2xl font-bold">{{ $candidate->name }}</h1>
		<a href="{{ route('candidates.edit',$candidate) }}" class="text-blue-600">Edit</a>
	</div>

	<div class="grid md:grid-cols-2 gap-4">
		<div class="border p-3">
			<h2 class="font-semibold mb-2">Details</h2>
			<ul class="space-y-1">
				<li><strong>Technology:</strong> {{ $candidate->technology }}</li>
				<li><strong>Level:</strong> {{ ucfirst($candidate->level) }}</li>
				<li><strong>Status:</strong> {{ ucfirst(str_replace('_',' ',$candidate->status)) }}</li>
				<li><strong>Experience:</strong> {{ $candidate->experience_years }} yrs</li>
				<li><strong>Salary Expectation:</strong> {{ $candidate->salary_expectation }}</li>
				<li><strong>Phone:</strong> {{ $candidate->phone }}</li>
				<li><strong>Email:</strong> {{ $candidate->email }}</li>
				<li><strong>Latest Interview Result:</strong>
					@if($candidate->interviews->count() > 0)
						{{ ucfirst($candidate->interviews->sortByDesc('scheduled_at')->first()->result) }}
					@else
						No interviews
					@endif
				</li>
			</ul>
			@if($candidate->cv_path)
				<div class="mt-3"><a class="text-blue-600" href="{{ asset('storage/'.$candidate->cv_path) }}" target="_blank">View CV</a></div>
			@endif
		</div>

		<div>
			<h2 class="font-semibold mb-2">Interviews</h2>
			<p class="mb-2">Total Interviews: {{ $candidate->interviews->count() }}</p>
			@if($candidate->interviews->count() > 0)
				<p>Latest: {{ ucfirst($candidate->interviews->sortByDesc('scheduled_at')->first()->round) }} - {{ $candidate->interviews->sortByDesc('scheduled_at')->first()->scheduled_at->format('d M Y H:i') }}</p>
			@endif
			<a href="{{ route('candidates.interviews.index', $candidate) }}" class="text-blue-600">Manage Interviews</a>
		</div>
	</div>
		<div class="border p-3">
			<h2 class="font-semibold mb-2">Assessments</h2>
			<form method="post" action="{{ route('candidates.assessments.store',$candidate) }}" enctype="multipart/form-data" class="space-y-2 mb-3">
				@csrf
				<input name="title" class="border p-2 w-full" placeholder="Assessment title"/>
				<select name="type" class="border p-2 w-full">
					<option value="">Select Type</option>
					<option value="behavioral">Behavioral Assessment</option>
					<option value="test">Test</option>
				</select>
				<input type="number" name="score" class="border p-2 w-full" placeholder="Score (0-100)" />
				<textarea name="remarks" class="border p-2 w-full" placeholder="Remarks"></textarea>
				<input type="file" name="attachment" class="border p-2 w-full" />
				<button class="bg-green-700 text-white px-4 py-2">Add</button>
			</form>
			@foreach($candidate->assessments as $a)
				<div class="border p-2 mb-2">
					<div class="font-semibold">{{ $a->title }} @if($a->type) - {{ ucfirst($a->type) }} @endif @if(!is_null($a->score)) - Score: {{ $a->score }} @endif</div>
					<div class="text-sm">{{ $a->remarks }}</div>
					<div class="flex justify-between mt-1">
						@if($a->attachment_path)
							<a class="text-blue-600" href="{{ asset('storage/'.$a->attachment_path) }}" target="_blank">Attachment</a>
						@endif
						<form method="post" action="{{ route('candidates.assessments.destroy',[$candidate,$a]) }}">
							@csrf
							@method('DELETE')
							<button class="text-red-600">Delete</button>
						</form>
					</div>
				</div>
			@endforeach
		</div>
	<div class="border p-3">
		<h2 class="font-semibold mb-2">Offer Letters</h2>
		@if($candidate->interviews()->where('round', 'second')->where('result', 'pass')->exists() || $candidate->interviews()->where('round', 'third')->where('result', 'pass')->exists())
			<a href="{{ route('offers.create',$candidate) }}" class="bg-purple-700 text-white px-3 py-1">Create Offer</a>
		@else
			<p class="text-gray-600">Offer can only be created after completing second round of interview or third round if needed.</p>
		@endif
		<ul class="mt-2">
			@foreach($candidate->offers as $o)
				<li class="border p-2 mb-2">
					<strong>{{ $o->title }}</strong>
					@if($o->status === 'sent')
						<span class="text-green-600 ml-2">Sent</span>
					@elseif($o->status === 'accepted')
						<span class="text-blue-600 ml-2">Accepted</span>
					@elseif($o->status === 'rejected')
						<span class="text-red-600 ml-2">Rejected</span>
					@else
						<span class="text-gray-600 ml-2">Draft</span>
					@endif
				</li>
			@endforeach
		</ul>
	</div>
</div>
@endsection


