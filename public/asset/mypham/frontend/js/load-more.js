$(document).ready(function(){
    $(".load-more").click(function() {
        var target = $(this).data('target');
        var url = $(this).data('url');
        var page = $(this).data('page') || 0;

        page = parseInt(page) + 1;
        url = url + '/page:'+page;
        $.ajax({
            type: "post",
            url: url,
            data: {'ajax': 1},
            success: function(data)
            {
                $(target).append(data.html);

                var btn = $('.load-more');
                btn.data('page', data.current)
                if (data.current == data.total) {
                    btn.unbind('click').hide();
                }

                $('.nailthumb').nailthumb({method:'crop', fitDirection:'center center'});
            }
        });
    });
});