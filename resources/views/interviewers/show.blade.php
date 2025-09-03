@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Interviews for {{ $interviewer['name'] }}</h1>

    @if($interviews->isEmpty())
        <p>No interviews scheduled.</p>
    @else
        <div class="space-y-4">
            @foreach($interviews as $interview)
                <div class="border p-4 rounded">
                    <h2 class="text-lg font-semibold">{{ ucfirst($interview->round) }} Round Interview</h2>
                    <p><strong>Candidate:</strong> {{ $interview->candidate->name }}</p>
                    <p><strong>Scheduled At:</strong> {{ $interview->scheduled_at->format('d M Y H:i') }}</p>
                    <p><strong>Remarks:</strong> {{ $interview->remarks ?: 'None' }}</p>
                    <p><strong>Result:</strong> {{ ucfirst($interview->result ?: 'Pending') }}</p>
                </div>
            @endforeach
        </div>
    @endif

    <a href="{{ route('interviewers.index') }}" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded">Back to Interviewers</a>
</div>
@endsection
