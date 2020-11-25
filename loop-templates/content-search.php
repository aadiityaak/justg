<?php
/**
 * Search results partial template
 *
 * @package justg
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class('block-primary'); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">

		<?php
		do_action('justg_before_title');

		the_title(
			sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ),
			'</a></h2>'
		);

		do_action('justg_after_title');
		?>

		<?php if ( 'post' === get_post_type() ) : ?>

			<div class="entry-meta">

				<?php justg_posted_on(); ?>

			</div><!-- .entry-meta -->

		<?php endif; ?>

	</header><!-- .entry-header -->

	<div class="entry-summary">

		<?php the_excerpt(); ?>

	</div><!-- .entry-summary -->

	<footer class="entry-footer">

		<?php justg_entry_footer(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
