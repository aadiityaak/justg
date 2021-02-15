<?php
/**
 * Template Function
 *
 * @package justg
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


if( ! function_exists( 'justg_header_open' )) {
    /**
     * Display header open
     * 
     */
    function justg_header_open() {
        $header_container = get_theme_mod( 'select_header_container', 'full' );
        $header_position    = get_theme_mod( 'select_header_position', 'relative' );
        $header1 = [
            'fixed'     => 'container mx-auto px-3 block-header',
            'full'      => 'py-2 block-header',
            'stretch'   => 'p-2 block-header',
        ];
        $header2 = [
            'fixed'     => '',
            'full'      => 'container mx-auto px-md-0',
            'stretch'   => '',
        ];
        ?>
        <header id="wrapper-header" class="bg-header header-<?php echo $header_container; ?> <?php echo $header_position; ?>">
            <div id="wrapper-navbar" class="<?php echo $header1[$header_container]; ?>" itemscope itemtype="http://schema.org/WebSite">
                <div class="d-flex align-items-center <?php echo $header2[$header_container]; ?>">
        <?php
    }
}

if( ! function_exists( 'justg_header_logo' ) ) {
    /**
     * Display header logo
     * 
     */
    function justg_header_logo() {
        $custom_logo_id = get_theme_mod( 'custom_logo' );
        $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
        if(!empty($logo[0])) {
            $title = '<img src="'.esc_url($logo[0]).'">';
        } else {
            $title = get_bloginfo( 'name' );
        }
        
        echo '<a class="navbar-brand" rel="home" href="'.get_home_url().'" title="'.esc_attr( get_bloginfo( 'name', 'display' ) ).'" itemprop="url">'.$title.'</a>';
    }
}
if( ! function_exists( 'justg_header_menu') ) {
    /**
     * Display Header Menu
     * 
     */
    function justg_header_menu(){
        ?>
        <nav class="navbar navbar-expand-md ml-auto px-0">
            <!-- The WordPress Menu goes here -->
            <?php wp_nav_menu(
                array(
                    'theme_location'  => 'primary',
                    'container_class' => 'collapse navbar-collapse',
                    'container_id'    => 'navbarNavDropdown',
                    'menu_class'      => 'navbar-nav ml-auto',
                    'fallback_cb'     => '',
                    'menu_id'         => 'main-menu',
                    'depth'           => 2,
                    'walker'          => new justg_WP_Bootstrap_Navwalker(),
                )
            ); ?>
        </nav><!-- .site-navigation -->
        <?php
    }
}

if ( ! function_exists( 'justg_header_profile' ) ) {
	/**
	 * Display Header Profile 
	 */
	function justg_header_profile() {
		if ( justg_is_woocommerce_activated() ) {
			?>
            <div class="site-header-profile position-relative">
                <a class="py-2 px-3" href="<?php echo get_home_url();?>/my-account"><i class="fa fa-user fa-lg" aria-hidden="true"></i></a>
            </div>
            <?php
		}
	}
}

if ( ! function_exists( 'justg_header_wishlist' ) ) {
	/**
	 * Display Header Wishlist 
	 */
	function justg_header_wishlist() {
		if ( justg_is_woocommerce_activated() ) {
			?>
            <div class="site-header-profile position-relative d-none d-sm-block">
                <a class="py-2 px-3" href="<?php echo get_home_url();?>/my-account/wishlist"><i class="fa fa-heart-o fa-lg" aria-hidden="true"></i></a>
            </div>
            <?php
		}
	}
}

if ( ! function_exists( 'justg_header_cart' ) ) {
	/**
	 * Display Header Cart
	 */
	function justg_header_cart() {
		if ( justg_is_woocommerce_activated() ) {

            if( is_cart() || is_checkout() ){
                return;
            }
			?>
            <div id="site-header-cart" class="site-header-cart position-relative">
                <?php justg_cart_link(); ?>
                <div class="close-mini-cart"></div>
                <div class="cart-widget-side">
                    <div class="widget-heading">
                        <h3 class="widget-title"><?php esc_html_e( 'Shopping cart', 'justg' ); ?></h3>
                    </div>
                    <?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
                </div>
            </div>
            <?php
		}
	}
}

