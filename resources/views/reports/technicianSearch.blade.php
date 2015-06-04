<table class="table table-condensed" id="table_show">
			<tr>
				
				<td class="text-center">Technician</td>
				<td class="text-center">Closed Tickets</td>
				<td class="text-center">Active Tickets</td>
			</tr>
			@for($i = 0; $i < count($technicians); $i++)
				    <tr id="{{ $technicians[$i]['tech_id'] }}">				   		
				   		<td class='subject text-center'><a  href="{{ url('/users/'.$technicians[$i]['tech_id']) }}">{{ $technicians[$i]['fname'] }} {{ $technicians[$i]['lname'] }}</a></td>
				   		<td class="category text-center">
				   			@if($technicians[$i]['closed'] != null)
				   				{{ $technicians[$i]['closed'] }}	
				   			@else
				   				0
				   			@endif
				   		</td>
				   		<td class="status text-center"> 
				   				@if($technicians[$i]['open'] != null)
				   				{{ $technicians[$i]['open'] }} 
				   				@else
				   					0
				   				@endif
				   		</td>
				   </tr>
			  @endfor
		  
		</table>