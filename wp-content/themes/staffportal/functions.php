<?php
/**
 * Main class for the WordPress Theme
 */
class Fourpoint {

	/**
	 * Name of the directory where the theme files resides
	 * @var string
	 * @since 1.0
	 */
	private $theme_name = "Fourpoint";
	private $scripts_version = '0.02';

	function __construct() {
		add_action('init', array($this, 'register_assets'));
		add_action('init', array($this, 'init_assets'));
		add_action('init', array($this, 'init_custom_post_types'));
		add_action('init', array($this, 'init_custom_taxonomies'));
		add_action('init', array($this, 'init_custom_user_roles'));
		add_action('admin_init', array($this, 'restrict_dashboard'));
		add_action('login_form_middle', array($this, 'add_lost_password_link'));
		add_filter('admin_init', array($this, 'register_fields'));
		add_action('wp_login_failed', array($this, 'front_end_login_fail'));
		// add_action( 'gform_after_submission', array($this, 'set_gform_custom_fields'));

		add_action( 'gform_after_submission_2', array($this, 'set_gform_custom_fields'));

		add_theme_support('post-thumbnails');
		set_post_thumbnail_size(596, 442, false);
		add_image_size('Post Thumbnail',522, 348, false);
		add_image_size('employee-photo',150, 150, false);

		// enables wigitized sidebars
		register_sidebars();

		add_filter('mce_buttons_2', 'my_mce_buttons_2');

		add_action( 'gform_user_registered', array($this, 'pi_gravity_registration_autologin'));
		add_filter('excerpt_more', array($this, 'new_excerpt_more'));
		add_filter( 'excerpt_length', array($this, 'custom_excerpt_length'), 999 );

		// custom menu support
		add_theme_support('nav-menus');
		if (function_exists('register_nav_menus')) {
			register_nav_menus(
				array(
					'main-menu' => 'Main Menu',
					'secondary-menu' => 'Secondary Menu',
					'footer-menu' => 'Footer Menu'
				)
			);
		}
	}

	function restrict_dashboard() {
		// die("restrict dashboard");
		if ( ! defined( 'DOING_AJAX' ) && ! current_user_can( 'manage_options' ) ) {
			wp_redirect( "/" ); //add this url here to where someone logged in on the front end
		}
	}

	function add_lost_password_link() {
		return '<p><a href="/wp-login.php?action=lostpassword">Lost Password?</a></p>';
	}

	function front_end_login_fail( $username, $password_empty = 'false', $username_empty = 'false' ) {
	   $referrer = $_SERVER['HTTP_REFERER'];  // where did the post submission come from?
		 $login_type = $_REQUEST['login_type'];

	   // if there's a valid referrer, and it's not the default log-in screen
	   if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {

		  $pos = strpos($referrer, '?login=failed');
			if($pos === false) {
			 	// add the failed
			 	// wp_redirect( $referrer . '?login=failed&pwblank='.$password_empty.'&ublank='.$username_empty );  // let's append some information (login=failed) to the URL for the theme to use
			 	wp_redirect( $referrer . '?login=failed&login_type='.$login_type);  // let's append some information (login=failed) to the URL for the theme to use
			}
			else {
				// already has the failed don't appened it again
				// wp_redirect( $referrer . '&pwblank='.$password_empty.'&ublank='.$username_empty );  // already appeneded redirect back
				wp_redirect( $referrer );  // already appeneded redirect back
			}

	      exit;
	   }
	}

	//This forces the login fail function if the username or password is empty
	function check_login_field_empty( $user, $username, $password ) {
	    if ( empty( $username ) || empty( $password ) ) {
	    	$username_empty = empty( $username );
	    	$password_empty = empty( $password );
	        do_action( 'wp_login_failed', $user, $password_empty, $username_empty );
	    }
	    return $user;
	}

	function register_assets() {
		if (!is_admin() & !is_login_page()) {

			// wp_register_script('modernizr', get_bloginfo("stylesheet_directory") . "/assets/javascripts/modernizr.js", false);
			// wp_register_script('fontawesome', "http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css", false);
			// wp_register_script('libs', get_bloginfo('stylesheet_directory') . '/assets/javascripts/libs.js', array('jquery'), $this->scripts_version, true);
			// wp_register_script($this->theme_name . '-site', get_bloginfo('stylesheet_directory') . '/assets/javascripts/main.js', array('jquery', 'libs'), $this->scripts_version, true);
		}
	}

	function images_path() {
		echo get_bloginfo('template_url') . '/assets/images';
	}

	function register_nav_menus() {
		// custom menu support
		add_theme_support('menus');
		if (function_exists('register_nav_menus')) {
			register_nav_menus(
				array(
					'main-menu' => 'Main Menu',
				)
			);
		}
	}

