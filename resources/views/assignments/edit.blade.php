@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 space-y-6">
    @if(session('status'))
        <div class="bg-green-100 border p-2">{{ session('status') }}</div>
    @endif

    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold">Edit Assignment: {{ $assignment->title }}</h1>
        <a href="{{ route('assignments.show', [$candidate, $assignment]) }}" class="text-blue-600">Back to Assignment</a>
    </div>

    <form method="post" action="{{ route('assignments.update', [$candidate, $assignment]) }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PATCH')

        <div>
            <label for="title" class="block font-medium">Title</label>
            <input type="text" name="title" id="title" class="border p-2 w-full" value="{{ $assignment->title }}" required>
        </div>

        <div>
            <label for="description" class="block font-medium">Description</label>
            <textarea name="description" id="description" class="border p-2 w-full" rows="4">{{ $assignment->description }}</textarea>
        </div>

        <div>
            <label for="attachment" class="block font-medium">Attachment (optional)</label>
            <input type="file" name="attachment" id="attachment" class="border p-2 w-full">
            @if($assignment->attachment_path)
                <p class="mt-1 text-sm text-gray-600">Current: <a href="{{ asset('storage/'.$assignment->attachment_path) }}" target="_blank" class="text-blue-600">Download</a></p>
            @endif
        </div>

        <div>
            <label for="due_date" class="block font-medium">Due Date (optional)</label>
            <input type="datetime-local" name="due_date" id="due_date" class="border p-2 w-full" value="{{ $assignment->due_date ? $assignment->due_date->format('Y-m-d\TH:i') : '' }}">
        </div>

        <div>
            <label for="status" class="block font-medium">Status</label>
            <select name="status" id="status" class="border p-2 w-full">
                <option value="pending" {{ $assignment->status === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="submitted" {{ $assignment->status === 'submitted' ? 'selected' : '' }}>Submitted</option>
                <option value="evaluated" {{ $assignment->status === 'evaluated' ? 'selected' : '' }}>Evaluated</option>
            </select>
        </div>

        <div>
            <label for="remarks" class="block font-medium">Remarks</label>
            <textarea name="remarks" id="remarks" class="border p-2 w-full" rows="3">{{ $assignment->remarks }}</textarea>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update Assignment</button>
    </form>
</div>
@endsection