if ( ! function_exists( 'justg_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments
	 */
	function justg_cart_link_fragment( $fragments ) {
		global $woocommerce;

		ob_start();
		justg_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		ob_start();
		justg_handheld_footer_bar_cart_link();
		$fragments['a.footer-cart-contents'] = ob_get_clean();

		return $fragments;
	}
}

if ( ! function_exists( 'justg_cart_link' ) ) {
	/**
	 * Cart Link
	 */
	function justg_cart_link() {
		if ( ! justg_woo_cart_available() ) {
			return;
        }
		?>
			<a class="cart-contents px-3 open-mini-cart" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'justg' ); ?>">
                <?php 
                // echo wp_kses_post( WC()->cart->get_cart_subtotal() ); 
                ?> 
                
                <span class="count d-block">
                    <i class="fa fa-shopping-cart fa-lg" aria-hidden="true"></i> 
                    <span class="position-absolute pt-2">
                    <?php echo wp_kses_data( sprintf( _n( '%d', '%d', WC()->cart->get_cart_contents_count(), 'justg' ), WC()->cart->get_cart_contents_count() ) ); ?>
                    </span>
                </span>
			</a>
		<?php
	}
}

if ( ! function_exists( 'justg_handheld_footer_bar_cart_link' ) ) {
	/**
	 * The cart callback function for the handheld footer bar
	 */
	function justg_handheld_footer_bar_cart_link() {
		if ( ! justg_woo_cart_available() ) {
			return;
		}
		?>
			<a class="footer-cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'justg' ); ?>">
				<span class="count"><?php echo wp_kses_data( WC()->cart->get_cart_contents_count() ); ?></span>
			</a>
		<?php
	}
}

if ( ! function_exists( 'justg_widget_shopping_cart_button_view_cart') ) {
    /**
     * Replace View cart button in shoping cart header
     */
    function justg_widget_shopping_cart_button_view_cart() {
        echo '<a href="' . esc_url( wc_get_cart_url() ) . '" class="btn btn-sm btn-secondary btn-block">' . esc_html__( 'View cart', 'justg' ) . '</a>';
    }
}

if( ! function_exists( 'justg_widget_shopping_cart_proceed_to_checkout' )){
    /**
     * Replace Checkout button in shoping cart header
     */
    function justg_widget_shopping_cart_proceed_to_checkout() {
        echo '<a href="' . esc_url( wc_get_checkout_url() ) . '" class="btn btn-sm btn-primary btn-block">' . esc_html__( 'Checkout', 'justg' ) . '</a>';
    }
}

if( ! function_exists( 'justg_header_close' )) {
    /**
     * Display header close
     * 
     */
    function justg_header_close() {
        echo '<button class="navbar-toggler d-inline-block d-md-none ml-3" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false">';
        echo '<i class="fa fa-align-right" aria-hidden="true"></i>';
        echo '</button>';

        echo '</div></div></header>';
    }
}

