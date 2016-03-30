@extends ('layouts.app') 
@section ('title', trans('labels.recruitments.resumes.content_title'))
@section('contentheader_title') 
{{
	trans('labels.recruitments.resumes.content_title') 
}}
<small> 
@endsection 
@section('contentheader_description') 
{{
	trans('labels.recruitments.resumes.content_title_description_list') 
}}
</small>
@endsection 
@section('main-content')
{!! Form::open(array('url' =>'', 'accept-charset'=>'UTF-8', 'name' =>'Frm_Delete_Interview', 'class'=>'form-horizontal','style'=>'display:inline')) !!} 
{!! Form::hidden('_method', 'DELETE')!!}		
<div class="box box-success">
	<div class="box-header with-border">
		<h3 class="box-title">{{
			trans('labels.recruitments.resumes.content_title_description_list')}}</h3>		
	</div>
	<input type="hidden" id='data_url' name='data_url' value="{{route('recruitments.search.resumes')}}">
	<!-- /.box-header -->
	<div class="box-body">
		<div class="table-responsive" style='overflow-x: visible'>		
			<table id="tblResumes" class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th>{{ trans('labels.recruitments.resumes.columns.id') }}</th>
						<th>{{ trans('labels.recruitments.resumes.columns.candidate_id') }}</th>
						<th>{{ trans('labels.recruitments.resumes.columns.email') }}</th>
						<th>{{ trans('labels.recruitments.resumes.columns.job_function_id') }}</th>
						<th>{{ trans('labels.recruitments.resumes.columns.mime') }}</th>
						<th>{{ trans('labels.recruitments.jobs.columns.actions') }}</th>
					</tr>
				</thead>
			</table>			
		</div>		
	</div>
	<!-- /.box-body -->
	<!--box-->
</div>
{!!Form::close()!!}	
@include('dialogs.dlg_delete_confirm')

<script src="{{ asset('/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {  
	$url = 	$('input[name="data_url"]').val();			
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
	});
	$('#tblResumes').dataTable( {
		 "processing": true,
		 "serverSide": true,
		 "ajax": {
			type: "post",		 
			url: $url,
			error: function(){  
				console.log('Error while retrieving data from server. Please check your server and try again.');
			}
		 },
		 "ordering": false,
	});
});
</script>

@stop
