@extends('layouts.app')

@section('content')
<div >
    <div >
        <h1>Cellapp</h1>
        <p class="text-gray-600">5</p>
        <p class="text-gray-600">Phone: +977 9864353243 | Email: hr@cellapp.com</p>
    </div>
    <div class="mb-6 text-right">
        <p>{{ \Carbon\Carbon::now()->format('F j, Y') }}</p>
    </div>
    <div class="mb-6">
        <p>{{ $candidate->name }}</p>
        <p>{{ $candidate->email }}</p>
        @if($candidate->phone)
        <p>{{ $candidate->phone }}</p>
        @endif
    </div>
    <div class="mb-6">
        <p>Dear {{ $candidate->name }},</p>
    </div>
    <div class="mb-6 space-y-4">
        <p>We are pleased to offer you the position of <strong>{{ $data['position'] }}</strong> at Cellapp. This letter outlines the terms and conditions of your employment.</p>

        <div>
            <h3 class="font-semibold text-lg mb-2">Position Details:</h3>
            <ul class="list-disc list-inside space-y-1 ml-4">
                <li><strong>Position:</strong> {{ $data['position'] }}</li>
                <li><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($data['start_date'])->format('F j, Y') }}</li>
                <li><strong>Salary:</strong> {{ $data['salary'] }}</li>
                <li><strong>Reporting To:</strong> {{ $data['reporting_to'] }}</li>
            </ul>
        </div>

        <div>
            <h3 class="font-semibold text-lg mb-2">Job Responsibilities:</h3>
            <p class="ml-4 whitespace-pre-line">{{ $data['responsibilities'] }}</p>
        </div>

        <div>
            <h3 class="font-semibold text-lg mb-2">Benefits:</h3>
            <p class="ml-4 whitespace-pre-line">{{ $data['benefits'] }}</p>
        </div>

        <div>
            <h3 class="font-semibold text-lg mb-2">Contingencies:</h3>
            <p class="ml-4 whitespace-pre-line">{{ $data['contingencies'] }}</p>
        </div>

        <p>We look forward to welcoming you to the Cellapp team!</p>
    </div>
    <div class="mb-8">
        <p>Sincerely,</p>
        <div class="mt-8">
            <p class="font-semibold">Cellapp HR Team</p>
        </div>
    </div>
    <div class="flex space-x-4 justify-center border-t pt-6">
        <form method="post" action="{{ route('offers.store', $candidate) }}">
            @csrf
            @foreach($data as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                Create Offer Letter
            </button>
        </form>
        <a href="{{ route('offers.create', $candidate) }}" class="bg-gray-600 text-white px-6 py-2 rounded hover:bg-gray-700">
            Edit
        </a>
    </div>
</div>
@endsection
