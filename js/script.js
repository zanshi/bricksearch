/*$(document).ready(function() {
    var $header = $("#mainSearch"),
        $clone = $header.before($header.clone().addClass("clone"));

    $(window).on("scroll", function() {
        var fromTop = $("html,body").scrollTop();
        $(window).toggleClass("down", (fromTop > 400));
    });
});*/

$(document).ready(function($) {
	
	var initalPos = $(".mainSearch").offset().top;

	$(window).scroll(function(event) {

		if(parseInt($(window).scrollTop()) > (initalPos - 10)) {

			$('.mainSearch').addClass('down');
			$('main').css("padding-top", "44px");

		} else {

			if($('.mainSearch').hasClass('down')) {

				$('main').css("padding-top", "0px");
				$('.mainSearch').removeClass('down');

			}
		}

	});

});
