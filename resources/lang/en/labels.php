<?php
return [ 
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
				
		] 
];