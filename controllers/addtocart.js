/**
 * Created by jameshill on 6/2/15.
 */
$(document).ready(function(){
	$(".add").submit(function(event) {
		// Stop form from submitting normally
		event.preventDefault();

		var $form = $(this);
		var url = $form.attr("action");
		var data = $form.serialize();

		$.ajax({
			type: "POST",
			url: url,
			data: data,
			success: function(data) {
				$('#output').html(data);
				console.log(data);
			}
		});
	});
});