@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Create Offer for {{ $candidate->name }}</h1>

    <form method="post" action="{{ route('offers.store', $candidate) }}" class="space-y-4">
        @csrf

        <!-- Offer Details Form -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Position Title</label>
                <input type="text" name="position" id="position" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ ucfirst($candidate->level) }} {{ $candidate->technology }} Developer" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Start Date</label>
                <input type="date" name="start_date" id="start_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ now()->addDays(30)->format('Y-m-d') }}" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Salary</label>
                <input type="text" name="salary" id="salary" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="Rs.{{ number_format($candidate->salary_expectation) }} per month" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Reporting To</label>
                <input type="text" name="reporting_to" id="reporting_to" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="Development Manager" required>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Job Responsibilities</label>
            <textarea name="responsibilities" id="responsibilities" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>As a {{ ucfirst($candidate->level) }} {{ $candidate->technology }} Developer, you will be responsible for developing and implementing user interface components using {{ $candidate->technology }} concepts and workflows. You will also be responsible for profiling and improving front-end performance and documenting our front-end codebase.</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Benefits</label>
            <textarea name="benefits" id="benefits" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>Cellapp offers a comprehensive benefits package including health insurance, dental and vision coverage, 401(k) matching, paid time off, professional development opportunities, and flexible working arrangements.</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Contingencies</label>
            <textarea name="contingencies" id="contingencies" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>This offer is contingent upon the successful completion of a background check and reference verification. Please indicate your acceptance of this offer by signing and returning this letter by {{ now()->addDays(14)->format('F j, Y') }}.</textarea>
        </div>

        <!-- Preview Button -->
        <button type="submit" formaction="{{ route('offers.preview', $candidate) }}" class="bg-blue-600 text-white px-4 py-2 rounded">Preview Offer Letter</button>

        <!-- Submit Button -->
        <button type="submit" class="bg-purple-700 text-white px-4 py-2 rounded">Create Offer</button>
    </form>
</div>
@endsection
