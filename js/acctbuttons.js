$(".openpanel1").on("click", function() {
	$("#panel1").collapse('show');
});
$(".openpanel2").on("click", function() {
	$("#panel2").collapse('show');
});
$(".openpanel3").on("click", function() {
	$("#panel3").collapse('show');
});
$(".openpanel4").on("click", function() {
	$("#panel4").collapse('show');
});
$('#update').on('show.bs.collapse', function () {
	$('#update .in').collapse('hide');
});
$(".closepanel1").on("click", function() {
	$("#panel1").collapse('hide');
});
$(".closepanel2").on("click", function() {
	$("#panel2").collapse('hide');
});
$(".closepanel3").on("click", function() {
	$("#panel3").collapse('hide');
});
$(".closepanel4").on("click", function() {
	$("#panel4").collapse('hide');
});