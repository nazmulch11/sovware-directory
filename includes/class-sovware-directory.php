<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://nazmul.xyz
 * @since      1.0.0
 *
 * @package    Sovware_Directory
 * @subpackage Sovware_Directory/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Sovware_Directory
 * @subpackage Sovware_Directory/includes
 * @author     Nazmul Hosen <nazmul.ch11@gmail.com>
 */
class Sovware_Directory {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Sovware_Directory_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'SOVWARE_DIRECTORY_VERSION' ) ) {
			$this->version = SOVWARE_DIRECTORY_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'sovware-directory';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Sovware_Directory_Loader. Orchestrates the hooks of the plugin.
	 * - Sovware_Directory_i18n. Defines internationalization functionality.
	 * - Sovware_Directory_Admin. Defines all hooks for the admin area.
	 * - Sovware_Directory_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sovware-directory-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sovware-directory-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-sovware-directory-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-sovware-directory-public.php';

		$this->loader = new Sovware_Directory_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Sovware_Directory_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Sovware_Directory_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Sovware_Directory_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Sovware_Directory_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

        add_action( 'init', [$this, 'create_sovware_listing_post_type'] );
        add_action( 'rest_api_init', [ $this, 'sovware_directory_rest' ] );
        add_shortcode('sovaredirectory',[$this,'showlistingform']);

	}

    public function create_sovware_listing_post_type() {
        register_post_type( 'sovware_listing',
            array(
                'labels' => array(
                    'name' => __( 'Sovware Listings' ),
                    'singular_name' => __( 'Sovware Listing' )
                ),
                'public' => true,
                'has_archive' => true,
                'supports' => array( 'title', 'editor', 'thumbnail' )
            )
        );
    }

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Sovware_Directory_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}



    /**
     * From function that is showing to frontend
     *
     * @since     1.0.0
     * @return    string    form html
     */
    public function showlistingform() {

        if (!is_user_logged_in() ) {
            return '<a href="'. esc_url( wp_login_url( get_permalink() ) ).'" alt="'.esc_attr( 'Login', 'sovware-directory' ).'">
	'. __( 'Login', 'sovware-directory' ).'</a>';
        }

        ob_start();
        include plugin_dir_path( dirname( __FILE__ ) )  . 'public/views/forms.php';
        return ob_get_clean();
    }

    /**
     * Custom url posting
     *
     * @since     1.0.0
     * @return    string    form html
     */

    public function sovware_directory_rest(){
        register_rest_route( 'sovware-directory/v1', 'submitlisting', array(
            'methods' => 'post',
            'callback' => [$this, 'sov_directory_submit_post'],
            'permission_callback' => '__return_true'
        ) );
    }

    public function sov_directory_submit_post($request)
    {
        $data = $request->get_json_params();
        $title = $data['title'];
        $content =  $data['content'];

        $post_id = wp_insert_post( array(
            'post_title' => $title,
            'post_content' => $content,
            'post_status' => 'publish',
            'post_type' => 'sovware_listing',
        ) );

        if ( is_wp_error( $post_id ) ) {
            return $post_id;
        }
        
        return get_post( $post_id );
    }


    public function sovware_directory_permission(){

        // e.g. check if current user has the necessary capability
        if( current_user_can( 'edit_posts' ) ) {
            return true;
        }
        return new WP_Error( 'rest_forbidden', __( 'You do not have permission' ), array( 'status' => 403 ) );
    }

    /**
     * Custom url posting
     *
     * @since     1.0.0
     * @return    string    form html
     */
    public function my_custom_endpoint_callback($request)
    {
print_r($request);


    }
}


