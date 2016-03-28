<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.1.4 -->
<script src="{{ asset('/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
<script src="{{ asset('/plugins/jQueryUI/jquery-ui.min.js') }}"></script>


<!-- Bootstrap 3.3.2 JS -->
<script src="{{ asset('/js/bootstrap.min.js') }}" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/js/app.min.js') }}" type="text/javascript"></script>

<script type="text/javascript"
	src="{{ asset ('/common/socialshare.js')}}"></script>

<!-- datepicker -->
<script type="text/javascript"
	src="{{ asset ('/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<!-- Date range Picker -->
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script src="{{asset ('plugins/daterangepicker/daterangepicker.js')}}"></script>
<script src='{{asset ("/bower_components/eonasdan-bootstrap-datetimepicker/src/js/bootstrap-datetimepicker.js") }}'></script>


<!-- DataTables -->
<script src="{{asset ('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{asset ('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->

<!-- Tag Editor JavaScript -->
<script src='{{ asset ("/bower_components/caret/jquery.caret.js") }}'></script>
<script
	src='{{ asset ("/bower_components/jquery-tag-editor/jquery.tag-editor.min.js") }}'></script>

<!-- Full Calendar -->
<script src='{{ asset ("/common/x_full_calendar/fullcalendar.js") }}'></script>
<!-- JQuery Date format -->
<script
	src='{{ asset ("/bower_components/jquery-dateFormat/dist/jquery-dateFormat.min.js") }}'></script>


<script type="text/javascript">
$(document).ready(function() {
    
	/*  className colors
	
	className: default(transparent), important(red), chill(pink), success(green), info(blue)
	
	*/
	function updateInterviewSchedule(event, revertFunc) {
	   var id = event.id;
  	   var start = event.start;
	   var end   = (event.end == null) ? start : event.end;

	   var longDateFormat  = 'yyyy-MM-dd HH:mm:ss';	   	   
	   start = jQuery.format.date(start, longDateFormat);
	   end = jQuery.format.date(end, longDateFormat);
	   	   
  	   $url = $('input[name="recruitments.interviews"]').val();
		   $interview_id = id;
	       $url   = $url+"/"+$interview_id;
	       var token = $('input[name="_token"]').val();
	       
	   	   $.ajax({
     	     url: $url,
     	     data: {'_method' :'PUT', 'start':start,'end':end, '_token' : token},
     	     type: 'POST',
     	     dataType: 'json',
     	     success: function(response){
         	   	console.log(response);
     	       if(response.success != true)
     	       {
         	       revertFunc();        	       
         	       return false;
     	       }
     	       else
         	       return true;
     	     },
     	     error: function(e){
     	       revertFunc();
       	       return false;
     	     }
     	});
	}
	  
	/* initialize the external events
	-----------------------------------------------------------------*/

	$('#external-events div.external-event').each(function() {
	
		// create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
		// it doesn't need to have a start or end
		var eventObject = {
			title: $.trim($(this).text()) // use the element's text as the event title
		};
		
		// store the Event Object in the DOM element so we can get to it later
		$(this).data('eventObject', eventObject);
		
		// make the event draggable using jQuery UI
		$(this).draggable({
			zIndex: 999,
			revert: true,      // will cause the event to go back to its
			revertDuration: 0  //  original position after the drag
		});
		
	});


	/* initialize the calendar
	-----------------------------------------------------------------*/	
	
	var calendar =  $('#calendar').fullCalendar({
		header: {
			left: 'title',
			center: 'agendaDay,agendaWeek,month',
			right: 'prev,next today'
		},
		editable: true,
		firstDay: 1, //  1(Monday) this can be changed to 0(Sunday) for the USA system
		selectable: true,
		defaultView: 'month',
		
		axisFormat: 'h:mm',
		columnFormat: {
            month: 'ddd',    // Mon
            week: 'ddd d', // Mon 7
            day: 'dddd M/d',  // Monday 9/7
            agendaDay: 'dddd d'
        },
        titleFormat: {
            month: 'MMMM yyyy', // September 2009
            week: "MMMM yyyy", // September 2009
            day: 'MMMM yyyy'                  // Tuesday, Sep 8, 2009
        },
		allDaySlot: false,
		selectHelper: true,
		select: function(start, end, allDay) {
			//$("#dlg_add_candidate_interviews").modal("show");
			/*var title = prompt('Event Title:');			
			if (title) {
				calendar.fullCalendar('renderEvent',
					{
						title: title,
						start: start,
						end: end,
						allDay: allDay
					},
					true // make the event "stick"
				);
			}
			*/
			calendar.fullCalendar('unselect');
		},
		droppable: true, // this allows things to be dropped onto the calendar !!!
		drop: function(date, allDay) { // this function is called when something is dropped
		
			// retrieve the dropped element's stored Event Object
			var originalEventObject = $(this).data('eventObject');
			
			// we need to copy it, so that multiple events don't have a reference to the same object
			var copiedEventObject = $.extend({}, originalEventObject);
			
			// assign it the date that was reported
			copiedEventObject.start = date;
			copiedEventObject.allDay = allDay;
			
			// render the event on the calendar
			// the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
			$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
			
			// is the "remove after drop" checkbox checked?
			if ($('#drop-remove').is(':checked')) {
				// if so, remove the element from the "Draggable Events" list
				$(this).remove();
			}
			
		},
		eventClick:  function(event, jsEvent, view) {
            $('input[name="interview_id"]').val(event.id);	
			$("#dlg_show_candidate_interviews").modal("show");
        },
        eventResize: function(event, delta, revertFunc) {
      	   	updateInterviewSchedule(event,revertFunc);
        },
        eventDrop: function(event, delta, revertFunc) {
        	updateInterviewSchedule(event,revertFunc);
        },
		events: {
			url : '/~ThanhPT/GlobalHRM/public/recruitments/schedules',
			type: 'GET',
			error: function() {
	            alert('There was an error while fetching events!');
	        },
	        color: 'yellow',
		}
	       
	});
	
	
});


