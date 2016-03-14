@extends ('layouts.app') 
@section ('title', trans('labels.recruitments.jobs.page_title')) 

@section('contentheader_title')
	{{ trans('labels.recruitments.jobs.content_title') }} <small>
@endsection 

@section('contentheader_description')
	{{ trans('labels.recruitments.jobs.content_title_description_edit') }}</small>
@endsection 

@section('main-content')
<div class="box box-success">
	<div class="box-header with-border">
		<h3 class="box-title">
		     {!! 'JD.'.str_pad($job->id, 8 , "0", STR_PAD_LEFT); !!} - [{{ $title->code}}] - 
			@if ($job->status_id == '1')
				<span class="label label-success">{!! $status->status_name!!}</span>
			@elseif ($job->status_id == '2')
				<span class="label label-warning">{!! $status->status_name !!}</span>
			@elseif ($job->status_id == '3')
				<span class="label label-danger">{!! $status->status_name !!}</span>
			@else
				<span class="label label-primary"">{!! $status->status_name !!}</span>
			@endif		     	
		</h3>
	</div>
	<!-- /.box-header -->

	<div class="box-body">
		<div class="control-group">
			<div class="controls">
				<span class="label label-warning" id="Job_submit_error"
					style="display: none;"> </span>
			</div>
		</div>		
		@include('errors.msg')				
		{!! Form::model($job, array('route' => array('recruitments.jobs.update', $job->id), 'method' => 'PUT', 'class'=>'form-horizontal')) !!}
				
		<div class="form-group" id="field_job_title_id">
			<label class="control-label col-sm-3" for="title_id">{{ trans('labels.recruitments.jobs.columns.title_id') }}
			<font class="text-red">*</font></label>
			<div class="controls col-sm-6">
				<select type="select-one" class="form-control" id="title_id"
					name="title_id">					
					@foreach ($mstJobTitles as $mstTitle)
						@if($mstTitle->id==$job->job_title_id)
      						<option value="{!! $mstTitle->id !!}" selected>{!! $mstTitle->name !!}</option>		
      					@else
      						<option value="{!! $mstTitle->id !!}">{!! $mstTitle->name !!}</option>	
      					@endif							
					@endforeach					
				</select>
			</div>
		</div>
		
		<div class="form-group" id="field_priority">
			<label class="col-sm-3 control-label" for="priority">{{ trans('labels.recruitments.jobs.columns.priority') }} <font
				class="text-red">*</font></label>
			<div class="controls col-sm-6">
				<select type="select-one" class="form-control" id="priority"
					name="priority" value='{{$job->priority}}'>
						<option value="SS">SS</option>	
						<option value="SS">S</option>					
						<option value="A">A</option>	
						<option value="B">B</option>	
						<option value="C">C</option>	
						<option value="D">D</option>										
				</select>
			</div>
		</div>
		
		<div class="form-group" id="field_No_Positions">
			<label class="col-sm-3 control-label" for="no_pos">{{ trans('labels.recruitments.jobs.columns.no_pos') }} 
			<font class="text-red">*</font></label>
			<div class="controls col-sm-6">
				<input class="form-control" type="text" id="no_pos"
					name="no_pos" value="{{$job->no_pos}}">
			</div>
		</div>
		
		<div class="form-group" id="field_shortDescription">
			<label class="control-label col-sm-3" for="short_description">{{ trans('labels.recruitments.jobs.columns.short_description') }}
			<font class="text-red">*</font>
			</label>
			<div class="controls col-sm-6">
				<textarea class="form-control" type="textarea" rows="4"
					id="short_description" name="short_description" >{{$job->short_description}}</textarea>
			</div>			
		</div>
			
		<div class="form-group" id="field_full_description">
			<label class="control-label col-sm-3" for="description">{{ trans('labels.recruitments.jobs.columns.description') }}<font
				class="text-red">*</font></label>
			<div class="controls col-sm-6">
				<textarea class="form-control" type="textarea" rows="4"
					id="description" name="description">{{ $job->description}}</textarea>
			</div>		
					
		</div>
		
		<div class="form-group" id="field_deplartment_id">
			<label class="control-label col-sm-3" for="department_id">{{ trans('labels.recruitments.jobs.columns.department_id') }}<font
				class="text-red">*</font></label>
			<div class="controls col-sm-6">
				<select type="select-one" class="form-control" id="department_id"
					name="department_id">
						@foreach ($mstDepartments as $dept)
							@if($dept->id==$job->department_id)
      							<option value="{!! $dept->id !!}" selected>{!! $dept->name !!}</option>		
      						@else
      							<option value="{!! $dept->id !!}">{!! $dept->name !!}</option>
      						@endif							
						@endforeach						
				</select>
			</div>
		</div>
		<div class="form-group" id="field_emp_type_id">
			<label class="control-label col-sm-3" for="employment_type_id">{{ trans('labels.recruitments.jobs.columns.employment_type_id') }}<font
				class="text-red">*</font></label>
			<div class="controls col-sm-6">
				<select type="select-one" class="form-control" id="employment_type_id"
					name="employment_type_id">					
					@foreach ($mstEmploymentTypes as $empType)	
							@if($empType->employment_type_id==$job->employment_type_id)
      							<option value="{!! $empType->id !!}" selected>{!! $empType->name !!}</option>	
      						@else
      							<option value="{!! $empType->id !!}">{!! $empType->name !!}</option>
      						@endif							
					@endforeach					
				</select>
			</div>
		</div>
		
		<div class="form-group" id="field_emp_level_id">
			<label class="control-label col-sm-3" for="experience_level_id">{{ trans('labels.recruitments.jobs.columns.experience_level_id') }}<font
				class="text-red">*</font></label>
			<div class="controls col-sm-6">
				<select type="select-one" class="form-control" id="experience_level_id"
					name="experience_level_id">					
					@foreach ($mstEmploymentLevels as $empLevel)
						@if($empLevel->employment_level_id==$job->experience_level_id)								
							<option value="{!! $empLevel->id !!}" selected>{!! $empLevel->name !!}</option>
						@else
      						<option value="{!! $empLevel->id !!}">{!! $empLevel->name !!}</option>
      					@endif						
					@endforeach
					
				</select>
			</div>
		</div>
		
		<div class="form-group" id="field_emp_education_id">
			<label class="control-label col-sm-3" for="employment_education_id">{{ trans('labels.recruitments.jobs.columns.education_level_id') }}<font
				class="text-red">*</font></label>
			<div class="controls col-sm-6">
				<select type="select-one" class="form-control" id="employment_education_id"
					name="employment_education_id">					
					@foreach ($mstEducationLevels as $educationLevel)
						@if($educationLevel->id==$job->education_level_id)										
							<option value="{!! $educationLevel->id !!}" selected>{!! $educationLevel->name !!}</option>
						@else 
							<option value="{!! $educationLevel->id !!}">{!! $educationLevel->name !!}</option>
						@endif					
					@endforeach					
				</select>
			</div>
		</div>
		
		<div class="form-group" id="field_emp_nationality">
			<label class="control-label col-sm-3" for="nationality_id">{{ trans('labels.recruitments.jobs.columns.nationality_id') }}<font
				class="text-red">*</font></label>
			<div class="controls col-sm-6">
				<select type="select-one" class="form-control" id="nationality_id"
					name="nationality_id">					
					@foreach ($mstCountries as $country)
						@if($country->id==$job->nationality_id)	
							<option value="{!! $country->id!!}" selected>{!! $country->name !!}</option>
						@else
							<option value="{!! $country->id!!}">{!! $country->name !!}</option>
						@endif
					@endforeach
				</select>
			</div>
		</div>
		
		<div class="form-group" id="field_salaryMin">
			<label class="col-sm-3 control-label" for="min_salary">{{ trans('labels.recruitments.jobs.columns.min_salary') }}</label>
			<div class="controls col-sm-6">
				<input class="form-control" type="text" id="min_salary"
					name="min_salary" value="{{ $job->min_salary }}" validation="none">
			</div>
		</div>
		<div class="form-group" id="field_salaryMax">
			<label class="col-sm-3 control-label" for="max_salary">{{ trans('labels.recruitments.jobs.columns.max_salary') }}</label>
			<div class="controls col-sm-6">
				<input class="form-control" type="text" id="max_salary"
					name="max_salary" value="{{ $job->max_salary }}" validation="none">
			</div>
		</div>
		
		<div class="form-group" id="field_status">
			<label class="control-label col-sm-3" for="status_id">{{trans('labels.recruitments.jobs.columns.status_id')}}<font
				class="text-red">*</font></label>
			<div class="controls col-sm-6">
				<select type="select-one" class="form-control" id="status_id"
					name="status_id">
					@foreach ($mstStatus as $status)
						@if ($status->id==$job->status_id)
							<option value="{!! $status->id!!}" selected>{!! $status->status_name !!}</option>
						@else
							<option value="{!! $status->id!!}">{!! $status->status_name !!} </option>
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