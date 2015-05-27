/**
 * Created by jameshill on 5/27/15.
 */
//ajax call to $_GET['../controllers/jsoncontroller.php']

$(document).ready(function(){
	$("#input").click(function(){
		$.getJSON( "jsoncontroller.php", function( data ) {
			var items = [];
			$.each( data, function( key, val ) {
				items.push( "<li id='" + key + "'>" + val + "</li>" );
			});

			$( "<ul/>", {
				"class": "resultlist",
				html: items.join( "" )
			}).appendTo( "body" );
		});
	});
});



