@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
	<h1 class="text-2xl font-bold mb-4">Candidates</h1>

	<form method="get" class="mb-4 flex gap-2">
		<input type="text" name="q" value="{{ request('q') }}" placeholder="Search name or technology" class="border p-2 flex-1" />
		<select name="status" class="border p-2">
			<option value="">All Status</option>
			@foreach(['shortlisted','first_interview','second_interview','third_interview','hired','rejected','blacklisted'] as $s)
				<option value="{{ $s }}" @selected(request('status')===$s)>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
			@endforeach
		</select>
		<button class="bg-blue-600 text-white px-4">Search</button>
		<a href="{{ route('candidates.create') }}" class="bg-green-600 text-white px-4 py-2">New</a>
	</form>

	@if(session('status'))
		<div class="bg-green-100 border p-2 mb-3">{{ session('status') }}</div>
	@endif

	<table class="w-full border">
		<thead>
			<tr class="bg-gray-100">
				<th class="p-2 text-left">Name</th>
				<th class="p-2 text-left">Technology</th>
				<th class="p-2 text-left">Level</th>
				<th class="p-2 text-left">Status</th>
				<th class="p-2">Actions</th>
			</tr>
		</thead>
		<tbody>
		@foreach($candidates as $c)
			<tr class="border-t">
				<td class="p-2">{{ $c->name }}</td>
				<td class="p-2">{{ $c->technology }}</td>
				<td class="p-2">{{ ucfirst($c->level) }}</td>
				<td class="p-2">{{ ucfirst(str_replace('_',' ',$c->status)) }}</td>
				<td class="p-2 flex gap-2">
					<a href="{{ route('candidates.show',$c) }}" class="text-blue-600">View</a>
					<form method="post" action="{{ route('candidates.destroy', $c) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this candidate?')">
						@csrf
						@method('DELETE')
						<button type="submit" class="text-red-600">Delete</button>
					</form>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>

	<div class="mt-3">{{ $candidates->links() }}</div>
</div>
@endsection