	function register_sidebars() {
		if (function_exists('register_sidebar')) {
			// Sidebar Widget
			// Location: the sidebar
			// register_sidebar(array('name' => __('Primary'),
			// 	'id' => 'article-sidebar',
			// 	'before_widget' => '<div class="widget-area widget-sidebar"><ul>',
			// 	'after_widget' => '</ul></div>',
			// 	'before_title' => '<h3>',
			// 	'after_title' => '</h3>',
			// ));
			//
			// register_sidebar(array('name' => __('Secondary'),
			// 	'id' => 'article-sidebar2',
			// 	'before_widget' => '<div class="widget-area widget-sidebar"><ul>',
			// 	'after_widget' => '</ul></div>',
			// 	'before_title' => '<h3>',
			// 	'after_title' => '</h3>',
			// ));
		}
	}

	/**
	 * Enqueues scripts and styles for this theme.
	 * This function will be run on initialization.
	 * @return void
	 * @since 1.0
	 */
	function init_assets() {
		if (!is_admin() & !is_login_page()) {
			// STYLES
			wp_enqueue_style($this->theme_name . '-styles', get_bloginfo('stylesheet_directory') . '/assets/stylesheets/style.css', false, $this->scripts_version, 'all');
			wp_enqueue_style('lib-styles', get_bloginfo('stylesheet_directory') . '/assets/stylesheets/libs.css', false, $this->scripts_version, 'all');
			wp_enqueue_style('fancybox', get_bloginfo('stylesheet_directory') . '/assets/fancybox/source/jquery.fancybox.css', false, $this->scripts_version, 'all');
			wp_enqueue_style('fonts', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css', false, '1.0', 'all');
			// SCRIPTS
			wp_deregister_script('jquery');
			wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js", false, null, true);
			wp_enqueue_script('modernizr', get_bloginfo("stylesheet_directory") . "/assets/javascripts/modernizr.js", false);
			/* wp_enqueue_script('fontawesome', "http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css", false); */
			wp_enqueue_script('jquery');
			wp_enqueue_script('libs', get_bloginfo('stylesheet_directory') . '/assets/javascripts/libs.js', array('jquery'), $this->scripts_version, true);

			// wp_enqueue_script('nav', get_bloginfo('stylesheet_directory') . '/assets/javascripts/nav.js', array('jquery'), $this->scripts_version, true);
			// wp_enqueue_script($this->theme_name . '-site', get_bloginfo('stylesheet_directory') . '/assets/javascripts/main.js', array('jquery', 'libs', 'nav'), $this->scripts_version, true);
			// wp_enqueue_script('fancybox', get_bloginfo('stylesheet_directory') . '/assets/fancybox/source/jquery.fancybox.pack.js', array('jquery'), $this->scripts_version, true);
			wp_enqueue_script($this->theme_name . '-site', get_bloginfo('stylesheet_directory') . '/assets/javascripts/staff-portal.js', array('jquery','libs'), $this->scripts_version, true);
		}
	}

	/**
	 * Initialize custom post types.
	 */
	function init_custom_post_types() {
		// Employee
		// $labels = array(
		// 	'name' => 'Employee',
		// 	'singular_name' => 'Employee',
		// 	'add_new' => 'Add New Employee',
		// 	'add_new_item' => 'Add Employee',
		// 	'edit_item' => 'Edit Employee',
		// 	'new_item' => 'New Employee',
		// 	'all_items' => 'All Employees',
		// 	'view_item' => 'View Employees',
		// 	'search_items' => 'Search Employees',
		// 	'not_found' =>  'No employees found',
		// 	'not_found_in_trash' => 'No employees found in Trash',
		// 	'menu_name' => 'Employee'
		// );
		// $args = array(
		// 	'labels' => $labels,
		// 	'public' => true,
		// 	'publicly_queryable' => true,
		// 	'show_ui' => true,
		// 	'show_in_menu' => true,
		// 	'query_var' => true,
		// 	'rewrite' => array( 'slug' => 'employee'),
		// 	'capability_type' => 'post',
		// 	'has_archive' => false,
		// 	'hierarchical' => false,
		// 	'menu_position' => 3,
		// 	'supports' => array('title')
		// );
		// register_post_type('employee', $args);

		//Benefits
		$labels = array(
			'name' => 'Benefit',
			'singular_name' => 'Benefit',
			'add_new' => 'Add New Benefit',
			'add_new_item' => 'Add Benefit',
			'edit_item' => 'Edit Benefit',
			'new_item' => 'New Benefit',
			'all_items' => 'All Benefits',
			'view_item' => 'View Benefits',
			'search_items' => 'Search Benefits',
			'not_found' =>  'No benefits found',
			'not_found_in_trash' => 'No benefits found in Trash',
			'menu_name' => 'Benefits'
		);
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'benefits'),
			'capability_type' => 'post',
			'has_archive' => false,
			'hierarchical' => false,
			'menu_position' => 4,
			'supports' => array('title')
		);
		register_post_type('benefit', $args);

