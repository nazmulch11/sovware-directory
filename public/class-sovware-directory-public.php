<?php


/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Sovware_Directory
 * @subpackage Sovware_Directory/public
 * @author     Nazmul Hosen <nazmul.ch11@gmail.com>
 */
class Sovware_Directory_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
        add_shortcode('sovaredirectory',[$this,'showlistingform']);
        add_shortcode('show_listing_record',[$this,'show_listing_record_frontend']);
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Sovware_Directory_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sovware_Directory_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/sovware-directory-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Sovware_Directory_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sovware_Directory_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/sovware-directory-public.js', array( 'jquery' ), $this->version, false );
        wp_localize_script( $this->plugin_name, 'RestObj', array(
            'restURL' => rest_url(),
            'restNonce' => wp_create_nonce('wp_rest'),
            'admin_ajax' => admin_url( 'admin-ajax.php' )
        ) );

	}

    /*
     * create sovware sovware_listing custom post type
     *
     *
     * @since    1.0.0
     */
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
     * Custom url posting
     *
     * @since     1.0.0
     * @return    string    form html
     */

    public function sovware_directory_rest(){
        register_rest_route( 'sovware-directory/v1', 'submitlisting', array(
            'methods' => 'post',
            'callback' => [$this, 'sovare_directory_submit_post'],
            'permission_callback' => '__return_true'
        ) );
    }

    /**
     * submit Post via rest api
     *
     * @since     1.0.0
     * @return    integer  - id of post
     */
    public function sovare_directory_submit_post($request)
    {
        wp_verify_nonce('wp_rest');

        $title = sanitize_text_field($_POST['title']);
        $content =  wp_kses_post($_POST['content']);
        $featured_image =  absint($_POST['featured_image']);

        $post_id = wp_insert_post( array(
            'post_title' => $title,
            'post_content' => $content,
            'post_author' => get_current_user_id(),
            'post_status' => 'publish',
            'post_type' => 'sovware_listing',
        ) );

        if ( is_wp_error( $post_id ) ) {
            return $post_id;
        }
        set_post_thumbnail( $post_id, $featured_image );

        $response = array(
            'massage' => 'post Inserted successfully'
        );

        return rest_ensure_response($response);
    }


    /**
     * Form function that is showing to frontend
     *
     * @since     1.0.0
     * @return    string    form html
     */
    public function showlistingform() {

        if (!is_user_logged_in() ) {
            return '<a class="login_button" href="'. esc_url( wp_login_url( get_permalink() ) ).'" alt="'.esc_attr( 'Login', 'sovware-directory' ).'">
	'. __( 'Login', 'sovware-directory' ).'</a>';
        }

        ob_start();
        include plugin_dir_path( dirname( __FILE__ ) )  . 'public/views/forms.php';
        return ob_get_clean();
    }

    /**
     * show records for custom post type in front end.
     *
     *  @since     1.0.0
     * @return view
     */

    public function show_listing_record_frontend()
    {

        ob_start();
        //uses for pagination . but later decide different thats why commented.
        /*$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $args = array(
            'post_type' => 'software_listing',
            'posts_per_page' => 5,
            'paged' => $paged
        );
        $query = new WP_Query( $args );

        // Step 2
        $pagination = paginate_links( array(
            'base' => get_pagenum_link(1) . '%_%',
            'format' => '?paged=%#%',
            'current' => $paged,
            'total' => $query->max_num_pages,
            'prev_text' => __('&larr;'),
            'next_text' => __('&rarr;'),
            'type' => 'list',
        ));

// Step 3
        wp_localize_script( $this->plugin_name, 'my_pagination', array(
            'pagination' => $pagination,
            'post_type' => 'software_listing',
            'posts_per_page' => 5,
        )); */
        include plugin_dir_path( dirname( __FILE__ ) )  . 'public/views/show.php';
        return ob_get_clean();
    }

}
