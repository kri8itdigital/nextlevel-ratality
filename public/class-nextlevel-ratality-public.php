<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.kri8it.com
 * @since      1.0.0
 *
 * @package    Nextlevel_Ratality
 * @subpackage Nextlevel_Ratality/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Nextlevel_Ratality
 * @subpackage Nextlevel_Ratality/public
 * @author     Hilton Moore <hilton@kri8it.com>
 */
class Nextlevel_Ratality_Public {

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
		 * defined in Nextlevel_Ratality_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Nextlevel_Ratality_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/nextlevel-ratality-public.css', array(), $this->version, 'all' );

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
		 * defined in Nextlevel_Ratality_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Nextlevel_Ratality_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */


		wp_enqueue_script('jquery/datepicker/js', 'https://code.jquery.com/ui/1.12.1/jquery-ui.min.js', array( 'jquery' ), false, false);

		wp_enqueue_style('jquery/datepicker/css', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css', null, false, false);

		wp_enqueue_script('bootstrap/js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css', array(), false, false);

		wp_enqueue_style( 'bootstrap/css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css', null, false, false);

		wp_enqueue_style('confirm/css', '//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css');

    	wp_enqueue_script('confirm/js', '//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js', array('jquery'));


    	$_REQUIREMENT = '';

    	if(!wp_script_is('enqueued', 'eael-google-map-api')):

	    	wp_enqueue_script('google/maps', 'https://maps.googleapis.com/maps/api/js?key='.get_field('ratality_google_api_key','option').'&libraries=places', array( 'jquery'), false, false);
	    	$_REQUIREMENT = 'google/maps';

	    else:

	    	$_REQUIREMENT = 'eael-google-map-api';

	    endif;

    	wp_enqueue_script( 'google/html', plugin_dir_url( __FILE__ ) . 'js/htmlmarker.js', array( 'jquery',$_REQUIREMENT ), $this->version, false );

    	wp_enqueue_script('select2/js', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', array( 'jquery'), false, false);

    	wp_enqueue_style('select2/css', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css');

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/nextlevel-ratality-public.js', array( 'jquery', 'google/html', 'confirm/js', 'jquery/datepicker/js', 'select2/js'  ), $this->version, false );



		$_ARRAY_OF_ARGS = array(
			'ajax_url' 					=> get_bloginfo('url').'/wp-admin/admin-ajax.php',
			'booking_lead_time' 		=> get_field('ratality_booking_lead_time','option'),
			'booking_session_title' 	=> get_field('ratality_booking_session_expired_title','option'),
			'booking_session_text' 		=> get_field('ratality_booking_session_expired_text','option'),
			'booking_session_button' 	=> get_field('ratality_booking_session_button_text','option'),
			'booking_session_link' 		=> get_field('ratality_booking_session_button_link','option'),
			'booking_session_time' 		=> (int)get_field('ratality_booking_session_homepage_timeout','option')*1000,
			'utility_queried_object_id' => get_queried_object_id()
		);

		if(get_field('ratality_enable_timer', 'option')):
			$_ARRAY_OF_ARGS['enable_timer'] = 'yes';
		else:
			$_ARRAY_OF_ARGS['enable_timer'] = 'no';
		endif;

		if(get_field('ratality_timer_length', 'option')):
			$_ARRAY_OF_ARGS['booking_timer_minutes'] = (int)get_field('ratality_timer_length', 'option');
		else:
			$_ARRAY_OF_ARGS['booking_timer_minutes'] = 0;
		endif;

		if(isset(WC()->session)):

			if(RATALITY_HELPERS::IS_SEARCH_PAGE()):
				$_ARRAY_OF_ARGS['is_search'] = 'yes';

				if(WC()->session->get('ratality_pickup_location')):
					$_ARRAY_OF_ARGS['search_ratality_pickup_location'] = WC()->session->get('ratality_pickup_location'); 
				endif;

				if(WC()->session->get('ratality_dropoff_location')):
					$_ARRAY_OF_ARGS['search_ratality_dropoff_location'] = WC()->session->get('ratality_dropoff_location');
				endif;

				if(WC()->session->get('ratality_tickets')):
					$_ARRAY_OF_ARGS['search_ratality_tickets'] = WC()->session->get('ratality_tickets');
				endif;

				if(WC()->session->get('ratality_return')):
					$_ARRAY_OF_ARGS['search_ratality_return'] = WC()->session->get('ratality_return');
				endif;

				if(WC()->session->get('ratality_pickup_date')):
					$_ARRAY_OF_ARGS['search_ratality_pickup_date'] = WC()->session->get('ratality_pickup_date');
				endif;

				if(WC()->session->get('ratality_dropoff_date')):
					$_ARRAY_OF_ARGS['search_ratality_dropoff_date'] = WC()->session->get('ratality_dropoff_date');
				endif;

			endif;

		endif;

		wp_localize_script( $this->plugin_name, 'ratality_params', $_ARRAY_OF_ARGS );

	}










	/* AFTER THEME: REMOVE GENERIC ACTIONS */
	public function after_setup_theme(){

		add_filter('woocommerce_cart_item_removed_notice_type', '__return_null');

		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
		
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

		add_action('woocommerce_single_product_summary', 'the_content', 20);

		remove_action( 'woocommerce_order_details_after_order_table', 'woocommerce_order_again_button' );

	}










	/* SHORTCODES */
	public function shortcodes(){


		add_shortcode('ratality_search_form', array($this, 'ratality_search_form'));
		add_shortcode('ratality_search_results', array($this, 'ratality_search_results'));
		add_shortcode('ratality_search_tickets', array($this, 'ratality_search_tickets'));

	}










	/* SHORTCODE - SEARCHFORM */
	public function ratality_search_form(){

		$_LOCATIONS = RATALITY_HELPERS::LOCATIONS();

		ob_start();
		?>

		<div id="RATALITYSEARCHCONTAINER">
			<form id="RATALITYSEARCHFORM" autocomplete="off">
				<div class="row">
					<div class="col-5">
						<div class="row">
							<div class="col-6">
								<div><label>Pick-Up Location</label></div>
								<div class="relative">
								<select autocomplete="off" name="ratalityPickUpLocation" id="ratalityPickUpLocation">
									<option value="">Select Pick-Up Location</option>
									<?php foreach($_LOCATIONS as $_KEY => $_LOC): ?>
										<option value="<?php echo $_KEY; ?>"><?php echo $_LOC; ?></option>
									<?php endforeach; ?>
								</select>
								</div>
							</div>
							<div class="col-6">
								<div><label>Drop-Off Location</label></div>
								<div class="relative">
								<select autocomplete="off" name="ratalityDropOffLocation" id="ratalityDropOffLocation">
									<option value="">Select Drop-Off Location</option>
									<?php foreach($_LOCATIONS as $_KEY => $_LOC): ?>
										<option value="<?php echo $_KEY; ?>"><?php echo $_LOC; ?></option>
									<?php endforeach; ?>
								</select>
								</div>
							</div>
						</div>
					</div>
					<div class="col-5">
						<div class="row">
							<div class="col-2">								
								<div><label>Seats</label></div>
								<div class="relative">
								<select autocomplete="off" name="ratalityTickets" id="ratalityTickets">
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
								</select>
								</div>
							</div>
							<div class="col-4">
								<div><label>Pick-Up Date</label></div>
								<div class="relative">
								<input autocomplete="off" type="text" name="ratalityPickUpDate" id="ratalityPickUpDate" />
								</div>
							</div>
							<div class="col-2">
								<div><label>Return</label></div>
								<div class="relative">
								<select name="ratalityReturn" id="ratalityReturn">
									<option value="no">No</option>
									<option value="yes">Yes</option>
								</select>
								</div>
							</div>
							<div class="col-4">
								<div><label>Return Date</label></div>
								<div class="relative">
								<input autocomplete="off" class="ratality_disabled" type="text" name="ratalityDropOffDate" id="ratalityDropOffDate" />	
								</div>							
							</div>
						</div>

						
					</div>
					<div class="col-2">
						<a id="RATALITYSEARCHACTION">Search</a>
					</div>
				</div>
			</form>
		</div>

		<?php

		return ob_get_clean();

	}










	/* SHORTCODE - SEARCH RESULTS */
	public function ratality_search_results(){

		if(!is_admin()):

			if(isset(WC()->session) && WC()->session->get('ratality_trips')):

				ob_start();

				RATALITY_HELPERS::DISPLAY_BOOKING_STEPS();

				$_TRIPS = WC()->session->get('ratality_trips');

				if(isset($_TRIPS['TRIPONE']) && is_array($_TRIPS['TRIPONE']) && count($_TRIPS['TRIPONE']) > 0):

					echo '<div class="trip_container">';
					echo '<h2>Select A Trip</h2>';

					foreach($_TRIPS['TRIPONE'] as $_TRIP):

						RATALITY_HELPERS::OUTPUT_TRIP($_TRIP, 1);

					endforeach;

					echo '</div>';

				endif;

				if(isset($_TRIPS['TRIPTWO']) && is_array($_TRIPS['TRIPTWO']) && count($_TRIPS['TRIPTWO']) > 0):

					echo '<div class="trip_container">';
					echo '<h2>Select A Return Trip</h2>';

					foreach($_TRIPS['TRIPTWO'] as $_TRIP):

						RATALITY_HELPERS::OUTPUT_TRIP($_TRIP, 2);

					endforeach;

					echo '</div>';

				endif;
				

				return ob_get_clean();

			else:

				echo do_shortcode('[ratality_search_form]');

			endif;
		endif;
	}










	/* SHORTCODE - TICKET INFORMATION */
	public function ratality_search_tickets(){

		if(isset(WC()->session) && WC()->session->get('ratality_tickets')):
		$_COUNTER = 1;
		$_TICKETS = (int)WC()->session->get('ratality_tickets');

		ob_start();
		RATALITY_HELPERS::DISPLAY_BOOKING_STEPS();
		echo '<form id="ratalityTicketDetails">';
		while($_COUNTER <= $_TICKETS):

			if($_COUNTER == 1):
				$_TITLE = 'Main Passenger';
			else:
				$_TITLE = 'Passenger '.$_COUNTER;
			endif;

			?>

				<div class="ratality_ticket_block">
					
					<h2><?php echo $_TITLE; ?></h2>

					<div class="row">
						<div class="col-4">
							<label>Passenger Type</label>
							<select autocomplete="off" name="ratality_passengers[<?php echo $_COUNTER; ?>]['ageGroup']">
								<option value="ADULT">Adult</option>
								<!--
									<option value="CHILD">Child</option>
									<option value="STUDENT">Student</option>
									<option value="PENSIONER">Pensioner</option>
								-->
							</select>
						</div>
						<div class="col-4">		
							<label>Gender</label>
							<select autocomplete="off" name="ratality_passengers[<?php echo $_COUNTER; ?>]['gender']">
								<option value=""></option> 
								<option value="MALE">Male</option>
								<option value="FEMALE">Female</option>
							</select>
						</div>
						<div class="col-4">
							<label>Title</label>
							<select autocomplete="off" name="ratality_passengers[<?php echo $_COUNTER; ?>]['title']">
								<option value=""></option>
								<option value="Mr">Mr</option>
								<option value="Ms">Ms</option>
								<option value="Mrs">Mrs</option>
								<option value="Dr">Dr</option>
								<option value="None">None</option>
							</select>
						</div>
					</div>

					<div class="row">
									
						<div class="col-4">
							<label>First Name</label>
							<input autocomplete="off" type="text" name="ratality_passengers[<?php echo $_COUNTER; ?>]['name']" />
						</div>
						<div class="col-4">
							<label>Last Name</label>
							<input autocomplete="off" type="text" name="ratality_passengers[<?php echo $_COUNTER; ?>]['surname']" />
						</div>
						<div class="col-4">
							<label>Travelling infant</label>
							<select autocomplete="off" name="ratality_passengers[<?php echo $_COUNTER; ?>]['travellingInfant']">
								<option value="no">No</option>
								<option value="Yes">Yes</option>
							</select>
						</div>
					</div>

					<div class="row">
						<div class="col-4">
								<label>ID Document Type</label>
								<select autocomplete="off" name="ratality_passengers[<?php echo $_COUNTER; ?>]['documentType']"> 
									<option value=""></option> 
									<option value="DRIVERS_LICENSE">Drivers License</option>
									<option value="PASSPORT">Passport</option>
									<option value="SOUTH_AFRICAN_ID">ID</option>
								</select>
						</div>
						<div class="col-4">
							<label>ID Document Number</label>
							<input autocomplete="off" type="text" name="ratality_passengers[<?php echo $_COUNTER; ?>]['documentNumber']" />
						</div>
						<div class="col-4">
							<label>Date Of Birth</label>
							<input autocomplete="off" class="ratality_DOB" type="text" name="ratality_passengers[<?php echo $_COUNTER; ?>]['dateOfBirth']" />
						</div>
					</div>

					<div class="row">
						<div class="col-6">
							<label>Email Address</label>	
							<input autocomplete="off" type="email" name="ratality_passengers[<?php echo $_COUNTER; ?>]['email']" />						
						</div>
						<div class="col-6">
							<label>Mobile Number</label>
							<input autocomplete="off" type="number" name="ratality_passengers[<?php echo $_COUNTER; ?>]['mobileNumber']" />
						</div>
					</div>

					<div class="row">
						<div class="col-6">
							<label>Emergency Contact Name</label>	
							<input autocomplete="off" type="text" name="ratality_passengers[<?php echo $_COUNTER; ?>]['emergencyContactName']" />							
						</div>
						<div class="col-6">
							<label>Emergency Contact Number</label>
							<input autocomplete="off" type="number" name="ratality_passengers[<?php echo $_COUNTER; ?>]['emergencyContactNumber']" />
						</div>
					</div>

				</div>

			<?php

			$_COUNTER++;

		endwhile;
		echo '</form>';
		?>
		<div id="ratalityTicketActions">
			<div class="row">
				<div class="col-6"><a id="ratalityTicketActionBack">Go Back</a></div>
				<div class="col-6"><a id="ratalityTicketActionContinue">Continue</a></div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	endif;

	}
	










	/* GENERIC: RETURN FALSE */
	public function generic_false_function(){
		return false;
	}	









	/* FOOTER FUNCTION FOR LOADER */
	public function wp_footer(){
		?>

		<style type="text/css">
			#ratalityLoader{
				background-color: <?php the_field('ratality_overlay_background_colour', 'option'); ?> !important;
				background-image:url( <?php the_field('ratality_overlay_loading_gif', 'option'); ?>);				
			}
		</style>

		<div id="ratalityLoader"></div>

		<?php
	}









	/* SHOW ITEM META FOR PRODUCT */
	public function woocommerce_get_item_data($item_data, $cart_item){

		if(isset($cart_item['ratality'])):

			$_TRIP = $cart_item['ratality']['trip']; 
			$_PASSENGER = $cart_item['ratality']['passenger'];

			$_NAME = array();
			$_NAME[] = $_PASSENGER['title'];
			$_NAME[] = $_PASSENGER['name'];
			$_NAME[] = $_PASSENGER['surname'];

			$_DEPARTURE_DT = explode("T", $_TRIP['departureDate']);
			$_ARRIVAL_DT = explode("T", $_TRIP['arrivalDate']);

			$item_data['ratality-passenger'] = array(
				'name' => 'Passenger', 
				'display'=> implode(" ", $_NAME)
			);

			$item_data['ratality-depart-datetime'] = array(
				'name' => 'Departing Date & Time', 
				'display'=> $_DEPARTURE_DT[0].' @ '.$_DEPARTURE_DT[1] 
			);

			$item_data['ratality-depart-location'] = array(
				'name' => 'Departing Location', 
				'display'=> $_TRIP['departure']['streetAddress']
			);

			$item_data['ratality-arrive-datetime'] = array(
				'name' => 'Arrival Date & Time', 
				'display'=> $_ARRIVAL_DT[0].' @ '.$_ARRIVAL_DT[1] 
			);

			$item_data['ratality-arrive-location'] = array(
				'name' => 'Arrival Location', 
				'display'=> $_TRIP['destination']['streetAddress'] 
			);

		endif;

		return $item_data;
	}










	/* GET APPROPRIATE PRICE AND AMEND SKU AND NAME */
	public function woocommerce_before_calculate_totals($_CART){

		if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
			return;
		}

		$_COUNT = 1;

		foreach ( $_CART->get_cart() as $_ITEM => $_DATA ) {
			$_TITLE = 'Ticket #'.$_COUNT.': '.$_DATA['ratality']['trip']['departure']['town'].' to '.$_DATA['ratality']['trip']['destination']['town'];
			$_SKU = $_DATA['ratality']['trip']['routeId'].'-'.$_DATA['ratality']['trip']['tripId'];
			$_DATA[ 'data' ]->set_price( $_DATA['ratality']['trip']['price']['value'] );
			$_DATA[ 'data' ]->set_name( $_TITLE );
			$_DATA[ 'data' ]->set_sku( $_SKU );
			$_COUNT++;
		}

	}










