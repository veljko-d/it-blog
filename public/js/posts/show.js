// Please sign in
$(document).ready(function() {
    $("#plsi").click(function() {
        $(this).hide();
    });
});

// Show/hide font size
$(document).ready(function() {
    var szbtn = $("#sec1 div:last-child button");
    $("#show-size").click(function() {
        szbtn.fadeToggle(800);
        var span = $("#show-size span");
        if (span.text() == '◂') {
            span.text('▸');
        } else {
            span.text('◂');
        }
        return false;
    });
});

// Increase/decrease font size
$(document).ready(function() {
	var content = $('#pst-cnt');
	var defaultSize = content.css('fontSize');
	$('#sec1 div:last-child button').click(function() {
        var num = parseFloat(content.css('fontSize'));
        switch (this.id) {
            case 'increase':
                num *= 1.1;
                break;
            case 'decrease':
                num /= 1.1;
                break;
            default:
                num = parseFloat(defaultSize);
        }
        content.css('fontSize', num);
        // another way to do the same thing:
        //content.animate({fontSize: num}, 200);
    });
});

// Confirm post delete
$(document).ready(function() {
    $("#p-del").click(function() {
        return confirm('Are you sure you want to delete this post?');
    });
});

// Confirm post edit
$(document).ready(function() {
    $("#p-edit").click(function() {
        return confirm('Edit post?');
    });
});

// Show/hide comment section
$(document).ready(function() {
    var cs = $("#comment-section");
    $("#comm").click(function() {
        cs.animate({height: 'toggle'}, 1000);
        var comm = $(this);
        if (comm.text() == 'Hide comment section ▴') {
            comm.text('Show comment section ▾');
        } else {
            comm.text('Hide comment section ▴');
        }
        return false;
    });
});

//Validate comment form
function validateForm() {
    var content = document.forms["comment"]["content"].value;
    var val_info = document.getElementById("val-info");

    if (content == "") {
        val_info.innerHTML = "Comment cannot be empty.";
        return false;
    }
}