if( ! function_exists( 'justg_breadcrumb' ) ) {
    /**
     * Function Breadcrumb
     * 
     */
    function justg_breadcrumb() {

        $sep = get_theme_mod('text_breadcrumb_separator', '/');
        $sep = '<span class="separator"> '.$sep.' </span>';

        $breadcrumbdisable   = get_theme_mod('breadcrumb_disable', array());
        $breadcrumb_position = get_theme_mod('breadcrumb_position', 'justg_after_title');
        $showbreadcrumb     = true;

        if ( is_front_page() && in_array( 'disable-on-home', $breadcrumbdisable)) {
            $showbreadcrumb = false;
        }

        if ( ! is_front_page() && is_singular( 'page' ) && in_array( 'disable-on-page', $breadcrumbdisable)) {
            $showbreadcrumb = false;
        }

        if ( is_archive() && in_array( 'disable-on-archive', $breadcrumbdisable)) {
            $showbreadcrumb = false;
        }
        
        if ( is_singular( 'post' ) && in_array( 'disable-on-post', $breadcrumbdisable)) {
            $showbreadcrumb = false;
        }

        if ( is_404() && in_array( 'disable-on-404', $breadcrumbdisable)) {
            $showbreadcrumb = false;
        }
        
        if ( in_array( 'disable-on-all', $breadcrumbdisable)) {
            $showbreadcrumb = false;
        }

        if ( $showbreadcrumb ) {
            
            if($breadcrumb_position == 'justg_top_content') {
                    echo '<div class="container mt-2">';
            }
                // Home Url
                echo '<div class="breadcrumbs pb-2"  itemscope itemtype="https://schema.org/BreadcrumbList">';
                
                $sethome = get_theme_mod('text_breadcrumb_home', 'home');
                echo '<a href="'.get_home_url().'">';
                    echo ($sethome=='home')?'Home':bloginfo('name');
                echo '</a>';
            
                // Check if the current page is a category, an archive or a single page
                if (is_category() || is_single() ){
                    if (get_the_category() && isset(get_the_category()[0])) {
                        echo $sep;
                        echo '<a href="'.get_term_link(get_the_category()[0]->term_id).'">'.get_the_category()[0]->name.'</a>';
                    }
                } elseif (is_archive() || is_single()){
                    if ( is_day() ) {
                        echo $sep;
                        printf( __( '%s', 'justg' ), get_the_date() );
                    } elseif ( is_month() ) {
                        echo $sep;
                        printf( __( '%s', 'justg' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'justg' ) ) );
                    } elseif ( is_year() ) {
                        echo $sep;
                        printf( __( '%s', 'justg' ), get_the_date( _x( 'Y', 'yearly archives date format', 'justg' ) ) );
                    } elseif ( is_tax() ) {
                        echo $sep;
                        echo single_term_title( '', false );
                    } else {
                        echo $sep;
                        echo post_type_archive_title( '', false );
                    }
                }
            
            
                // Singgle post and separator
                if (is_single()) {
                    echo $sep;
                    the_title();
                }
            
                // Static page title.
                if (is_page()) {
                    echo $sep;
                    the_title();
                }

                // Show search query
                if (is_search()) {
                    echo $sep;
                    the_search_query();
                }
            
                // if you have a static page assigned to be you posts list page
                if (is_home()){
                    global $post;
                    $page_for_posts_id = get_option('page_for_posts');
                    if ( $page_for_posts_id ) { 
                        $post = get_page($page_for_posts_id);
                        setup_postdata($post);
                        the_title();
                        rewind_posts();
                    }
                }

                // if 404
                if ( is_404() ) {
                    echo $sep;
                    echo esc_html_e( 'Not Found', 'justg' );
                }

                echo '</div>';
            if($breadcrumb_position == 'justg_top_content') {
                echo '</div>';
            }

        }
    }
}

