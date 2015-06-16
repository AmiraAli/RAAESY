<table class="table table-hover">
	<thead>
		<tr class="navbtn txtnav">
			<th class="text-center">Model</th>
			<th class="text-center">Manufacturer</th>
			<th class="text-center">Type</th>
			<th class="text-center">Serial Number</th>
			<th class="text-center">Belongs To</th>
			<th class="text-center">Location</th>
			<th class="text-center">Action</th>
		</tr>
	</thead>
	<tbody>
 		@foreach ($assets as $asset)
	        <tr id="{{ $asset->id }}">
	            <td class="text-center"><a href="/assets/{{ $asset->id }}"><b>{{ $asset->name }}</b></a></td>
	            <td class="text-center">{{ $asset->manufacturer }}</td>
	            <td class="text-center">{{ $asset->assettype->name }}</td>
	            <td class="text-center">{{ $asset->serialno }}</td>
	            <td class="text-center"><a href="/users/{{ $asset->user_id}}"><b>{{ $asset->user->fname }} {{ $asset->user->lname }}</b></a></td>
	            <td class="text-center">{{ $asset->location }}</td>
	            <td class="text-center">
	            	<a  title="Edit Asset" href="/assets/{{$asset->id}}/edit" class="do"><img src="/images/edit.png" width="30px" height="30px">	</a>
	          		&ensp;&ensp; &ensp;
		          	<a title="Delete Asset" href="#" onclick="deleteAsset( {{ $asset->id }} )"><img src="/images/delete.png" width="30px" height="30px"></a>

	            </td>
	        </tr>
 		@endforeach
 	</tbody>
</table>
<center><?php echo $assets->render(); ?></center>
