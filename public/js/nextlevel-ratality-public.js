(function( $ ) {
	//'use strict';

	var map;
	var mapArgs;


	const monthARRAY = [
	  'January',
	  'February',
	  'March',
	  'April',
	  'May',
	  'June',
	  'July',
	  'August',
	  'September',
	  'October',
	  'November',
	  'December'
	];




	/* MAP FUNCTIONS */
	var infoWindows = [];

	function initMarker( $marker, map ) {

	    // Get position from marker.
	    var lat = $marker.data('lat');
	    var lng = $marker.data('lng');
	    var num = $marker.data('num');

	    myLatLng = new google.maps.LatLng(parseFloat( lat ), parseFloat( lng )); 

	    var marker = new HTMLMapMarker({
	      position: myLatLng,
	      latlng: myLatLng,
	      map: map,
	      html: '<div class="ratality_map_marker">'+num+'</div>'
	    });

	    // Append to reference for later use.
	    map.markers.push( marker );

	    // If marker contains HTML, add it to an infoWindow.
	    if( $marker.html() ){

	        // Create info window.
	        var infowindow = new google.maps.InfoWindow({
	            content: $marker.html()
	        });

	        // Show info window when marker is clicked.
	        google.maps.event.addListener(marker, 'click', function() {
	            infowindow.open( map, marker );
	        });
	    }
	}


	/**
	 * centerMap
	 *
	 * Centers the map showing all markers in view.
	 *
	 * @date    22/10/19
	 * @since   5.8.6
	 *
	 * @param   object The map instance.
	 * @return  void
	 */
	function centerMap( map ) {

	    // Create map boundaries from all map markers.
	    
	    var bounds = new google.maps.LatLngBounds();
	    map.markers.forEach(function( marker ){
	        bounds.extend({
	            lat: marker.position.lat(),
	            lng: marker.position.lng()
	        });
	    });
	    
	    // Case: Single marker.
	    if( map.markers.length === 1 ){
	        map.setCenter( bounds.getCenter() );

	    // Case: Multiple markers.
	    } else{
	        map.fitBounds( bounds );
	    }
	}


	  function initMap( $el ) {

	    // Find marker elements within map.
	    var $markers = $el.find('.marker');
	    var $coords = null;

	    if($el.data('lat') && $el.data('lng') ){
	        $coords = new google.maps.LatLng($el.data('lat'), $el.data('lng'));
	    }else{
	        $coords = new google.maps.LatLng(0, 0);
	    }
	    
	    mapArgs = {
	        zoom        : $el.data('zoom') || 12,
	        center: $coords,
	          scaleControl: true,
	          streetViewControl: false,
	          mapTypeControl: false,
	          panControl: false,
	          zoomControl: true,
	          scrollwheel: false,
	          draggable: true,
	          zoomControlOptions: {
	            style: google.maps.ZoomControlStyle.SMALL
	          }
	    };

	    var map = new google.maps.Map( $el[0], mapArgs );

	    // Add markers.
	    map.markers = [];
	    $markers.each(function(){
	        initMarker( $(this), map );
	    });

	    // Center map based on markers.
	    centerMap( map );

	    // Return map instance.
	    return map;
	}




	function nl_utility_set_timer_session_storage(){

		var today = new Date();

		var start_date = today.getFullYear() + '-' + (today.getMonth()+1) + '-' + today.getDate();
		var start_time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
		var start_date_time = start_date + ' ' + start_time;

		window.sessionStorage.setItem("ratality_search_start", start_date_time);

		now = new Date(today.getTime() + ratality_params.booking_timer_minutes*60000);
		var end_date = now.getFullYear() + '-' + (now.getMonth()+1) + '-' + now.getDate();
		var end_time = now.getHours() + ":" + now.getMinutes() + ":" + now.getSeconds();
		var end_date_time = end_date + ' ' + end_time;

		if(window.sessionStorage.getItem("ratality_search_cleaned")){
			window.sessionStorage.removeItem("ratality_search_cleaned");
		}

		window.sessionStorage.setItem("ratality_search_end", end_date_time);
		window.sessionStorage.setItem("ratality_search_end_int", now.getTime());

	}





	function nl_utility_clear_timer_session_storage(){

		if(window.sessionStorage.getItem("ratality_search_start")){
			window.sessionStorage.removeItem("ratality_search_start");
		}

		if(window.sessionStorage.getItem("ratality_search_end")){
			window.sessionStorage.removeItem("ratality_search_end");
		}

		if(window.sessionStorage.getItem("ratality_search_end_int")){
			window.sessionStorage.removeItem("ratality_search_end_int");
		}

		window.sessionStorage.setItem("ratality_search_cleaned", 'yes');
	}




	function nl_utility_check_timer_session_storage(){

		if(window.sessionStorage.getItem("ratality_search_end_int")){
			
				var rightNow = new Date();
				var rightNow = rightNow.getTime();

				if(rightNow > window.sessionStorage.getItem("ratality_search_end_int")){
					return true;
				}

		}

		if(!window.sessionStorage.getItem("ratality_search_start")){
			return true;
		}



		return false;


	}



	$(document).ready(function(){


		var REGULARARGS = {
			changeMonth: true,
      changeYear: true,
      firstDay: 1,
      yearRange: "c-100:c"			
		}

		$('.ratality_DOB').each(function(){ $(this).datepicker( REGULARARGS );});


		var DROPOFFARGS = {
            minDate: parseInt(ratality_params.booking_lead_time) + parseInt(1),
            startDate: parseInt(ratality_params.booking_lead_time) + parseInt(1),
            dateFormat: 'dd MM yy',
            changeMonth: true,
            changeYear: true,
            firstDay: 1
        };

      $('#ratalityDropOffDate').datepicker( DROPOFFARGS );


		var PICKUPARGS = {
          minDate: parseInt(ratality_params.booking_lead_time),
          dateFormat: 'dd MM yy',
          changeMonth: true,
          changeYear: true,
          firstDay: 1,
          onSelect: function(date){
            $_DATE_START = new Date(date); 
            $_DATE_START.setDate($_DATE_START.getDate() + parseInt(1));
            $_DATE_START_VAL = $_DATE_START.getDate() + ' ' + monthARRAY[$_DATE_START.getMonth()] + ' ' + $_DATE_START.getFullYear();
            $('#ratalityDropOffDate').datepicker( "option", "minDate", $_DATE_START );
            $('#ratalityDropOffDate').val($_DATE_START_VAL).trigger('change'); 
                 
          }
        };

      $('#ratalityPickUpDate').datepicker( PICKUPARGS );

      $('#ratalityPickUpDate').datepicker('setDate', parseInt(ratality_params.booking_lead_time));
      $('#ratalityDropOffDate').datepicker('setDate', parseInt(ratality_params.booking_lead_time) + parseInt(1));

	   	$('#ratalityPickUpLocation').select2({dropdownParent: $('#RATALITYSEARCHCONTAINER') });
      $('#ratalityDropOffLocation').select2({dropdownParent: $('#RATALITYSEARCHCONTAINER') });
      $('#ratalityTickets').select2({dropdownParent: $('#RATALITYSEARCHCONTAINER') , minimumResultsForSearch: -1});
      $('#ratalityReturn').select2({dropdownParent: $('#RATALITYSEARCHCONTAINER') , minimumResultsForSearch: -1});

	   	$('#ratalityReturn').on('change', function(){

	   		if($(this).val() == 'yes'){
	   			$('#ratalityDropOffDate').removeClass('ratality_disabled');
	   		}else{
	   			$('#ratalityDropOffDate').addClass('ratality_disabled');
	   		}

	   	});


	   	/* SET TIMER IF A SEARCH HAS HAPPENED */
      if(ratality_params.enable_timer == 'yes'){
      	$_TIMER = setInterval(ratalityOrderTimeout, 1000);
      }



	  	$('#RATALITYSEARCHACTION').on('click', function(){

	  		var $_ERRORS = '';

        	if(!$('#ratalityPickUpLocation').val() || $('#ratalityPickUpLocation').val() == ''){
         		$_ERRORS+= '<br/><br/><em>No pick-up location selected';
        	}

        	if(!$('#ratalityDropOffLocation').val() || $('#ratalityDropOffLocation').val() == ''){
         		$_ERRORS+= '<br/><br/><em>No drop-off location selected';
        	}

        	if(!$('#ratalityPickUpDate').val() || $('#ratalityPickUpDate').val() == ''){
         		$_ERRORS+= '<br/><br/><em>No pick-up date selected';
        	}

        	if($('#ratalityReturn').val() == 'yes'){
	        	if(!$('#ratalityDropOffDate').val() || $('#ratalityDropOffDate').val() == ''){
	         		$_ERRORS+= '<br/><br/><em>No drop-off date selected';
	        	}
	    	}


	    	if($_ERRORS.length > 0){

	    		jQuery.confirm({
		            title: 'Search Error',
		            content: 'Apologies, there seems to be some issues with your search: '+$_ERRORS,
		            //type: 'blue',
		            theme: 'black',
		            buttons: {
		                ok: {
		                    text: "Ok, I Understand"
		                }
		            }
		        });

		    }else{
		    	
			   	var ajax_data = {
		        	action: 'ratality_ajax_do_search',
		        	data: $('#RATALITYSEARCHFORM').serialize()
		      	};

		      jQuery.ajax({
		         url: ratality_params.ajax_url,
		         type:'POST',
		         data: ajax_data,
		         beforeSend:function(){
		            jQuery('#ratalityLoader').addClass('SHOWING');
		         },
		         success: function (url) {

		         	  if(ratality_params.enable_timer == 'yes'){
		         	  	nl_utility_set_timer_session_storage();
		         		}

		            window.location.href = url;
		         }
		      });
		      

		   }

	  	});



	  	$('.route_one_select').on('click', function(){

	    	$(this).closest('.trip_item').addClass('selected_trip_one_item');
	    	var $_TRIP 	= $(this).attr('data-trip');
	    	var $_ROUTE = $(this).attr('data-route');

	    	var ajax_data = {
	        	action: 'ratality_ajax_select_trip',
	        	type: 'one',
	        	trip: $_TRIP,
	        	route: $_ROUTE
	      	};

	      	jQuery.ajax({
		        url: ratality_params.ajax_url,
		        type:'POST',
		        data: ajax_data,
		        beforeSend:function(){
		            $('#ratalityLoader').addClass('SHOWING');
		        },
		        success: function (response) {
		        	//console.log(response);
		        	$('.route_one_select').each(function(){ $(this).addClass('inactive')});
		            

		            if(response != 'busy'){
		            	window.location.href = response;
		            }else{
		            	$('#ratalityLoader').removeClass('SHOWING');
		            }
		        }
		    });
	  		
	  	});


	  	$('.route_two_select').on('click', function(){

	    	$(this).closest('.trip_item').addClass('selected_trip_two_item');
	    	var $_TRIP 	= $(this).attr('data-trip');
	    	var $_ROUTE = $(this).attr('data-route');

	    	var ajax_data = {
	        	action: 'ratality_ajax_select_trip',
	        	type: 'two',
	        	trip: $_TRIP,
	        	route: $_ROUTE
	      	};

	      	jQuery.ajax({
		        url: ratality_params.ajax_url,
		        type:'POST',
		        data: ajax_data,
		        beforeSend:function(){
		            $('#ratalityLoader').addClass('SHOWING');
		        },
		        success: function (response) {
		        	//console.log(response);
		        	$('.route_two_select').each(function(){ $(this).addClass('inactive')});
		            
		            if(response != 'busy'){
		            	window.location.href = response;
		            }else{
		            	$('#ratalityLoader').removeClass('SHOWING');
		            }
		        }
		    });

	  	});




	  	$('#ratalityTicketActionBack').on('click', function(){

	  		var ajax_data = {
	        	action: 'ratality_ajax_destroy_tickets'
	      	};

	  		jQuery.ajax({
		        url: ratality_params.ajax_url,
		        type:'POST',
		        data: ajax_data,
		        beforeSend:function(){
		            $('#ratalityLoader').addClass('SHOWING');
		        },
		        success: function (response) {
		            window.location.href=response;
		        }
		    });

	  	});




	  	$('#ratalityTicketActionContinue').on('click', function(){

	  		$('.ratality_error').each(function(){
	  			$(this).removeClass('ratality_error');
	  		});

	  		var $_VALID = true;

	  	
	  		$(".ratality_ticket_block").each(function(){

	  			$(this).find('select').each(function(){

	  				if(!$(this).val() || $(this).val() == ''){
	  					$_VALID = false;
	  					$(this).addClass('ratality_error');
	  				}

	  			});

	  			$(this).find('input').each(function(){

	  				if(!$(this).val() || $(this).val() == ''){
	  					$_VALID = false;
	  					$(this).addClass('ratality_error');
	  				}

	  			});
	  		});

	  		if($_VALID){

		  		var ajax_data = {
		        	action: 'ratality_ajax_create_tickets',
		        	tickets: $('#ratalityTicketDetails').serialize()
		      	};

		  		jQuery.ajax({
			        url: ratality_params.ajax_url,
			        type:'POST',
			        data: ajax_data,
			        beforeSend:function(){
			            $('#ratalityLoader').addClass('SHOWING');
			        },
			        success: function (response) {
			            window.location.href=response;
			        }
			    });

		  	}else{

		  		jQuery.confirm({
		            title: 'Passenger Error',
		            content: 'Apologies, all fields are required. Kindly make sure they are all filled in correctly',
		            //type: 'blue',
		            theme: 'black',
		            buttons: {
		                ok: {
		                    text: "Ok, I Understand"
		                }
		            }
		        });

		  	}
	  		
	  	});






	  	jQuery('.TRIP_MAP_TOGGLE').on('click', function(){

	  		$_TRIPSTOPS = jQuery(this).closest('.trip_item').find('.TRIPSTOPS');

	  		$_TRIPSTOPS.slideToggle('fast', function(){

	  			jQuery('.RATALITY_MAP').each(function(){

	  				$_MAP = $_TRIPSTOPS.find('.RATALITY_MAP');

	  				if(!$_MAP.hasClass('loaded')){
				  		initMap($_MAP);
				  		$_MAP.addClass('loaded');
				  	}

			  	});

	  		});

	  	});




	  	jQuery('#ratalityPaymentCancel').on('click', function(){

	  		var ajax_data = {
        	action: 'ratality_ajax_destroy_everything'
      	};

      	jQuery.ajax({
			        url: ratality_params.ajax_url,
			        type:'POST',
			        data: ajax_data,
			        beforeSend:function(){
			            $('#ratalityLoader').addClass('SHOWING');
			        },
			        success: function (response) {
			            window.location.href=response;
			        }
			    });

	  	});


	});



	

	/* ORDER TIMEOUT */
  function ratalityOrderTimeout(){

    if(jQuery('body').hasClass('woocommerce-order-received') || nl_utility_check_timer_session_storage()){

      clearInterval($_TIMER);

      jQuery('#ratalityTimerText').html('');
      jQuery('#topBarTimer').html('');
      jQuery('#ratalityTimer').removeClass('showing');

      var ajax_data = {
        action: 'ratality_ajax_reset_search',
        object_id: ratality_params.utility_queried_object_id
      };

      jQuery.ajax({
        url: ratality_params.ajax_url,
        type:'POST',
        data: ajax_data,
        beforeSend:function(){

			            
			  },
        success:function(response){

        	nl_utility_clear_timer_session_storage();

        	if(response != 'donothing'){
        		jQuery('#ratalityTimer').addClass('showing');
        		setTimeout(function(){ window.location.href = response; }, 1000);
        		
        	}

        }
      });

    }else{
    		if(window.sessionStorage.getItem('ratality_search_end')){
        $_END = new Date(window.sessionStorage.getItem('ratality_search_end').replace(/-/g, '/'));
        $_NOW = new Date();
        var $_LEFT = $_END - $_NOW;

        var days = Math.floor($_LEFT / (1000 * 60 * 60 * 24));
        var hours = Math.floor(($_LEFT % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor(($_LEFT % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor(($_LEFT % (1000 * 60)) / 1000);

        var orig_minute = minutes;
        var orig_seconds = seconds;

        if(minutes < 10){ minutes = '0'+minutes; }
        if(seconds < 10){ seconds = '0'+seconds; }

        $_TIMETEXT = minutes+':'+seconds;

        jQuery('#ratalityTimerText').html($_TIMETEXT);
        jQuery('#topBarTimer').html($_TIMETEXT);
        jQuery('#ratalityTimer').addClass('showing');


        if((orig_minute < 0 && orig_seconds < 0) || (parseInt(orig_minute) <= 0 && parseInt(orig_seconds) <= 0) ){

          clearInterval($_TIMER);
          jQuery('#ratalityTimer').removeClass('showing');

          var ajax_data = {
            action: 'ratality_ajax_reset_search',
          };

           jQuery.ajax({
              url: ratality_params.ajax_url,
              type:'POST',
              data: ajax_data
          });

          jQuery.confirm({
              title: ratality_params.booking_session_title,
              content: ratality_params.booking_session_text,
              theme: 'black',
              buttons: {
                  ok: {
                      text: ratality_params.booking_session_button,
                      action: function(){

                      	nl_utility_clear_timer_session_storage();
                        window.location.href = ratality_params.booking_session_link;

                      }
                  }
              },
              autoClose: 'ok|'+ratality_params.booking_session_time,
          });

      	}

      }
     }
}




})( jQuery );
