// close status message
$(document).ready(function(){
    $("#status span").click(function(){
        $("#status").fadeOut("slow");
    });
});

// Hover effect for header span elements
// Two inner functions: inFunction, outFunction
$(document).ready(function(){
    var span = $("header p span");

    $("header").hover(function(){
        span.css({
            "color": "#e0301e",
            "padding": "0em 1em"
        });
        }, function(){
        span.css({
            "color": "white",
            "padding": "0em 0em"
        });
    });
});

/* Toggle between adding and removing the "responsive" class to topnav when
    the user clicks on the icon */
function collapseNav() {
    var x = document.getElementById("myTopnav");

    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}
