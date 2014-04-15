<?php
/*
Template Name: Live Search
*/

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<input id="live-search" type="text" autocomplete="off">
			
			<h4 id="live-search-text"><?php _e( 'Showing results for:', 'hm-handbook' ); ?> <span id="live-search-string"></span></h4>
				
			<ul id="live-search-results"></ul>
			
		</main><!-- #main -->
	</div><!-- #primary -->
	
<?php get_footer(); ?>