if( ! function_exists( 'justg_left_sidebar_check' ) ) {
    /**
     * Left sidebar check
     * 
     */
    function justg_left_sidebar_check() {
        $sidebar_pos            = get_theme_mod( 'justg_sidebar_position', 'right');
        $pages_sidebar_pos      = get_theme_mod( 'justg_pages_sidebar_position', 'default');
        $singular_sidebar_pos   = get_theme_mod( 'justg_blogs_sidebar_position', 'default');
        $archives_sidebar_pos   = get_theme_mod( 'justg_archives_sidebar_position', 'default');
        $shop_sidebar_pos       = get_theme_mod( 'justg_shop_sidebar_position', 'default');

        if (is_page() && !in_array($pages_sidebar_pos, array('', 'default')) ){
            $sidebar_pos = $pages_sidebar_pos;
        }
        
        if (is_singular() && !in_array($singular_sidebar_pos, array('', 'default'))){
            $sidebar_pos = $singular_sidebar_pos;
        }

        if (is_archive() && !in_array($archives_sidebar_pos, array('', 'default'))){
            $sidebar_pos = $archives_sidebar_pos;
        }
        
        if( justg_is_woocommerce_activated() && is_shop() && !in_array($shop_sidebar_pos, array('', 'default'))){
            $sidebar_pos = $shop_sidebar_pos;
        }

        if( justg_is_woocommerce_activated() && ( is_account_page() || is_product() || is_cart() || is_checkout()) ){
            return;
        }

        if ( 'left' === $sidebar_pos ) {
            if ( ! is_active_sidebar( 'main-sidebar' ) ) {
                return;
            }
            ?>
            <div class="widget-area left-sidebar pr-md-2 pl-md-0 col-sm-12 order-md-1 order-3" id="left-sidebar" role="complementary">
                <?php do_action('justg_before_main_sidebar'); ?>
                <?php dynamic_sidebar( 'main-sidebar' ); ?>
                <?php do_action('justg_after_main_sidebar'); ?>
            </div>
            <?php
        }
    }
}

if( ! function_exists( 'justg_right_sidebar_check' ) ) {
    /**
     * Right sidebar check
     * 
     */
    function justg_right_sidebar_check() {
        $sidebar_pos            = get_theme_mod( 'justg_sidebar_position', 'right');
        $pages_sidebar_pos      = get_theme_mod( 'justg_pages_sidebar_position' );
        $singular_sidebar_pos   = get_theme_mod( 'justg_blogs_sidebar_position' );
        $archives_sidebar_pos   = get_theme_mod( 'justg_archives_sidebar_position' );
        $shop_sidebar_pos       = get_theme_mod( 'justg_shop_sidebar_position', 'default');

        if (is_page() && !in_array($pages_sidebar_pos, array('', 'default')) ){
            $sidebar_pos = $pages_sidebar_pos;
        }

        if (is_singular() && !in_array($singular_sidebar_pos, array('', 'default')) ){
            $sidebar_pos = $singular_sidebar_pos;
        }

        if (is_archive() && !in_array($archives_sidebar_pos, array('', 'default')) ){
            $sidebar_pos = $archives_sidebar_pos;
        }

        if( justg_is_woocommerce_activated() && is_shop() && !in_array($shop_sidebar_pos, array('', 'default'))){
            $sidebar_pos = $shop_sidebar_pos;
        }

        if( justg_is_woocommerce_activated() && ( is_account_page() || is_product() || is_cart() || is_checkout()) ){
            return;
        }

        if ( 'right' === $sidebar_pos ) {
            if ( ! is_active_sidebar( 'main-sidebar' ) ) {
                return;
            }
            ?>
            <div class="widget-area right-sidebar pl-md-2 pr-md-0 col-sm-12 order-3" id="right-sidebar" role="complementary">
                <?php do_action('justg_before_main_sidebar'); ?>
                <?php dynamic_sidebar( 'main-sidebar' ); ?>
                <?php do_action('justg_after_main_sidebar'); ?>
            </div>
            <?php
        }
    }
}

if( ! function_exists( 'justg_loop_product_title' ) ) {
    /**
     * Product Loop Title
     * 
     */
    function justg_loop_product_title() {
        echo '<h3 class="' . esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title' ) ) . '" >';
        echo '<a href="' .get_the_permalink(). '">' .get_the_title().'</a>';
        echo '</h3>';
    }
}