		//Document Files
		$labels = array(
			'name' => 'Document File',
			'singular_name' => 'Document File',
			'add_new' => 'Add New Document File',
			'add_new_item' => 'Add Document File',
			'edit_item' => 'Edit Document File',
			'new_item' => 'New Document File',
			'all_items' => 'All Document Files',
			'view_item' => 'View Document Files',
			'search_items' => 'Search Document Files',
			'not_found' =>  'No document files found',
			'not_found_in_trash' => 'No document files found in Trash',
			'menu_name' => 'Document Files'
		);
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'document-files'),
			'capability_type' => 'post',
			'has_archive' => false,
			'hierarchical' => false,
			'menu_position' => 3,
			'supports' => array('title')
		);
		register_post_type('document-file', $args);

		//Documents
		$labels = array(
			'name' => 'Document',
			'singular_name' => 'Document',
			'add_new' => 'Add New Document',
			'add_new_item' => 'Add Document',
			'edit_item' => 'Edit Document',
			'new_item' => 'New Document',
			'all_items' => 'All Documents',
			'view_item' => 'View Documents',
			'search_items' => 'Search Documents',
			'not_found' =>  'No documents found',
			'not_found_in_trash' => 'No documents found in Trash',
			'menu_name' => 'Documents/Forms'
		);
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'documents'),
			'capability_type' => 'post',
			'has_archive' => false,
			'hierarchical' => false,
			'menu_position' => 3,
			'supports' => array('title'),
			'taxonomies' => array('document_catagory')
		);
		register_post_type('document', $args);

		//Brand Documents
		$labels = array(
			'name' => 'Document',
			'singular_name' => 'Document',
			'add_new' => 'Add New Document',
			'add_new_item' => 'Add Document',
			'edit_item' => 'Edit Document',
			'new_item' => 'New Document',
			'all_items' => 'All Documents',
			'view_item' => 'View Documents',
			'search_items' => 'Search Documents',
			'not_found' =>  'No documents found',
			'not_found_in_trash' => 'No documents found in Trash',
			'menu_name' => 'Brand Center'
		);
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'brand-documents'),
			'capability_type' => 'post',
			'has_archive' => false,
			'hierarchical' => false,
			'menu_position' => 3,
			'supports' => array('title'),
			'taxonomies' => array('brand_category')
		);
		register_post_type('brand_document', $args);

		//Quicklinks
		$labels = array(
			'name' => 'Quick Link',
			'singular_name' => 'Quick Link',
			'add_new' => 'Add New Quick Link',
			'add_new_item' => 'Add Quick Link',
			'edit_item' => 'Edit Quick Link',
			'new_item' => 'New Quick Link',
			'all_items' => 'All Quick Links',
			'view_item' => 'View Quick Link',
			'search_items' => 'Search Quick Links',
			'not_found' =>  'No quick links found',
			'not_found_in_trash' => 'No quick links found in Trash',
			'menu_name' => 'Quick Links'
		);
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'quick-links'),
			'capability_type' => 'post',
			'has_archive' => false,
			'hierarchical' => false,
			'menu_position' => 3,
			'supports' => array('title')
		);
		register_post_type('quick-link', $args);

		//Alerts
		$labels = array(
			'name' => 'Alert',
			'singular_name' => 'Alert',
			'add_new' => 'Add New Alert',
			'add_new_item' => 'Add Alert',
			'edit_item' => 'Edit Alert',
			'new_item' => 'New Alert',
			'all_items' => 'All Alert',
			'view_item' => 'View Alert',
			'search_items' => 'Search Alerts',
			'not_found' =>  'No alerts found',
			'not_found_in_trash' => 'No alerts found in Trash',
			'menu_name' => 'Alerts'
		);
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'alerts'),
			'capability_type' => 'post',
			'has_archive' => false,
			'hierarchical' => false,
			'menu_position' => 3,
		);
		register_post_type('alert', $args);

		//Ticket
		$labels = array(
			'name' => 'Ticket',
			'singular_name' => 'Ticket',
			'add_new' => 'Add New Ticket',
			'add_new_item' => 'Add Ticket',
			'edit_item' => 'Edit Ticket',
			'new_item' => 'New Ticket',
			'all_items' => 'All Tickets',
			'view_item' => 'View Ticket',
			'search_items' => 'Search Tickets',
			'not_found' =>  'No tickets found',
			'not_found_in_trash' => 'No tickets found in Trash',
			'menu_name' => 'IT Tickets'
		);
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'tickets'),
			'capability_type' => 'post',
			'has_archive' => false,
			'hierarchical' => false,
			'menu_position' => 3,
			'supports' => array('title','editor','excerpt')
		);
		register_post_type('ticket', $args);

		//Holidays
		$labels = array(
			'name' => 'Holiday',
			'singular_name' => 'Holiday',
			'add_new' => 'Add New Holiday',
			'add_new_item' => 'Add Holiday',
			'edit_item' => 'Edit Holiday',
			'new_item' => 'New Holiday',
			'all_items' => 'All Holidays',
			'view_item' => 'View Holiday',
			'search_items' => 'Search Holidays',
			'not_found' =>  'No holidays found',
			'not_found_in_trash' => 'No holidays found in Trash',
			'menu_name' => 'Holidays'
		);
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'holidays'),
			'capability_type' => 'post',
			'has_archive' => false,
			'hierarchical' => false,
			'menu_position' => 3,
			'supports' => array('title')
		);
		register_post_type('holiday', $args);
	}


	/**
	 * Initialize custom taxonomies.
	 */
	function init_custom_taxonomies() {

		/** Office **/
		$labels = array(
			'name' => __( 'Office', 'office' ),
			'singular_name' => __( 'Office', 'office' ),
			'search_items' =>  __( 'Search Office' ),
			'all_items' => __( 'All Offices' ),
			'edit_item' => __( 'Edit Office' ),
			'update_item' => __( 'Update Office' ),
			'add_new_item' => __( 'Add New Office' ),
			'new_item_name' => __( 'New Office' ),
			'menu_name' => __( 'Offices' ),
		);
		$args = array(
			'public' => true,
			'hierarchical' => false,
			'labels' => $labels,
			'show_ui' => true,
			'show_admin_column' => true,
			'query_var' => true,
			'rewrite' => array('with_front' => true,'slug' => 'author/office'),
			'capabilities' => array(
				'manage_terms' => 'edit_users', // Using 'edit_users' cap to keep this simple.
				'edit_terms'   => 'edit_users',
				'delete_terms' => 'edit_users',
				'assign_terms' => 'read',
			),
			'update_count_callback' => 'update_office_count'
		);
		register_taxonomy('office', 'user', $args);

		/** Document Category **/
		$labels = array(
			'name' => __( 'Document Category', 'document category' ),
			'singular_name' => __( 'Document Category', 'document category' ),
			'search_items' =>  __( 'Search Document Category' ),
			'all_items' => __( 'All Document Categories' ),
			'edit_item' => __( 'Edit Document Category' ),
			'update_item' => __( 'Update Document Category' ),
			'add_new_item' => __( 'Add New Document Category' ),
			'new_item_name' => __( 'New Document Category' ),
			'menu_name' => __( 'Document Categories' ),
		);
		$args = array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_ui' => true,
			'show_admin_column' => true,
			'query_var' => true,
			'supports' => array('title'),
			'rewrite' => array('slug' => 'document-categories'),
		);
		register_taxonomy('document_category', array('document'), $args);

		/** Benefit Category **/
		$labels = array(
		'name' => __( 'Benefit Category', 'benefit_category' ),
		'singular_name' => __( 'Benefit Category', 'office' ),
		'search_items' =>  __( 'Search Benefit Category' ),
		'all_items' => __( 'All Benefit Category' ),
		'edit_item' => __( 'Edit Benefit Category' ),
		'update_item' => __( 'Update Benefit Category' ),
		'add_new_item' => __( 'Add New Benefit Category' ),
		'new_item_name' => __( 'New Benefit Category' ),
		'menu_name' => __( 'Benefit Categories' ),
		);
		$args = array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_ui' => true,
			'show_admin_column' => true,
			'query_var' => true,
			'supports' => array('title'),
			'rewrite' => array('slug' => 'benefit_category'),
		);
		register_taxonomy('benefit_category', array('benefit'), $args);

		/** Brand Document Category **/
		$labels = array(
			'name' => __( 'Brand Category', 'brand category' ),
			'singular_name' => __( 'Brand Category', 'brand category' ),
			'search_items' =>  __( 'Search Brand Category' ),
			'all_items' => __( 'All Brand Categories' ),
			'edit_item' => __( 'Edit Brand Category' ),
			'update_item' => __( 'Update Brand Category' ),
			'add_new_item' => __( 'Add New Brand Category' ),
			'new_item_name' => __( 'New Brand Category' ),
			'menu_name' => __( 'Brand Categories' ),
		);
		$args = array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_ui' => true,
			'show_admin_column' => true,
			'query_var' => true,
			'supports' => array('title'),
			'rewrite' => array('slug' => 'brand-categories'),
		);
		register_taxonomy('brand_category', array('brand_document'), $args);

		/** IT Ticket Category **/
		$labels = array(
			'name' => __( 'Ticket Category', 'ticket category' ),
			'singular_name' => __( 'Ticket Category', 'ticket category' ),
			'search_items' =>  __( 'Search Ticket Category' ),
			'all_items' => __( 'All Ticket Categories' ),
			'edit_item' => __( 'Edit Ticket Category' ),
			'update_item' => __( 'Update Ticket Category' ),
			'add_new_item' => __( 'Add New Ticket Category' ),
			'new_item_name' => __( 'New Ticket Category' ),
			'menu_name' => __( 'Ticket Categories' ),
		);
		$args = array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_ui' => true,
			'show_admin_column' => true,
			'query_var' => true,
			'supports' => array('title'),
			'rewrite' => array('slug' => 'ticket-categories'),
		);
		register_taxonomy('ticket_category', array('ticket'), $args);
	}

	/**
	* Initialize custom roles
	**/
	function init_custom_user_roles() {
		$result = add_role(
		    'employee',
		    __( 'Employee' ),
		    array(
		    	'administrator' => false,
		        'read'         => true,  // true allows this capability
		        'edit_posts'   => false,
		        'delete_posts' => false, // Use false to explicitly deny
		        'delete_others_posts' => false,
		        'delete_others_pages' => false,
		        'edit_others_posts' => false,
		        'edit_others_pages' => false,
		        'manage_categories' => false,
		        'moderate_comments' => false,
		        'publish_posts' => true,
		        'publish_pages' => false,
		        'upload_files' => true,
		        'update_core' => false,
		        'update_plugins' => false,
		        'update_themes' => false,
		        'install_plugins' => false,
		        'install_themes' => false,
		        'delete_themes' => false,
		        'delete_plugins' => false,
		        'edit_plugins' => false,
		        'edit_themes' => false,
		        'edit_files' => false,
		        'edit_users' => false,
		        'create_users' => false,
		        'delete_users' => false,
		        'activate_plugins' => false,
		        'delete_pages' => false,
		    )
		);
	}
	/**
	 * Get attached image by post ID or image ID and echo an img tag with src, alt and class attributes.
	 * @param number 	$post_id 	Post ID of the post the featured image is attached to.
	 * @param number 	$img_ID 	Used when the image is not attached to a post, but the ID is known.
	 * @param array 	$classes 	An array of classes to add to the image tag.
	 * @param string 	$size 		Size of the image to grab. Defaults to 'full'.
	 */
	function echo_attached_image($post_id = null, $img_ID = null, $classes = null, $size = 'full') {
		if ($img_ID === null) {
			$img_ID = get_post_thumbnail_id($post_id);
		}
		$img_src = wp_get_attachment_image_src($img_ID, $size);
		if ($img_src && $img_src != '') {
			$img_alt = get_post_meta($img_ID, '_wp_attachment_image_alt', true);
			$img_tag = '<img src="' . $img_src[0] . '" alt="' . $img_alt . '"';
			if ($classes) {
				$img_tag .= ' class="';
				foreach ($classes as $class) {
					$img_tag .= $class . ' ';
				}
				$img_tag .= '" ';
			}
			$img_tag .= '>';
			echo $img_tag;
		} else {
			echo '';
		}
	}

	function get_attached_image($post_id = null, $img_ID = null, $classes = null, $size = 'full') {
		if ($img_ID === null) {
			$img_ID = get_post_thumbnail_id($post_id);
		}
		$img_src = wp_get_attachment_image_src($img_ID, $size);
		if ($img_src && $img_src != '') {
			$img_alt = get_post_meta($img_ID, '_wp_attachment_image_alt', true);
			$img_tag = '<img src="' . $img_src[0] . '" alt="' . $img_alt . '"';
			if ($classes) {
				$img_tag .= ' class="';
				foreach ($classes as $class) {
					$img_tag .= $class . ' ';
				}
				$img_tag .= '" ';
			}
			$img_tag .= '>';
			return $img_tag;
		} else {
			return '';
		}
	}

	function has_attached_image($post_id = null, $img_ID = null) {
		if ($img_ID === null) {
			$img_ID = get_post_thumbnail_id($post_id);
		}
		$returnval = false;
		if($img_ID && $img_ID > 0) {
			$returnval = true;
		}
		return $returnval;
	}

	function get_attached_image_url($post_id = null, $img_ID = null, $classes = null, $size = 'full') {
		if ($img_ID === null) {
			$img_ID = get_post_thumbnail_id($post_id);
		}
		$img_src = wp_get_attachment_image_src($img_ID, $size);
		if ($img_src && $img_src != '') {
			return $img_src[0];
		} else {
			return '';
		}
	}

	function echo_attached_image_url($post_id = null, $img_ID = null, $classes = null, $size = 'full') {
		if ($img_ID === null) {
			$img_ID = get_post_thumbnail_id($post_id);
		}
		$img_src = wp_get_attachment_image_src($img_ID, $size);
		if ($img_src && $img_src != '') {
			echo $img_src[0];
		}
	}

	function echo_links_from_title($str) {
		$return_val = str_replace(" ", "-", strtolower($str));
		$return_val = str_replace('’', '', $return_val);
		echo ($return_val);
	}

	// Removes Trackbacks from the comment cout
	function comment_count($count) {
		if (!is_admin()) {
			global $id;
			$comments_by_type = &separate_comments(get_comments('status=approve&post_id=' . $id));
			return count($comments_by_type['comment']);
		} else {
			return $count;
		}
	}

	// custom excerpt ellipses for 2.9+
	function custom_excerpt_more($more) {
		return 'READ MORE &raquo;';
	}

	// no more jumping for read more link
	function no_more_jumping($post) {
		return '<a href="' . get_permalink($post->ID) . '" class="read-more">' . '&nbsp; Continue Reading &raquo;' . '</a>';
	}

	// category id in body and post class
	function category_id_class($classes) {
		global $post;
		foreach ((get_the_category($post->ID)) as $category) {
			$classes[] = 'cat-' . $category->cat_ID . '-id';
		}

		return $classes;
	}

	// adds a class to the post if there is a thumbnail
	function has_thumb_class($classes) {
		global $post;
		if (has_post_thumbnail($post->ID)) {$classes[] = 'has_thumb';}
		return $classes;
	}

	function security_measures() {
		// removes detailed login error information for security
		add_filter('login_errors', create_function('$a', "return null;"));
		// removes the WordPress version from your header for security
		add_filter('the_generator', create_function('$a', "return '';"));
	}

	function register_fields() {
		// register_setting( 'general', 'contact_address', 'esc_attr' );
		// register_setting('general', 'contact_address');
		// register_setting('general', 'emergency_contact_phone');
		register_setting('general', 'linkedin_link');
		register_setting('general', 'header_tooltip_text');
		register_setting('general', 'footer_copyright');
		// add_settings_field('contact_address', '<label for="contact_address">' . __('Contact Address', 'contact_address') . '</label>', array(&$this, 'contact_address_html'), 'general');
		add_settings_field('linkedin_link', '<label for="linkedin_link">' . __('LinkedIn Link', 'linkedin_link') . '</label>', array(&$this, 'linkedin_link_html'), 'general');
		add_settings_field('footer_copyright', '<label for="footer_copyright">' . __('Footer Copyright Info', 'footer_copyright') . '</label>', array(&$this, 'footer_copyright_html'), 'general');
		// add_settings_field('emergency_contact_phone', '<label for="emergency_contact_phone">' . __('Emergency Contact Phone', 'emergency_contact_phone') . '</label>', array(&$this, 'emergency_contact_phone_html'), 'general');
		add_settings_field('header_tooltip_text', '<label for="header_tooltip_text">' . __('Leasing Selling Tooltip Text', 'header_tooltip_text') . '</label>', array(&$this, 'header_tooltip_text_html'), 'general');
	}
	function footer_copyright_html() {
		$value = get_option('footer_copyright', '');
		echo '<input type="text" id="footer_copyright" name="footer_copyright" value="'. $value .'" width="300">';
	}
	function header_tooltip_text_html() {
		$value = get_option('header_tooltip_text', '');
		echo '<textarea type="text" id="header_tooltip_text" name="header_tooltip_text" rows="5" cols="40">'. $value .'</textarea>';
	}
	// function contact_address_html() {
	// 	$value = get_option('contact_address', '');
	// 	echo '<textarea type="text" id="contact_address" name="contact_address" rows="5" cols="40">'. $value .'</textarea>';
	// }
	// function emergency_contact_phone_html() {
	// 	$value = get_option('emergency_contact_phone', '');
	// 	echo '<input type="text" id="emergency_contact_phone" name="emergency_contact_phone" value="' . $value . '">';
	// }
	function linkedin_link_html() {
		$value = get_option('linkedin_link', '');
		echo '<input type="text" id="linkedin_link" name="linkedin_link" value="' . $value . '">';
	}

	function get_excerpt_by_id($post_id){
	    $the_post = get_post($post_id); //Gets post ID
	    $the_excerpt = $the_post->post_content; //Gets post_content to be used as a basis for the excerpt
	    $excerpt_length = 55; //Sets excerpt length by word count
	    $the_excerpt = strip_tags(strip_shortcodes($the_excerpt)); //Strips tags and images

	    if(strlen($the_excerpt) > $excerpt_length) {
	    	$the_excerpt = trim(substr($the_excerpt,0,$excerpt_length)).'…';
	    }

	    $the_excerpt = '<p>' . $the_excerpt . '</p>';

	    return $the_excerpt;
	}

	/**
	 * Auto login after registration.
	 */
	function pi_gravity_registration_autologin( $user_id, $user_config, $entry, $password ) {
		$user = get_userdata( $user_id );
		$user_login = $user->user_login;
		$user_password = $password;

	    wp_signon( array(
			'user_login' => $user_login,
			'user_password' =>  $user_password,
			'remember' => false
	    ) );
	}

	function new_excerpt_more($more) {
		return '...';
	}

	function custom_excerpt_length( $length ) {
		return 20;
	}

	function get_last_name_filer( $last_name ) {
		$category = '';
		$last_name_ord = ord( strtolower($last_name) );
		switch( $last_name_ord ) {
			case ( $last_name_ord <= ord( 'f' ) ):
				$category = 'a-f';
				break;
			case ( $last_name_ord >= ord( 'g' ) && $last_name_ord <= ord( 'm' ) ):
				$category = 'g-m';
				break;
			case ( $last_name_ord >= ord( 'n' ) && $last_name_ord <= ord( 's' ) ):
				$category = 'n-s';
				break;
			case ( $last_name_ord >= ord( 't' ) && $last_name_ord <= ord( 'z' ) ):
				$category = 't-z';
				break;
		}
		return $category;
	}


}

