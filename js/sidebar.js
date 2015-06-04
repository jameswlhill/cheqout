$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();

	$('#home').mouseenter(function () {
		$('#home').effect("bounce", {
			direction: 'right',
			times: 1
		}, 200);
	});
	$('#shop').mouseenter(function () {
		$('#shop').effect("bounce", {
			direction: 'right',
			times: 1
		}, 200);
	});
	$('#cart').mouseenter(function () {
		$('#cart').effect("bounce", {
			direction:'right',
			times: 1
		}, 200);
	});
	$('#acct').mouseenter(function () {
		$('#acct').effect("bounce", {
			direction:'right',
			times: 1
		}, 200);
	});
	$('#about').mouseenter(function () {
		$('#about').effect("bounce", {
			direction:'right',
			times: 1
		}, 200);
	});
});