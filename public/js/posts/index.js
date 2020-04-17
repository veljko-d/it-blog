// Hover effect for li buttons
$(document).ready(function(){
    $("#main div:first-child #categories a").hover(function(){
        $(this).css("margin-left", "3em");
        }, function(){
        $(this).css("margin-left", "2em");
    });
});

// More/less text function
$(document).ready(function() {
	var truncLength = 300;

	$('.pst-cnt').each(function() {
	    var content = $(this).html();

	    if (content.length > truncLength) {
	        var partOne = content.substr(0, truncLength);
	        var partTwo = content.substr(truncLength);

            var html = [
    	        partOne,
    	        '<span class="ell">&hellip; </span>',
    	        '<span class="part-two">' + partTwo + ' </span>',
    	        '<span class="mr-ls">more</span>'
    	    ].join('');

            $(this).html(html);
            $('.part-two').addClass('hidden');
		}
	});

	$('.mr-ls').click(function() {
		var parent = $(this).parent();
		var partTwo = parent.find('.part-two');
		var ellipses = parent.find('.ell');

        if($(this).text() == 'less') {
			$(this).text('more');
			partTwo.addClass('hidden');
			ellipses.removeClass('hidden');
		} else {
			$(this).text('less');
			partTwo.removeClass('hidden');
			ellipses.addClass('hidden');
		}
	});
});

// sort form submit
function sortFunc() {
	var x = document.getElementById("sort_opt").value;
	document.getElementById("sortForm").submit();
}
