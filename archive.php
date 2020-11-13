<?php
/**
 * The template for displaying archive pages
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package justg
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'justg_container_type' );
?>

<div class="wrapper" id="archive-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check -->
			<?php do_action('justg_before_content'); ?>

			<main class="site-main col order-2" id="main">

				<?php

				if ( have_posts() ) {
					?>
					<header class="page-header block-primary">
						<?php
						do_action('justg_before_title');
						
						the_archive_title( '<h1 class="page-title">', '</h1>' );
						the_archive_description( '<div class="taxonomy-description">', '</div>' );
						?>
					</header><!-- .page-header -->
					<?php
					// Start the loop.
					while ( have_posts() ) {
						the_post();

						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'loop-templates/content', get_post_format() );
					}
				} else {
					get_template_part( 'loop-templates/content', 'none' );
				}
				?>
				<!-- Display the pagination component. -->
				<?php justg_pagination(); ?>
			</main><!-- #main -->

			<!-- Do the right sidebar check. -->
			<?php do_action('justg_after_content'); ?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #archive-wrapper -->

<?php
get_footer();
