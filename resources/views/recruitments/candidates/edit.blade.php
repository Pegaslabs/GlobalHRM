@extends ('layouts.app') 
@section ('title', trans('labels.recruitments.candidates.page_title')) 

@section('contentheader_title')
	{{ trans('labels.recruitments.candidates.content_title') }} <small>
@endsection 

@section('contentheader_description')
	{{ trans('labels.recruitments.candidates.content_title_description_create') }}</small>
@endsection 

@section('main-content')
<div class="box box-success">
	<div class="box-header with-border">
		<h3 class="box-title">{{
			trans('labels.recruitments.candidates.content_title_description_edit') }}</h3>
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
		
		{!! Form::model($candidateInfo, array('route' => array('recruitments.candidates.update', $candidateInfo->id), 'method' => 'PUT', 'class'=>'form-horizontal', 'files' => true)) !!}

		<div class="form-group" id="field_first_name">
			<label class="col-sm-3 control-label" for="first_name">{{ trans('labels.recruitments.candidates.columns.first_name') }}
			<font class="text-red">*</font></label>
			<div class="controls col-sm-6">
				<input class="form-control" type="text" id="first_name"
					name="first_name" value="{{ (Input::old('first_name')) ? Input::old('first_name') : $candidateInfo->first_name}}" validation="none">
			</div>
		</div>
		
		<div class="form-group" id="field_middle_name">
			<label class="col-sm-3 control-label" for="middle_name">{{ trans('labels.recruitments.candidates.columns.middle_name') }}</label>
			<div class="controls col-sm-6">
				<input class="form-control" type="text" id="middle_name"
					name="middle_name" value="{{ (Input::old('middle_name')) ? Input::old('middle_name') : $candidateInfo->middle_name  }}" validation="none">
			</div>
		</div>
		<div class="form-group" id="field_last_name">
			<label class="col-sm-3 control-label" for="last_name">{{ trans('labels.recruitments.candidates.columns.last_name') }}<font
				class="text-red">*</font></label>
			<div class="controls col-sm-6">
				<input class="form-control" type="text" id="last_name"
					name="last_name" value="{{ (Input::old('last_name'))  ? Input::old('last_name')  : $candidateInfo->last_name}}" validation="none">
			</div>
		</div>
		
		<div class="form-group" id="field_gender">
			<label class="control-label col-sm-3" for="gender">{{ trans('labels.recruitments.candidates.columns.gender') }}<font
				class="text-red">*</font></label>
			<div class="controls col-sm-6">
				<select type="select-one" class="form-control" id="gender"
					name="gender">					
      					<option value="Male">{{ trans('labels.recruitments.candidates.columns.gender_values.male') }}</option>	
      					<option value="Female">{{ trans('labels.recruitments.candidates.columns.gender_values.female') }}</option>
      					<option value="Unspecified">{{ trans('labels.recruitments.candidates.columns.gender_values.unspecified') }}</option>											      															      														      															
				</select>
			</div>
		</div>
		
		<div class="form-group" id="field_avatar_file">
			<label class="col-sm-3 control-label" for="avatar_file">{{ trans('labels.recruitments.candidates.columns.avatar_id') }}</label>
			<div class="controls col-sm-6">
				<img id="current_avatar"
						src="{!!route('getUploadedAvatar', $avatarFile)!!}"
						class="img-polaroid img-thumbnail"
						style="border-radius: 0px; margin-left: 0px;">
				<br>
				<br>
				{!! Form::file('avatar_file', ['class' => 'form-control']) !!}									
			</div>
			
		</div>
		
		<div class="form-group" id="field_address">
			<label class="col-sm-3 control-label" for="address">{{ trans('labels.recruitments.candidates.columns.address') }}</label>
			<div class="controls col-sm-6">
				<input class="form-control" type="text" id="address"
					name="address" value="{{ (Input::old('address'))  ? Input::old('address')  : $candidateInfo->address }}" validation="none">
			</div>
		</div>
		
		<div class="form-group" id="field_nationality_id">
			<label class="control-label col-sm-3" for="nationality_id">{{ trans('labels.recruitments.candidates.columns.nationality_id') }}<font
				class="text-red">*</font></label>
			<div class="controls col-sm-6">
				<select type="select-one" class="form-control" id="nationality_id"
					name="nationality_id">					
					@foreach ($mstCountries as $country)
						@if($country->id == $candidateInfo->nationality_id)
							<option value="{!! $country->id !!}" selected>{!! $country->name !!}</option>
						@else	
							<option value="{!! $country->id !!}">{!! $country->name !!}</option>
						@endif
					@endforeach
				</select>
			</div>
		</div>
		
		<div class="form-group" id="field_email">
			<label class="col-sm-3 control-label" for="email">{{ trans('labels.recruitments.candidates.columns.email') }}<font
				class="text-red">*</font></label>
			<div class="controls col-sm-6">
				<input class="form-control" type="text" id="email"
					name="email" value="{{ (Input::old('email'))  ? Input::old('email')  : $candidateInfo->email  }}" validation="none">
			</div>
		</div>
		<div class="form-group" id="field_mobile">
			<label class="col-sm-3 control-label" for="mobile">{{ trans('labels.recruitments.candidates.columns.mobile') }}<font
				class="text-red">*</font></label>
			<div class="controls col-sm-6">
				<input class="form-control" type="text" id="mobile"
					name="mobile" value="{{ (Input::old('mobile') )  ? Input::old('mobile')   : $candidateInfo->mobile }}" validation="none">
			</div>
		</div>

		<div class="form-group" id="field_job_title_id">
			<label class="control-label col-sm-3" for="resume_title_id">{{ trans('labels.recruitments.candidates.columns.resume_title_id') }}<font
				class="text-red">*</font></label>
			<div class="controls col-sm-6">
				<select type="select-one" class="form-control" id="resume_title_id"
					name="resume_title_id">					
					@foreach ($mstJobTitles as $jobTitle)						
      					<option value="{!! $jobTitle->id !!}">{!! $jobTitle->name !!}</option>											
					@endforeach					
				</select>
			</div>
		</div>
		<div class="form-group" id="field_resume_file">
			<label class="col-sm-3 control-label" for="resume_file">{{ trans('labels.recruitments.candidates.columns.resume_id') }}</label>
			<div class="controls col-sm-6">
				{!! Form::file('resume_file', ['class' => 'form-control']) !!}
				<br>		
				@if(!is_null($cvFile))
						<a
							href="{!!route('getUploadedResume', $cvFile)!!}"
							target='blank' class="btn btn-small btn-primary"> <i
							class="fa fa-print"></i> {{trans('labels.recruitments.candidates.button_label_resume_view') }}
						</a> &nbsp;&nbsp;
						@else
						<a
							href="#"
							target='blank' class="btn btn-small btn-primary disabled"> <i
							class="fa fa-print"></i> {{trans('labels.recruitments.candidates.button_label_resume_view') }}
						</a> &nbsp;&nbsp;
				@endif
				
				
			</div>
		</div>
		<div class="form-group" id="field_profile_summary">
			<label class="control-label col-sm-3" for="profile_summary">{{ trans('labels.recruitments.candidates.columns.profile_summary') }}
			</label>
			<div class="controls col-sm-6">
				<textarea class="form-control" type="textarea" rows="4"
					id="profile_summary" name="profile_summary">{{ (Input::old('profile_summary'))  ? old('profile_summary') : $candidateInfo->profile_summary }}</textarea>
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
