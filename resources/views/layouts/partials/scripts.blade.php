<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.1.4 -->
<script src="{{ asset('/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
<script src="{{ asset('/plugins/jQueryUI/jquery-ui.min.js') }}"></script>


<!-- Bootstrap 3.3.2 JS -->
<script src="{{ asset('/js/bootstrap.min.js') }}" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/js/app.min.js') }}" type="text/javascript"></script>

<script type="text/javascript" src="{{ asset ('/common/socialshare.js')}}"></script>

<!-- datepicker -->
<script  type="text/javascript" src="{{ asset ('/plugins/datepicker/bootstrap-datepicker.js') }}"></script>


<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
	
<script src='{{ asset ("/bower_components/eonasdan-bootstrap-datetimepicker/src/js/bootstrap-datetimepicker.js") }}'></script>


<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->
      
<!-- Tag Editor JavaScript -->
<script src='{{ asset ("/bower_components/caret/jquery.caret.js") }}'></script>
<script src='{{ asset ("/bower_components/jquery-tag-editor/jquery.tag-editor.min.js") }}'></script>


<!-- Candidate's skills tagging -->

		
<script type="text/javascript">
	// jQuery UI autocomplete extension - suggest labels may contain HTML tags
	// github.com/scottgonzalez/jquery-ui-extensions/blob/master/src/autocomplete/jquery.ui.autocomplete.html.js
	(function($){var proto=$.ui.autocomplete.prototype,initSource=proto._initSource;function filter(array,term){var matcher=new RegExp($.ui.autocomplete.escapeRegex(term),"i");return $.grep(array,function(value){return matcher.test($("<div>").html(value.label||value.value||value).text());});}$.extend(proto,{_initSource:function(){if(this.options.html&&$.isArray(this.options.source)){this.source=function(request,response){response(filter(this.options.source,request.term));};}else{initSource.call(this);}},_renderItem:function(ul,item){return $("<li></li>").data("item.autocomplete",item).append($("<a></a>")[this.options.html?"html":"text"](item.label)).appendTo(ul);}});})(jQuery);
	/* temporary comment out
	var cache = {};
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
	    if (term in cache) { response(cache[term]); return; } 	    
	    $.ajax({
            type: "GET",		    
	    	url: 'http://localhost/~ThanhPT/GlobalHRM/public/recruitments/master/skills/'+ term,
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
	                		var s = skills[i].name.toLowerCase() + (skills[i].no_years==null ? "": ":" + skills[i].no_years + " years") ;
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