if( ! function_exists( 'justg_the_footer_open' ) ) {
    /**
     * Footer open function
     * 
     */
    function justg_the_footer_open() {        
        $footer_container = get_theme_mod( 'option_footer_container', 'full' );
        $footer1 = [
            'fixed'     => 'container mx-auto p-3 block-footer',
            'full'      => 'py-3 block-footer',
            'stretch'   => 'p-3 block-footer',
        ];
        $footer2 = [
            'fixed'     => '',
            'full'      => 'container mx-auto px-md-0',
            'stretch'   => '',
        ];
        ?>
        
        <div class="bg-footer footer-<?php echo $footer_container; ?>" id="wrapper-footer">
            <div class="<?php echo $footer1[$footer_container]; ?>">
                <footer class="site-footer <?php echo $footer2[$footer_container]; ?>" id="colophon">            
        <?php
    }
}

if( ! function_exists( 'justg_widget_float' ) ) {
    /**
     * Floating whatsapp
     * 
     */
    function justg_widget_float() {

        $no_wa          = get_theme_mod('nomor_whatsapp', 0);
        $to_top_status  = get_theme_mod('to_top_status', 'off');
        $icon_to_top    = get_theme_mod('icon_to_top', 'arrow-up');
        $text_wa        = get_theme_mod('text_whatsapp', 'Contact Us!');
        $wa_position    = get_theme_mod('posisi_wa', 'right');
        if (substr($no_wa, 0, 1) === '0') {
           $no_wa    = '62' . substr($no_wa, 1);
        } else if (substr($no_wa, 0, 1) === '+') {
            $no_wa    = '' . substr($no_wa, 1);
        }
        if($to_top_status == 'on' || $no_wa){
            echo '<div class="float-widget">';
                if(get_theme_mod('nomor_whatsapp', 0)) {
                    echo '<a class="position-fixed btn btn-sm bg-whatsapp-float whatsapp-float text-white ml-auto wa-'.$wa_position.'" href="https://wa.me/'.$no_wa.'" target="_blank"><i class="fa fa-whatsapp" aria-hidden="true"></i> <span class="d-none d-md-inline">'.$text_wa.'</span></a>';
                }
                if($to_top_status == 'on') {
                    echo '<a id="go-to-top" class="position-fixed btn btn-sm bg-to-top-float to-top-float text-white"><span class="dashicons dashicons-'.esc_attr( $icon_to_top ).'"></span></a>';
                }
                echo '</div>';
        }
    }
}

if( ! function_exists( 'justg_the_footer_content' ) ) {
    /**
     * Footer content function
     * 
     */
    function justg_the_footer_content() {

        $footer_widget = get_theme_mod('footer_widget_setting', '0');
        if($footer_widget != '0'){
            echo '<div class="row">';
                
                for ($x = 1; $x <= $footer_widget; $x++) {

                    echo '<div class="col-md col-12 footer-widget-1" >';

                    if ( is_active_sidebar( 'footer-widget-'.$x ) ) {
                        dynamic_sidebar( 'footer-widget-'.$x );
                    } elseif ( current_user_can( 'edit_theme_options' ) ) {
                        ?>
                        <aside class="mb-3 widget">
                            <p class='no-widget-text'>
                                <a href='<?php echo esc_url( admin_url( 'widgets.php' ) ); ?>'>
                                    <?php esc_html_e( 'Click here to edit widget.', 'justg' ); ?>
                                </a>
                            </p>
                        </aside>
                        <?php
                    }

                    echo '</div>';

                }
                
            echo '</div>';
        }
        ?>
        
        <div class="site-info">
            <div class="text-center">© <?php echo date("Y"); ?> <?php echo get_bloginfo('name');?>. All Rights Reserved.</div>
        </div><!-- .site-info -->
        <?php
    }
}

if( ! function_exists( 'justg_the_footer_close' ) ) {
    /**
     * Footer Close function
     * 
     */
    function justg_the_footer_close() {
        ?>
        </footer><!-- #colophon -->
        </div><!-- container end -->
        </div><!-- wrapper end -->
        <?php
    }
}
