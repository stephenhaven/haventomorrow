<?php
/**
 * haventomorrow functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package haventomorrow
 */

if ( ! function_exists( 'haventomorrow_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function haventomorrow_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on haventomorrow, use a find and replace
	 * to change 'haventomorrow' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'haventomorrow', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Primary', 'haventomorrow' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'haventomorrow_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif;
add_action( 'after_setup_theme', 'haventomorrow_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function haventomorrow_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'haventomorrow_content_width', 640 );
}
add_action( 'after_setup_theme', 'haventomorrow_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function haventomorrow_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'haventomorrow' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'haventomorrow' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'haventomorrow_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function haventomorrow_scripts() {
	wp_enqueue_style( 'slick-slider', '//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css' );

	wp_enqueue_style( 'slick-theme', '//cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick-theme.min.css' );

	wp_enqueue_style( 'haventomorrow-style', get_stylesheet_uri() );

	wp_enqueue_script( 'slick-script', '//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js' );

	wp_enqueue_script( 'haventomorrow-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'haventomorrow-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	wp_enqueue_script( 'haventomorrow-programs', get_template_directory_uri() . '/js/programs.js', array(), '20170731', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'haventomorrow_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once dirname( __FILE__ ) . '/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', 'my_theme_register_js_composer_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function my_theme_register_js_composer_plugins() {
    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(
        // This is an example of how to include a plugin pre-packaged with a theme
        array(
            'name'          => 'WPBakery Visual Composer', // The plugin name
            'slug'          => 'js_composer', // The plugin slug (typically the folder name)
            'source'            => get_stylesheet_directory() . '/js_composer.zip', // The plugin source
            'required'          => true, // If false, the plugin is only 'recommended' instead of required
            'version'           => '3.7', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'      => '', // If set, overrides default API URL and points to an external URL
        )
    );

    // Change this to your theme text domain, used for internationalising strings
    $theme_text_domain = 'haventomorrow';

    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'domain'        => $theme_text_domain, // Text domain - likely want to be the same as your theme.
        'default_path'      => '', // Default absolute path to pre-packaged plugins
        'parent_menu_slug'  => 'themes.php', // Default parent menu slug
        'parent_url_slug'   => 'themes.php', // Default parent URL slug
        'menu'          => 'install-required-plugins', // Menu slug
        'has_notices'       => true, // Show admin notices or not
        'is_automatic'      => false, // Automatically activate plugins after installation or not
        'message'       => '', // Message to output right before the plugins table
        'strings'       => array(
            'page_title'            => __( 'Install Required Plugins', $theme_text_domain ),
            'menu_title'            => __( 'Install Plugins', $theme_text_domain ),
            'installing'            => __( 'Installing Plugin: %s', $theme_text_domain ), // %1$s = plugin name
            'oops'              => __( 'Something went wrong with the plugin API.', $theme_text_domain ),
            'notice_can_install_required'   => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
            'notice_can_install_recommended'    => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
            'notice_cannot_install'     => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
            'notice_can_activate_required'  => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
            'notice_can_activate_recommended'   => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
            'notice_cannot_activate'        => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
            'notice_ask_to_update'      => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
            'notice_cannot_update'      => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
            'install_link'          => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
            'activate_link'         => _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
            'return'                => __( 'Return to Required Plugins Installer', $theme_text_domain ),
            'plugin_activated'          => __( 'Plugin activated successfully.', $theme_text_domain ),
            'complete'              => __( 'All plugins installed and activated successfully. %s', $theme_text_domain ), // %1$s = dashboard link
            'nag_type'              => 'updated' // Determines admin notice type - can only be 'updated' or 'error'
        )
    );
    tgmpa( $plugins, $config );
}

/**
 * Force Visual Composer to initialize as "built into the theme". This will hide certain tabs under the Settings->Visual Composer page
 */
add_action( 'vc_before_init', 'your_prefix_vcSetAsTheme' );
function your_prefix_vcSetAsTheme() {
    vc_set_as_theme();
}




/*
******************************************
*** Taken from haven2015 functions.php ***
******************************************
*/

// add_action( 'init', 'create_taxonomies' );
// function create_taxonomies() {
// 	register_taxonomy(
// 		'series', 'page',
// 		array(
// 			'label' => __( 'Program Series' ),
// 			//'rewrite' => array( 'slug' => 'series' ),
// 			'rewrite' => array('with_front' => false, 'slug' => 'series'),
// 			'hierarchical' => true
// 		)
// 	);
// 	register_taxonomy(
// 		'speaker', 'programs',
// 		array(
// 			'label' => __( 'Guest Speakers' ),
// 			//'rewrite' => array( 'slug' => 'speaker' ),
// 			'rewrite' => array('with_front' => false, 'slug' => 'speaker'),
// 			'hierarchical' => true
// 		)
// 	);
//
// 	$labels_campaign = array(
// 		'name'              => _x( 'Campaigns', 'taxonomy general name' ),
// 		'singular_name'     => _x( 'Campaign Types', 'taxonomy singular name' ),
// 		'search_items'      => __( 'Search Campaigns Types' ),
// 		'all_items'         => __( 'All Campaigns Types' ),
// 		'parent_item'       => __( 'Parent Campaign' ),
// 		'parent_item_colon' => __( 'Parent Campaign:' ),
// 		'edit_item'         => __( 'Edit Campaign Type' ),
// 		'update_item'       => __( 'Update Campaign Type' ),
// 		'add_new_item'      => __( 'Add New Campaign Type' ),
// 		'new_item_name'     => __( 'New Campaign Type Name' ),
// 		'menu_name'         => __( 'Campaign' ),
// 	);
//
// 	$args_campaign = array(
// 		'hierarchical'      => true,
// 		'labels'            => $labels_campaign,
// 		'show_ui'           => true,
// 		'show_admin_column' => true,
// 		'query_var'         => true,
// 		'rewrite'           => array('with_front' => false, 'slug' => 'campaign'),
// 	);
//
// 	register_taxonomy('campaign', 'product', $args_campaign);
// }


add_action( 'init', 'create_posttypes' );
function create_posttypes() {
// 	register_post_type( 'programs',
// 		array(
// 			'labels' => array(
// 			'name' => __( 'Program' ),
// 			'singular_name' => __( 'Program' ),
// 			'menu_name'          => _x( 'Programs', 'admin menu' ),
// 			'name_admin_bar'     => _x( 'Program', 'add new on admin bar' ),
// 			'add_new'            => _x( 'Add New', 'Program' ),
// 			'add_new_item'       => __( 'Add New Program' ),
// 			'new_item'           => __( 'New Program' ),
// 			'edit_item'          => __( 'Edit Program' ),
// 			'view_item'          => __( 'View Program' ),
// 			'all_items'          => __( 'All Programs' ),
// 			'search_items'       => __( 'Search Programs' ),
// 			'parent_item_colon'  => __( 'Parent Programs:' ),
// 			'not_found'          => __( 'No programs found.' ),
// 			'not_found_in_trash' => __( 'No programs found in Trash.' )
// 		),
// 			'public' => true,
// 			'publicly_queryable' => true,
// 			'has_archive' => true,
// 			//'rewrite' => array('slug' => 'program'),
// 			'rewrite' => array('with_front' => false, 'slug' => 'program'),
// 			'hierarchical' => true,
// 			'menu_icon' => 'dashicons-media-audio',
// 			'menu_position' => 20,
// 			'show_ui' => true,
// 			'show_in_menu' => true,
// 			'capability_type' => 'page',
// 			'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes'),
// 			'taxonomies' => array('series', 'category', 'post_tag', 'speaker')
// 		)
// 	);
	register_post_type( 'anchor',
		array(
			'labels' => array(
			'name' => __( 'Anchor' ),
			'singular_name' => __( 'Anchor' ),
			'menu_name'          => _x( 'Anchors', 'admin menu' ),
			'name_admin_bar'     => _x( 'Anchor', 'add new on admin bar' ),
			'add_new'            => _x( 'Add New', 'Anchor' ),
			'add_new_item'       => __( 'Add New Anchor' ),
			'new_item'           => __( 'New Anchor' ),
			'edit_item'          => __( 'Edit Anchor' ),
			'view_item'          => __( 'View Anchor' ),
			'all_items'          => __( 'All Anchors' ),
			'search_items'       => __( 'Search Anchors' ),
			'parent_item_colon'  => __( 'Parent Anchors:' ),
			'not_found'          => __( 'No anchors found.' ),
			'not_found_in_trash' => __( 'No anchors found in Trash.' )
		),
			'public' => true,
			'publicly_queryable' => true,
			'has_archive' => true,
			//'rewrite' => array('slug' => 'anchor'),
			'rewrite' => array('with_front' => false, 'slug' => 'anchor'),
			'hierarchical' => true,
			'menu_icon' => 'dashicons-book',
			'menu_position' => 20,
			'show_ui' => true,
			'show_in_menu' => true,
			'capability_type' => 'page',
			'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes'),
			'taxonomies' => array('category')
		)
	);
	register_post_type( 'haven',
		array(
			'labels' => array(
			'name' => __( 'Haven Now' ),
			'singular_name' => __( 'Haven Now' ),
			'menu_name'          => _x( 'Haven Now', 'admin menu' ),
			'name_admin_bar'     => _x( 'Haven Now', 'add new on admin bar' ),
			'add_new'            => _x( 'Add New', 'Haven Now' ),
			'add_new_item'       => __( 'Add New Haven Now' ),
			'new_item'           => __( 'New Haven Now' ),
			'edit_item'          => __( 'Edit Haven Now' ),
			'view_item'          => __( 'View Haven Now' ),
			'all_items'          => __( 'All Haven Now' ),
			'search_items'       => __( 'Search Haven Now' ),
			'parent_item_colon'  => __( 'Parent Haven Now:' ),
			'not_found'          => __( 'No posts found.' ),
			'not_found_in_trash' => __( 'No posts found in Trash.' )
		),
			'public' => true,
			'publicly_queryable' => true,
			'has_archive' => true,
			//'rewrite' => array('slug' => 'haven'),
			'rewrite' => array('with_front' => false, 'slug' => 'haven'),
			'hierarchical' => true,
			'menu_icon' => 'dashicons-book',
			'menu_position' => 20,
			'show_ui' => true,
			'show_in_menu' => true,
			'capability_type' => 'page',
			'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes'),
			'taxonomies' => array('category')
		)
	);
	register_post_type( 'anchortoday',
		array(
			'labels' => array(
			'name' => __( 'Anchor Today' ),
			'singular_name' => __( 'Anchor Today' ),
			'menu_name'          => _x( 'Anchor Today', 'admin menu' ),
			'name_admin_bar'     => _x( 'Anchor Today', 'add new on admin bar' ),
			'add_new'            => _x( 'Add New', 'Anchor Today' ),
			'add_new_item'       => __( 'Add New Anchor Today' ),
			'new_item'           => __( 'New Anchor Today' ),
			'edit_item'          => __( 'Edit Anchor Today' ),
			'view_item'          => __( 'View Anchor Today' ),
			'all_items'          => __( 'All Anchor Today' ),
			'search_items'       => __( 'Search Anchor Today' ),
			'parent_item_colon'  => __( 'Parent Anchor Today:' ),
			'not_found'          => __( 'No posts found.' ),
			'not_found_in_trash' => __( 'No posts found in Trash.' )
		),
			'public' => true,
			'publicly_queryable' => true,
			'has_archive' => true,
			//'rewrite' => array('slug' => 'anchortoday'),
			'rewrite' => array('with_front' => false, 'slug' => 'anchortoday'),
			'hierarchical' => true,
			'menu_icon' => 'dashicons-book',
			'menu_position' => 20,
			'show_ui' => true,
			'show_in_menu' => true,
			'capability_type' => 'page',
			'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes'),
			'taxonomies' => array('category')
		)
	);
// 	register_post_type( 'giving',
// 		array(
// 			'labels' => array(
// 			'name' => __( 'Recurring Giving' ),
// 			'singular_name' => __( 'Recurring Giving' ),
// 			'menu_name'          => _x( 'Recurring Giving', 'admin menu' ),
// 			'name_admin_bar'     => _x( 'Recurring Giving', 'add new on admin bar' ),
// 			'add_new'            => _x( 'Add New', 'Recurring Giving' ),
// 			'add_new_item'       => __( 'Add New Recurring Giving' ),
// 			'new_item'           => __( 'New Recurring Giving' ),
// 			'edit_item'          => __( 'Edit Recurring Giving' ),
// 			'view_item'          => __( 'View Recurring Giving' ),
// 			'all_items'          => __( 'All Recurring Giving' ),
// 			'search_items'       => __( 'Search Recurring Giving' ),
// 			'parent_item_colon'  => __( 'Parent Recurring Giving:' ),
// 			'not_found'          => __( 'No posts found.' ),
// 			'not_found_in_trash' => __( 'No posts found in Trash.' )
// 		),
// 			'public' => false,
// 			'publicly_queryable' => false,
// 			'has_archive' => true,
// 			//'rewrite' => array('slug' => 'recurring-giving'),
// 			'rewrite' => array('with_front' => false, 'slug' => 'recurring-giving'),
// 			'hierarchical' => false,
// 			'menu_icon' => 'dashicons-vault',
// 			'menu_position' => 100,
// 			'show_ui' => true,
// 			'show_in_menu' => true,
// 			'capability_type' => 'page',
// 			'capabilities' => array(
// 				'create_posts' => false // Removes support for the "Add New" function ( use 'do_not_allow' instead of false for multisite set ups )
// 			),
// 			'map_meta_cap' => true, // Set to `false`, if users are not allowed to edit/delete existing posts
// 			'supports' => array( 'title')
// 		)
}

/*set sort order by date for custom post types in CMS*/
function order_cpt_by_date_default( $wp_query ) {
	if ( is_admin() && !isset( $_GET['orderby'] ) ) {
	// Get the post type from the query
		$post_type = $wp_query->query['post_type'];
		if ( in_array( $post_type, array('programs','anchor','haven','anchortoday','giving') ) ) {
			$wp_query->set('orderby', 'date');
			$wp_query->set('order', 'DESC');
		}
	}
}
add_filter('pre_get_posts', 'order_cpt_by_date_default');

add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}

remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40, 0);
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20, 0);
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30, 0);

