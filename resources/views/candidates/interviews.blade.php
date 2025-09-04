@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    @if(session('status'))
        <div class="bg-green-100 border p-2">{{ session('status') }}</div>
    @endif

    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">Interviews for {{ $candidate->name }}</h1>
        <a href="{{ route('candidates.show', $candidate) }}" class="text-blue-600">Back to Candidate</a>
    </div>

    <div class="grid md:grid-cols-2 gap-4 mb-6">
        <div>
            <h2 class="text-xl font-semibold mb-2">Schedule Interview</h2>
            <p class="mb-2">Scheduling interview for: <strong>{{ $candidate->name }}</strong></p>
            <form method="post" action="{{ route('candidates.interviews.store', $candidate) }}">
                @csrf
                <div class="mb-2">
                    <label>Round:</label>
                    <select name="round" class="border p-2 w-full">
                        <option value="first">First</option>
                        <option value="second">Second</option>
                        <option value="third">Third</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label>Scheduled At:</label>
                    <input type="datetime-local" name="scheduled_at" class="border p-2 w-full" required />
                </div>
                <div class="mb-2">
                    <label>Interviewer:</label>
                    <select name="interviewer" class="border p-2 w-full">
                        @foreach(config('interviewers') as $interviewer)
                            <option value="{{ $interviewer['name'] }}|{{ $interviewer['email'] }}">{{ $interviewer['name'] }} ({{ $interviewer['email'] }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-2">
                    <label>Remarks:</label>
                    <textarea name="remarks" class="border p-2 w-full" placeholder="Remarks"></textarea>
                </div>
                <button class="bg-blue-600 text-white px-4 py-2">Schedule</button>
            </form>
        </div>

        <div>
            <h2 class="text-xl font-semibold mb-2">Interviews</h2>
            @foreach($candidate->interviews as $i)
                <div class="border p-4 mb-4">
                    <div class="font-semibold">{{ ucfirst($i->round) }} - {{ $i->scheduled_at->format('d M Y H:i') }}</div>
                    <div class="text-sm">{{ $i->interviewer_name }} ({{ $i->interviewer_email }})</div>
                    <div class="text-sm">Remarks: {{ $i->remarks }}</div>
                    <div class="text-sm">Result: {{ ucfirst($i->result) }}</div>
                    <form method="post" class="mt-2 flex gap-2" action="{{ route('candidates.interviews.update', [$candidate, $i]) }}">
                        @csrf
                        @method('PATCH')
                        <select name="result" class="border p-1">
                            @foreach(['pending','pass','fail'] as $r)
                                <option value="{{ $r }}" @selected($i->result === $r)>{{ ucfirst($r) }}</option>
                            @endforeach
                        </select>
                        <button class="bg-gray-700 text-white px-2 py-1">Save</button>
                        <button class="bg-red-600 text-white px-2 py-1" type="button" onclick="if(confirm('Are you sure?')) { document.getElementById('delete-form-{{ $i->id }}').submit(); }">Delete</button>
                    </form>
                    <form id="delete-form-{{ $i->id }}" method="post" action="{{ route('candidates.interviews.destroy', [$candidate, $i]) }}" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
