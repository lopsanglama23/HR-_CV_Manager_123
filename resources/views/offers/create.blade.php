@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
	<h1 class="text-2xl font-bold mb-4">Create Offer for {{ $candidate->name }}</h1>
	<form method="post" action="{{ route('offers.store',$candidate) }}" class="space-y-2">
		@csrf
		<textarea id="body" name="body_markdown" class="border p-2 w-full h-64" placeholder="Markdown body" required></textarea>
		<button class="bg-purple-700 text-white px-4 py-2">Create Offer</button>
	</form>
	<script>
		const picker=document.getElementById('templatePicker');
		const body=document.getElementById('body');
		picker?.addEventListener('change',()=>{ if(picker.value){ body.value=picker.value; } });
	</script>
</div>
@endsection
