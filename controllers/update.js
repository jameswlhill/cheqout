/**
 * Created by jameshill on 6/5/15.
 */
$(document).ready(function(){
	$( "form.add" ).submit(function( event ) {

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
				var total = 0;
				$('.data-row').each(function(){
					total += $('.price', this).html() * $('.quantityField', this).html();
					console.log(total);
				})
				$('.total').html(total);
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