	/* REMOVE CART ITEM */
	public function woocommerce_remove_cart_item($_KEY, $_CART){
		
		RATALITY_HELPERS::CLEAR_CART();

	}










	/* RETURN TO SHOP TEXT */
	public function woocommerce_return_to_shop_text($_TEXT){

		$_TEXT = 'Back to Search Results';

		return $_TEXT;
	}










	/* CHANGE CART RETURN TO SHOP REDIRECT */
	public function woocommerce_return_to_shop_redirect($_URL){

		$_URL = get_field('search_results_page', 'option');

		return $_URL;

	}










	/* BEFORE CART */
	public function woocommerce_before_cart(){
		
	}










	/* AMEND CHECKOUT FIELDS */
	public function woocommerce_checkout_fields($fields){

		if(isset(WC()->session) && WC()->session->get('ratality_passengers')):
			$_PASSENGERS = WC()->session->get('ratality_passengers');
			$_PASSENGER = reset($_PASSENGERS);
			$fields['billing']['billing_first_name']['default'] = $_PASSENGER['name'];
			$fields['billing']['billing_last_name']['default'] = $_PASSENGER['surname'];
			$fields['billing']['billing_phone']['default'] = $_PASSENGER['mobileNumber'];
			$fields['billing']['billing_email']['default'] = $_PASSENGER['email'];
		endif;

		unset($fields['billing']['billing_company']);
		unset($fields['billing']['billing_address_1']);
		unset($fields['billing']['billing_address_2']);
		unset($fields['billing']['billing_country']);
		unset($fields['billing']['billing_city']);
		unset($fields['billing']['billing_state']);
		unset($fields['billing']['billing_postcode']);

		return $fields;


	}










