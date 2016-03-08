@extends ('layouts.app') 
@section ('title', trans('labels.recruitments.candidates.page_title')) 
@section('contentheader_title')
	{{ trans('labels.recruitments.candidates.content_title') }} <small>
@endsection 
@section('contentheader_description')
	{{ trans('labels.recruitments.candidates.content_title_description_show') }}</small>
@endsection 
@section('main-content')

<div class="span9">
	<div id="Candidate" class="reviewBlock" data-content="List"
		style="padding-left: 5px;">
		<div class="row-fluid clearfix" style="font-size: 13px;">
			<div class="col-md-2">				
				<img id="current_avatar"
						src="{!!route('getUploadedAvatar', $avatarFile)!!}"
						class="img-polaroid img-thumbnail"
						style="border-radius: 0px; margin-left: 0px;">				        
			</div>
			<div class="col-md-10">
				<div class="row-fluid">
					<div class="col-md-12">
						<h2 id="candidateName">
							@if($candidate->gender=='Male') 
								Mr. 
							@else
								Ms. 
							@endif
							{{$candidate->first_name.' '. $candidate->middle_name.' '.$candidate->last_name}}
						</h2>
					</div>
				</div>
				<div class="row-fluid">
					<div class="col-md-12">
						<p>
							<i class="fa fa-phone"></i> <span id="phone">{{$candidate->mobile}}</span>&nbsp;&nbsp;
							<i class="fa fa-envelope"></i> <span id="email">{{$candidate->email}}</span>
						</p>
					</div>
				</div>
				<div class="row-fluid">
					<div class="col-md-12">
						<a
							href="{!! route('recruitments.candidates.edit', $candidate->candidate_id)!!}"
							class="btn btn-small btn-warning"> <i class="fa fa-edit"></i>
							{{trans('labels.recruitments.candidates.button_label_candidate_edit') }}
						</a> &nbsp;&nbsp; 
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
						
						<button class="btn btn-small btn-success">
							<i class="fa fa-lock"></i>  {{trans('labels.recruitments.candidates.button_label_job_apply') }}
						</button>												
						&nbsp;&nbsp;
						<button class="btn btn-small btn-danger">
							<i class="fa fa-bell"></i>  {{trans('labels.recruitments.candidates.button_label_interview_schedule') }}
						</button>	
					</div>
				</div>
			</div>
		</div>					
		</div>
</div>
<div id="CandidateForm" class="reviewBlock" data-content="Form"
		style="padding-left: 5px; display: none;"></div>
</div>
<div class="tab-pane" id="tabPageApplication">
	<div id="Application" class="reviewBlock" data-content="List"
		style="padding-left: 5px;"></div>
	<div id="ApplicationForm" class="reviewBlock" data-content="Form"
		style="padding-left: 5px; display: none;"></div>
</div>
@stop
