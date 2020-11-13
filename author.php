<?php
/**
 * The template for displaying the author pages
 *
 * Learn more: https://codex.wordpress.org/Author_Templates
 *
 * @package justg
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
$container = get_theme_mod( 'justg_container_type' );
?>

<div class="wrapper" id="author-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check -->
			<?php do_action('justg_before_content'); ?>

			<main class="site-main" id="main">

				<header class="page-header author-header block-primary">

					<?php
					if ( get_query_var( 'author_name' ) ) {
						$curauth = get_user_by( 'slug', get_query_var( 'author_name' ) );
					} else {
						$curauth = get_userdata( intval( $author ) );
					}
					?>

					<h1><?php echo esc_html__( 'About:', 'justg' ) . ' ' . esc_html( $curauth->nickname ); ?></h1>

					<?php
					if ( ! empty( $curauth->ID ) ) {
						echo get_avatar( $curauth->ID );
					}
					?>

					<?php if ( ! empty( $curauth->user_url ) || ! empty( $curauth->user_description ) ) : ?>
						<dl>
							<?php if ( ! empty( $curauth->user_url ) ) : ?>
								<dt><?php esc_html_e( 'Website', 'justg' ); ?></dt>
								<dd>
									<a href="<?php echo esc_url( $curauth->user_url ); ?>"><?php echo esc_html( $curauth->user_url ); ?></a>
								</dd>
							<?php endif; ?>

							<?php if ( ! empty( $curauth->user_description ) ) : ?>
								<dt><?php esc_html_e( 'Profile', 'justg' ); ?></dt>
								<dd><?php echo esc_html( $curauth->user_description ); ?></dd>
							<?php endif; ?>
						</dl>
					<?php endif; ?>

					<h2><?php echo esc_html__( 'Posts by', 'justg' ) . ' ' . esc_html( $curauth->nickname ); ?>:</h2>

				</header><!-- .page-header -->

				<div class="block-primary">
					<!-- The Loop -->
					<?php
					if ( have_posts() ) {
						echo '<ul>';
						while ( have_posts() ) {
							the_post();
							echo '<li>';
								printf(
									'<a rel="bookmark" href="%1$s" title="%2$s %3$s">%3$s</a>',
									esc_url( apply_filters( 'the_permalink', get_permalink( $post ), $post ) ),
									esc_attr( __( 'Permanent Link:', 'justg' ) ),
									get_the_title()
								);
								justg_posted_on();
								esc_html_e( 'in', 'justg' );
								the_category( '&' );
							echo '</li>';
						}
						echo '</ul>';
					} else {
						get_template_part( 'loop-templates/content', 'none' );
					}
					?>
					<!-- End Loop -->
				</div>
				<!-- The pagination component -->
				<?php justg_pagination(); ?>
			</main><!-- #main -->

			<!-- Do the right sidebar check. -->
			<?php do_action('justg_after_content'); ?>

		</div> <!-- .row -->

	</div><!-- #content -->

</div><!-- #author-wrapper -->

<?php
get_footer();