$theme = new Fourpoint();

function register_editor_style() {
	add_editor_style('editor-styles.css');
}

// Callback function to insert 'styleselect' into the $buttons array
function my_mce_buttons_2($buttons) {
	array_unshift($buttons, 'styleselect');
	return $buttons;
}

function is_login_page() {
	return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
}

function update_office_count( $terms, $taxonomy ) {
	global $wpdb;
	foreach ( (array) $terms as $term ) {
		$count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $wpdb->term_relationships WHERE term_taxonomy_id = %d", $term ) );
		do_action( 'edit_term_taxonomy', $term, $taxonomy );
		$wpdb->update( $wpdb->term_taxonomy, compact( 'count' ), array( 'term_taxonomy_id' => $term ) );
		do_action( 'edited_term_taxonomy', $term, $taxonomy );
	}
}

/* Adds the taxonomy page in the admin. */
add_action( 'admin_menu', 'add_office_admin_page' );

/**
 * Creates the admin page for the 'profession' taxonomy under the 'Users' menu.  It works the same as any
 * other taxonomy page in the admin.  However, this is kind of hacky and is meant as a quick solution.  When
 * clicking on the menu item in the admin, WordPress' menu system thinks you're viewing something under 'Posts'
 * instead of 'Users'.  We really need WP core support for this.
 */