add_action( 'woocommerce_sidebar', 'woocommerce_output_related_products', 60 );

add_filter( 'woocommerce_default_address_fields' , 'custom_override_default_address_fields' );
function custom_override_default_address_fields( $address_fields ) {
	$address_fields['first_name']['class'] = array('short left');
	$address_fields['last_name']['class'] = array('short right');
	$address_fields['first_name']['placeholder'] = 'First Name';
	$address_fields['last_name']['placeholder'] = 'Last Name';
	return $address_fields;
}

add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
function custom_override_checkout_fields( $fields ) {
	$fields['billing']['billing_email']['class'] = array('short left');
	$fields['billing']['billing_phone']['class'] = array('short right');
	$fields['billing']['billing_state']['class'] = array('short left address-field');
	$fields['billing']['billing_postcode']['class'] = array('short right');
	$fields['shipping']['shipping_state']['class'] = array('short left');
	$fields['shipping']['shipping_postcode']['class'] = array('short right');
	//$fields['billing']['billing_company']['placeholder'] = 'Company Name';
	$fields['billing']['billing_email']['placeholder'] = 'Email Address';
	$fields['billing']['billing_phone']['placeholder'] = 'Phone';
	//$fields['shipping']['shipping_company']['placeholder'] = 'Company Name';
	unset($fields['billing']['billing_company']);
	unset($fields['shipping']['shipping_company']);
    return $fields;
}

