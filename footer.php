<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package justg
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<?php do_action('justg_do_footer'); ?>

</div><!-- #page we need this extra closing tag here -->

<?php wp_footer(); ?>

</body>

</html>

