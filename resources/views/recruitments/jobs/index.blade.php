@extends ('layouts.app') @section ('title',
trans('labels.recruitments.jobs.page_title'))
@section('contentheader_title') {{
trans('labels.recruitments.jobs.content_title') }}
<small> @endsection @section('contentheader_description') {{
	trans('labels.recruitments.jobs.content_title_description_list') }}</small>
@endsection @section('main-content')
<div class="box box-success">
	<div class="box-header with-border">
		<h3 class="box-title">{{
			trans('labels.recruitments.jobs.content_title_description_list')}}</h3>		
	</div>
	<input type="hidden" id='data_url' name='data_url' value="{{route('recruitments.search.jobs')}}">
	<!-- /.box-header -->
	<div class="box-body">
		<div class="table-responsive" style='overflow-x: visible'>		
			<table id="tblJobs" class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th>{{ trans('labels.recruitments.jobs.columns.id') }}</th>
						<th>{{ trans('labels.recruitments.jobs.columns.title_id') }}</th>
						<th>{{ trans('labels.recruitments.jobs.columns.no_pos') }}</th>
						<th>{{ trans('labels.recruitments.jobs.columns.short_description')
							}}</th>
						<th>{{ trans('labels.recruitments.jobs.columns.department_id') }}</th>
						<th>{{ trans('labels.recruitments.jobs.columns.priority') }}</th>
						<th>{{
							trans('labels.recruitments.jobs.columns.employment_type_id') }}</th>
						<th>{{
							trans('labels.recruitments.jobs.columns.experience_level_id') }}</th>
						<th>{{ trans('labels.recruitments.jobs.columns.status_id') }}</th>
						<th>{{ trans('labels.recruitments.jobs.columns.closing_date') }}</th>
						<th>{{ trans('labels.recruitments.jobs.columns.actions') }}</th>
					</tr>
				</thead>
			</table>			
		</div>
		<div class="col-sm-12">
			<button
				onclick="window.location.href='{{ URL::to('recruitments/jobs/create') }}'; return false;"
				class="btn btn-small btn-primary">
				Add New <i class="fa fa-plus"></i>
			</button>
		</div>
	</div>
	<!-- /.box-body -->
	<!--box-->
</div>

<script src="{{ asset('/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {  
	$url = 	$('input[name="data_url"]').val();			
	
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
	});
	$('#tblJobs').dataTable( {
		 "processing": true,
		 "serverSide": true,
		 "ajax": {
			type: "post",		 
			url: $url,
			error: function(){  
				console.log('Error while retrieving data from server. Please check your server and try again.');
			}
		 },
		 "aoColumnDefs": [
		      { 'bSortable': false, 'aTargets': [ 1,3,6,7,8,10 ] }
		 ]
	});
});
</script>

@stop