function add_office_admin_page() {
	$tax = get_taxonomy( 'office' );
	add_users_page(
		esc_attr( $tax->labels->menu_name ),
		esc_attr( $tax->labels->menu_name ),
		$tax->cap->manage_terms,
		'edit-tags.php?taxonomy=' . $tax->name
	);
}

/* Add section to the edit user page in the admin to select profession. */
add_action( 'show_user_profile', 'edit_user_profession_section' );
add_action( 'edit_user_profile', 'edit_user_profession_section' );
function edit_user_profession_section( $user ) {

	$tax = get_taxonomy( 'office' );

	/* Make sure the user can assign terms of the profession taxonomy before proceeding. */
	if ( !current_user_can( $tax->cap->assign_terms ) )
		return;

	/* Get the terms of the 'profession' taxonomy. */
	$terms = get_terms( 'office', array( 'hide_empty' => false ) ); ?>

	<h3><?php _e( 'Office' ); ?></h3>

	<table class="form-table">

		<tr>
			<td><?php

			/* If there are any profession terms, loop through them and display checkboxes. */
			if ( !empty( $terms ) ) {

				foreach ( $terms as $term ) { ?>
					<input type="radio" name="office" id="office-<?php echo esc_attr( $term->slug ); ?>" value="<?php echo esc_attr( $term->slug ); ?>" <?php checked( true, is_object_in_term( $user->ID, 'office', $term ) ); ?> /> <label for="office-<?php echo esc_attr( $term->slug ); ?>"><?php echo $term->name; ?></label> <br />
				<?php }
			}

			/* If there are no profession terms, display a message. */
			else {
				_e( 'There are no offices available.' );
			}

			?></td>
		</tr>

	</table>
<?php }

