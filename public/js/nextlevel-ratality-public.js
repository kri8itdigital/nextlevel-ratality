(function( $ ) {
	//'use strict';

	var map;
	var mapArgs;




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



	$(document).ready(function(){

		var $_DATE_MINIMUM = new Date();
	   	$_DATE_MINIMUM.setDate($_DATE_MINIMUM.getDate() + parseInt(ratality_params.booking_lead_time));
	   	var $_DATE_MINIMUM_VAL = $_DATE_MINIMUM.toISOString().substr(0, 10);

	   	$('#ratalityPickUpDate').val($_DATE_MINIMUM_VAL).attr('min', $_DATE_MINIMUM_VAL).trigger('update');

	   	var $_DATE_START = new Date(); 
	   	$_DATE_START.setDate($_DATE_MINIMUM.getDate() + parseInt(1));
      	var $_DATE_START_VAL = $_DATE_START.toISOString().substr(0, 10);

	   	$('#ratalityDropOffDate').val($_DATE_START_VAL).attr('min', $_DATE_START_VAL).trigger('update');

	   	$('#ratalityPickUpDate').on('change', function(){
	   		if($(this).val() != ''){
         		var $_DATE_START = new Date($(this).val()); 
         		$_DATE_START.setDate($_DATE_START.getDate() + parseInt(1));
         		var $_DATE_START_VAL = $_DATE_START.toISOString().substr(0, 10);
         		$('#ratalityDropOffDate').val($_DATE_START_VAL).attr('min', $_DATE_START_VAL).trigger('update');
         	}
	   	});

	   	$('#ratalityReturn').on('change', function(){

	   		if($(this).val() == 'yes'){
	   			$('#ratalityDropOffDate').removeClass('ratality_disabled');
	   		}else{
	   			$('#ratalityDropOffDate').addClass('ratality_disabled');
	   		}

	   	});

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
		            $('#ratalityLoader').removeClass('SHOWING');

		            if(response != 'busy'){
		            	window.location.href = response;
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
		            $('#ratalityLoader').removeClass('SHOWING');

		            if(response != 'busy'){
		            	window.location.href = response;
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
		            $('#ratalityLoader').removeClass('SHOWING');
		            window.location.href=response;
		        }
		    });

	  	});




	  	$('#ratalityTicketActionContinue').on('click', function(){

	  		var $_VALID = true;

	  	
	  		$(".ratality_ticket_block").each(function(){

	  			$(this).find('select').each(function(){

	  				if(!$(this).val() || $(this).val() == ''){
	  					$_VALID = false;
	  				}

	  			});

	  			$(this).find('input').each(function(){

	  				if(!$(this).val() || $(this).val() == ''){
	  					$_VALID = false;
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
			            $('#ratalityLoader').removeClass('SHOWING');
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


	});

})( jQuery );
