<html>
<head>

        <script src="/js/ticket_status.js"></script>
</head>
<body>
<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />
@extends('app')
@section('content')
<div class="container">
<h1>
Related tags
</h1>
@foreach($relatedTickets as $relatedTicket)
@foreach($relatedTicket as $Ticket)
@if($Ticket->id!=$ticket->id)
<a href="/tickets/{{$Ticket->id}}">{{substr($Ticket->description,0,10)."....."}}</a><br>
@endif
@endforeach
@endforeach



__________________________________________________

<h1>related assets</h2>
@foreach($relatedAssets as $relatedAsset)

<a href="/assets/{{$relatedAsset->id}}">{{$relatedAsset->name}}</a><br>

@endforeach


_____________________________________________

@if($checkStatus->value=='open')
<button name="close" id="{{$ticket->id}}" onclick="Status({{$ticket->id}})">closed</button>
@endif

@if($checkStatus->value=='close')
<button name="open" id="{{$ticket->id}}" onclick="Status({{$ticket->id}})" >reopen</button>
@endif


@if($ticket->tech_id and $checkStatus->value=='open')
<button>takeover</button>
@endif
<p> Subject: {{ $ticket->subject->name }}</p>
<p> Description: {{ $ticket->description }}</p>
<p> Category: {{ $ticket->category->name }}</p>
<p> Periorty: {{ $ticket->priority }}</p>
<hr>
</div>
@endsection
</body>
</html>
