/**
 * Created by jameshill on 6/5/15.
 */
$(document).ready(function(){
	$( "form" ).submit(function( event ) {

		// Stop form from submitting normally
		event.preventDefault();

		var $form = $(this);
		var url = $form.attr("action");
		var data = $form.serialize();
		var productId = $form.serializeArray()[3]['value'];
		$.ajax({
			type: "POST",
			url: url,
			data: data,
			success: function(data) {
				$('#' + productId + ' .quantityField').html(data);
			}
		});

		$.ajax({
			type: "GET",
			url: "../lib/generatecsrf.php",
			success: function(data) {
				$('.csrf').html(data);
			}
		});
	});

});