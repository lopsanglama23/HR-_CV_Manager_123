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
        <h2 class="font-semibold mb-2">Schedule Interview</h2>
        <p class="mb-2">Scheduling interview for: <strong>{{ $candidate->name }}</strong></p>
                <form method="post" action="{{ route('candidates.interviews.store',$candidate) }}" class="space-y-2">
                    @csrf
					
                    <select name="round" class="border p-2 w-full">
                        <option value="first">First</option>
                        <option value="second">Second</option>
                        <option value="third">Third</option>
                    </select>
                    <input type="datetime-local" name="scheduled_at" class="border p-2 w-full" required />
                    <select name="interviewer" class="border p-2 w-full" required>
                        @foreach(config('interviewers') as $interviewer)
                            <option value="{{ $interviewer['name'] }}|{{ $interviewer['email'] }}">{{ $interviewer['name'] }} ({{ $interviewer['email'] }})</option>
                        @endforeach
                    </select>
                    <textarea name="remarks" class="border p-2 w-full" placeholder="Remarks"></textarea>
                    <button class="bg-blue-600 text-white px-4 py-2">Schedule</button>
                </form>
    	</div>

		<div class="border p-3">
			<h2 class="font-semibold mb-2">Interviews</h2>
			@foreach($candidate->interviews as $i)
				<div class="border p-2 mb-2">
					<div><strong>{{ ucfirst($i->round) }}</strong> - {{ $i->scheduled_at->format('d M Y H:i') }}</div>
					<div class="text-sm">{{ $i->interviewer_name }} ({{ $i->interviewer_email }})</div>
					<div class="text-sm">Remarks: {{ $i->remarks }}</div>
					<form method="post" class="mt-1 flex gap-2" action="{{ route('candidates.interviews.update',[$candidate,$i]) }}">
						@csrf
						@method('PATCH')
						<select name="result" class="border p-1">
							@foreach(['pending','pass','fail'] as $r)
								<option value="{{ $r }}" @selected($i->result===$r)>{{ ucfirst($r) }}</option>
							@endforeach
						</select>
						<button class="bg-gray-700 text-white px-2">Save</button>
						<button class="bg-red-600 text-white px-2" type="button" onclick="if(confirm('Are you sure?')) { document.getElementById('delete-form-{{ $i->id }}').submit(); }">Delete</button>
					</form>
					<form id="delete-form-{{ $i->id }}" method="post" action="{{ route('candidates.interviews.destroy',[$candidate,$i]) }}" style="display: none;">
						@csrf
						@method('DELETE')
					</form>
				</div>
			@endforeach
		</div>
	</div>
	<div class="grid md:grid-cols-2 gap-4">
		<div class="border p-3">
			<h2 class="font-semibold mb-2">Assessments</h2>
			@if($candidate->interviews()->where('round', 'second')->where('result', 'pass')->exists())
				<form method="post" action="{{ route('candidates.assessments.store',$candidate) }}" enctype="multipart/form-data" class="space-y-2 mb-3">
					@csrf
					<input name="title" class="border p-2 w-full" placeholder="Assessment title" required />
					<input type="number" name="score" class="border p-2 w-full" placeholder="Score (0-100)" />
					<textarea name="remarks" class="border p-2 w-full" placeholder="Remarks"></textarea>
					<input type="file" name="attachment" class="border p-2 w-full" />
					<button class="bg-green-700 text-white px-4 py-2">Add</button>
				</form>
			@else
				<p class="text-gray-600">Assessments can only be added after the second round of interview is completed.</p>
			@endif

			@foreach($candidate->assessments as $a)
				<div class="border p-2 mb-2">
					<div class="font-semibold">{{ $a->title }} @if(!is_null($a->score)) - Score: {{ $a->score }} @endif</div>
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
		<a href="{{ route('offers.create',$candidate) }}" class="bg-purple-700 text-white px-3 py-1">Create Offer</a>
		<ul class="mt-2">
			@foreach($candidate->offers as $o)
				<li class="border p-2 mb-2">
					<strong>{{ $o->title }}</strong>
				</li>
			@endforeach
		</ul>
	</div>
</div>
@endsection


