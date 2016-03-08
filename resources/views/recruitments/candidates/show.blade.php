@extends ('layouts.master') 
@section ('title', trans('labels.recruitments.title')) 
@section('page-header')
<h1>
	{{ trans('labels.recruitments.title') }} 
	<small>{{trans('labels.recruitments.candidates.candidate_information') }}</small>
</h1>
@endsection 
@section('content')
<div class="span9">
	<div id="Candidate" class="reviewBlock" data-content="List"
		style="padding-left: 5px;">
		<div class="row-fluid clearfix" style="font-size: 13px;">
			<div class="col-md-2">				
				    <div class="hovereffect">
				    	<input id="avatar" type="file" style="visibility:hidden" />
						<img id="current_avatar"
						src="http://apps.gamonoid.com/icehrm-hosted-core/images/user_male.png"
						class="img-polaroid img-thumbnail"
						style="border-radius: 0px; margin-left: 0px;">				        
						<div class="overlay img-polaroid img-thumbnail">
				           <h2>Change Avatar</h2>
				           <a id='btnChangeAvatar' class="info" href="#">Click Here</a>
				                     
				           
				           
				        </div>
				    </div>		
			</div>
			
			<div class="col-md-10">
				<div class="row-fluid">
					<div class="col-md-12">
						<h2 id="candidateName">@if($candidateInfo->gender==1) Mr. @else
							Ms. @endif
							{{$candidateInfo->first_name.$candidateInfo->middle_name.$candidateInfo->last_name}}
						</h2>
					</div>
				</div>
				<div class="row-fluid">
					<div class="col-md-12">
						<p>
							<i class="fa fa-phone"></i> <span id="phone">{{$candidateInfo->mobile}}</span>&nbsp;&nbsp;
							<i class="fa fa-envelope"></i> <span id="email">{{$candidateInfo->email}}</span>
						</p>
					</div>
				</div>
				<div class="row-fluid">
					<div class="col-md-12">
						<a
							href="{!! route('recruitments.candidates.edit', $candidateInfo->candidate_id)!!}"
							class="btn btn-small btn-warning"> <i class="fa fa-edit"></i>
							{{trans('labels.recruitments.candidates.commands.candidate_edit') }}
						</a> &nbsp;&nbsp; <a
							href="{!!route('recruitments.candidate.get_upload_cv', $candidateInfo->filename)!!}"
							target='blank' class="btn btn-small btn-primary"> <i
							class="fa fa-print"></i> {{trans('labels.recruitments.candidates.commands.view_resume') }}
						</a> &nbsp;&nbsp;
						
						<button class="btn btn-small btn-success"
							data-toggle="modal" data-target="#dlg_add_candidate_jobs" data-title="{{trans('labels.recruitments.candidate_jobs_application_create') }}">
							<i class="fa fa-lock"></i>  {{trans('labels.recruitments.candidates.commands.job_apply') }}
						</button>
												
						&nbsp;&nbsp;
						@include('common.dlg_add_candidate_jobs')						
						<button class="btn btn-small btn-danger"
							data-toggle="modal" data-target="#dlg_add_candidate_interviews" data-title="{{trans('labels.recruitments.interviews.title') }}">
							<i class="fa fa-bell"></i>  {{trans('labels.recruitments.candidates.commands.schedule_interview') }}
						</button>	
						@include('common.dlg_add_candidate_interviews')						
					</div>
				</div>
			</div>
		</div>

		<div class="row-fluid clearfix"
			style="font-size: 13px; margin-top: 20px;">
			<div class="col-md-4">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Personal Information</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<strong><i class="fa fa-institution margin-r-5"></i> {{ trans('labels.recruitments.candidates.table.education') }}</strong>
						@foreach($educationsHistory as $education)
							<p class="text-muted "><i class="fa fa-book margin-r-5"></i>{{$education->education_level_name}} in {{$education->majority}} from the {{$education->institute}} 
							({{date('Y', strtotime($education->start_year))}} ~ {{date('Y', strtotime($education->graduation_year))}})
							 </p>							
						@endforeach
						<hr>
						<strong><i class="fa fa-map-marker margin-r-5"></i>{{ trans('labels.recruitments.candidates.table.address') }}</strong>
						<p class="text-muted">{{$candidateInfo->address}}</p>
						<hr>
						<strong><i class="fa fa-pencil margin-r-5"></i> {{ trans('labels.recruitments.candidates.table.skills') }}</strong>
						<p>
							@foreach($candidateSkills as $candidateSkill)
								@if ($candidateSkill->category==1)
									<span class="label label-danger" data-toggle="tooltip" title="{!!$candidateSkill->no_years!!} years">{!!$candidateSkill->skill_name!!}</span> 
								@elseif ($candidateSkill->category==2)
									<span class="label label-success" data-toggle="tooltip" title="{!!$candidateSkill->no_years!!} years">{!!$candidateSkill->skill_name!!}</span> 
								@elseif ($candidateSkill->category==3)
									<span class="label label-info" data-toggle="tooltip" title="{!!$candidateSkill->no_years!!} years">{!!$candidateSkill->skill_name!!}</span> 
								@elseif ($candidateSkill->category==4)
									<span class="label label-warning" data-toggle="tooltip" title="{!!$candidateSkill->no_years!!} years">{!!$candidateSkill->skill_name!!}</span> 
								@else
									<span class="label label-primary">{!!$candidateSkill->skill_name!!}</span>
								@endif
							@endforeach
						</p>
						<hr>
						<strong><i class="fa fa-file-text-o margin-r-5"></i> {{ trans('labels.recruitments.candidates.table.profile_summary') }}</strong>
						<p>
							{{$candidateInfo->profile_summary}}
						</p>
					</div>
					<!-- /.box-body -->
				</div>
			</div>

			<div class="col-md-4">
				
				<div class="box box-primary">
					<div id="CandidateApplication" class="" data-content="List" style="padding-left: 0px;">
						<div class="list-group">
							<a href="#" onclick="return false;" class="list-group-item" style="background: #fff;">
								<h4 class="list-group-item-heading">
									Job Applications
								</h4></a>
								@foreach($appliedPositions as $appliedPosition)
								<a href="#" class="list-group-item">
									<h5 class="list-group-item-heading" style="font-weight: bold;">
										{{$appliedPosition->job_title_name}} [{!!'No.'.str_pad($appliedPosition->job_id, 8 , "0", STR_PAD_LEFT);!!} ]
										
										{!! Form::open(array('route' => ['recruitments.candidate.applicant.destroy', $appliedPosition->id], 'accept-charset'=>'UTF-8', 'name' =>'Frm_Delete_Applicant',
											'class'=>'form-horizontal','style'=>'display:inline')) !!} 
										{!! Form::hidden('_method', 'DELETE')!!}
																				
										<button id="btnDeleteApplicant"
											data-toggle="modal" data-target="#confirmDelete" 
											data-title="{{trans('labels.recruitments.candidate_jobs_application_delete') }}"
											data-message="{{trans('labels.general.dialog.delete.message') }}"	
											type="button"
											style="position: absolute; bottom: 5px; right: 5px; font-size: 13px;"
											tooltip="Delete">
											<li class="fa fa-times"></li>
										</button>									
										{!!Form::close()!!}	
																				
										<button id="btnEditApplicant"
											data-toggle="modal" data-target="#dlg_update_candidate_jobs" 
											data-base_url="{{asset('/')}}"
											data-title="{{trans('labels.recruitments.candidate_jobs_application_update') }}"
											data-id	  = "{{$appliedPosition->id}}"
											data-job_title_id = "{{$appliedPosition->job_title_id}}"
											data-notes = "{{$appliedPosition->notes}}"
											type="button"
											style="position: absolute; bottom: 5px; right: 35px; font-size: 13px;"
											tooltip="Edit">
											<li class="fa fa-edit"></li>
										</button>
										
									</h5>
									<p class="list-group-item-text">
										<i class="fa fa-clock-o"> </i> {{$appliedPosition->notes}}
									</p>
								</a>
								@endforeach
								@include('common.dlg_update_candidate_jobs')				
						</div>
					</div>			
					<!-- /.box-body -->
				</div>		
				@include('common.dlg_delete_confirm')
			</div>


			<div class="col-md-4">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Interview Schedule & Result</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						@foreach ($scheduledInterviews as $scheduledInterview)
						<a class="list-group-item">
							<h5 class="list-group-item-heading" style="font-weight: bold;">
								@foreach($appliedPositions as $appliedPosition)
									@if($scheduledInterview->job_id == $appliedPosition->job_id)
										{{$appliedPosition->job_title_name}}							
									@endif
								@endforeach
								
								
								
								{!! Form::open(array('route' => ['recruitments.candidate.interview.destroy', $scheduledInterview->id], 'accept-charset'=>'UTF-8', 'name' =>'Frm_Delete_Interview',
											'class'=>'form-horizontal','style'=>'display:inline')) !!} 
								{!! Form::hidden('_method', 'DELETE')!!}																
										<button id="btnDeleteInterview"
											data-toggle="modal" data-target="#confirmDelete" 
											data-title="{{trans('labels.recruitments.interviews.title') }}"
											data-message="{{trans('labels.general.dialog.delete.message') }}"	
											type="button"
											style="position: absolute; bottom: 5px; right: 5px; font-size: 13px;"
											tooltip="Delete Interview">
											<li class="fa fa-times"></li>
										</button>									
								{!!Form::close()!!}	
								
								
								
								<button id="btnEditInterview"
									onclick="modJs.subModJsList['tabCandidateInterview'].edit('2');return false;"
									type="button"
									style="position: absolute; bottom: 5px; right: 35px; font-size: 13px;"
									tooltip="Edit">
									<li class="fa fa-edit"></li>
								</button>
							</h5>
							
							<p class="list-group-item-text text-muted">
								<strong><i class="fa fa-check-circle margin-r-5"></i>{{ trans('labels.recruitments.interviews.table.interview_state') }} :</strong>									
								{{$scheduledInterview->interview_state}}
							</p>
							<p class="list-group-item-text text-muted">							
								<strong><i class="fa fa-location-arrow margin-r-5"></i>{{ trans('labels.recruitments.interviews.table.interview_location') }} :</strong>																
								{{$scheduledInterview->location}}
							</p>
							<p class="list-group-item-text text-muted">
								<i class="fa fa-clock-o"></i> {{date('l jS \of F Y h:i:s A',strtotime($scheduledInterview->scheduled_time))}}
							</p>
							<p class="list-group-item-text text-muted">
								<strong><i class="fa fa-thumb-tack margin-r-5"></i>{{ trans('labels.recruitments.interviews.table.result_id') }} :</strong>									
								{{$scheduledInterview->result}}
							</p>
						</a>	
						@endforeach		
						      							
								
					</div>
					<!-- /.box-body -->
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
