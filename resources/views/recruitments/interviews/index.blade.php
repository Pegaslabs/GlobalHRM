@extends ('layouts.app') 
@section ('title', trans('labels.recruitments.jobs.page_title')) 
@section('contentheader_title')
	{{ trans('labels.recruitments.candidate_interviews.content_title') }} <small>
@endsection 
@section('contentheader_description')
	{{ trans('labels.recruitments.candidate_interviews.content_title_description_list') }}</small>
@endsection 


@section('main-content')
<div class="box box-success">
	<div class="box-header with-border">
		<h3 class="box-title">{{ trans('labels.recruitments.candidate_interviews.content_title_description_list')}}</h3>
	</div>
	<!-- /.box-header -->

	<div class="box-body">
		<div id="calendar" class="fc fc-ltr fc-unthemed"></div>  
	</div>
	<!-- /.box-body -->	
	<!--box-->	
</div>
@stop
