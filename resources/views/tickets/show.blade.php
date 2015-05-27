@extends('app')
@section('content')
<div class="container">
<p> Subject: {{ $ticket->subject->name }}</p>
<p> Description: {{ $ticket->description }}</p>
<p> Category: {{ $ticket->category->name }}</p>
<p> Periorty: {{ $ticket->priority }}</p>
<hr>
</div>
@endsection