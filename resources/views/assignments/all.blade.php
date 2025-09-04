@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 space-y-6">
    @if(session('status'))
        <div class="bg-green-100 border p-2">{{ session('status') }}</div>
    @endif

    <div class="flex items-center justify-between">
        <h1 style="color: #333;">All Assignments</h1>
        <a href="{{ route('candidates.index') }}" class="text-blue-600">Back to Candidates</a>
    </div>

    @if($assignments->count() > 0)
        <div class="space-y-4">
            @foreach($assignments as $assignment)
                <div class="border p-4 rounded">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <h3 class="font-semibold text-lg">{{ $assignment->title }}</h3>
                            <p class="text-gray-600 mt-1">{{ $assignment->description }}</p>
                            <div class="mt-2 space-y-1">
                                <p><strong>Candidate:</strong> <a href="{{ route('candidates.show', $assignment->candidate) }}" class="text-blue-600">{{ $assignment->candidate->name }}</a></p>
                                <p><strong>Status:</strong> <span class="px-2 py-1 rounded text-sm {{ $assignment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($assignment->status === 'submitted' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">{{ ucfirst($assignment->status) }}</span></p>
                                @if($assignment->due_date)
                                    <p><strong>Due Date:</strong> {{ $assignment->due_date->format('d M Y H:i') }}</p>
                                @endif
                                @if($assignment->submitted_at)
                                    <p><strong>Submitted At:</strong> {{ $assignment->submitted_at->format('d M Y H:i') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="flex space-x-2 ml-4">
                            <a href="{{ route('assignments.show', [$assignment->candidate, $assignment]) }}" class="bg-gray-600 text-white px-3 py-1 rounded">View</a>
                            <a href="{{ route('assignments.edit', [$assignment->candidate, $assignment]) }}" class="bg-yellow-600 text-white px-3 py-1 rounded">Edit</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-600">No assignments found.</p>
    @endif
</div>
@endsection
