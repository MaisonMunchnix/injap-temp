<style>
	table{
		width: 100%;
		border-collapse: collapse;
	}
	
	th,td{
		border: 1px solid gray;
		padding: 5px;
	}
	
	
</style>


<table class="table mb-0 thead-border-top-0" id="generated_codes_table">
	<thead>
		<tr>
			<th>Code</th>
			<th>Security Pin</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody class="list">
		@foreach($product_codes as $product_code)
		<tr>
			<td id="myInput_{{ $product_code->id }}">{{ $product_code->code }}</td>
			<td id="myInput_{{ $product_code->id }}">{{ $product_code->security_pin }}</td>
			<td>{{ $product_code->status }}</td>
		</tr>
		@endforeach
	</tbody>
</table>