add_filter( 'woocommerce_billing_fields', 'wc_billing_fields_state_filter', 10, 1 );
function wc_billing_fields_state_filter( $address_fields ) {
	$address_fields['billing_state']['label'] = 'State / Province';
	$address_fields['billing_state']['placeholder'] = 'State / Province';
	return $address_fields;
}

function wc_validate_phone_number() {
	$phone = (isset( $_POST['billing_phone'] ) ? trim( $_POST['billing_phone'] ) : '');
	if ( ! preg_match( '/\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/', $phone ) ) {
		wc_add_notice( __( 'Please enter with a valid phone number. EX: 555-555-5555' ), 'error' );
	}
}

add_action( 'woocommerce_checkout_process', 'wc_validate_phone_number' );

// add_action( 'woocommerce_before_calculate_totals', 'change_cart_gift_price' );

// function change_cart_gift_price( $gift_id ) {
	// foreach ( WC()->cart->get_cart() as $cart_item_id => $value ) {
		// // check if product not belonging to giving category
		// $value['data']->price = 0;
		// //var_dump($value['product_id']);
		// // if ( $value['product_id'] == $gift_id ) {
			// // //var_dump($value['product_id']);
			// // $value['data']->price = 0;
			// // break;
		// // }
	// }
// }

function pagination_bar() {
    global $wp_query;

    $total_pages = $wp_query->max_num_pages;

    if ($total_pages > 1){
        $current_page = max(1, get_query_var('paged'));

        echo paginate_links(array(
            'base' => get_pagenum_link(1) . '%_%',
            'format' => 'page/%#%',
            'current' => $current_page,
            'total' => $total_pages,
        ));
    }
}

