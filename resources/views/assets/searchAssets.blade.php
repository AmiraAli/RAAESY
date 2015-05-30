@if (Auth::user()->type === "admin")
<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />

<table class="table table-hover">
		<thead>
			<tr>
				<th class="text-center">Model</th>
				<th class="text-center">Manufacturer</th>
				<th class="text-center">Type</th>
				<th class="text-center">Serial Number</th>
				<th class="text-center">Belongs To</th>
				<th class="text-center">Location</th>
			</tr>
		</thead>
		<tbody>
		@foreach ($assets as $asset) 
     		
			        <tr id="{{ $asset->id }}">
			            <td class="text-center"><a href="/assets/{{ $asset->id }}"><b>{{ $asset->name }}</b></a></td>
 						<td class="text-center">{{ $asset->manufacturer }}</td>
			            <td class="text-center">{{ $asset->assettype->name }}</td>
			            <td class="text-center">{{ $asset->serialno }}</td>
			            <td class="text-center">{{ $asset->user->fname }}</td>
			            <td class="text-center">{{ $asset->location }}</td>

			            <td class="text-center">
			            	 <a href="/assets/{{$asset->id}}/edit " class="btn btn-success btn" >Edit</a>
			            </td>
			            <td class="text-center">

				            <button class="btn btn-danger" onclick="deleteAsset( {{ $asset->id }} )">Delete</button>

			            </td>

			        </tr>
     		@endforeach

     	</tbody>
	</table>
@endif