/* Update the profession terms when the edit user page is updated. */
add_action( 'personal_options_update', 'save_user_office_terms' );
add_action( 'edit_user_profile_update', 'save_user_office_terms' );

/**
 * Saves the term selected on the edit user/profile page in the admin. This function is triggered when the page
 * is updated.  We just grab the posted data and use wp_set_object_terms() to save it.
 *
 * @param int $user_id The ID of the user to save the terms for.
 */
function save_user_office_terms( $user_id ) {
	$tax = get_taxonomy( 'office' );
	$term = esc_attr( $_POST['office'] );
	wp_set_object_terms( $user_id, $term, 'office' );
	clean_object_term_cache( $user_id, 'office' );
}

//add_filter( 'posts_search', 'db_filter_authors_search' );
function db_filter_authors_search( $posts_search ) {
	// Don't modify the query at all if we're not on the search template
	// or if the LIKE is empty
	if ( !is_search() || empty( $posts_search ) )
		return $posts_search;
	global $wpdb;
	// Get all of the users of the blog and see if the search query matches either
	// the display name or the user login
	// add_filter( 'pre_user_query', 'db_filter_user_query' );
	$search = sanitize_text_field( get_query_var( 's' ) );

	$args = array(
		'count_total' => false,
		'search' => sprintf( '*%s*', $search ),
		'search_fields' => array(
			'display_name',
			'user_login',
		),
		'fields' => 'ID',
	);
	$matching_users = get_users( $args );
	// remove_filter( 'pre_user_query', 'db_filter_user_query' );
	// Don't modify the query if there aren't any matching users
	if ( empty( $matching_users ) )
		return $posts_search;
	// Take a slightly different approach than core where we want all of the posts from these authors
	$posts_search = str_replace( ')))', ")) OR ( {$wpdb->posts}.post_author IN (" . implode( ',', array_map( 'absint', $matching_users ) ) . ")))", $posts_search );
	return $posts_search;
}

