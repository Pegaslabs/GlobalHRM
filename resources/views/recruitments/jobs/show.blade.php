@extends ('layouts.app') 
@section ('title', trans('labels.recruitments.jobs.page_title')) 

@section('contentheader_title')
	{{ trans('labels.recruitments.jobs.content_title') }} <small>
@endsection 

@section('contentheader_description')
	{{ trans('labels.recruitments.jobs.content_title_description_show') }}</small>
@endsection 

@section('main-content')
<div class="box box-success">
	<div class="box-header with-border">
		<h3 class="box-title">
		     {!! 'JD.'.str_pad($job->id, 8 , "0", STR_PAD_LEFT); !!} - [{{ $title->code}}] - 			
			<span class="badge bg-{{$status->description}}">{{ $status->status_name }}</span>
			 	
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
		<div class = 'form-horizontal'>
		
		<div class="form-group" id="field_job_title_id">
			<label class="control-label col-sm-3" for="job_title">{{ trans('labels.recruitments.jobs.columns.title_id') }}<font
				class="text-red">*</font></label>
			<div class="controls col-sm-6">
				<input class="form-control" type="text" id="title" name="title" value="{{ $title->name}}" validation="none" readonly>
			</div>
		</div>
		
		<div class="form-group" id="field_priority">
			<label class="col-sm-3 control-label" for="priority">{{ trans('labels.recruitments.jobs.columns.priority') }} <font
				class="text-red">*</font></label>
			<div class="controls col-sm-6">
				<input class="form-control" type="text" id="priority" name="priority" value="{{ $job->priority}}" validation="none" readonly>
				
			</div>
		</div>
		
		<div class="form-group" id="field_No_Positions">
			<label class="col-sm-3 control-label" for="job_no_positions">{{ trans('labels.recruitments.jobs.columns.no_pos') }} <font
				class="text-red">*</font></label>
			<div class="controls col-sm-6">
				<input class="form-control" type="text" id="job_no_positions"
					name="job_no_positions" value="{{$job->no_pos}}" readonly>
			</div>
		</div>
		<div class="form-group" id="field_shortDescription">
			<label class="control-label col-sm-3" for="job_short_description">{{ trans('labels.recruitments.jobs.columns.short_description') }}
			<font class="text-red">*</font>
			</label>
			<div class="controls col-sm-6">
				<textarea class="form-control" type="textarea" rows="4"
					id="job_short_description" name="job_short_description" readonly>{{$job->short_description}}</textarea>
			</div>			
		</div>
		
		<div class="form-group" id="field_full_description">
			<label class="control-label col-sm-3" for="job_full_description">{{ trans('labels.recruitments.jobs.columns.description') }}<font
				class="text-red">*</font></label>
			<div class="controls col-sm-6">
				<textarea class="form-control" type="textarea" rows="4"
					id="job_full_description" name="job_full_description" readonly>{{ $job->description}}</textarea>
			</div>							
		</div>
		
		<div class="form-group" id="field_deplartment_id">
			<label class="control-label col-sm-3" for="request_department_id">{{ trans('labels.recruitments.jobs.columns.department_id') }}<font
				class="text-red">*</font></label>
			<div class="controls col-sm-6">
			<input class="form-control" type="text" id="request_department_id"
					name="request_department_id" value="{{$department->name}}" readonly>
			</div>
		</div>
				
		<div class="form-group" id="field_emp_type_id">
			<label class="control-label col-sm-3" for="employment_type_id">{{ trans('labels.recruitments.jobs.columns.employment_type_id') }}<font
				class="text-red">*</font></label>
			<div class="controls col-sm-6">			
				<input class="form-control" type="text" id="employment_type_id"
					name="employment_type_id" value="{{$empType->name}}" readonly>
							
			</div>
		</div>
		
		<div class="form-group" id="field_emp_level_id">
			<label class="control-label col-sm-3" for="employment_level_id">{{ trans('labels.recruitments.jobs.columns.experience_level_id') }}<font
				class="text-red">*</font></label>
			<div class="controls col-sm-6">
			<input class="form-control" type="text" id="employment_level_id"
					name="employment_level_id" value="{{$empLevel->name}}" readonly>				
			</div>
		</div>
		
		<div class="form-group" id="field_salaryMin">
			<label class="col-sm-3 control-label" for="min_salary">{{ trans('labels.recruitments.jobs.columns.min_salary') }}</label>
			<div class="controls col-sm-6">
				<input class="form-control" type="text" id="min_salary"
					name="min_salary" value="{{ $job->min_salary }}" validation="none" readonly>
			</div>
		</div>
		<div class="form-group" id="field_salaryMax">
			<label class="col-sm-3 control-label" for="max_salary">{{ trans('labels.recruitments.jobs.columns.max_salary') }}</label>
			<div class="controls col-sm-6">
				<input class="form-control" type="text" id="max_salary"
					name="max_salary" value="{{ $job->max_salary }}" validation="none" readonly>
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
						validation="none" readonly>
					<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>					
				</div>
			</div>			
		</div>		
		<div class="form-group" id="field_emp_nationality">
			<label class="control-label col-sm-3" for="employment_nationality">{{ trans('labels.recruitments.jobs.columns.nationality_id') }}
			<font class="text-red">*</font></label>
			<div class="controls col-sm-6">
				<input class="form-control" type="text" id="employment_nationality"
					name="employment_nationality" value="{{ $nationality->name }}" validation="none" readonly>
			</div>
		</div>
		
		<div class="form-group row">
		    	<div class="control-label col-sm-3">
		      		<a class="btn btn-primary pull-right" href="{{ URL::to('recruitments/jobs/' . $job->id . '/edit')}}"><i class="fa fa-edit"></i> Edit</a>
		    	</div>
		    	<div class="control-label col-sm-6">
		    	{!! Form::open(array('url' => 'recruitments/jobs/' . $job->id, 'class' => 'pull-left', 'accept-charset'=>'UTF-8', 'style'=>'display:inline')) !!} 
					{!! Form::hidden('_method', 'DELETE')!!}
						<button class="btn btn-danger pull-left" type="button" data-toggle="modal" type='submit'
							data-target="#confirmDelete" data-title="{{trans('labels.recruitments.jobs.messages.dlg_delete_confirm_title') }}" 
							data-message="{{trans('labels.recruitments.jobs.messages.dlg_delete_confirm_msg') }}">
        				<i class="glyphicon glyphicon-trash"></i> Delete
   						</button>					
					{!! Form::close() !!}
					@include('dialogs.dlg_delete_confirm')		      	
		    	</div>
		</div>
	</div>
	</div>
	<!-- /.box-body -->
</div>
<!--box-->
@stop