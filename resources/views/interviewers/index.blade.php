@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Interviewers</h1>

    <ul class="list-disc pl-5 space-y-2">
        @foreach(config('interviewers') as $interviewer)
            <li>
                <a href="{{ route('interviewers.show', ['email' => $interviewer['email']]) }}" class="text-blue-600 hover:underline">
                    {{ $interviewer['name'] }} ({{ $interviewer['email'] }})
                </a>
            </li>
        @endforeach
    </ul>
</div>
@endsection