</script>


<!-- Candidate's skills tagging -->


<script type="text/javascript">
	// jQuery UI autocomplete extension - suggest labels may contain HTML tags
	// github.com/scottgonzalez/jquery-ui-extensions/blob/master/src/autocomplete/jquery.ui.autocomplete.html.js
	(function($){var proto=$.ui.autocomplete.prototype,initSource=proto._initSource;function filter(array,term){var matcher=new RegExp($.ui.autocomplete.escapeRegex(term),"i");return $.grep(array,function(value){return matcher.test($("<div>").html(value.label||value.value||value).text());});}$.extend(proto,{_initSource:function(){if(this.options.html&&$.isArray(this.options.source)){this.source=function(request,response){response(filter(this.options.source,request.term));};}else{initSource.call(this);}},_renderItem:function(ul,item){return $("<li></li>").data("item.autocomplete",item).append($("<a></a>")[this.options.html?"html":"text"](item.label)).appendTo(ul);}});})(jQuery);
	var cache = {};
	/* temporary comment out
	
	function googleSuggest(request, response) {
	    var term = request.term;
	    if (term in cache) { response(cache[term]); return; }
	    $.ajax({
	        url: 'https://query.yahooapis.com/v1/public/yql',
	        dataType: 'JSONP',
	        data: { format: 'json', q: 'select * from xml where url="http://google.com/complete/search?output=toolbar&q='+term+'"' },
	        success: function(data) {
	            var suggestions = [];
	            try { 
		            var results = data.query.results.toplevel.CompleteSuggestion; 
		        } catch(e) { 
			        var results = []; 
			    }
	            $.each(results, function() {
	                try {
	                    var s = this.suggestion.data.toLowerCase();
	                    suggestions.push({label: s.replace(term, '<b>'+term+'</b>'), value: s});
	                } catch(e){}
	            });
	            cache[term] = suggestions;
	            response(suggestions);
	        }
	    });
	};
	*/
	
	function masterSkillsSuggess(request, response){
		var term = request.term;
		var api_mst_skills = document.getElementById("api_mst_skills");
		
	    if (term in cache) { response(cache[term]); return; } 	    
	    $.ajax({
            type: "GET",		    
	    	url: api_mst_skills.value +'/'+ term,
	    	success: function(result) {
	    		var suggestions = [];
	            try { 
	                var skills = JSON.parse(result.data);
	            } catch(e) { 
			        var skills = []; 
			    }    			    
	            var success = result.success;
	            if(success == true){
	              	for (i = 0; i < skills.length; i++) { 
	                	try {
	                		var s = skills[i].name.toLowerCase() + (skills[i].no_years==null ? "": ":" + skills[i].no_years + "years") ;
		                    suggestions.push({label: s.replace(term, '<b>'+term.toLowerCase()+'</b>'), value: s});
	                	} catch(e){}
	                }
	                cache[term] = suggestions;
	    	        response(suggestions);
	            }	
		    }
	    });
	};
	
	jQuery(document).ready(function(){					
		$('#candidate_skills').tagEditor({ 
		    autocomplete: {
		        delay: 0, // show suggestions immediately
		        position: { collision: 'flip' }, // automatic menu position up/down
		        source: masterSkillsSuggess,
		        minLength: 3,
		        html: true,
		    },
			delimiter: ', ', /* space and comma */
			placeholder: 'Enter tags ...'
		});
						
	});
</script>
