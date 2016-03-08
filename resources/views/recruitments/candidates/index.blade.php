@extends ('layouts.app') 
@section ('title', trans('labels.recruitments.candidates.page_title')) 
@section('contentheader_title')
	{{ trans('labels.recruitments.candidates.content_title') }} <small>
@endsection 
@section('contentheader_description')
	{{ trans('labels.recruitments.candidates.content_title_description_list') }}</small>
@endsection 
@section('main-content')

<div class="nav-tabs-custom">
	<div class="tab-content">
		<div class="tab-pane active" id="tab_1-1">
			<div class="box box-success">
				<div class="box-header with-border">
					<h3 class="box-title">{{
						trans('labels.recruitments.candidates.content_title_description_list') }}</h3>
					<div class="box-tools">
						<div class="input-group input-group-sm" style="width: 150px;">
							<input type="text" name="table_search"
								class="form-control pull-right" placeholder="Search">

							<div class="input-group-btn">
								<button type="submit" class="btn btn-default">
									<i class="fa fa-search"></i>
								</button>
							</div>
						</div>

					</div>
				</div>
				@if(Session::has('errors'))
					<div class="alert alert-danger alert-dismissible">
				         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
				                 {{ Session::get('errors') }}
				    </div>
				@endif
				
				@if(Session::has('success'))
				
				<div class="alert alert-success alert-dismissible">
				         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				                <h4><i class="icon fa fa-check"></i> Alert!</h4>
				                {{ Session::get('success') }}
				              </div>
				@endif
				
				<!-- /.box-header -->
				<div class="box-body no-padding">
					<div class="table-responsive" style='overflow-x: visible'>

						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th>{{
										trans('labels.recruitments.candidates.columns.candidate_id') }}</th>
									<th>{{ trans('labels.recruitments.candidates.columns.first_name')
										}}</th>
									<th>{{
										trans('labels.recruitments.candidates.columns.middle_name') }}</th>
									<th>{{ trans('labels.recruitments.candidates.columns.last_name')
										}}</th>
									<th>{{ trans('labels.recruitments.candidates.columns.gender') }}</th>
									<th>{{ trans('labels.recruitments.candidates.columns.email') }}</th>
									<th>{{ trans('labels.recruitments.candidates.columns.mobile') }}</th>
									<th>{{
										trans('labels.recruitments.candidates.columns.resume_title_id')
										}}</th>
									<th>{{ trans('labels.recruitments.candidates.columns.actions') }}</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($candidates as $candidate)
								<tr>
									<td>{!! 'No.'.str_pad($candidate->id, 10 , "0",
										STR_PAD_LEFT); !!}</td>
									<td>{!! $candidate->first_name !!}</td>
									<td>{!! $candidate->middle_name !!}</td>
									<td>{!! $candidate->last_name !!}</td>

									<td>
										@if ($candidate->gender == 'Male') 
											<span class="label label-success">{{ trans('labels.recruitments.candidates.columns.gender_values.male') }}</span> 
										@elseif ($candidate->gender == 'Female') 
											<span class="label label-danger""> {{ trans('labels.recruitments.candidates.columns.gender_values.female') }}</span> 
										@elseif ($candidate->gender == 'Unspecified') 
											<span class="label label-danger""> {{ trans('labels.recruitments.candidates.columns.gender_values.unspecified') }}</span> 	
										@endif
									</td>

									<td>{!! $candidate->email !!}</td>
									<td>{!! $candidate->mobile !!}</td>
									<td>{!! $candidate->job_title_name !!}</td>
									<td>
										<div class="text-left">
											<button type="button" class="btn btn-block btn-info"
												onclick="window.location='{{url('recruitments/candidates/' . $candidate->id) }}'">Details</button>
										</div>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						<div class="col-sm-7">
							<div class="dataTables_paginate paging_simple_numbers"
								id="paginate">{{ $candidates->links() }}</div>
						</div>

					</div>
				</div>
				<!-- /.box-body -->
			</div>
			<!--box-->
		</div>
	</div>
	<!-- /.tab-content -->
</div>
<div class="col-xs-12">
	<button
		onclick="window.location.href='{{ URL::to('recruitments/candidates/create') }}'; return false;"
		class="btn btn-small btn-primary">
		New Candidate <i class="fa fa-plus"></i>
	</button>
</div>



@stop
