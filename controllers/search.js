/**
 * Created by jameshill on 5/27/15.
 */
//ajax call to $_GET['../controllers/jsoncontroller.php']

$(document).ready(function(){
	$( "#searchSubmit" ).submit(function( event ) {

		// Stop form from submitting normally
		event.preventDefault();

		var $form = $(this);
		var url = $form.attr("action");
		var data = $form.serialize();

		$.ajax({
			type: "GET",
			url: url,
			data: data,
			success: function(data) {
				$('#output').html(data);
			}
		});
	});
});



