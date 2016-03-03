@extends ('layouts.master')
@section ('title', trans('labels.recruitments.title')) @section('page-header')
<h1>
	{{ trans('labels.recruitments.title') }} 
	<small>{{
		trans('labels.recruitments.jobs.job_request_list') }}
	</small>
</h1>
@endsection 

@section('content')
<div class="box box-success">
	<div class="box-header with-border">
		<h3 class="box-title">{{
			trans('labels.recruitments.jobs.job_request_update') }}</h3>
	</div>
	<!-- /.box-header -->

	<div class="box-body">
		<div class="control-group">
			<div class="controls">
				<span class="label label-warning" id="Job_submit_error"
					style="display: none;"> </span>
			</div>
		</div>
		
		@include('common.errors')				
		{!! Form::model($job, array('route' => array('recruitments.jobs.update', $job->job_id), 'method' => 'PUT', 'class'=>'form-horizontal')) !!}
		
		<div class="form-group" id="field_job_title_id">
			<label class="control-label col-sm-3" for="job_title">{{ trans('labels.recruitments.jobs.table.job_title') }}<font
				class="text-red">*</font></label>
			<div class="controls col-sm-6">
				<select type="select-one" class="form-control" id="job_title"
					name="job_title">					
					@foreach ($jobTitles as $jobTitle)
						@if($jobTitle->job_title_id==$job->job_title_id)
      						<option value="{!! $jobTitle->job_title_id !!}" selected>{!! $jobTitle->job_title_name !!}</option>		
      					@else
      						<option value="{!! $jobTitle->job_title_id !!}">{!! $jobTitle->job_title_name !!}</option>	
      					@endif							
					@endforeach					
				</select>
			</div>
		</div>
		
				
		<div class="form-group" id="field_No_Positions">
			<label class="col-sm-3 control-label" for="job_no_positions">{{ trans('labels.recruitments.jobs.table.job_no_positions') }} <font
				class="text-red">*</font></label>
			<div class="controls col-sm-6">
				<input class="form-control" type="text" id="job_no_positions"
					name="job_no_positions" value="{{$job->job_no_positions}}">
			</div>
		</div>
		
		<div class="form-group" id="field_shortDescription">
			<label class="control-label col-sm-3" for="job_short_description">{{ trans('labels.recruitments.jobs.table.job_short_description') }}
			<font class="text-red">*</font>
			</label>
			<div class="controls col-sm-6">
				<textarea class="form-control" type="textarea" rows="4"
					id="job_short_description" name="job_short_description" >{{$job->job_short_description}}</textarea>
			</div>			
		</div>
			
		<div class="form-group" id="field_full_description">
			<label class="control-label col-sm-3" for="job_full_description">{{ trans('labels.recruitments.jobs.table.job_full_description') }}<font
				class="text-red">*</font></label>
			<div class="controls col-sm-6">
				<textarea class="form-control" type="textarea" rows="4"
					id="job_full_description" name="job_full_description">{{ $job->job_full_description}}</textarea>
			</div>		
					
		</div>
		
		
		
		<div class="form-group" id="field_deplartment_id">
			<label class="control-label col-sm-3" for="request_department_id">{{ trans('labels.recruitments.jobs.table.request_department_id') }}<font
				class="text-red">*</font></label>
			<div class="controls col-sm-6">
				<select type="select-one" class="form-control" id="request_department_id"
					name="request_department_id">
					
						@foreach ($deptList as $dept)
							@if($dept->department_id==$job->request_department_id)
      							<option value="{!! $dept->department_id !!}" selected>{!! $dept->department_name !!}</option>		
      						@else
      							<option value="{!! $dept->department_id !!}">{!! $dept->department_name !!}</option>
      						@endif							
						@endforeach						
				</select>
			</div>
		</div>
		
		<div class="form-group" id="field_emp_type_id">
			<label class="control-label col-sm-3" for="employment_type_id">{{ trans('labels.recruitments.jobs.table.employment_type_id') }}<font
				class="text-red">*</font></label>
			<div class="controls col-sm-6">
				<select type="select-one" class="form-control" id="employment_type_id"
					name="employment_type_id">
					
					@foreach ($empTypes as $empType)	
							@if($empType->employment_type_id==$job->employment_type_id)
      							<option value="{!! $empType->employment_type_id !!}" selected>{!! $empType->employment_type_name !!}</option>	
      						@else
      							<option value="{!! $empType->employment_type_id !!}">{!! $empType->employment_type_name !!}</option>
      						@endif							
					@endforeach					
				</select>
			</div>
		</div>
		
		<div class="form-group" id="field_emp_level_id">
			<label class="control-label col-sm-3" for="employment_level_id">{{ trans('labels.recruitments.jobs.table.employment_level_id') }}<font
				class="text-red">*</font></label>
			<div class="controls col-sm-6">
				<select type="select-one" class="form-control" id="employment_level_id"
					name="employment_level_id">					
					@foreach ($empLevels as $empLevel)
						@if($empLevel->employment_level_id==$job->experience_level_id)								
							<option value="{!! $empLevel->employment_level_id !!}" selected>{!! $empLevel->employment_level_name !!}</option>
						@else
      						<option value="{!! $empLevel->employment_level_id !!}">{!! $empLevel->employment_level_name !!}</option>
      					@endif						
					@endforeach
					
				</select>
			</div>
		</div>
		
		<div class="form-group" id="field_education_level_id">
			<label class="control-label col-sm-3" for="education_level_id">{{ trans('labels.recruitments.jobs.table.education_level_id') }}<font
				class="text-red">*</font></label>
			<div class="controls col-sm-6">
				<select type="select-one" class="form-control" id="education_level_id"
					name="education_level_id">					
					@foreach ($educationLevels as $eduLevel)
						@if($eduLevel->education_level_id==$job->education_level_id)										
							<option value="{!! $eduLevel->education_level_id !!}" selected>{!! $eduLevel->education_level_name !!}</option>
						@else
							<option value="{!! $eduLevel->education_level_id !!}">{!! $eduLevel->education_level_name !!}</option>
						@endif			
					@endforeach
					
				</select>
			</div>
		</div>
						
		<div class="form-group" id="field_emp_nationality">
			<label class="control-label col-sm-3" for="employment_nationality">{{ trans('labels.recruitments.jobs.table.nationality_id') }}<font
				class="text-red">*</font></label>
			<div class="controls col-sm-6">
				<select type="select-one" class="form-control" id="employment_nationality"
					name="employment_nationality">					
					@foreach ($countries as $country)
						@if($country['country-code']==$job->nationality_id)	
							<option value="{!! $country['country-code'] !!}" selected>{!! $country['name'] !!}</option>
						@else
							<option value="{!! $country['country-code'] !!}">{!! $country['name'] !!}</option>
						@endif
					@endforeach
				</select>
			</div>
		</div>
				
		
		<div class="form-group" id="field_salaryMin">
			<label class="col-sm-3 control-label" for="min_salary">{{ trans('labels.recruitments.jobs.table.min_salary') }}</label>
			<div class="controls col-sm-6">
				<input class="form-control" type="text" id="min_salary"
					name="min_salary" value="{{ $job->min_salary }}" validation="none">
			</div>
		</div>
		<div class="form-group" id="field_salaryMax">
			<label class="col-sm-3 control-label" for="max_salary">{{ trans('labels.recruitments.jobs.table.max_salary') }}</label>
			<div class="controls col-sm-6">
				<input class="form-control" type="text" id="max_salary"
					name="max_salary" value="{{ $job->max_salary }}" validation="none">
			</div>
		</div>
		
		
		<div class="form-group" id="field_status">
			<label class="control-label col-sm-3" for="status">{{trans('labels.recruitments.jobs.table.status')}}<font
				class="text-red">*</font></label>
			<div class="controls col-sm-6">
				<select type="select-one" class="form-control" id="status"
					name="status">
					@foreach ($status as $st)
						@if ($st->status_id==$job->status)
							<option value="{!! $st->status_id!!}" selected>{!! $st->status_name !!}</option>
						@else
							<option value="{!! $st->status_id!!}">{!! $st->status_name !!}</option>
						@endif
					@endforeach
					
				</select>
			</div>
		</div>
		
		<div class="form-group" id="field_closingDate">
			<label class="control-label col-sm-3" for="closing_date">Closing Date</label>
			<div class="controls">
				<span class="help-inline" id="help_closingDate"></span>
			</div>
			<div class="controls col-sm-6">
				<div class="input-group date datefield" id="closingDate"
					name="closingDate" data-date="" data-date-format="yyyy-mm-dd">
					<span class="add-on input-group-addon">
					<i class="fa fa-calendar"></i></span>
					<input readonly="readonly" id="closing_date" name="closing_date"
						class="form-control" size="16" type="text" value="{{ $job->closing_date }}"
						validation="none">
					<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
					<script type="text/javascript">           			
						$(function () {               
               			 	$('#closingDate').datepicker({format: "yyyy-mm-dd"});
           				 });    
        			</script>
				</div>
			</div>
			
		</div>

		<div class="control-group row">
			<div class="controls col-sm-9">
				<button class="saveBtn btn btn-primary pull-right">
					<i class="fa fa-save"></i> Save
				</button>
			</div>
			<div class="controls col-sm-3"></div>
		</div>
	</div>

	{!! Form::close() !!}
	<!-- /.box-body -->
</div>
<!--box-->
@stop