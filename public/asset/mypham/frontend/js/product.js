$(document).ready(function() {
    $("#show-cart-info").click(function(){
        $("#cart").modal();
    });

    get($('#vote-list'));
    get($('#faq-list'));
});

function get(target) {
    $.ajax({
        type: "get",
        url: target.data('url'),
        dataType : "html",
        ContentType : 'application/x-www-form-urlencoded; charset=utf-8',
        success: function(data)
        {
            target.append(data); // show response from the php script.
        }
    });
}

$("#vote").submit(function(e) {
    $.ajax({
        type: "post",
        url: $(this).data('action'),
        data: $(this).serialize(), // serializes the form's elements.
        success: function(data)
        {
            $('#vote').get(0).reset();
            $('#vote-callback').show(); // show response from the php script.
            setTimeout(function() {
                $('#vote-callback').hide();
            }, 10000);
        }
    });

    e.preventDefault(); // avoid to execute the actual submit of the form.
    return false;
});

$("#faq").submit(function(e) {
    $.ajax({
        type: "post",
        url: $(this).data('action'),
        data: $(this).serialize(), // serializes the form's elements.
        success: function(data)
        {
            $("#faq").get(0).reset();
            $('#faq-callback').show(); // show response from the php script.
            setTimeout(function() {
                $('#faq-callback').hide();
            }, 10000);
        }
    });

    e.preventDefault(); // avoid to execute the actual submit of the form.
    return false;
});