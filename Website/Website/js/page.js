$(document).ready(function ($) {
	$(".table-row").click(function () {
		 window.open($(this).data("href"), $(this).data("target"));
	});
});