// Hook Gravity Forms user registration -> Map taxomomy
add_action("gform_user_updated", "map_taxonomy", 10, 4);
function map_taxonomy($user_id, $config, $entry, $user_pass) {
	global $wpdb;
	if($entry['id'] == 1) {
	// Get all taxonomies
		$taxs = get_taxonomies();

	// Get all user meta
		$all_meta_for_user = get_user_meta($user_id);

	// Loop through meta data and map to taxonomies with same name as user meta key
		foreach ($all_meta_for_user as $taxonomy => $value ) {

			if (in_array ($taxonomy, $taxs) ) {			// Check if there is a Taxonomy with the same name as the Custom user meta key

			// Get term id
				$term_id = get_user_meta($user_id, $taxonomy, true);
				If (is_numeric($term_id)) {				// Check if Custom user meta is an ID

					// Echo $taxonomy.'='.$term_id.'<br>';

				// Add user to taxomomy term
					$term = get_term( $term_id, $taxonomy );
					$termslug = $term->slug;
					wp_set_object_terms( $user_id, array( $termslug ), $taxonomy, false);

				}
			}
		}
	}
	if($entry['id'] == 2) {

	}
}

$gravity_form_id = 1; // gravity form id, or replace {$gravity_form_id} below with this number
add_filter( "gform_after_submission_1", 'set_post_acf_gallery_field', 10, 2 );
function set_post_acf_gallery_field( $entry ) {
	global $current_user;
	wp_get_current_user();
	$gf_images_field_id = 11; // the upload field id
	$acf_field_id = 'field_576d3b096e8ef'; // the acf gallery field id
	if( $entry[$gf_images_field_id] != '' ) {
			$attach_id = convert_upload_field_url_to_attachment( $current_user->ID, $entry[$gf_images_field_id]);
			update_field('profile_photo', $attach_id, 'user_'.$current_user->ID);
	}
}

