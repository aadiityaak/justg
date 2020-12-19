<?php
/**
 * Wishlist Function
 *
 * @package justg
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


if (justg_is_woocommerce_activated()) {


    // Get current user data
    function fetch_user_data() {
        if (is_user_logged_in()){
            $current_user = wp_get_current_user();
            $current_user_wishlist = get_user_meta( $current_user->ID, 'wishlist',true);
            echo json_encode(array('user_id' => $current_user->ID,'wishlist' => $current_user_wishlist));
        }
        die();
    }
    add_action( 'wp_ajax_fetch_user_data', 'fetch_user_data' );
    add_action( 'wp_ajax_nopriv_fetch_user_data', 'fetch_user_data' );

    // Add wishlist to product
    add_action('woocommerce_before_shop_loop_item_title','wishlist_toggle',15);
    add_action('woocommerce_after_add_to_cart_button','wishlist_single',25);
    function wishlist_toggle(){
        global $product;
        echo '<a class="wishlist-toggle wishlist-fix" data-product="'.esc_attr($product->get_id()).'" href="#" title="'.esc_attr__("Add to wishlist","justg").'"><i class="fa fa-heart-o" aria-hidden="true"></i></a>';
    }
    function wishlist_single(){
        global $product;
        echo '<a class="wishlist-toggle btn btn-outline-primary btn-sm ml-2" data-product="'.esc_attr($product->get_id()).'" href="#" title="'.esc_attr__("Add to wishlist","justg").'"><i class="fa fa-heart-o" aria-hidden="true"></i></a>';
    }

    // Wishlist option in the user profile
    add_action( 'show_user_profile', 'wishlist_user_profile_field' );
    add_action( 'edit_user_profile', 'wishlist_user_profile_field' );
    function wishlist_user_profile_field( $user ) { ?>
        <table class="form-table wishlist-data">
            <tr>
                <th><?php echo esc_attr__("Wishlist","justg"); ?></th>
                <td>
                    <input type="text" name="wishlist" id="wishlist" value="<?php echo esc_attr( get_the_author_meta( 'wishlist', $user->ID ) ); ?>" class="regular-text" />
                </td>
            </tr>
        </table>
    <?php }

    add_action( 'personal_options_update', 'save_wishlist_user_profile_field' );
    add_action( 'edit_user_profile_update', 'save_wishlist_user_profile_field' );
    function save_wishlist_user_profile_field( $user_id ) {
        if ( !current_user_can( 'edit_user', $user_id ) ) {
            return false;
        }
        update_user_meta( $user_id, 'wishlist', $_POST['wishlist'] );
    }

    function update_wishlist_ajax(){
        if (isset($_POST["user_id"]) && !empty($_POST["user_id"])) {
            $user_id   = $_POST["user_id"];
            $user_obj = get_user_by('id', $user_id);
            if (!is_wp_error($user_obj) && is_object($user_obj)) {
                update_user_meta( $user_id, 'wishlist', $_POST["wishlist"]);
            }
        }
        die();
    }
    add_action('admin_post_nopriv_user_wishlist_update', 'update_wishlist_ajax');
    add_action('admin_post_user_wishlist_update', 'update_wishlist_ajax');

    // Dipanggil di inc/woocommerce.php
    function wishlist() {
        
        return '<table class="wishlist-table table loading"></table>';

    }

    // Extend REST API
    function rest_register_fields(){

        register_rest_field('product',
            'price',
            array(
                'get_callback'    => 'rest_price',
                'update_callback' => null,
                'schema'          => null
            )
        );

        register_rest_field('product',
            'stock',
            array(
                'get_callback'    => 'rest_stock',
                'update_callback' => null,
                'schema'          => null
            )
        );

        register_rest_field('product',
            'image',
            array(
                'get_callback'    => 'rest_img',
                'update_callback' => null,
                'schema'          => null
            )
        );
    }
    add_action('rest_api_init','rest_register_fields');

    function rest_price($object,$field_name,$request){

        global $product;

        $id = $product->get_id();

        if ($id == $object['id']) {
            return $product->get_price();
        }

    }

    function rest_stock($object,$field_name,$request){

        global $product;

        $id = $product->get_id();

        if ($id == $object['id']) {
            return $product->get_stock_status();
        }

    }

    function rest_img($object,$field_name,$request){

        global $product;

        $id = $product->get_id();

        if ($id == $object['id']) {
            return $product->get_image();
        }

    }

    function maximum_api_filter($query_params) {
        $query_params['per_page']["maximum"]=100;
        return $query_params;
    }
    add_filter('rest_product_collection_params', 'maximum_api_filter');
}
