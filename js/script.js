/*$(document).ready(function() {
    var $header = $("#mainSearch"),
        $clone = $header.before($header.clone().addClass("clone"));

    $(window).on("scroll", function() {
        var fromTop = $("html,body").scrollTop();
        $(window).toggleClass("down", (fromTop > 400));
    });
});*/

	
	$(window).scroll(function(event) {
		console.log($(window).scrollTop());
		if($(window).scrollTop() >= 249) {
			$('.mainSearch').addClass('.down');
		} else {
			if($('.mainSearch').hasClass('.down')) {
				$('.mainSearch').removeClass('.down');
			}
		}

	});
