$(function() {
    $('.cart-item-amount').change(function() {
        var amount = $(this).val();
        var price = $(this).data('price');
        var sub_total = amount * price;
        // $(this).parent().next().text(sub_total.toLocaleString());

        var id = $(this).data('id');
        $('#cart-item-total-'+id).text(sub_total.toLocaleString());
        $('#cart-item-total-'+id).data('value', sub_total);

        var order_sub_total = 0;
        $('.cart-item-total').each(function() {
            order_sub_total += parseInt($(this).data('value'));
        })

        order_sub_total = order_sub_total.toLocaleString();
        $('.order-sub_total').text(order_sub_total);
        $('.order-total').text(order_sub_total);
    })

    $('.remove-cart-item').click(function() {
        var id = $(this).data('id');
        $('#' + id).remove();

        var order_amount = $('.cart-item').length;
        $('#order-amount').text(order_amount);

        var order_sub_total = 0;
        $('.cart-item-total').each(function() {
            order_sub_total += parseInt($(this).data('value'));
        })

        order_sub_total = order_sub_total.toLocaleString();
        $('.order-sub_total').text(order_sub_total);
        $('.order-total').text(order_sub_total);
    })

    $('#province').change(function() {
        var province = $(this).val();
        var district = $('#district').data('value');

        var items = locations[province];
        var html = '<option value="0">Vui lòng chọn quận huyện.</option>';
        if (parseInt(province) > 0) {
            for (var i in items) {
                selected = '';
                if (items[i]['id'] == district) {
                    selected = 'selected ';
                }
                html += "<option value='" + items[i]['id'] + "' " +  selected + ">" + items[i]['title']+ "</option>"
            }
        }

        $('#district').html(html);

        $('#deliver_day').html('');
        $('#deliver_price').html('');

    })

    $('#district').change(function() {
        var province = $('#province').val();
        var district = $(this).val();

        $('#deliver_price').html('');
        $('#deliver_day').html('');

        if (province == 0) {
            return true;
        }

        var item = locations[province][district];

        var price = parseInt(item.delivery_price);
        price = price.toLocaleString();
        $('#deliver_price').html("Phí vận chuyển: <b>" + price + "</b> VND<br />");

        var day = item.delivery_day;
        $('#deliver_day').html("Số ngày vận chuyển: <b>" + day + "</b> ngày");
    })

    $('#province').trigger('change');
})