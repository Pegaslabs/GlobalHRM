@if (count($errors) > 0)

<div class="alert alert-danger alert-dismissible">
	<button type="button" class="close" data-dismiss="alert"
		aria-hidden="true">×</button>
	<h4>
		<i class="icon fa fa-ban"></i> Alert!
	</h4>
	<strong>Whoops! Something went wrong!</strong> <br> <br>

	<ul>
		@foreach ($errors->all() as $error)
			<li>{{ $error }}</li> 
		@endforeach
	</ul>
</div>

@endif
