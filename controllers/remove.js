/**
 * Created by jameshill on 6/5/15.
 */
$(document).ready(function() {
	$("form.remove").submit(function(event) {

		// Stop form from submitting normally
		event.preventDefault();

		console.log('remove fired');

		var $form = $(this);
		var url = $form.attr("action");
		var data = $form.serialize();
		var productId = $form.serializeArray()[0]['value'];

		$.ajax({
			type: "GET",
			url: url,
			success: function(data) {
				$('#' + productId).remove();
				var total = 0;
				$('.data-row').each(function(){
					total += $('.price', this).html() * $('.quantityField', this).html();
					console.log(total);
				});
				$('.total').html(total);
			}
		});
	});
});

