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
	});

});