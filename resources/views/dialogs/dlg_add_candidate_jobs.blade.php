<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>

<script>
$(document).ready(function(){
	$('#dlg_add_candidate_jobs').on('show.bs.modal', function (e) {
	    $title = $(e.relatedTarget).attr('data-title');
	    $url   = $(e.relatedTarget).attr('data-url');
	    $(this).find('.modal-title').text($title);

	    $.ajax({
            type: "GET",
            url : $url,
            success: function (result) {
                console.log(result);
                var retData = JSON.parse(result.data);
                var success = result.success;
            	var optAvailableJobs = document.getElementById("job_id");
            	/*
            	* Clear 
            	*/
                for (i=0; i < optAvailableJobs.length; i++){
                	optAvailableJobs.remove(i);
                }
                if(success == true){
                	for (i = 0; i < retData.length; i++) { 
                		var option = document.createElement("option");
                		option.text  = '[ JD.'+ ( '00000000' + retData[i].id ).slice( -8 ) + ' ] '+ retData[i].titleName;
                		option.value = retData[i].id;
                		optAvailableJobs.add(option);
                	}
                }else{
                    alert(data);
                }
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
	    
	     // Pass form reference to modal for submission on yes/ok
	    $form = $('form[name="Frm_Add_Candidate_Jobs"]');
	    $(this).find('.modal-footer #confirmSave').data('form', $form);
	});
	<!-- Form confirm (yes/ok) handler, submits form -->
	$('#dlg_add_candidate_jobs').find('.modal-footer #confirmSave').on('click', function(){			
	      	$(this).data('form').submit();	      
	});
	$('#dlg_add_candidate_jobs').find('.modal-footer #confirmSave').submit(function(event){
	    // Cancels the form submission
	    event.preventDefault();	    
	    submitForm();
	});	
})  
</script>

<div id='dlg_add_candidate_jobs' name='dlg_add_candidate_jobs'
	class='modal modal-primary fade' tabindex='-1' role="dialog"
	aria-labelledby="dlg_add_candidate_jobs" aria-hidden="true"
	data-width='760'>
	{!! Form::open(array('route' => 'recruitments.candidate.application.create', 'accept-charset'=>'UTF-8',
	'name' =>'Frm_Add_Candidate_Jobs', 'class'=>'form-horizontal','style'=>'display:inline')) !!} 
	{!! Form::hidden('candidate_id', $candidate->id) !!}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title">Primary Modal</h4>
			</div>

			<div class="modal-body ">

				<div class="row">
					<div class="form-group" id="field_job_title_id">
						<label class="control-label col-sm-3" for="job_id">
							{{trans('labels.recruitments.candidate_jobs.columns.job_id') }}<font
							class="text-red">*</font>
						</label>
						<div class="controls col-sm-6">
							<select type="select-one" class="form-control" id="job_id"
								name="job_id">
							</select>
						</div>
					</div>
					
					<div class="form-group" id="field_note">
						<label class="control-label col-sm-3" for="applicants_note">{{
							trans('labels.recruitments.candidate_jobs.columns.notes') }} </label>
						<div class="controls col-sm-6">
							<textarea class="form-control" type="textarea" rows="4"
								id="applicants_note" name="applicants_note"
								value="{{ old('applicants_note') }}"></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
				<button type="button" id="confirmSave" name="confirmSave"
					type='submit' class="btn btn-primary">Save changes</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	{!!Form::close()!!}
</div>
