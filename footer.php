<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Handbook
 */
?>

	<div id="three-widgets" class="site-footer">

		<?php dynamic_sidebar( 'footer-sidebar-1' ); ?>

	</div>

	<footer id="colophon" class="site-footer" role="contentinfo">

		<div class="site-info">
			<a href="http://hmn.md/" title="Human Made"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/hm-sketch.png" /></a>
		</div><!-- .site-info -->

		<div class="footer-2">

			<?php dynamic_sidebar( 'footer-sidebar-2' ); ?>

		</div>

	</footer><!-- #colophon -->

</div><!-- #content -->

<?php wp_footer(); ?>

</body>
</html>
