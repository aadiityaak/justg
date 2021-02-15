<?php
/**
 * The template for displaying search results pages
 *
 * @package justg
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'justg_container_type' );

?>

<div class="wrapper" id="search-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check -->
			<?php do_action('justg_before_content'); ?>

			<main class="site-main col order-2 px-md-0" id="main">

				<?php if ( have_posts() ) : ?>

					<header class="page-header">

							<h1 class="page-title block-primary">
								<?php
								printf(
									/* translators: %s: query term */
									esc_html__( 'Search Results for: %s', 'justg' ),
									'<span>' . get_search_query() . '</span>'
								);
								?>
							</h1>

					</header><!-- .page-header -->

					<?php /* Start the Loop */ ?>
					<?php
					while ( have_posts() ) :
						the_post();

						/*
						 * Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called content-search.php and that will be used instead.
						 */
						get_template_part( 'loop-templates/content', 'search' );
					endwhile;
					?>

				<?php else : ?>

					<?php get_template_part( 'loop-templates/content', 'none' ); ?>

				<?php endif; ?>
				<!-- The pagination component -->
				<?php justg_pagination(); ?>
			</main><!-- #main -->

			<!-- Do the right sidebar check. -->
			<?php do_action('justg_after_content'); ?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #search-wrapper -->

<?php
get_footer();
