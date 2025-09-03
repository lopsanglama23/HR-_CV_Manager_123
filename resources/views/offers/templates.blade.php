@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
	<h1 class="text-2xl font-bold mb-4">Offer Templates</h1>
	@if(session('status'))
		<div class="bg-green-100 border p-2 mb-3">{{ session('status') }}</div>
	@endif
	<form method="post" action="{{ route('offers.templates.store') }}" class="space-y-2 mb-4">
		@csrf
		<input name="name" class="border p-2 w-full" placeholder="Template name" required />
		<textarea name="body_markdown" class="border p-2 w-full h-40" placeholder="Markdown body" required>Subject: Employment offer from [company name]

Dear [candidate's first name],

We are pleased to offer you the position of [designation] at [company name].

Your annual cost to company is ₹ xxx,xxx [in words]. The break down of your gross salary and information specific to employee benefits can be found in Annexure A.

We would like you to start work on [joining date] from the base location, [work location].

You will work with the [team's name - Development/Marketing/HR] team and report directly to [manager's name and designation].

If you choose to accept this job offer, please sign and return this letter by [offer expiry date]. Once we receive your acceptance, we will provide information about onboarding and other asset details.

We are confident that you will find this offer exciting and I, on behalf of [company name], assure you of a very rewarding career in our organization.

Sincerely,

[Sender name]
[Designation], [Company name]</textarea>
		<button class="bg-green-700 text-white px-4 py-2">Save Template</button>
	</form>
	@foreach($templates as $t)
		<div class="border p-3 mb-2"><strong>{{ $t->name }}</strong></div>
	@endforeach
</div>
@endsection


