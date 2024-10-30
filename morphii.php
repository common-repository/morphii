<?php

if ( ! defined( 'ABSPATH' ) ) {

	exit;

}



if ( ! class_exists( 'Morphii' ) ) {



	class Morphii {



		protected static $instance;



		public $custom_column_review = "review-text";

		public $custom_column_review_rate = "review-rating";

		public $custom_column_date = "review-date";

		public $custom_column_author = "review-author";

		public $custom_column_product = "product";

		//Questions Parameter

		public $custom_column_question = "question-id";

		public $custom_column_question_name = "question-name";

		public $custom_column_morphiies = "question-morphiis";

		public $custom_column_morphii_author = "question-author";



		public $post_type_name = 'morphii-reviews';



		public $items_for_page = 10;

		public $reviews_post_type_name = "morphii-reviews";

		public $questions_post_type_name = "morphii-questions";



		public $meta_key_product_id = "_morphii_product_id";

		public $meta_key_approved = "_morphii_review_approved";

		public $meta_key_user_id = "_morphii_reviewer_id";

		public $meta_key_user_name = "_morphii_reviewer_user_name";

		public $meta_key_user_email = "_morphii_reviewer_user_email";

		public $meta_key_reviews = "_morphii_final_review";

		public $meta_key_comments = "_morphii_all_question_comments";



		public static function get_instance() {

			if ( is_null( self::$instance ) ) {

				self::$instance = new self();

			}

			return self::$instance;

		}



		protected function __construct() {
			//if ( is_plugin_active('morphii-pro/morphii-init.php')  )
			//	return;
			// if ( ! function_exists( 'WC' ) ) {

			// 	return;

			// }     



			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );

			add_action( 'init', array( $this, 'initialize_settings' ) );   

			add_action( 'init', array( $this, 'register_post_type' ) );

			add_action( 'admin_menu', array( $this, 'add_menu_item' ) );			

			

			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles_scripts' ) );

			add_action( 'add_meta_boxes', array( $this, 'wpt_add_question_metaboxes'));

			add_action( 'save_post', array( $this, 'wpt_save_events_meta'), 1, 2 );

			

			add_filter( 'woocommerce_product_tabs',  array( $this, 'woo_new_product_tab' ), 98 );

		

			add_action( "wp_ajax_submit_reviews", array( $this, 'submit_reviews') );

			add_action( "wp_ajax_nopriv_submit_reviews", array( $this, 'submit_reviews') );   

		}



		public function enqueue_scripts() {		

			//wp_enqueue_script( 'jquery-min',  MORPHII_MWAR_URL . 'assets/js/jquery.min.js', false );

			wp_enqueue_script( 'morphii-widget', 'https://widget.morphii.com/v2/morphii-widget.min.js', false );

			wp_register_script( 'morphii-custom', MORPHII_MWAR_URL . 'assets/js/morphii-custom.js', array(), false, true);

			wp_enqueue_script( 'morphii-custom' );

			wp_localize_script( 

			    'morphii-custom', 

			    'ajax_object', 

			    array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'nonce' => wp_create_nonce('morphii-custom-nonce') ) 

			);



		}



		public function woo_new_product_tab( $tabs ) {

		// Adds the new tab

		    $tabs['morphii'] = array(

		        'title'     => __( 'Morphii Reviews', 'woocommerce' ),

		        'priority'  => 100,

		        'callback'  => array( $this, 'show_advanced_reviews_template')

		    );



		    return $tabs;

		}

		public function add_menu_item() {

			add_menu_page( 
				esc_html__( 'Morphii Reviews', 'morphii' ), 
				esc_html__( 'Morphii Reviews', 'morphii' ), 
				'manage_options', 
				esc_html__( 'morphii-reviews', 'morphii' ), 
				array( $this, 'show_reviews_table' ), 
				'dashicons-text-page', 
				66.32
			);

			add_menu_page( 
				esc_html__( 'Morphii Questions', 'morphii' ), 
				esc_html__( 'Morphii Questions', 'morphii' ), 
				'manage_options', 
				esc_html__( 'morphii-questions', 'morphii' ), 
				array( $this, 'show_questions_table' ), 
				'dashicons-insert', 
				67.32
			);

			add_submenu_page('morphii-reviews', 'Settings', 'Settings', 'manage_options', 'morphii-settings', array( $this, 'morphii_render_settings_page'));

			//add_submenu_page('morphii-reviews', 'Licence', 'Licence', 'manage_options', 'morphii-licence', array( $this, 'morphii_render_licence_page'));

		}



		public function initialize_settings() {

		

		}



		public function register_post_type() {

			

			$labels = array(

				'name'               => _x( 'Morphii Questions', 'Post Type General Name', 'morphii' ),

				'singular_name'      => _x( 'Morphii Question', 'Post Type Singular Name', 'morphii' ),

				'menu_name'          => esc_html__( 'Morphii Questions', 'morphii' ),

				'parent_item_colon'  => esc_html__( 'Parent Morphii Questions', 'morphii' ),

				'all_items'          => esc_html__( 'All Morphii Questions', 'morphii' ),

				'view_item'          => esc_html__( 'View Morphii Question', 'morphii' ),

				// 'add_new_item'       => esc_html__( 'Add New Question', 'morphii' ),

				// 'add_new'            => esc_html__( 'Add New Question', 'morphii' ),

				'edit_item'          => esc_html__( 'Edit Question', 'morphii' ),

				// 'update_item'        => esc_html__( 'Update Question', 'morphii' ),

				'search_items'       => esc_html__( 'Search Question', 'morphii' ),

				'not_found'          => esc_html__( 'Not Found', 'morphii' ),

				'not_found_in_trash' => esc_html__( 'Not found in bin', 'morphii' ),

			);



			$args = array(

				'label' => esc_html__( 'Morphii Questions', 'morphii' ),

				'description' => esc_html__( 'Morphii Questions', 'morphii' ),

				'labels' => $labels,

				'supports' => array(

					'title',

					'editor',

					'author',

				),

				'hierarchical'                 => false,

				'public'                       => false,

				'show_ui'                      => true,

				'show_in_menu'                 => false,

				'show_in_nav_menus'            => false,

				'show_in_admin_bar'            => false,

				'menu_position'                => 70,

				'can_export'                   => false,

				'has_archive'                  => false,

				'exclude_from_search'          => true,

				'publicly_queryable'           => false,

				// 'capability_type'              => 'page',

				'capability_type' 			   => 'post',
				
				'capabilities' 				   => array(
				    'create_posts' => 'do_not_allow',
				 ),
				  
				'map_meta_cap' 					=> false, // Set to `false`, if users are not allowed to edit/delete existing posts

				'menu_icon'                    => 'dashicons-insert',

				'query_var'                    => false,

			);



			// Registering your Custom Post Type.

			register_post_type( $this->questions_post_type_name, $args );

		}



		public function wpt_add_question_metaboxes() {

			add_meta_box(
				'wpt_morphii_location',
				'Select Morphiis',
				array($this,'wpt_morphii_location'),
				'morphii-questions',
				'normal',
				'high'
			);

			add_meta_box(
				'wpt_morphii_category',
				'Morphii Category',
				array($this,'wpt_morphii_category'),
				'morphii-questions',
				'side',
				'default'
			);

		}

		public function wpt_morphii_location() {

			global $post;

			// Nonce field to validate form request came from current site

			wp_nonce_field( basename( __FILE__ ), 'morphii_fields' );

			// Get the location data if it's already been entered

			$morphiis = get_post_meta( $post->ID, 'morphiis', true );

			if(!empty($morphiis)){

				$morphii_array = unserialize($morphiis);

				echo '<input type="hidden" name="selected-morphiies" id="selected-morphiies" value="'.esc_attr(implode(',', $morphii_array)).'" />';

			}else{

				echo '<input type="hidden" name="selected-morphiies" id="selected-morphiies" value="" />';

			}

			// Output the field

			echo '<p class="morphii-desc">Select morphiis from below to get different types of reviews from users about your site/products.</p><p class="morphii-desc">Click on morphii image to see the actual morphii reaction.</p><div id="morphii-list-container" class="morphii-list-group"></div>';

		}

		public function wpt_morphii_category() {

			global $post;

			wp_nonce_field( basename( __FILE__ ), 'morphii_fields_post' );

			$args=array(
		        'public' => true,
		        'exclude_from_search' => false,
		    ); 

		    $output = 'objects';
		    $operator = 'and';
		    $post_types = get_post_types($args,$output,$operator);

		    $morphiis_posts = get_post_meta( $post->ID, 'morphii_post_types_to_display', true );

			// Output the field

			if(!empty($morphiis_posts)){
				$posttypes_array = unserialize($morphiis_posts);
			}

			echo '<p class="morphii-desc">Select the post types you want to add this question(Only Applicable while using shortcode).</p>';

			echo '<ul id="morphii-posts-list" class="categorychecklist form-no-clear">';			

			foreach ($post_types  as $post_type ) {
		        if($post_type->name != 'product'){ ?>
		        	<li id="post_type_-<?php echo esc_attr($post_type->name); ?>" class="popular-category"><label class="selectit"><input value="<?php echo esc_attr($post_type->name); ?>" type="checkbox" name="post_types_to_display[]" <?php if(isset($posttypes_array) && in_array($post_type->name, $posttypes_array)){ echo "checked"; }?>>
		        	<?php echo esc_html($post_type->label); ?></label></li>
		    	<?php }
		    }

		    echo '</ul>';
		}


		function wpt_save_events_meta( $post_id, $post ) {


			if ( ! current_user_can( 'edit_post', $post_id ) ) {

				return $post_id;

			}

			if ( ! isset( $_POST['morphiis'] ) || ! wp_verify_nonce( $_POST['morphii_fields'], basename(__FILE__) ) ) {

				return $post_id;

			}


			if ( ! isset( $_POST['post_types_to_display'] ) || ! wp_verify_nonce( $_POST['morphii_fields_post'], basename(__FILE__) ) ) {

				return $post_id;

			}

			$morphii_meta = sanitize_text_field($_POST['morphiis']);

			$post_types_to_display = sanitize_text_field($_POST['post_types_to_display']);

			if ( 'morphii-questions' === $post->post_type ) {

				if ( get_post_meta( $post_id, 'morphiis', true ) ) {

					update_post_meta( $post_id, 'morphiis', $morphii_meta );

				} else {

					add_post_meta( $post_id, 'morphiis', $morphii_meta );

				}


				if ( empty($morphii_meta) ) {

					delete_post_meta( $post_id, 'morphiis' );

				}

				if ( empty($morphiis_label) ) {

					delete_post_meta( $post_id, 'morphiis_label' );

				}


				if ( get_post_meta( $post_id, 'morphii_post_types_to_display', true ) ) {

					update_post_meta( $post_id, 'morphii_post_types_to_display', $post_types_to_display);

				} else {

					add_post_meta( $post_id, 'morphii_post_types_to_display', $post_types_to_display);

				}

				if ( empty($post_types_to_display) ) {

					delete_post_meta( $post_id, 'morphii_post_types_to_display' );

				}

			}

		}

		public function show_reviews_table() {

			if ( ! class_exists( 'WP_Posts_List_Table' ) ) {

				require_once( ABSPATH . 'wp-admin/includes/class-wp-posts-list-table.php' );

			}

			if(isset($_GET['action']) && $_GET['action'] == 'view_review'){
				
				$file = MORPHII_INCLUDE_DIR . "single-review.php";

		    	include($file);	    	

			}else{
				
				require_once( MORPHII_DIR . 'includes/class.morphii-list-table.php' );

				// $product_reviews = new Morphii_List_Table();

				// $product_reviews->prepare_items();

				$file = MORPHII_TEMPLATES_DIR . "product-reviews-table.php";

		    	include($file);	 

				//wc_get_template( 'product-reviews-table.php', array( 'product_reviews' => $product_reviews ), MORPHII_TEMPLATES_DIR, MORPHII_TEMPLATES_DIR );
			}			

		}

		public function show_questions_table() {

			if ( ! class_exists( 'WP_Posts_List_Table' ) ) {

				require_once( ABSPATH . 'wp-admin/includes/class-wp-posts-list-table.php' );

			}

			require_once( MORPHII_INCLUDE_DIR ."class.morphii-questions-table.php" );

			$file = MORPHII_TEMPLATES_DIR . "morphii-questions-table.php";

		    include($file);	 						

		}

		public function morphii_render_settings_page(){

		    global $title; 

		    print '<div class="wrap">';

		    $file = MORPHII_INCLUDE_DIR . "general-options.php";

		    include($file);

		    print '</div>';

		}

		public function show_advanced_reviews_template( $template ) {


			if ( get_post_type() === 'product' ) {

				print '<div class="morphii-reviews-loop">';

			    $file = plugin_dir_path( __FILE__ ) . "templates/product-reviews.php";

			    include($file);	

			    print '</div>';

			}

			return $template;

		}



		public function submit_reviews() {

			ob_clean();			 

		    if ( ! wp_verify_nonce( $_POST['nonce'], 'morphii-custom-nonce' ) ) {

		         die ( 'Busted!');

		    }

			if ( ! isset( $_REQUEST ) ) {

				return;

			}

			$product_id = sanitize_text_field($_REQUEST['product_id']);

			// $user_name = $_REQUEST['user_name'];

			// $user_email = $_REQUEST['user_email'];

			// $user_id = $_REQUEST['user_id'];

			$mainRecord = sanitize_text_field($_REQUEST['mainRecord']);

			$comments = sanitize_text_field($_REQUEST['comments']);

			$current_post_type = sanitize_text_field($_REQUEST['current_post_type']);

			$current_post_id = sanitize_text_field($_REQUEST['current_post_id']);

			$current_post_name = sanitize_text_field($_REQUEST['current_post_name']);

			// // Create post object

			$args = array(

				'post_author'         => $user_id,

				'post_title'          => $current_post_name,

				'post_content'        => 'Morphii User Reviews',

				'post_status'         => 'publish',

				'post_type'           => $this->reviews_post_type_name,

				'post_parent'         => 0,

			);



			$review_id = wp_insert_post( $args );



			if(!empty($review_id)){

				update_post_meta( $review_id, $this->meta_key_product_id, $product_id );

				// update_post_meta( $review_id, $this->meta_key_user_id, $user_id );

				// update_post_meta( $review_id, $this->meta_key_user_name, $user_name );

				// update_post_meta( $review_id, $this->meta_key_user_email, $user_email );

				update_post_meta( $review_id, $this->meta_key_reviews, $mainRecord );

				update_post_meta( $review_id, $this->meta_key_approved, 1 );

				update_post_meta( $review_id, $this->meta_key_comments, $comments ? $comments : null );

				update_post_meta( $review_id, 'morphii-current-post_name', $current_post_name ? $current_post_name : null );

				update_post_meta( $review_id, 'morphii-current-post_id', $current_post_id ? $current_post_id : null );

				update_post_meta( $review_id, 'morphii-current-post_type', $current_post_type ? $current_post_type : null );


				$return = array(

				    'status' => 1,

				    'message' => 'Thank you for your comments! Your review submitted successfully.'

				);

			}else{

				$return = array(

				    'status' => 0,

				    'message' => 'Something went wrong.Please try again later.'

				);

			}

			wp_send_json($return);

			wp_die(); 

		}

		public function enqueue_styles() {

			wp_enqueue_style( 'morphii-custom', MORPHII_MWAR_URL . 'assets/css/morphii-custom.css' );

		}

		function enqueue_admin_styles_scripts( $hook ) {

			wp_enqueue_style( 'morphii-list-admin', MORPHII_MWAR_URL . 'assets/css/morphii-list-admin.css' );

			wp_register_script( 'morphii-admin', MORPHII_MWAR_URL . 'assets/js/morphii-admin.js', array(), false, true);

			wp_enqueue_script( 'morphii-admin' );

			wp_localize_script( 

			    'morphii-admin', 

			    'ajax_object', 

			    array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'nonce' => wp_create_nonce('morphii-admin-nonce') ) 

			);



			wp_enqueue_style( 'wp-color-picker' );

			wp_enqueue_script( 'color-picker', MORPHII_MWAR_URL . 'assets/js/color-picker.js', array( 'wp-color-picker' ), false, true );

		}

	}

}