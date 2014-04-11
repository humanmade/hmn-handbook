<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Handbook
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<?php
	if ( $post->post_parent ) {
   		wp_list_pages('title_li=&include='.$post->post_parent);
    	wp_list_pages('title_li=&child_of='.$post->post_parent);
    } else {
    	// wp_list_pages('title_li=&include='.$post->ID);
    	wp_list_pages('title_li=&child_of='.$post->ID);
    }
	?>
	
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'handbook' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php edit_post_link( __( 'Edit', 'handbook' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer>' ); ?>
</article><!-- #post-## -->
