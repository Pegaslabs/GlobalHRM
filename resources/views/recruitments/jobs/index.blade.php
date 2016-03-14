@extends ('layouts.app') 
@section ('title', trans('labels.recruitments.jobs.page_title')) 
@section('contentheader_title')
	{{ trans('labels.recruitments.jobs.content_title') }} <small>
@endsection 
@section('contentheader_description')
	{{ trans('labels.recruitments.jobs.content_title_description_list') }}</small>
@endsection 


@section('main-content')
<div class="box box-success">
	<div class="box-header with-border">
		<h3 class="box-title">{{ trans('labels.recruitments.jobs.content_title')}}</h3>
		<div class="box-tools">
			<div class="input-group input-group-sm" style="width: 150px;">
				<input type="text" name="table_search"
					class="form-control pull-right" placeholder="Search">

				<div class="input-group-btn">
					<button type="submit" class="btn btn-default">
						<i class="fa fa-search"></i>
					</button>
				</div>
			</div>
			
		</div>
	</div>
	<!-- /.box-header -->

	<div class="box-body">
		
		<div class="table-responsive" style = 'overflow-x:visible'>	
			<table class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th>{{ trans('labels.recruitments.jobs.columns.id') }}</th>
						<th>{{ trans('labels.recruitments.jobs.columns.title_id') }}</th>
						<th>{{ trans('labels.recruitments.jobs.columns.no_pos') }}</th>
						<th>{{ trans('labels.recruitments.jobs.columns.short_description') }}</th>
						<th>{{ trans('labels.recruitments.jobs.columns.department_id') }}</th>
						<th>{{ trans('labels.recruitments.jobs.columns.priority') }}</th>
						<th>{{ trans('labels.recruitments.jobs.columns.employment_type_id') }}</th>
						<th>{{ trans('labels.recruitments.jobs.columns.experience_level_id') }}</th>						
						<th>{{ trans('labels.recruitments.jobs.columns.status_id') }}</th>
						<th>{{ trans('labels.recruitments.jobs.columns.closing_date') }}</th>
						<th>{{ trans('labels.recruitments.jobs.columns.actions') }}</th>
					</tr>
				</thead>
			
				<tbody>
					@foreach ($jobs as $job)
					<tr>
						<td>{!! 'JD.'.str_pad($job->id, 8 , "0", STR_PAD_LEFT); !!}</td>
						<td>{!! $job->title_name !!}</td>
						<td>{!! $job->no_pos !!}</td>
						<td>{!! $job->short_description !!}</td>
						<td>{!! $job->department_name !!}</td>
						<td>{!! $job->priority !!}</td>
						<td>{!! $job->emp_type_name !!}</td>
						<td>{!! $job->emp_level_name !!}</td>
						<td>
							<span class="badge bg-{{$job->display}}">{{ $job->status_name }}</span>												
						</td>
						<td>{!! $job->closing_date !!}</td>

						<td>
							<div class="text-left">					
				                <a class="btn btn-social-icon btn-facebook" onClick="SocialShare.facebook('{{route('recruitments.jobs.show',['jobs'=>$job->id])}}')"><i class="fa fa-facebook"></i></a>
				                <a class="btn btn-social-icon btn-google"   onClick="SocialShare.google('{{route('recruitments.jobs.show',['jobs'=>$job->id])}}')"><i class="fa fa-google-plus"></i></a>
				                <a class="btn btn-social-icon btn-linkedin" onClick="SocialShare.linkedin('{{route('recruitments.jobs.show',['jobs'=>$job->id])}}')"><i class="fa fa-linkedin"></i></a>
				                <a class="btn btn-social-icon btn-twitter"  onClick="SocialShare.twitter('{{route('recruitments.jobs.show',['jobs'=>$job->id])}}')"><i class="fa fa-twitter"></i></a>
				                <br>
				                <br>
				                <button type="button" class="btn btn-block btn-info" onclick="window.location='{{url('recruitments/jobs/' . $job->id) }}'">Details</button>							
			              </div>													
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>			
			<div class="col-sm-7">
				<div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
					{!! $jobs->links() !!}
				</div>
			</div>			
		</div>	
		<div class="col-sm-12">
			<button onclick="window.location.href='{{ URL::to('recruitments/jobs/create') }}'; return false;" class="btn btn-small btn-primary">Add New <i class="fa fa-plus"></i></button>
		</div>	
	</div>
	<!-- /.box-body -->	
	<!--box-->	
</div>
@stop
