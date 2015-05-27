@extends('app')

@section('content')
	
		<h2>Model :</h2>
			{{ $asset->name }}
		<h2>Manufacturer :</h2>
			{{ $asset->manufacturer }}
		<h2>Type :</h2>
			{{ $asset->assettype->name }}
		<h2>Serial Number :</h2>
			{{ $asset->serialno }}
		<h2>Belongs To :</h2>
			{{ $asset->user->name }}
		<h2>Location :</h2>
			{{ $asset->location }}
	


@endsection
