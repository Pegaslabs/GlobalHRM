@extends ('layouts.master') @section ('title',
trans('labels.recruitments.title')) @section('page-header')
<h1>
	{{ trans('labels.recruitments.title') }} <small>{{
		trans('labels.recruitments.candidates.title') }}</small>
</h1>
@endsection @section('content')
<div class="box box-success">
	<div class="box-header with-border">
		<h3 class="box-title">{{
			trans('labels.recruitments.candidates.candidate_request_edit') }}</h3>
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
				
		{!! Form::model($candidateInfo, array('route' => array('recruitments.candidates.update', $candidateInfo->candidate_id), 'method' => 'PUT', 'class'=>'form-horizontal', 'files' => true)) !!}
		

		<div class="form-group" id="field_first_name">
			<label class="col-sm-3 control-label" for="first_name">{{ trans('labels.recruitments.candidates.table.first_name') }}<font
				class="text-red">*</font></label>
			<div class="controls col-sm-6">
				<input class="form-control" type="text" id="first_name"
					name="first_name" value="{{$candidateInfo->first_name}}" validation="none">
			</div>
		</div>
		
		<div class="form-group" id="field_middle_name">
			<label class="col-sm-3 control-label" for="middle_name">{{ trans('labels.recruitments.candidates.table.middle_name') }}</label>
			<div class="controls col-sm-6">
				<input class="form-control" type="text" id="middle_name"
					name="middle_name" value="{{ $candidateInfo->middle_name }}" validation="none">
			</div>
		</div>
		<div class="form-group" id="field_last_name">
			<label class="col-sm-3 control-label" for="last_name">{{ trans('labels.recruitments.candidates.table.last_name') }}<font
				class="text-red">*</font></label>
			<div class="controls col-sm-6">
				<input class="form-control" type="text" id="last_name"
					name="last_name" value="{{ $candidateInfo->last_name }}" validation="none">
			</div>
		</div>
		
		<div class="form-group" id="field_gender">
			<label class="control-label col-sm-3" for="gender">{{ trans('labels.recruitments.candidates.table.gender') }}<font
				class="text-red">*</font></label>
			<div class="controls col-sm-6">
				<select type="select-one" class="form-control" id="gender"
					name="gender">
						@if($candidateInfo->gender==1)
      						<option value="1" selected>{{ trans('labels.general.gender.male') }}</option>	
      					@else
      						<option value="1">{{ trans('labels.general.gender.male') }}</option>
      					@endif		
      					@if($candidateInfo->gender==2)
      						<option value="2" selected>{{ trans('labels.general.gender.female') }}</option>	
      					@else
      						<option value="2">{{ trans('labels.general.gender.female') }}</option>
      					@endif								      															
				</select>
			</div>
		</div>
		
		<div class="form-group" id="field_address">
			<label class="col-sm-3 control-label" for="address">{{ trans('labels.recruitments.candidates.table.address') }}</label>
			<div class="controls col-sm-6">
				<input class="form-control" type="text" id="address"
					name="address" value="{{ $candidateInfo->address }}" validation="none">
			</div>
		</div>
		
		<div class="form-group" id="field_nationality_id">
			<label class="control-label col-sm-3" for="nationality_id">{{ trans('labels.recruitments.candidates.table.nationality_id') }}<font
				class="text-red">*</font></label>
			<div class="controls col-sm-6">
				<select type="select-one" class="form-control" id="nationality_id"
					name="nationality_id">					
					@foreach ($countries as $country)
						@if($candidateInfo->nationality_id == $country['country-code'])
							<option value="{!! $country['country-code'] !!}" selected>{!! $country['name'] !!}</option>
						@else
							<option value="{!! $country['country-code'] !!}">{!! $country['name'] !!}</option>
						@endif
							
					@endforeach
				</select>
			</div>
		</div>
		
		<div class="form-group" id="field_email">
			<label class="col-sm-3 control-label" for="email">{{ trans('labels.recruitments.candidates.table.email') }}<font
				class="text-red">*</font></label>
			<div class="controls col-sm-6">
				<input class="form-control" type="text" id="email"
					name="email" value="{{ $candidateInfo->email }}" validation="none">
			</div>
		</div>
		<div class="form-group" id="field_mobile">
			<label class="col-sm-3 control-label" for="mobile">{{ trans('labels.recruitments.candidates.table.mobile') }}<font
				class="text-red">*</font></label>
			<div class="controls col-sm-6">
				<input class="form-control" type="text" id="mobile"
					name="mobile" value="{{ $candidateInfo->mobile }}" validation="none">
			</div>
		</div>

		<div class="form-group" id="field_job_title_id">
			<label class="control-label col-sm-3" for="resume_title_id">{{ trans('labels.recruitments.candidates.table.resume_title_id') }}<font
				class="text-red">*</font></label>
			<div class="controls col-sm-6">
				<select type="select-one" class="form-control" id="resume_title_id"
					name="resume_title_id">					
					@foreach ($jobTitles as $jobTitle)
						@if	($candidateInfo->resume_title_id == $jobTitle->job_title_id)
      						<option value="{!! $jobTitle->job_title_id !!}" selected>{!! $jobTitle->job_title_name !!}</option>
      					@else
      						<option value="{!! $jobTitle->job_title_id !!}" >{!! $jobTitle->job_title_name !!}</option>
      					@endif									
					@endforeach					
				</select>
			</div>
		</div>
		<div class="form-group" id="field_resume_file">
			<label class="col-sm-3 control-label" for="resume_file">{{ trans('labels.recruitments.candidates.table.resume_upload') }}</label>
			<div class="controls col-sm-6">
				<label class="control-label" id="uploaded_resume" name = "uploaded_resume">{{$candidateInfo->original_filename}}</label>				
				{!! Form::file('resume_file', ['class' => 'form-control']) !!}				
			</div>
		</div>
		<div class="form-group" id="field_profile_summary">
			<label class="control-label col-sm-3" for="profile_summary">{{ trans('labels.recruitments.candidates.table.profile_summary') }}
			</label>
			<div class="controls col-sm-6">
				<textarea class="form-control" type="textarea" rows="4"
					id="profile_summary" name="profile_summary">{{$candidateInfo->profile_summary}}</textarea>
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
