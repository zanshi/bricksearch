/*$(document).ready(function() {
    var $header = $("#mainSearch"),
        $clone = $header.before($header.clone().addClass("clone"));

    $(window).on("scroll", function() {
        var fromTop = $("html,body").scrollTop();
        $(window).toggleClass("down", (fromTop > 400));
    });
});*/




	function loadExtended(parent)
	{
	    var setID = parent.children[1].children[1].innerHTML;

	    console.log(setID);

	    if (parent.nextSibling.className == "row extendedResults") {
	        $( parent.nextSibling ).toggle();
	    } else {
	        $.get("extended.php", { id: setID })
	            .done(function (data) {
	                $(parent).after(data);
	                console.log("success");
	            });
	    }

	}
