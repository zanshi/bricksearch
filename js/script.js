/*$(document).ready(function() {
    var $header = $("#mainSearch"),
        $clone = $header.before($header.clone().addClass("clone"));

    $(window).on("scroll", function() {
        var fromTop = $("html,body").scrollTop();
        $(window).toggleClass("down", (fromTop > 400));
    });
});*/

	
	$(window).scroll(function(event) {
		if($(window).scrollTop() >= 249) {
			$('.mainSearch').addClass('down');
			$('main').css("padding-top", "44px")
		} else {
			if($('.mainSearch').hasClass('down')) {
				$('main').css("padding-top", "0px");
				$('.mainSearch').removeClass('down');
			}
		}

	});
