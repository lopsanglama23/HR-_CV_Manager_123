@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 space-y-6">
    @if(session('status'))
        <div class="bg-green-100 border p-2">{{ session('status') }}</div>
    @endif

    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold">Create Assignment for {{ $candidate->name }}</h1>
        <a href="{{ route('assignments.candidate.index', $candidate) }}" class="text-blue-600">Back to Assignments</a>
    </div>

    <form method="post" action="{{ route('assignments.store', [$candidate]) }}" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label for="title" class="block font-medium">Title</label>
            <input type="text" name="title" id="title" class="border p-2 w-full" required>
        </div>

        <div>
            <label for="description" class="block font-medium">Description</label>
            <textarea name="description" id="description" class="border p-2 w-full" rows="4"></textarea>
        </div>

        <div>
            <label for="attachment" class="block font-medium">Attachment (optional)</label>
            <input type="file" name="attachment" id="attachment" class="border p-2 w-full">
        </div>

        <div>
            <label for="due_date" class="block font-medium">Due Date (optional)</label>
            <input type="datetime-local" name="due_date" id="due_date" class="border p-2 w-full">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Create Assignment</button>
    </form>
</div>
@endsection
