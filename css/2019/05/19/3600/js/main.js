$(document).ready(function () {
    $('[data-action="add-cart"]').click(function (e) {
        e.preventDefault();

        var id = $(this).data('id');
        $.ajax({
            type: 'post',
            url: '/cart/add_good',
            data: {
                id: (id),
                shop_good_child_id: (0),
                is_result: (1),
                count: (1)
            },
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));
                if (obj.error) {
                    alert(obj.msg);
                }
            },
            error: function () {
                console.log(data.responseText);
            }
        });

        var that = $(this).parent().parent().find('[data-id="img"]');
        var basket = $("#basket");
        var w = that.width();

        that.clone().css({
            'position': 'absolute',
            'z-index': '11100',
            top: $(this).offset().top,
            left: $(this).offset().left
        }).appendTo("body").animate({
            opacity: 0.05,
            left: basket.offset()['left'],
            top: basket.offset()['top'],
            width: 20
        }, 1000, function() {
            $(this).remove();
        });

        return false;
    });


    /**
     * удаление товара из корзины
     * на кнопки параметры:
     * data-cart-action="del-good" data-id="" data-child="0" data-shop=""
     */
    $('[data-cart-action="del-good"]').click(function (e) {
        e.preventDefault();

        var goodID = parseInt($(this).data('id'));
        jQuery.ajax({
            url: '/cart/del_good',
            data: ({
                id: (goodID),
                shop_good_child_id: (0),
                is_result: (0),
            }),
            type: "POST",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));
                if (obj.error) {
                    alert(obj.msg);
                }else{
                    location.reload();
                }
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });

        return false;
    });

    /**
     * добавление товара в корзину
     * на кнопки параметры:
     * data-cart-action="set-good-count" data-id="" data-child="0" data-shop="0"
     *
     * если нужно, чтобы происходит просчет локально
     * data-count-up="1" data-good-price="0" data-good-amount="0"
     * куда надо установить значения надо добавить:
     * data-cart="total" data-cart-amount="0"
     */
    $('[data-cart-action="set-good-count"]').change(function (e) {
        e.preventDefault();

        var goodID = parseInt($(this).data('id'));
        var count = parseInt($(this).val());
        jQuery.ajax({
            url: '/cart/edit_good',
            data: ({
                id: (goodID),
                count: (count),
                is_result: (0),
            }),
            type: "POST",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));
                if (obj.error) {
                    alert(obj.msg);
                }else{
                    location.reload();
                }
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    });
});