function pagination_bar_search() {
    global $wp_query;

    $total_pages = $wp_query->max_num_pages;

    if ($total_pages > 1){
        $current_page = max(1, get_query_var('paged'));


        echo paginate_links(array(
            'base' =>'%_%',
            'format' => '/page/%#%',
            'current' => $current_page,
            'total' => $total_pages,
        ));
    }
}

class WC_Haven_Recurring_Admin {

	static $simple_supported_types = array( 'simple' );

	public function init() {

		// Product Meta boxes
		add_filter( 'product_type_options', array( __CLASS__, 'product_type_options' ) );
		add_action( 'woocommerce_product_options_general_product_data', array( __CLASS__, 'add_to_metabox' ) );
		add_action( 'woocommerce_process_product_meta', array( __CLASS__, 'save_product_meta' ), 20, 2 );

		// Setup Product Data
		add_action( 'the_post', array( __CLASS__, 'setup_product' ), 20 );

	}

	public function product_type_options( $options ){

	  $options['recurring'] = array(
	      'id' => '_recurring',
	      'wrapper_class' => 'show_if_simple',
	      'label' => __( 'Haven Recurring', 'wc_recurring_haven'),
	      'description' => __( 'Show the Haven recurring options.', 'wc_recurring_haven'),
	      'default' => 'no'
	    );

	  return $options;

	}

