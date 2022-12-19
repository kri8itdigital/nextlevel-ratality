<?php




class RATALITY{






	public static function DOCALL($_ENDPOINT, $_PARAMS = array()){

		$_URL = get_field('ratality_api_url','option');
		$_KEY = get_field('ratality_api_key','option');

		$_URL = trailingslashit(trailingslashit($_URL).$_ENDPOINT);


		$_ARGS = array(
		    'method' => 'GET',
		    'timeout' => 600,
		    'headers' => array(
		        'Content-Type' => 'application/json',
		        'Accept' => 'application/json',
		        'THEONERINGTORULETHEMALL' => $_KEY
		    )
		);

		if(count($_PARAMS) > 0):
			$_ARGS['method'] = 'POST';
			$_ARGS['body'] = json_encode($_PARAMS, JSON_NUMERIC_CHECK);
		endif;

		$_RETURN = wp_remote_post($_URL, $_ARGS);
		
		$_RESPONSE = json_decode($_RETURN['body'], true);

		return $_RESPONSE;


	}






	public static function LOCATIONS(){

		$_ENDPOINT = 'locations';

		$_LOCATIONS = self::DOCALL($_ENDPOINT);


		if(isset($_LOCATIONS['status']) && $_LOCATIONS['status'] == 'success'):

			return $_LOCATIONS['locations'];

		endif;

		return false;

	}






	public static function TRIP($_PARAMS){

		$_ENDPOINT = 'trip';

		$_TRIPS = self::DOCALL($_ENDPOINT, $_PARAMS);

		if(isset($_TRIPS['status']) && $_TRIPS['status'] == 'success'):

			return $_TRIPS['trips'];

		endif;

		return false;
		
	}







	public static function BOOKING($_ORDER_ID){

		$_ENDPOINT = 'reservation';

		$_TITLE = get_field('ratality_reference_prefix', 'option');

		$_TICKET_DATA = get_post_meta($_ORDER_ID, 'ratality_ticket_information', true);

		$_THE_DATA_TO_SEND = array();

		$_POST_DATA = array(
			'thirdPartyReference' => $_TITLE.'-'.$_ORDER_ID,
			'trips' => array()
		);

		$_ADDED_TRIPS = array();

		/* CREATE AN ARRAY OF TRIPS */
		foreach($_TICKET_DATA as $_TICKET):

			$_TRIP = $_TICKET['trip'];

			if(!in_array($_TRIP['tripId'], $_ADDED_TRIPS)):
				$_TRIP_ITEM = array('tripId' => $_TRIP['tripId'], 'tickets' => array());
				$_POST_DATA['trips'][] = $_TRIP_ITEM;
				$_ADDED_TRIPS[] = $_TRIP['tripId'];
			endif;

		endforeach;

		/* ADD PASSENGERS TO TRIPS */
		$_COUNT = 1;
		foreach($_TICKET_DATA as $_TICKET):

			$_TRIP = $_TICKET['trip'];
			$_PASS = $_TICKET['passenger'];

			$_ID_TYPE = false;

			switch($_PASS['documentType']):

				case "ID":
					$_ID_TYPE = "SOUTH_AFRICAN_ID";
				break;
				
				case "ID":
					$_ID_TYPE = "SOUTH_AFRICAN_ID";
				break;
				
				case "ID":
					$_ID_TYPE = "SOUTH_AFRICAN_ID";
				break;

			endswitch;

			$_ITEM_NO = str_pad($_COUNT, 2, '0', STR_PAD_LEFT);			

			$_INFANT_TRAVEL = false;

			if($_PASS['travellingInfant'] == 'yes'):
				$_INFANT_TRAVEL = true;
			endif;

			$_THIS_PASSENGER = array( 
				'thirdPartyReference' => $_TITLE.'-'.$_ORDER_ID.'-'.$_ITEM_NO, 
				'passenger' => array(
					"title" => $_PASS['title'],
		            "name" => $_PASS['name'],
		            "surname" => $_PASS['surname'],
		            "mobileNumber" => array(
		              "number" => strval($_PASS['mobileNumber'])
		            ),
		            "ageGroup" => $_PASS['ageGroup'],
		            "gender" => $_PASS['gender'],
		            "dateOfBirth" => date('Y-m-d', strtotime($_PASS['dateOfBirth'])),
		            "email" => $_PASS['email'],
		            "infantTravelling" => $_INFANT_TRAVEL,
					"identityDocument" => array(
		              "documentType" => $_PASS['documentType'],
		              "number" => strval($_PASS['documentNumber'])
		            ),
		            "emergencyContact" => array(
		            	"name" => $_PASS['emergencyContactName'],
		            	"contactNumber" => array(
		            		"number" => strval($_PASS['emergencyContactNumber'])
		            	)
		             )
				),
	          	"ticketPrice" => array(
	          		"value" => $_TRIP['price']['value'],
	          		"currency" => "ZAR"
	          	) 
			);

			foreach($_POST_DATA['trips'] as &$_A_TRIP):

				if((int)trim($_A_TRIP['tripId']) == (int)trim($_TRIP['tripId'])):

					$_A_TRIP['tickets'][] = $_THIS_PASSENGER;

				endif;

			endforeach;
			
			$_COUNT++;


		endforeach;

		$_THE_DATA_TO_SEND['reservation'] = $_POST_DATA;
		$_THE_DATA_TO_SEND['json'] = json_encode($_POST_DATA);
		$_THE_DATA_TO_SEND['tickets'] = $_TICKET_DATA;

		update_post_meta($_ORDER_ID, 'ratality_post_data_sorted', $_THE_DATA_TO_SEND);
		update_post_meta($_ORDER_ID, 'ratality_post_data_json', json_encode($_POST_DATA));

	
		$_RESPONSE = self::DOCALL($_ENDPOINT, $_THE_DATA_TO_SEND);

		update_post_meta($_ORDER_ID, 'ratality_post_data_response', $_RESPONSE);


		$_FAILURE = false;

		if(isset($_RESPONSE['status']) && $_RESPONSE['status'] == 'success'):

			$_RES_NO = $_RESPONSE['reservation'];

			update_post_meta($_ORDER_ID, 'ratality_reservation_no', $_RES_NO);

			self::PAYMENT($_ORDER_ID, $_TICKET_DATA);

		else:

			update_post_meta($_ORDER_ID, 'ratality_error', $_RESPONSE['errors']);

        	$_FAILURE = true;

		endif;

		/* DO WOO EMAIL NOTIFICATIONS */
        $_WOO_EMAILS = WC()->mailer()->get_emails();
        //$_WOO_EMAILS['WC_Email_New_Order']->trigger( $_ORDER_ID );
        //$_WOO_EMAILS['WC_Email_Customer_Completed_Order']->trigger( $_ORDER_ID );

        if($_FAILURE):

        //	self::DOFAILUREEMAIL($_ORDER_ID, $_PARAMS, $_RESPONSE['errors']);

        endif;
		

	}








