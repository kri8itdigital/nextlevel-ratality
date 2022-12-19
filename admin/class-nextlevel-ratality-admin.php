<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.kri8it.com
 * @since      1.0.0
 *
 * @package    Nextlevel_Ratality
 * @subpackage Nextlevel_Ratality/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Nextlevel_Ratality
 * @subpackage Nextlevel_Ratality/admin
 * @author     Hilton Moore <hilton@kri8it.com>
 */
class Nextlevel_Ratality_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Nextlevel_Ratality_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Nextlevel_Ratality_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/nextlevel-ratality-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Nextlevel_Ratality_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Nextlevel_Ratality_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/nextlevel-ratality-admin.js', array( 'jquery' ), $this->version, false );

	}









	/* ACF Custom Fields */
	public function custom_fields(){

		if( function_exists('acf_add_options_page') ) {
  
		   $main_menu = acf_add_options_page(array(
		    'page_title'  => 'RATALITY',
		    'menu_title'  => 'RATALITY',
		    'icon_url' => 'dashicons-admin-site-alt'
		  ));

		}	

					if( function_exists('acf_add_local_field_group') ):

			acf_add_local_field_group(array(
				'key' => 'group_627134b9c2568',
				'title' => 'RATALITY Settings',
				'fields' => array(
					array(
						'key' => 'field_62a8441f353a6',
						'label' => 'GENERAL',
						'name' => '',
						'type' => 'tab',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'placement' => 'top',
						'endpoint' => 0,
					),
					array(
						'key' => 'field_627135498107d',
						'label' => 'RATALITY API KEY',
						'name' => 'ratality_api_key',
						'type' => 'text',
						'instructions' => '',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_627135548107e',
						'label' => 'RATALITY API URL',
						'name' => 'ratality_api_url',
						'type' => 'text',
						'instructions' => '',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_62b1a0e141f12',
						'label' => 'RATALITY Reference Prefix',
						'name' => 'ratality_reference_prefix',
						'type' => 'text',
						'instructions' => '',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_62ff5c2baca4f',
						'label' => 'RATALITY Google API Key',
						'name' => 'ratality_google_api_key',
						'type' => 'text',
						'instructions' => '',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_62a8442a353a7',
						'label' => 'Search Settings',
						'name' => '',
						'type' => 'tab',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'placement' => 'top',
						'endpoint' => 0,
					),
					array(
						'key' => 'field_62a72eea35197',
						'label' => 'RATALITY Booking Lead Time',
						'name' => 'ratality_booking_lead_time',
						'type' => 'number',
						'instructions' => '',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => 2,
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'min' => '',
						'max' => '',
						'step' => '',
					),
					array(
						'key' => 'field_62a73476cbbf7',
						'label' => 'RATALITY Search Results Page',
						'name' => 'ratality_search_results_page',
						'type' => 'page_link',
						'instructions' => '',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'post_type' => '',
						'taxonomy' => '',
						'allow_null' => 0,
						'allow_archives' => 0,
						'multiple' => 0,
					),
					array(
						'key' => 'field_62a845f240b8f',
						'label' => 'RATALITY Tickets Page',
						'name' => 'ratality_tickets_page',
						'type' => 'page_link',
						'instructions' => '',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'post_type' => '',
						'taxonomy' => '',
						'allow_null' => 0,
						'allow_archives' => 0,
						'multiple' => 0,
					),
					array(
						'key' => 'field_62a84435353a8',
						'label' => 'Overlays',
						'name' => '',
						'type' => 'tab',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'placement' => 'top',
						'endpoint' => 0,
					),
					array(
						'key' => 'field_62a84448353a9',
						'label' => 'Ratality Overlay Background Colour',
						'name' => 'ratality_overlay_background_colour',
						'type' => 'color_picker',
						'instructions' => '',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => 'rgba(0,0,0,0.85)',
						'enable_opacity' => 1,
						'return_format' => 'string',
					),
					array(
						'key' => 'field_62a8446c353aa',
						'label' => 'Ratality Overlay Loading Gif',
						'name' => 'ratality_overlay_loading_gif',
						'type' => 'image',
						'instructions' => '',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'return_format' => 'url',
						'preview_size' => 'medium',
						'library' => 'all',
						'min_width' => '',
						'min_height' => '',
						'min_size' => '',
						'max_width' => '',
						'max_height' => '',
						'max_size' => '',
						'mime_types' => '',
					),
					array(
						'key' => 'field_62a85bedc9134',
						'label' => 'Cart Settings',
						'name' => '',
						'type' => 'tab',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'placement' => 'top',
						'endpoint' => 0,
					),
					array(
						'key' => 'field_62a85bf4c9135',
						'label' => 'Ratality Ticket Product',
						'name' => 'ratality_ticket_product',
						'type' => 'post_object',
						'instructions' => '',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'post_type' => array(
							0 => 'product',
						),
						'taxonomy' => '',
						'allow_null' => 0,
						'multiple' => 0,
						'return_format' => 'id',
						'ui' => 1,
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'options_page',
							'operator' => '==',
							'value' => 'acf-options-ratality',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => true,
				'description' => '',
				'show_in_rest' => 0,
			));

			endif;		

		if( function_exists('acf_add_local_field_group') ):

			acf_add_local_field_group(array(
				'key' => 'group_62b1a83da4f42',
				'title' => 'RATALITY INFORMATION',
				'fields' => array(
					array(
						'key' => 'field_62b1a8467a92a',
						'label' => 'Ratality Reservation No',
						'name' => 'ratality_reservation_no',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_62b1a8837a92b',
						'label' => 'Ratality Dropoff Date',
						'name' => 'ratality_dropoff_date',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_62b1a89d7a92c',
						'label' => 'Ratality Dropoff Location',
						'name' => 'ratality_dropoff_location',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_62b1a8a27a92d',
						'label' => 'Ratality Pickup Date',
						'name' => 'ratality_pickup_date',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_62b1a8a77a92e',
						'label' => 'Ratality Pickup Location',
						'name' => 'ratality_pickup_location',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_62b1a8bc7a92f',
						'label' => 'Ratality Return',
						'name' => 'ratality_return',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_62b1a8d27a930',
						'label' => 'Ratality Tickets',
						'name' => 'ratality_tickets',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_62b1a90cab080',
						'label' => 'Ratality Paid',
						'name' => 'ratality_paid',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'shop_order',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'side',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => true,
				'description' => '',
				'show_in_rest' => 0,
			));

			endif;			
		
	}










	/* POST TYPES */
	public function post_types(){

		$labels = array(
		    'name' => _x( 'Ratality Booking', 'post type general name', 'thriftylocal' ),
		    'singular_name' => _x( 'Ratality Booking', 'post type singular name', 'thriftylocal' ),
		    'add_new' => _x( 'Add New', 'slider', 'thriftylocal' ),
		    'add_new_item' => __( 'Add Ratality Booking', 'thriftylocal' ),
		    'edit_item' => __( 'Edit Ratality Booking', 'thriftylocal' ),
		    'new_item' => __( 'New Ratality Booking', 'thriftylocal' ),
		    'view_item' => __( 'View Ratality Booking', 'thriftylocal' ),
		    'search_items' => __( 'Search Ratality Bookings', 'thriftylocal' ),
		    'not_found' =>  __( 'No Ratality Bookings found', 'thriftylocal' ),
		    'not_found_in_trash' => __( 'No Ratality Bookings found in Trash', 'thriftylocal' ), 
		    'parent_item_colon' => ''
		  );
		  
		  $rewrite = 'ratality-bookings';
		  
		  $args = array(
		    'labels' => $labels,
		    'public' => true,
		    'publicly_queryable' => true,
		    'show_ui' => true, 
		    'query_var' => true,
		    'rewrite' => array( 'slug' => $rewrite ),
		    'capability_type' => 'post',
		    'hierarchical' => false,
		    'menu_position' => null, 
		    'menu_icon' => 'dashicons-calendar',
		    'has_archive' => true, 
		    'show_in_rest' => true,
		    'supports' => array('title'),
		  );
		      
		  register_post_type( 'ratalitybooking', $args );

		  
		
	}










	/* AJAX: AVAILABILITY */
	public function ratality_ajax_do_search(){

		parse_str($_POST['data'],$_POSTED);

		$_DIRECTION_ONE = array(
		  "departureLocationId" => $_POSTED['ratalityPickUpLocation'],
		  "destinationLocationId" => $_POSTED['ratalityDropOffLocation'],
		  "numberOfPassengers" => $_POSTED['ratalityTickets'],
		  "departureDate" => wp_date('d-m-Y', strtotime($_POSTED['ratalityPickUpDate'])),
		);

		$_DIRECTION_TWO = false;

		$_DUAL_DIRECTION = false;

		if($_POSTED['ratalityReturn'] == 'yes'):
			$_DUAL_DIRECTION = true;

			$_DIRECTION_TWO = array(
			  "departureLocationId" => $_POSTED['ratalityDropOffLocation'],
			  "destinationLocationId" => $_POSTED['ratalityPickUpLocation'],
			  "numberOfPassengers" => $_POSTED['ratalityTickets'],
			  "departureDate" => wp_date('d-m-Y', strtotime($_POSTED['ratalityDropOffDate'])),
			);

		endif;

		RATALITY_HELPERS::CLEAR_RATALITY();

		RATALITY_HELPERS::SET_RATALITY($_POSTED);

		RATALITY_HELPERS::DOTRIPS($_DIRECTION_ONE, $_DIRECTION_TWO);
		
		$_URL = get_field('ratality_search_results_page', 'option');
		echo $_URL;

		exit;


	}










	/* STORE SELECTED TRIP */
	public function ratality_ajax_select_trip(){

		$_TYPE 		= $_POST['type'];
		$_TRIP 		= $_POST['trip'];
		$_ROUTE 	= $_POST['route'];

		$_RATALITY_TRIPS = WC()->session->get('ratality_trips');

		$_THESE_TRIPS = false;

		switch($_TYPE):

			case "one":
				$_THESE_TRIPS = $_RATALITY_TRIPS['TRIPONE'];
			break;

			case "two":
				$_THESE_TRIPS = $_RATALITY_TRIPS['TRIPTWO'];
			break;

		endswitch;

		foreach($_THESE_TRIPS AS $_THIS_TRIP):

			if((int)trim($_THIS_TRIP['tripId']) == (int)trim($_TRIP) && (int)trim($_THIS_TRIP['routeId']) == (int)trim($_ROUTE)):
				$_SELECTED_TRIP = $_THIS_TRIP;
				WC()->session->set('ratality_selected_trip_'.$_TYPE, $_SELECTED_TRIP);
			endif;

		endforeach;

		$_RETURNTRIP = WC()->session->get('ratality_return');

		$_URL = get_field('ratality_tickets_page', 'option');

		if($_RETURNTRIP == 'no' && WC()->session->get('ratality_selected_trip_one')):
			echo $_URL;
		elseif($_RETURNTRIP == 'yes' && WC()->session->get('ratality_selected_trip_one') && WC()->session->get('ratality_selected_trip_two')):
			echo $_URL;
		else:
			echo 'busy';
		endif;

		exit;

	}










	/* UNDO TICKET SELECTION */
	public function ratality_ajax_destroy_tickets(){

		RATALITY_HELPERS::CLEAR_SELECTED();

		$_URL = get_field('ratality_search_results_page', 'option');
		echo $_URL;

		exit;

	}










	/* CREATE TICKET DATA FOR STORAGE */
	public function ratality_ajax_create_tickets(){

		parse_str(str_replace("'", "", stripslashes($_POST['tickets'])) ,$_POSTED);
		$_PASSENGERS = $_POSTED['ratality_passengers'];		

		WC()->session->set('ratality_passengers', $_PASSENGERS);

		$_TICKET = get_field('ratality_ticket_product', 'option');

		$_RETURNTRIP = WC()->session->get('ratality_return');

		$_DO_TRIPS = array();

		if($_RETURNTRIP == 'yes'):
			$_DO_TRIPS[] = WC()->session->get('ratality_selected_trip_one');
			$_DO_TRIPS[] = WC()->session->get('ratality_selected_trip_two');
		else:
			$_DO_TRIPS[] = WC()->session->get('ratality_selected_trip_one');
		endif;

		$_TICKET_DATA = array();

		$_COUNT = 1;

		foreach($_DO_TRIPS as $_TRIP):

			foreach($_PASSENGERS as $_PASSENGER):

				$_ROW = array('trip' => $_TRIP, 'passenger' => $_PASSENGER);

				$_CART_ITEM_DATA = array( 'ratality' => $_ROW);
				$_TICKET_DATA[] = $_ROW;

				WC()->cart->add_to_cart($_TICKET, 1, 0, array(), $_CART_ITEM_DATA);

			endforeach;

		endforeach;

		WC()->session->set('ratality_ticket_information', $_TICKET_DATA);

		echo wc_get_cart_url();

		exit;
		

	}










	/* MARK ORDER AUTO COMPLETED */
	public function woocommerce_bacs_process_payment_order_status($_STATUS, $_ORDER){
		return 'completed';
	}










	/* MARK ORDER AUTO COMPLETED */
	public function woocommerce_payment_complete_order_status($_STATUS){

		return 'completed';

	}










	/* ON COMPLETE - DO RESERVATION AND CLEAR SESSION */
	public function woocommerce_order_status_completed($_ORDER_ID){
		RATALITY::BOOKING($_ORDER_ID);
		RATALITY_HELPERS::CLEAR_RATALITY();
	}










	/* FILTER ORDER NUMBER TO CARPRO RESERVATION */
	public function woocommerce_order_number($_ID){


		if(get_post_meta($_ID, 'ratality_reservation_no', true)):
			$_ID = get_post_meta($_ID, 'ratality_reservation_no', true);
		endif;


		return $_ID;


	}










	/* ADD DETAILS TO ORDER EMAIL */
	public function woocommerce_email_order_details($_ORDER){

		if(get_post_meta($_ORDER->get_id(), 'ratality_error', true)):

			$_RATALITY_ERROR = get_post_meta($_ORDER->get_id(), 'ratality_error', true);

			$_EMAIL = WC()->mailer()->get_emails()['WC_Email_New_Order']->recipient;

			echo '<p>Our apologies, there seems to have been an issue with our reservation system. kindly EMAIL <a href="mailto:'.$_EMAIL.'">'.$_EMAIL.'</a> with <strong>REFERENCE: '.$_ORDER->get_id().'</strong> and <strong>ERROR: '.$_RATALITY_ERROR.'</strong></p>';

		endif;	



	}










	/* REMOVE PROCESSING NOTIFICATIONS */
	public function woocommerce_email($_EMAIL_CLASS){

		remove_action( 
			'woocommerce_order_status_pending_to_processing_notification', 
			array( $_EMAIL_CLASS->emails['WC_Email_Customer_Processing_Order'], 
				'trigger' 
			) 
		);

		remove_action( 
			'woocommerce_order_status_pending_to_completed_notification', 
			array( $_EMAIL_CLASS->emails['WC_Email_New_Order'], 
				'trigger' 
			) 
		);

		remove_action( 
			'woocommerce_order_status_pending_to_on-hold_notification', 
			array( $_EMAIL_CLASS->emails['WC_Email_Customer_Processing_Order'], 
				'trigger' 
			) 
		);

		remove_action( 'woocommerce_order_status_completed_notification', 
			array( $_EMAIL_CLASS->emails['WC_Email_Customer_Completed_Order'], 
				'trigger' 
			) 
		);

	}










	/* SAVE RATALITY DATA TO ORDER */
	public function woocommerce_checkout_update_order_meta($_ORDER_ID){
		RATALITY_HELPERS::SAVE_RATALITY($_ORDER_ID);
		RATALITY_HELPERS::CLEAR_RATALITY();
	}










	/* SAVE RATALITY DATA TO LINE ITEMS */
	public function woocommerce_checkout_create_order_line_item($item, $cart_item_key, $values, $order){

		if(isset($values['ratality'])):
			$_TRIP = $values['ratality']['trip']; 
			$_PASSENGER = $values['ratality']['passenger'];

			$_NAME = array();
			$_NAME[] = $_PASSENGER['title'];
			$_NAME[] = $_PASSENGER['name'];
			$_NAME[] = $_PASSENGER['surname'];

			$_DEPARTURE_DT = explode("T", $_TRIP['departureDate']);
			$_ARRIVAL_DT = explode("T", $_TRIP['arrivalDate']);

			$item->update_meta_data( 'Passenger', implode(" ", $_NAME));

			$item->update_meta_data( 'Departing Date & Time', $_DEPARTURE_DT[0].' @ '.$_DEPARTURE_DT[1]);

			$item->update_meta_data( 'Departing Location', $_TRIP['departure']['streetAddress']);

			$item->update_meta_data( 'Out Branch', $_ARRIVAL_DT[0].' @ '.$_ARRIVAL_DT[1]);

			$item->update_meta_data( 'Arrival Location', $_TRIP['destination']['streetAddress']);

		endif;

	}





}
