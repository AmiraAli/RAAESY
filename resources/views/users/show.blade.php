@extends('app')
@section('content')
<div class="container">
<h4>First Name:</h4>{{$user->fname}}
<h4>Last Name : </h4>{{$user->lname}}
<h4>Email:</h4>{{$user->email}}
<h4>Phone :</h4> {{$user->phone}}
<h4>Location :</h4> {{$user->location}}
<h4> Type:</h4> {{$user->type}}
<h4>Disabled :</blh4> <input type="checkbox" value={{$user->isspam}} disabled>
</div>
@stop