	public static function PAYMENT($_ORDER_ID){

		$_ENDPOINT = "payment";
		
		$_THE_ORDER = new WC_Order($_ORDER_ID);

		$_MAIN_PASSENGER_EMAIL = $_THE_ORDER->get_billing_email();
		$_MP = false;

		$_PASSENGERS = get_post_meta($_ORDER_ID, 'ratality_passengers', true);

		foreach($_PASSENGERS as $_P):

			if($_P['email'] == $_MAIN_PASSENGER_EMAIL):
				$_MP = $_P;
				break;
			endif;

		endforeach;		

		$_RESERVATION = get_post_meta($_ORDER_ID, 'ratality_reservation_no', true);

		$_PAYMENT_DATE = $_THE_ORDER->get_date_created();

		$_PAYMENT = array(
			"payer" => array(
				"ageGroup" => $_MP['ageGroup'],
    			"dateOfBirth" => date('Y-m-d', strtotime($_MP['dateOfBirth'])),
				"email" => $_MP['email'],
			    "gender" => $_MP['gender'],
			    "identityDocument" => array(
			      "documentType" => $_MP['documentType'],
			      "number" => strval($_MP['documentNumber'])
			    ),
			    "mobileNumber" => array(
			      "number" => strval($_MP['mobileNumber'])
			    ),
			    "name" => $_MP['name'],
			    "surname" => $_MP['surname'],
			),
			"paymentMethod" => array(
				"paymentType" => "PAYMENT_GATEWAY",
				"paymentDate" => $_PAYMENT_DATE->date_i18n("Y-m-d\TH:i:s"),
      			"paymentReference" => $_THE_ORDER->get_transaction_id(), 
				"total" => array(				
				"currency" => "ZAR",
			        "value" => (float)$_THE_ORDER->get_total()
				)
			)
		);

		$_DATA = array('reservation' => $_RESERVATION, 'payment' => $_PAYMENT, 'json' => json_encode($_PAYMENT));

		update_post_meta($_ORDER_ID, 'ratality_post_data_payment', $_DATA);
		
		$_RESPONSE = self::DOCALL($_ENDPOINT, $_DATA);

		if(isset($_RESPONSE['status']) 
			&& $_RESPONSE['status'] == 'success' 
			&& isset($_RESPONSE['message'])
			&& $_RESPONSE['message'] == 'Payment Successful'
		):

			update_post_meta($_ORDER_ID, 'ratality_paid', 'Yes');

		else:

			update_post_meta($_ORDER_ID, 'ratality_paid', 'Yes');

		endif;
		


	}








	public static function DOFAILUREEMAIL($_ORDER_ID, $_DATA, $_ERRORS, $_TYPE = 'admin' ){

		switch($_TYPE):
			case "admin":
				$_TITLE = 'RATALITY ERROR';
				$_SUBJECT = 'RATALITY RESERVATION ERROR ('.$_ORDER_ID.')';

				$_FROM_E = get_option('woocommerce_email_from_address');
				$_FROM_N = get_bloginfo('name');

				$_TO = WC()->mailer()->get_emails()['WC_Email_New_Order']->recipient;


				$_HEADERS = array(
			    	'From: '.$_FROM_N.' <'.$_FROM_E.'>'
				);

				$_MAILER = WC()->mailer();
				$_CONTENT = '<h2>ORDER: '.$_ORDER_ID.'</h2>';
				$_CONTENT .= '<h2>ERRORS:</h2>';
				$_CONTENT .= '<ul><li>'.implode('</li><li>', $_ERRORS).'</li></ul>';
			break;

			case "customer":
			break;

		endswitch;





		$_FILE = 'emails/ratalityemail.php';

		$_FORMATTED =  wc_get_template_html( $_FILE, 
			array(
				'email_heading' => $_TITLE,
				'msg_copy'		=> $_CONTENT,
				'sent_to_admin' => false,
				'plain_text'    => false,
				'email'         => $_MAILER
			) 
		);

		$_MAILER->send( $_TO, $_SUBJECT, $_FORMATTED, $_HEADERS );
	}













}




?>