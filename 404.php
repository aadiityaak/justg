<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package justg
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'justg_container_type' );
?>

<div class="wrapper" id="error-404-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check -->
			<?php do_action('justg_before_content'); ?>

			<div class="content-area col" id="primary">

				<main class="site-main" id="main">

					

					<section class="error-404 not-found">

						<header class="page-header block-primary">

							<?php do_action('justg_before_title'); ?>

							<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'justg' ); ?></h1>

							<?php do_action('justg_after_title'); ?>

						</header><!-- .page-header -->

						<div class="page-content block-primary">

							<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'justg' ); ?></p>

							<?php get_search_form(); ?>

							<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>

							<?php if ( justg_categorized_blog() ) : // Only show the widget if site has multiple categories. ?>

								<div class="widget widget_categories">

									<h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'justg' ); ?></h2>

									<ul>
										<?php
										wp_list_categories(
											array(
												'orderby'  => 'count',
												'order'    => 'DESC',
												'show_count' => 1,
												'title_li' => '',
												'number'   => 10,
											)
										);
										?>
									</ul>

								</div><!-- .widget -->

							<?php endif; ?>

							<?php

							/* translators: %1$s: smiley */
							$archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'justg' ), convert_smilies( ':)' ) ) . '</p>';
							the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );

							the_widget( 'WP_Widget_Tag_Cloud' );
							?>

						</div><!-- .page-content -->

					</section><!-- .error-404 -->

				</main><!-- #main -->

			</div><!-- #primary -->
			
			<!-- Do the right sidebar check. -->
			<?php do_action('justg_after_content'); ?>


		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #error-404-wrapper -->

<?php
get_footer();
