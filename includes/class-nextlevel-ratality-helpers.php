<?php


class RATALITY_HELPERS{









	public static function OUTPUT_TRIP($_TRIP){

		$_DEPARTURE_DATE 		= explode('T', $_TRIP['departureDate']);
		$_ARRIVAL_DATE 			= explode('T', $_TRIP['arrivalDate']);
		$_DEPARTURE_LOCATION 	= $_TRIP['departure'];
		$_ARRIVAL_LOCATION 		= $_TRIP['destination'];
		$_STOPS 				= $_TRIP['stops'];

		?>

			<div data-route="<?php echo $_TRIP['routeId']; ?>" data-trip="<?php echo $_TRIP['tripId']; ?>" class="trip_item">
				
				<?php if(count($_STOPS) > 0): ?>
					<a class="TRIP_MAP_TOGGLE">View Map</a>
				<?php endif; ?>

				<div class="row">
					<div class="col-6">
						<h3>Pick-Up</h3>
						<div class="trip_item_data"><?php echo $_DEPARTURE_LOCATION['town']; ?></div>
						<div class="trip_item_data"><?php echo $_DEPARTURE_DATE[0]; ?> @ <?php echo $_DEPARTURE_DATE[1]; ?></div>
						<div class="trip_item_data"><?php echo $_DEPARTURE_LOCATION['streetAddress']; ?></div>
					</div>
					<div class="col-6">
						<h3>Drop-Off</h3>
						<div class="trip_item_data"><?php echo $_ARRIVAL_LOCATION['town']; ?></div>
						<div class="trip_item_data"><?php echo $_ARRIVAL_DATE[0]; ?> @ <?php echo $_ARRIVAL_DATE[1]; ?></div>
						<div class="trip_item_data"><?php echo $_ARRIVAL_LOCATION['streetAddress']; ?></div>
					</div>
					<div class="col-12 trip-action-row">
						<div class="row">
							<div class="col-4">
								<strong>Seats Available: </strong>  <?php echo $_TRIP['availableSeats']; ?>
							</div>
							<div class="col-4">
								<strong>Price: </strong> <?php echo wc_price($_TRIP['price']['value']); ?>
							</div>
							<div class="col-4">
								<a data-route="<?php echo $_TRIP['routeId']; ?>" data-trip="<?php echo $_TRIP['tripId']; ?>" class="route_select_button route_one_select">Select Route</a> 
							</div>
						</div>
					</div>
				</div>

				<?php if(count($_STOPS) > 0): ?>
					<div class="TRIPSTOPS">
						<div class="row ">
							<div class="col-4">
								<?php 
									foreach($_STOPS as $_STOP):
										?>
										<div class="trip_stop_item">
											<div class="trip_stop_name"><strong><?php echo $_STOP['order'];?>: <?php echo $_STOP['location']['town']; ?></strong></div>
											<div class="trip_stop_address"><?php echo $_STOP['location']['streetAddress']; ?></div>

											<?php if($_STOP['arriveTime'] == $_STOP['departTime']): 

												if((int)$_STOP['order'] == 1): ?>
													<div class="trip_stop_depart"><small>Depart: <?php echo $_STOP['departTime']; ?></small></div>
												<?php else: ?>
													<div class="trip_stop_arrive"><small>Arrive: <?php echo $_STOP['arriveTime']; ?></small></div>
												<?php endif;

											else:

											?>

												<div class="trip_stop_arrive"><small>Arrive: <?php echo $_STOP['arriveTime']; ?></small></div>
												<div class="trip_stop_depart"><small>Depart: <?php echo $_STOP['departTime']; ?></small></div>

											<?php endif; ?>
										</div>
										<?php
									endforeach;
								?>
							</div>
							<div class="col-8">
								<div class="RATALITY_MAP" data-lat="<?php echo $_STOPS[0]['location']['geoLocation']['latitude']; ?>" data-lng="<?php echo $_STOPS[0]['location']['geoLocation']['longitude']; ?>" data-zoom="14">
									<?php 
									foreach($_STOPS as $_STOP):
										?>
										<div class="marker trip_map_marker"
										data-num="<?php echo $_STOP['order']; ?>"
										data-lng="<?php echo $_STOP['location']['geoLocation']['longitude']; ?>"
										data-lat="<?php echo $_STOP['location']['geoLocation']['latitude']; ?>"
										></div>
										<?php
									endforeach;
								?>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>

		<?php

	}









