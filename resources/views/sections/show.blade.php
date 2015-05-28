@extends('app')
@section('content')
<div class="container">
<h1> {{ $section->name}}
</h1>
<ul>
 @foreach ($section->categories as $category)

	<li>{{ $category->name }}</li>
	@endforeach
</ul>
</div>
@endsection