	/* THANK YOU - CLEAR SESSION */
	public function woocommerce_thankyou($_ORDER_ID){
		RATALITY_HELPERS::CLEAR_RATALITY();
	}









	
	/* WOOCOMMERCE TEMPLATE OVERRIDE */
	public function woocommerce_locate_template($template, $template_name, $template_path){

		$_PLUGIN_PATH = trailingslashit(trailingslashit(ABSPATH).'wp-content/plugins/nextlevel-ratality/woocommerce');

		$_NEW_FILE = $_PLUGIN_PATH.$template_name;

		if(file_exists($_NEW_FILE)):
			$template = $_NEW_FILE;
		endif;

		return $template;
	}








	public function woocommerce_review_order_before_submit(){
		?>
		<div id="ratalityPaymentRow" class="row">

			<div class="col-6 textleft">
				<a id="ratalityPaymentCancel"><?php the_field('ratality_cancel_button_text', 'option'); ?></a>
			</div>

			<div class="col-6 textright">
			
		<?php
	}








	public function woocommerce_review_order_after_submit(){

		?>

			</div>

		</div>

		<?php
		
	}




	public function woocommerce_order_button_text($_TEXT){
		$_TEXT = get_field('ratality_order_button_text', 'option');

		return $_TEXT;
	}






	public function woocommerce_before_checkout_form(){

		RATALITY_HELPERS::DISPLAY_BOOKING_STEPS();

	}

}