	public static function CLEAR_CART(){

		self::CLEAR_RATALITY();
		WC()->cart->empty_cart();

	}








	public static function SET_RATALITY($_POSTED){

		if(function_exists('WC')):

			WC()->session->set_customer_session_cookie(true);
			WC()->session->set('ratality_pickup_location', $_POSTED['ratalityPickUpLocation']);
			WC()->session->set('ratality_dropoff_location', $_POSTED['ratalityDropOffLocation']);
			WC()->session->set('ratality_tickets', $_POSTED['ratalityTickets']);
			WC()->session->set('ratality_return', $_POSTED['ratalityReturn']);
			WC()->session->set('ratality_pickup_date', $_POSTED['ratalityPickUpDate']);
			WC()->session->set('ratality_dropoff_date', $_POSTED['ratalityDropOffDate']);

		endif;

	}








	public static function SAVE_RATALITY($_ORDER_ID){

		if(function_exists('WC')):

			update_post_meta($_ORDER_ID, 'ratality_pickup_location', WC()->session->get('ratality_pickup_location'));
			update_post_meta($_ORDER_ID, 'ratality_dropoff_location', WC()->session->get('ratality_dropoff_location'));
			update_post_meta($_ORDER_ID, 'ratality_tickets', WC()->session->get('ratality_tickets'));
			update_post_meta($_ORDER_ID, 'ratality_return', WC()->session->get('ratality_return'));
			update_post_meta($_ORDER_ID, 'ratality_pickup_date', WC()->session->get('ratality_pickup_date'));
			update_post_meta($_ORDER_ID, 'ratality_dropoff_date', WC()->session->get('ratality_dropoff_date'));
			update_post_meta($_ORDER_ID, 'ratality_selected_trip_one', WC()->session->get('ratality_selected_trip_one'));
			update_post_meta($_ORDER_ID, 'ratality_selected_trip_two', WC()->session->get('ratality_selected_trip_two'));
			update_post_meta($_ORDER_ID, 'ratality_passengers', WC()->session->get('ratality_passengers'));
			update_post_meta($_ORDER_ID, 'ratality_ticket_information', WC()->session->get('ratality_ticket_information'));

		endif;

	}








	public static function CLEAR_SELECTED(){

		if(function_exists('WC')):

			WC()->session->__unset('ratality_selected_trip_one');
			WC()->session->__unset('ratality_selected_trip_two');
			WC()->session->__unset('ratality_passengers');
			WC()->session->__unset('ratality_ticket_information');

		endif;
	}








	public static function CLEAR_RATALITY(){

		if(function_exists('WC')):
			WC()->session->__unset('ratality_pickup_location');
			WC()->session->__unset('ratality_dropoff_location');
			WC()->session->__unset('ratality_tickets');
			WC()->session->__unset('ratality_return');
			WC()->session->__unset('ratality_pickup_date');
			WC()->session->__unset('ratality_dropoff_date');
			WC()->session->__unset('ratality_selected_trip_one');
			WC()->session->__unset('ratality_selected_trip_two');
			WC()->session->__unset('ratality_trips');
			WC()->session->__unset('ratality_passengers');
			WC()->session->__unset('ratality_ticket_information');
		endif;
	}









	/* LOCATIONS */
	public static function LOCATIONS(){

		$_LOCATIONS = RATALITY::LOCATIONS();


		$_RETURN = array();

		foreach($_LOCATIONS as $_LOC):
			$_RETURN[$_LOC['id']] = $_LOC['town'];
		endforeach;

		return $_RETURN;

	}






	/* TRIPS */
	public static function DOTRIPS($_TRIP_ONE, $_TRIP_TWO = false){

		WC()->session->set('ratality_trip_one_data', $_TRIP_ONE);
		WC()->session->set('ratality_trip_two_data', $_TRIP_TWO);

		$_RETURN = array();

		$_TRIP_ONE_DATA = RATALITY::TRIP($_TRIP_ONE);

		$_RETURN['TRIPONE'] = $_TRIP_ONE_DATA;

		if($_TRIP_TWO):
			$_TRIP_TWO_DATA = RATALITY::TRIP($_TRIP_TWO);

			$_RETURN['TRIPTWO'] = $_TRIP_TWO_DATA;
		endif;

		WC()->session->set('ratality_trips', $_RETURN);

		return $_RETURN;


	}




}




?>