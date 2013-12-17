/*$(document).ready(function() {
    var $header = $("#mainSearch"),
        $clone = $header.before($header.clone().addClass("clone"));

    $(window).on("scroll", function() {
        var fromTop = $("html,body").scrollTop();
        $(window).toggleClass("down", (fromTop > 400));
    });
});*/


$(document).ready(function() {

	$(window).on("scroll", function() {
		var fromTop = $("html, body").scrollTop();
		$("mainSearch").toggleClass("down", (fromTop > 249));

	});

});