	public function save_product_meta( $post_id, $post ) {

	   	$product_type = empty( $_POST['product-type'] ) ? 'simple' : sanitize_title( stripslashes( $_POST['product-type'] ) );

	   	if ( isset( $_POST['_recurring'] ) && in_array( $product_type, self::$simple_supported_types) ) {
			update_post_meta( $post_id, '_recurring', 'yes' );
		} else {
			update_post_meta( $post_id, '_recurring', 'no' );
		}

	}

	public function setup_product(){
		global $product;

		if ( !$product )
			return;

		if ( has_term( array( 'simple' ), 'product_type', $product->id ) && 'yes' == get_post_meta( $product->id, '_recurring', true ) ) {
			$product->recurring = true;
		} else {
			$product->recurring = false;
		}
	}

}
WC_Haven_Recurring_Admin::init();

add_action('woocommerce_after_checkout_form', 'print_recurring_form');
function print_recurring_form() {

	global $product;

	if($product->recurring == true){

		include(TEMPLATEPATH . '/woocommerce/haven/form-recurring.php');

	}
}

add_action('edit_form_after_title', 'get_recurring_info');
function get_recurring_info() {
	global $wpdb;
	global $post;

	$id = $post->ID;

	if($post->post_type == 'giving'){

		include(TEMPLATEPATH . '/woocommerce/haven/form-admin.php');

	}
}