function convert_upload_field_url_to_attachment( $post_id, $field_value) {
		require ( ABSPATH . 'wp-admin/includes/image.php' );
	  $success = false;
		$filename = $field_value;

		if(!is_numeric($filename) && $filename != '') {

		     $wp_filetype = wp_check_filetype(basename($filename), null );

		     $attachment = array(
		     'post_mime_type' => $wp_filetype['type'],
		     'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
		     'post_content' => '',
		     'post_status' => 'inherit'
		    );

		    //Get the absolute path of the uploaded image by Gravity Forms
		    $abs_path = getcwd();
		    $actual_file = str_replace(site_url(),$abs_path,$filename);
		    $attach_id = wp_insert_attachment( $attachment, $actual_file, $post_id );
				$attach_metadata = wp_generate_attachment_metadata( $attach_id, $actual_file );
				wp_update_attachment_metadata( $attach_id, $attach_metadata );
		}

		return $attach_id;

	}
add_action( 'template_redirect', 'redirect_to_login' );

function redirect_to_login() {
	if ( !is_page('login') && ! is_user_logged_in() ) {
		wp_redirect( '/login', 301 );
	  exit;
	}
}

show_admin_bar(false);

// change wp-admin page logo
function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/images/FourPoint_Logo_blk.png);
            width: 200px;
            height: 100px;
            background-size: 200px 100px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

function my_login_logo_url() {
    return 'http://staff.fourpointenergy.com';
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
    return 'FourPoint Energy';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );
