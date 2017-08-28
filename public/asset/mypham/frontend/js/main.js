$('.nailthumb').nailthumb({method:'crop', fitDirection:'center center'});

$(document).ready(function(){
    $(".login").click(function(){
        $("#home").addClass('active');
        $("#li-home").addClass('active');
        $("#profile").removeClass('active');
        $("#li-profile").removeClass('active');
        $("#myModal").modal();
    });

    $(".sign-up").click(function(){
        $("#home").removeClass('active');
        $("#li-home").removeClass('active');
        $("#profile").addClass('active');
        $("#li-profile").addClass('active');
        $("#myModal").modal();
    });

    $(".j-show-cart").click(function(){
        $("#cart").modal();
    });

    $(".add-cart").click(function(){
        $("#cart").modal();
    });

    $(".dropdown").hover(
        function() { $('.dropdown-menu', this).stop().fadeIn("fast");
        },
        function() { $('.dropdown-menu', this).stop().fadeOut("fast");
    });
});


