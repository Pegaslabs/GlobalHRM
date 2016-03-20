<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>

<script>
$(document).ready(function(){
	$('#dlg_add_candidate_interviews').on('show.bs.modal', function (e) {
	    $title = $(e.relatedTarget).attr('data-title');
	    $url   = $(e.relatedTarget).attr('data-url');
	    /*
	    * Set redirect url
	    */
	    $redirect_url = $(e.relatedTarget).attr('data-redirect');
		$('input[name="redirect_url"]').val($redirect_url);			
	    
	    $(this).find('.modal-title').text($title);	    


	    $.ajax({
            type: "GET",
            url : $url,
            success: function (result) {
                console.log(result);
                var retData = JSON.parse(result.data);
                var success = result.success;
            	var optAvailableJobs = document.getElementById("applied_job_id");
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
	    $form = $('form[name="Frm_Add_Interview"]');
	    $(this).find('.modal-footer #confirmSave').data('form', $form);
	});
	<!-- Form confirm (yes/ok) handler, submits form -->
	$('#dlg_add_candidate_interviews').find('.modal-footer #confirmSave').on('click', function(){	
			var mydatetimepicker = $('#scheduled_date').datetimepicker();
			$dtp = mydatetimepicker.data('DateTimePicker').date();
			$interviewDate = new Date($dtp);
			$interviewDate = $interviewDate.getFullYear() + '-' + ($interviewDate.getMonth() + 1) + '-' + $interviewDate.getDate() + ' ' +
							 $interviewDate.getHours() + ':' + $interviewDate.getMinutes() + ':' +  $interviewDate.getSeconds();						
			$('input[name="interview_datetime"]').val($interviewDate);			
	      	$(this).data('form').submit();	      
	});
	$('#dlg_add_candidate_interviews').find('.modal-footer #confirmSave').submit(function(event){
	    // Cancels the form submission
	    event.preventDefault();	    
	    submitForm();
	});
})  
</script>


<div id='dlg_add_candidate_interviews' name='dlg_add_candidate_interviews'
	class='modal modal-primary fade' tabindex='-1' role="dialog"
	aria-labelledby="dlg_add_candidate_interviews" aria-hidden="true"
	data-width='760'>
	{!! Form::open(array('route' => 'recruitments.interviews.store', 'accept-charset'=>'UTF-8', 'name' =>'Frm_Add_Interview', 'class'=>'form-horizontal','style'=>'display:inline')) !!} 
	{!! Form::hidden('candidate_id', $candidate->id)!!}	
	{!! Form::hidden('interview_datetime')!!}
	{!! Form::hidden('redirect_url')!!}
	
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title">Primary Modal</h4>
			</div>

			<div class="modal-body">
				<div class="row">

					<div class="form-group" id="field_job_title_id">
						<label class="control-label col-sm-3" for="applied_job_id">{{
							trans('labels.recruitments.candidate_interviews.columns.candidate_job_id') }}<font
							class="text-red">*</font>
						</label>
						<div class="controls col-sm-6">
							<select type="select-one" class="form-control" id="applied_job_id"
								name="applied_job_id"> 							
							</select>
						</div>
					</div>
					
					<div class="form-group" id="field_interview_state">
						<label class="control-label col-sm-3" for="interview_state">{{
							trans('labels.recruitments.candidate_interviews.columns.interview_state') }}<font
							class="text-red">*</font>
						</label>
						<div class="controls col-sm-6">
							<select type="select-one" class="form-control" id="interview_state"
								name="interview_state"> 
									<option value="1st Interview">1st Interview</option>
									<option value="2nd Interview">2nd Interview</option>
									<option value="3rd Interview">3rd Interview</option>
									<option value="Final Interview">Final Interview</option>									
							</select>
						</div>
					</div>
					
					<div class="form-group" id="field_scheduledDate">
						<label class="control-label col-sm-3" for="scheduled_date">{{trans('labels.recruitments.candidate_interviews.columns.scheduled_time') }}</label>
						<div class="controls">
							<span class="help-inline" id="help_scheduledDate"></span>
						</div>																	
							<div class="controls" style="overflow:hidden;">
							    <div class="form-group">
							        <div class="row">
							            <div class="col-md-8">
							                <div id="scheduled_date"></div>
							            </div>
							        </div>
							    </div>
							    <script type="text/javascript">
							        $(function () {
							            $('#scheduled_date').datetimepicker({
							                inline: true,
							                sideBySide: false,
							                format:'YYYY-MM-DD hh:mm:ss',
						                    extraFormats: ['YYYY-MM-DD hh:mm:ss'],												                
							                showTodayButton:true
							            });
							        });
							    </script>
							</div>	
					</div>
					<div class="form-group" id="field_location">
						<label class="col-sm-3 control-label" for="interview_location">{{ trans('labels.recruitments.candidate_interviews.columns.location') }}</label>
						<div class="controls col-sm-6">
							<input class="form-control" type="text" id="interview_location"
								name="interview_location" value="{{ old('interview_location') }}" validation="none">
						</div>
					</div>			
					
					<div class="form-group" id="field_interviewer_id">
						<label class="control-label col-sm-3" for="interviewer_id">{{
							trans('labels.recruitments.candidate_interviews.columns.interviewer_id') }}<font
							class="text-red">*</font>
						</label>
						<div class="controls col-sm-6">						
							<input class="form-control" type="text" id="interviewer_id"
								name="interviewer_id" value="{{ old('interviewer_id') }}" validation="none">
						</div>
					</div>
					
					<div class="form-group" id="field_result_id">
						<label class="control-label col-sm-3" for="result_id">{{
							trans('labels.recruitments.candidate_interviews.columns.result_id') }}<font
							class="text-red">*</font>
						</label>
						<div class="controls col-sm-6">							
							<select type="select-one" class="form-control" id="result_id"
								name="result_id"> 
								@foreach($mstInterviewResults as $interviewResult)
									<option value="{{$interviewResult->id}}">{{$interviewResult->name}}</option>									
								@endforeach
							</select>																	
						</div>
					</div>
					
								
					<div class="form-group" id="field_note">
						<label class="control-label col-sm-3" for="interview_notes">{{
							trans('labels.recruitments.candidate_interviews.columns.notes') }}
						</label>
						<div class="controls col-sm-6">
							<textarea class="form-control" type="textarea" rows="4"
								id="interview_notes" name="interview_notes"
								value="{{ old('interview_notes') }}"></textarea>
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
