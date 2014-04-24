// Start Ready
jQuery(document).ready(function($) {  

	// Live Search
	function search() {
		var query_value = $('input#live-search').val();
		$('span#live-search-string').html(query_value);
		if (query_value !== '') {
			$.ajax({
				type: "POST",
				url: hm_handbook.ajaxurl,
				data: { hm_handbook_search_query: query_value, action: 'hm_handbook', security: hm_handbook.ajaxnonce },
				cache: false,
				success: function(data){
					var html = $.parseJSON(data);
					$("#live-search-results").html(html);
				}
			});
		} return false;    
	}

	$("input#live-search").live("keyup", function(e) {
		
		if ( e.keyCode != 40 && e.keyCode != 38 && e.keyCode != 13 ) {
		
			clearTimeout($.data(this, 'timer'));
			var search_string = $(this).val();

			// Do Search!
			if (search_string == '') {
				$("#live-search-results").fadeOut();
				$('#live-search-text').fadeOut();
			} else {
				$("#live-search-results").fadeIn();
				$('#live-search-text').fadeIn();
				$(this).data('timer', setTimeout(search, 100));
			};
		
		}
		
	});
	
	var chosenResult = "";
	
	$("input#live-search").focus().keydown(function(e) {
		
		// Enter
		if ( e.keyCode == 13 ) {
			document.location.href = $('#live-search-results li.selected a').attr('href');
			return false;
		}
		
		// Key Down
	    if ( e.keyCode == 40 ) { 
	        if (chosenResult === "") {
	            chosenResult = 0;
	        } else if ((chosenResult+1) < $('#live-search-results li').length) {
	            chosenResult++; 
	        }
	        $('#live-search-results li').removeClass('selected');
	        $('#live-search-results li:eq('+chosenResult+')').addClass('selected');
	        return false;
	    }
		
		// Key Up
	    if ( e.keyCode == 38 ) { 
	        if (chosenResult === "") {
	            chosenResult = 0;
	        } else if (chosenResult > 0) {
	            chosenResult--;            
	        }
	        $('#live-search-results li').removeClass('selected');
	        $('#live-search-results li:eq('+chosenResult+')').addClass('selected');
	        return false;
	    }
	});

});