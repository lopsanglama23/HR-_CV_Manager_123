@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 space-y-6">
    @if(session('status'))
        <div class="bg-green-100 border p-2">{{ session('status') }}</div>
    @endif

    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold">{{ $assignment->title }}</h1>
        <div class="flex space-x-2">
            <a href="{{ route('assignments.edit', [$candidate, $assignment]) }}" class="bg-yellow-600 text-white px-3 py-1 rounded">Edit</a>
            <a href="{{ route('assignments.candidate.index', $candidate) }}" class="text-blue-600">Back to Assignments</a>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <div class="border p-4 rounded">
            <h2 class="text-xl font-semibold mb-4">Assignment Details</h2>
            <div class="space-y-3">
                <div>
                    <strong>Title:</strong> {{ $assignment->title }}
                </div>
                <div>
                    <strong>Description:</strong>
                    <p class="mt-1">{{ $assignment->description }}</p>
                </div>
                <div>
                    <strong>Status:</strong>
                    <span class="px-2 py-1 rounded text-sm {{ $assignment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($assignment->status === 'submitted' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                        {{ ucfirst($assignment->status) }}
                    </span>
                </div>
                @if($assignment->due_date)
                    <div>
                        <strong>Due Date:</strong> {{ $assignment->due_date->format('d M Y H:i') }}
                    </div>
                @endif
                @if($assignment->submitted_at)
                    <div>
                        <strong>Submitted At:</strong> {{ $assignment->submitted_at->format('d M Y H:i') }}
                    </div>
                @endif
                @if($assignment->attachment_path)
                    <div>
                        <strong>Attachment:</strong>
                        <a href="{{ asset('storage/'.$assignment->attachment_path) }}" target="_blank" class="text-blue-600">Download</a>
                    </div>
                @endif
                @if($assignment->submission_path)
                    <div>
                        <strong>Submission:</strong>
                        <a href="{{ asset('storage/'.$assignment->submission_path) }}" target="_blank" class="text-blue-600">Download</a>
                    </div>
                @endif
                @if($assignment->remarks)
                    <div>
                        <strong>Remarks:</strong>
                        <p class="mt-1">{{ $assignment->remarks }}</p>
                    </div>
                @endif
            </div>
        </div>

        @if($assignment->status === 'pending')
            <div class="border p-4 rounded">
                <h2 class="text-xl font-semibold mb-4">Submit Assignment</h2>
                <form method="post" action="{{ route('assignments.submit', [$candidate, $assignment]) }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label for="submission" class="block font-medium">Submission File</label>
                        <input type="file" name="submission" id="submission" class="border p-2 w-full" required>
                    </div>

                    <div>
                        <label for="remarks" class="block font-medium">Remarks (optional)</label>
                        <textarea name="remarks" id="remarks" class="border p-2 w-full" rows="3"></textarea>
                    </div>

                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Submit Assignment</button>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection
