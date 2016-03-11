<?php
return [ 
		'system_name' => "Seta Asia - HRM",
		'sidebar' =>[
			'recruitments' => 
				[
					'main_menu'=>'Recruitments',
					'sub_menu'=>[
						'jobs' =>'Jobs Managemenet',
						'candidates' => 'Candidates Management',
						'settings'   => 'Settings'
					]
				]
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
							'header' => 'Applicantion History',
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
								'skill_id'       => 'Skill',
								'education' => 'Education',
								'actions'    => 'Actions'
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
				]
				
		] 
];