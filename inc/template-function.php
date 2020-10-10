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
        $header_container = get_theme_mod( 'select_header_container', 'container' );
        ?>
        <header class="py-2 bg-header">
            <div id="wrapper-navbar" itemscope itemtype="http://schema.org/WebSite">
                <div class="<?php echo $header_container; ?> mx-auto d-flex align-items-center">
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
        
        echo '<a class="navbar-brand" rel="home" href="'.get_site_url().'" title="'.esc_attr( get_bloginfo( 'name', 'display' ) ).'" itemprop="url">'.$title.'</a>';
    }
}
if( ! function_exists( 'justg_header_menu') ) {
    /**
     * Display Header Menu
     * 
     */
    function justg_header_menu(){
        ?>
        <nav class="navbar navbar-expand-md ml-auto">
            <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'justg'); ?>">
                <i class="fa fa-align-right" aria-hidden="true"></i>
            </button>

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

if ( ! function_exists( 'justg_header_cart' ) ) {
	/**
	 * Display Header Cart
	 */
	function justg_header_cart() {
		if ( justg_is_woocommerce_activated() ) {
			if ( is_cart() ) {
				$class = 'current-menu-item';
			} else {
				$class = '';
			}
			?>
            <div id="site-header-cart" class="site-header-cart position-relative">
                <?php justg_cart_link(); ?>
                <div class="dropdown-cart pt-3">
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
			<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'justg' ); ?>">
                <?php 
                // echo wp_kses_post( WC()->cart->get_cart_subtotal() ); 
                ?> 
                
                <span class="count">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i> 
                    <?php echo wp_kses_data( sprintf( _n( '%d', '%d', WC()->cart->get_cart_contents_count(), 'justg' ), WC()->cart->get_cart_contents_count() ) ); ?>
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
        echo '<a href="' . esc_url( wc_get_cart_url() ) . '" class="btn btn-sm btn-dark text-white">' . esc_html__( 'View cart', 'justg' ) . '</a>';
    }
}

if( ! function_exists( 'justg_widget_shopping_cart_proceed_to_checkout' )){
    /**
     * Replace Checkout button in shoping cart header
     */
    function justg_widget_shopping_cart_proceed_to_checkout() {
        echo '<a href="' . esc_url( wc_get_checkout_url() ) . '" class="btn btn-sm btn-dark text-white">' . esc_html__( 'Checkout', 'justg' ) . '</a>';
    }
}

if( ! function_exists( 'justg_header_close' )) {
    /**
     * Display header close
     * 
     */
    function justg_header_close() {
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
        $sep = ' '.$sep.' ';

        $breadcrumbdisable  = get_theme_mod('breadcrumb_disable', array());
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

        if ( $showbreadcrumb ) {
        
            // Home Url
            echo '<div class="breadcrumbs pb-2"  itemscope itemtype="https://schema.org/BreadcrumbList">';
            echo '<a href="';
                echo get_option('home');
                echo '">';
                bloginfo('name');
            echo '</a>' . $sep;
        
            // Check if the current page is a category, an archive or a single page
            if (is_category() || is_single() ){
                the_category('title_li=');
            } elseif (is_archive() || is_single()){
                if ( is_day() ) {
                    printf( __( '%s', 'justg' ), get_the_date() );
                } elseif ( is_month() ) {
                    printf( __( '%s', 'justg' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'justg' ) ) );
                } elseif ( is_year() ) {
                    printf( __( '%s', 'justg' ), get_the_date( _x( 'Y', 'yearly archives date format', 'justg' ) ) );
                } else {
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
                the_title();
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
                echo esc_html_e( 'Not Found', 'justg' );
            }
    
            echo '</div>';
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
        $pages_sidebar_pos      = get_theme_mod( 'justg_pages_sidebar_position' );
        $singular_sidebar_pos   = get_theme_mod( 'justg_blogs_sidebar_position' );
        $archives_sidebar_pos   = get_theme_mod( 'justg_archives_sidebar_position' );

        if (is_page() && !in_array($pages_sidebar_pos, array('', 'default')) ){
            $sidebar_pos = $pages_sidebar_pos;
        }

        if (is_singular() && !in_array($singular_sidebar_pos, array('', 'default')) ){
            $sidebar_pos = $singular_sidebar_pos;
        }

        if (is_archive() && !in_array($archives_sidebar_pos, array('', 'default')) ){
            $sidebar_pos = $archives_sidebar_pos;
        }

        if( justg_is_woocommerce_activated() && is_account_page() ){
            return;
        }

        if ( 'left' === $sidebar_pos ) {
            if ( ! is_active_sidebar( 'main-sidebar' ) ) {
                return;
            }
            ?>
            <div class="widget-area left-sidebar pr-md-2 col-sm-12 order-md-1 order-3" id="left-sidebar" role="complementary">
                <?php dynamic_sidebar( 'main-sidebar' ); ?>
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

        if (is_page() && !in_array($pages_sidebar_pos, array('', 'default')) ){
            $sidebar_pos = $pages_sidebar_pos;
        }

        if (is_singular() && !in_array($singular_sidebar_pos, array('', 'default')) ){
            $sidebar_pos = $singular_sidebar_pos;
        }

        if (is_archive() && !in_array($archives_sidebar_pos, array('', 'default')) ){
            $sidebar_pos = $archives_sidebar_pos;
        }

        if( justg_is_woocommerce_activated() && is_account_page() ){
            return;
        }

        if ( 'right' === $sidebar_pos ) {
            if ( ! is_active_sidebar( 'main-sidebar' ) ) {
                return;
            }
            ?>
            <div class="widget-area right-sidebar pl-md-2 col-sm-12 order-3" id="right-sidebar" role="complementary">
                <?php dynamic_sidebar( 'main-sidebar' ); ?>
            </div>
            <?php
        }
    }
}

if( ! function_exists( 'justg_the_footer_open' ) ) {
    /**
     * Footer open function
     * 
     */
    function justg_the_footer_open() {
        ?>
        
        <div class="wrapper bg-dark text-white" id="wrapper-footer">
        <div class="container">
        <footer class="site-footer" id="colophon">
            
        <?php
    }
}

if( ! function_exists( 'justg_the_footer_content' ) ) {
    /**
     * Footer content function
     * 
     */
    function justg_the_footer_content() {

        $footer_widget = get_theme_mod('footer_widget_setting', '0');
        if($footer_widget == '4'){
            echo '<div class="row">';
                
                for ($x = 1; $x <= 4; $x++) {

                    echo '<div class="col-md-3 col-12 footer-widget-1" >';

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