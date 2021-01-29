<?php
/**
 * Single post partial template
 *
 * @package justg
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
$full_url = get_the_post_thumbnail_url(get_the_ID(),'full');
?>

<article <?php post_class('block-primary'); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">

		<?php 
		
		do_action('justg_before_title');

		the_title( '<h1 class="entry-title">', '</h1>' ); 
		?>

		<div class="entry-meta mb-2">

			<?php justg_posted_on(); ?>

		</div><!-- .entry-meta -->

	</header><!-- .entry-header -->

	<?php
	if($full_url){
		echo '<img class="w-100 mb-2" src="'.$full_url.'">';
	}
	?>

	<div class="entry-content">

		<?php the_content(); ?>

		<?php
		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'justg' ),
				'after'  => '</div>',
			)
		);
		?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php justg_entry_footer(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
