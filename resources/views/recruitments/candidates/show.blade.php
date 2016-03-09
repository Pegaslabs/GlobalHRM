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
		
		
		<div class="row-fluid clearfix"
			style="font-size: 13px; margin-top: 20px;">
			<div class="col-md-4">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">{{ trans('labels.recruitments.candidates.table_header_personal_information') }}</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<strong><i class="fa fa-institution margin-r-5"></i> {{ trans('labels.recruitments.candidates.columns.education_id') }}</strong>
						@foreach($educationHistory as $education)
							<p class="text-muted "><i class="fa fa-book margin-r-5"></i>{{$education->getEducationLevel->name}} in {{$education->majority}} from the {{$education->institute}} 
							({{date('Y', strtotime($education->start_year))}} ~ {{date('Y', strtotime($education->graduation_year))}})
							 </p>							
						@endforeach
						<hr>
						<strong><i class="fa fa-map-marker margin-r-5"></i>{{ trans('labels.recruitments.candidates.columns.address') }}</strong>
						<p class="text-muted">{{$candidate->address}}</p>
						<hr>
						<strong><i class="fa fa-pencil margin-r-5"></i> {{ trans('labels.recruitments.candidates.columns.skill_id') }}</strong>
						<p>
							@foreach($skillList as $candidateSkill)
								@if ($candidateSkill->getSkill->category==1)
									<span class="label label-danger" data-toggle="tooltip" title="{!!$candidateSkill->no_years!!} years">{!!$candidateSkill->getSkill->name!!}</span> 
								@elseif ($candidateSkill->getSkill->category==2)
									<span class="label label-success" data-toggle="tooltip" title="{!!$candidateSkill->no_years!!} years">{!!$candidateSkill->getSkill->name!!}</span> 
								@elseif ($candidateSkill->getSkill->category==3)
									<span class="label label-info" data-toggle="tooltip" title="{!!$candidateSkill->no_years!!} years">{!!$candidateSkill->getSkill->name!!}</span> 
								@elseif ($candidateSkill->getSkill->category==4)
									<span class="label label-warning" data-toggle="tooltip" title="{!!$candidateSkill->no_years!!} years">{!!$candidateSkill->getSkill->name!!}</span> 
								@else
									<span class="label label-primary">{!!$candidateSkill->getSkill->skill_name!!}</span>
								@endif
							@endforeach
						</p>
						<hr>
						<strong><i class="fa fa-file-text-o margin-r-5"></i> {{ trans('labels.recruitments.candidates.columns.profile_summary') }}</strong>
						<p>
							{{$candidate->profile_summary}}
						</p>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
			<div class="col-md-8">
	          <div class="box box-primary">
	            <div class="box-header with-border">
	              <h3 class="box-title">{{ trans('labels.recruitments.candidates.table_applicants_history.header') }}</h3>
	            </div>
	            <!-- /.box-header -->
	            <div class="box-body">
	              <table class="table table-bordered">
	                <tbody><tr>
	                  <th style='width: 10%'>{{ trans('labels.recruitments.candidates.table_applicants_history.column_job_id') }}</th>
	                  <th style='width: 25%'>{{ trans('labels.recruitments.candidates.table_applicants_history.column_job_title') }}</th>
	                  <th style='width: 55%'>{{ trans('labels.recruitments.candidates.table_applicants_history.column_job_interview_schedule') }}</th>
	                  <th style='width: 10%'>{{ trans('labels.recruitments.candidates.table_applicants_history.column_job_interview_result') }}</th>
	                </tr>
	                @foreach($appliedJobs as $job)
	                <tr>
	                  <td>{!!'No.'.str_pad($job->id, 8 , "0", STR_PAD_LEFT);!!} </td>
	                  <td>{{ $job->getJobInfo->title->name}}</td>
	                  <td>
	                    
						@foreach ($job->getInterviewList as $scheduledInterview)						
							<a class="list-group-item ">
								<p class="list-group-item-text">
									<strong><i class="fa fa-check-circle margin-r-5"></i>{{ trans('labels.recruitments.candidates.table_applicants_history.row_job_interview_schedule_state') }} :</strong>									
									{{$scheduledInterview->interview_state}}
								</p>
								<p class="list-group-item-text">							
									<strong><i class="fa fa-location-arrow margin-r-5"></i>{{ trans('labels.recruitments.candidates.table_applicants_history.row_job_interview_schedule_location') }} :</strong>																
									{{$scheduledInterview->location}}
								</p>
								<p class="list-group-item-text">
									<i class="fa fa-clock-o"></i> {{date('l jS \of F Y h:i:s A',strtotime($scheduledInterview->scheduled_time))}}
								</p>
								<p class="list-group-item-text">							
									<strong><i class="fa fa-eye margin-r-5"></i>{{ trans('labels.recruitments.candidates.table_applicants_history.row_job_interview_schedule_interviewer') }} :</strong>																
									{{$scheduledInterview->interviewer_id}}
								</p>
								<p class="list-group-item-text">
									<strong><i class="fa fa-thumb-tack margin-r-5"></i>{{ trans('labels.recruitments.candidates.table_applicants_history.row_job_interview_schedule_result') }} :</strong>									
									<span class="badge bg-{{$scheduledInterview->getInterviewResult->description}}">{{$scheduledInterview->getInterviewResult->name}}</span>
								</p>
							</a>	
						@endforeach							
	                  </td>
	                  <td><span class="badge bg-red">55%</span></td>
	                </tr>	                	                
	                @endforeach	                	                
	              </tbody>
	              </table>
	            </div>
	            <!-- /.box-body -->
	            <div class="box-footer clearfix">
	             
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