add_action( 'admin_init', 'remove_recurring' );
function remove_recurring() {
	global $post;
	add_action( 'delete_post', 'codex_sync_recurring', 10 );
}

function codex_sync_recurring( $pid ) {
    global $wpdb;
    if ( $wpdb->get_var( $wpdb->prepare( 'SELECT postid FROM wp_ht_recurring WHERE postid = %d', $pid ) ) ) {
        $wpdb->query( $wpdb->prepare( 'DELETE FROM wp_ht_recurring WHERE postid = %d', $pid ) );
    }
}

function search_filter($query) {
	if (!$query->is_admin && $query->is_search) {

		$filter = strtolower($_GET["filter"]);

		if($filter == 'product'){
			$query->set('post_type', array('product'));
		} else if ($filter == 'anchor'){
			$query->set('post_type', array('anchor'));
		} else if ($filter == 'programs'){
			$query->set('post_type', array('programs'));
		} else if ($filter == 'blog'){
			$query->set('post_type', array('blog'));
		}
		$query->set('posts_per_page', 12);
	}
	return $query;
}
add_filter( 'pre_get_posts', 'search_filter' );

function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
    $output = NULL;
    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }
    $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
    $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
    $continents = array(
        "AF" => "Africa",
        "AN" => "Antarctica",
        "AS" => "Asia",
        "EU" => "Europe",
        "OC" => "Australia (Oceania)",
        "NA" => "North America",
        "SA" => "South America"
    );
    if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
            switch ($purpose) {
                case "location":
                    $output = array(
                        "city"           => @$ipdat->geoplugin_city,
                        "state"          => @$ipdat->geoplugin_regionName,
                        "country"        => @$ipdat->geoplugin_countryName,
                        "country_code"   => @$ipdat->geoplugin_countryCode,
                        "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                        "continent_code" => @$ipdat->geoplugin_continentCode
                    );
                    break;
                case "address":
                    $address = array($ipdat->geoplugin_countryName);
                    if (@strlen($ipdat->geoplugin_regionName) >= 1)
                        $address[] = $ipdat->geoplugin_regionName;
                    if (@strlen($ipdat->geoplugin_city) >= 1)
                        $address[] = $ipdat->geoplugin_city;
                    $output = implode(", ", array_reverse($address));
                    break;
                case "city":
                    $output = @$ipdat->geoplugin_city;
                    break;
                case "state":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "region":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "country":
                    $output = @$ipdat->geoplugin_countryName;
                    break;
                case "countrycode":
                    $output = @$ipdat->geoplugin_countryCode;
                    break;
            }
        }
    }
    return $output;
}

// add_filter( 'woocommerce_order_button_text', 'woo_custom_order_button_text' ); // 2.1 +
// function woo_custom_order_button_text() {
// return __( 'Confirm Gift', 'woocommerce' );
// }

require_once( ABSPATH . 'wp-admin/includes/export.php' );

function havenexport() {
    wp_schedule_event(time(), 'hourly', 'haven_hourly_export');
}

add_action('haven_hourly_export', 'haven_export_posts');

function haven_export_posts() {
    $args=array(
        'content' => 'posts',
        'status' => 'published');

    ob_start();
    export_wp($args);
    $xml = ob_get_clean();

    file_put_contents( ABSPATH . 'wp-content/themes/haven2015/XML/haven_export_posts.xml', $xml);
}

function pjs_truncate($text, $length) {
   $length = abs((int)$length);
   if(strlen($text) > $length) {
	  $text = preg_replace("/^(.{1,$length})(\s.*|$)/s", '\\1...', $text);
   }
   return($text);
}

function technig_content($limit){
  $content = explode(' ', get_the_content(), $limit);

  if (count($content)>=$limit){
       array_pop($content);
       $content = implode(" ",$content).'...';
  } else {
    $content = implode(" ",$content);
  }

  $content = preg_replace('/\[.+\]/','', $content);
  $content = apply_filters('the_content', $content);
  $content = str_replace(']]>', ']]&gt;', $content);
  return $content;
}

if( function_exists('acf_add_options_page') ) {

	acf_add_options_page();

}

?>
