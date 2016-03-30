<?php
return [ 
		'system_name' => "Seta Asia - HRM",
		'sidebar' =>[
			'dashboard' =>[
					'main_menu'=>'Dashboard'
			],	
			'pim' =>[
					'main_menu'=>'Personal Info Management',
			],
			'recruitments' => 
				[
					'main_menu'=>'Recruitments',
					'sub_menu'=>[
						'jobs' =>'Jobs Managemenet',				
						'candidates' => 'Candidates Management',
						'interviews' => 'Interview Management',
						'resumes'    => 'Resumes Management',
						'settings'   => 'Settings'
					]
				]
		],
		'dashboard'=>[
				'content_title'   => 'Dashboard',
				'content_title_description' =>'Keep your information up-to-date',
				'caption_job_request_report'=>'Job Request Report',
		],
		'recruitments' => [ 
				'jobs' => [ 
						'content_title'   => 'Job Managment',
						'content_title_description_list' => 'Manage All Available Jobs',
						'content_title_description_show' => 'Job Detail Information',
						'content_title_description_edit' => 'Edit Job Detail Information',		
						'content_title_description_create' => 'Create New Job Request',						
						'messages'=>[
								'dlg_delete_confirm_title' => 'Delete Job Confirm',
								'dlg_delete_confirm_msg' => 'Are you sure you want to delete this job ?'
								
						],
						'columns'=>[
								'id' => 'Job ID',
								'title_id' => 'Job title',
								'no_pos'   => 'No. Position',
								'short_description' => 'Brief Description',
								'description' => 'Description',
								'department_id' =>'Department',
								'employment_type_id' =>'Emp. Type',
								'experience_level_id'=>'Emp. Level',
								'education_level_id'=> 'Emp. Education',								
								'job_function_id'=> 'Job Function',
								'nationality_id' => 'Nationality',
								'min_salary' => 'Min Salary',
								'max_salary' => 'Max Salary',
								'status_id'  => 'Status',
								'priority'   => 'Priority',
								'closing_date' => 'Expected Date',
								'actions'       => 'Action'
						]
				] ,
				'candidates' =>[
						'page_title'      => 'Candidate Management Page',
						'content_title'   => 'Candidate Managment',
						'content_title_description_list'   => 'Manage Candidate Database',
						'content_title_description_show'   => 'Candidate Detail Information',
						'content_title_description_edit'   => 'Edit Candidate Information',
						'content_title_description_create' => 'Create New Candidate',
						'button_label_candidate_edit' => 'Edit Information',
						'button_label_resume_view' =>'View Resume',
						'button_label_job_apply' =>'Apply For a Job',
						'button_label_interview_schedule' =>'Schedule an Interview',
						'table_header_personal_information' => 'Personal Information',
						'table_applicants_history'   => [
							'header' => 'Comming Up Interviews',
							'column_job_id' => 'Job ID',
							'column_job_title' => 'Job Title',
							'column_job_interview_schedule' => 'Interview Schedule',
							'row_job_interview_schedule_state' => 'State',
							'row_job_interview_schedule_location' => 'Location',
							'row_job_interview_schedule_result' => 'Result',
							'row_job_interview_schedule_interviewer' => 'Interviewer',
							
							'column_job_status' => 'Status',
						],
						
						'messages'=>[
								'dlg_delete_confirm_title' => 'Delete Candidate Confirm',
								'dlg_delete_confirm_msg' => 'Are you sure you want to delete this candidate ?',
								'000_RC_CANDIDATE_CREATE_SUCCESS'  => 'Create candidate successfully.',								
								'001_RC_CANDIDATE_CREATE_FAILED'   => 'Failed to create new candidate',								
						
						],
						'columns'=>[
								'candidate_id' => 'Candidate ID',
								'first_name'   => 'First Name',
								'middle_name'  => 'Middle Name',
								'last_name'    => 'Last Name',
								'gender'       => 'Gender',
								'gender_values' => [
									'male' => 'Male',
									'female' => 'Female',
									'unspecified' => 'Unspecified'
								],
								'avatar_id'    => 'Avatar',
								'email'        => 'Contact Email',
								'address'	   => 'Current Address',
								'mobile'       => 'Mobile.No',
								'education_id' => 'Education History',
								'resume_title_id' => 'Resume Title',
								'profile_summary' => 'Profile Summary',
								'nationality_id'  => 'Nationality',
								'resume_id'   => 'CV File',
								'skill_id'       => 'Skills',
								'education' => 'Education',
								'actions'    => 'Actions'
						]
				],
				'candidate_interviews' => [
						'content_title'   => 'Interviews Managment',
						'content_title_description_list' => 'Manage All Scheduled Interviews',
						'content_title_description_show'   => 'Interview Detail Information',
						
						'messages' => [
								'dlg_add_candidate_interview_title' => 'Schedule An Interview',
								'dlg_edit_candidate_interview_title' => 'Edit Interview Information',							
								'dlg_delete_candidate_interview_title' =>'Remove An Interview',
								'dlg_delete_candidate_interview_msg' => 'Are you sure you want to remove this interview ?',
								
						],
						'columns'=>[
								'candidate_job_id' => 'Applied Job',
								'interview_state'  => 'Interview State',
								'interviewer_id'   => 'Interviewer',
								'scheduled_time'   => 'Interview Date Time',
								'location'         => 'Interview Location',
								'result_id'        => 'Interview Result',
								'notes'            => 'Interview Note'
								
						]
				],
				'candidate_jobs' =>[
						'messages' => [
								'dlg_add_candidate_job_title' => 'Apply For A Job',
								
						],
						'columns'=>[
								'candidate_id' => 'Candidate Name',
								'job_id'       => 'Job Title',
								'notes'         => 'Notes'
						]
				],
				'resumes' =>[
						'content_title'   => 'Resumes Managment',
						'content_title_description_list' => 'Manage All Uploaded Resumes',
						'columns'=>[
								'id' => 'No.',
								'candidate_id' => 'Candidate Name',
								'email' => 'Email',
								'job_function_id' => 'Job Function',
								'mime'=>'MIME',
								'actions' => 'Actions' 
						],
						'messages'=>[
								'dlg_delete_confirm_title' => 'Delete Resume Confirm',
								'dlg_delete_confirm_msg' => 'Are you sure you want to delete this resume ?',
						]
						
				]
				
		] 
];