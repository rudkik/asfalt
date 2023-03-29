$(document).ready(function () {
    /**
     * добавление товара в корзину
     * на кнопки параметры:
     * data-cart-action="add-good" data-id="" data-child="0" data-shop="0"
     *
     * на текстовом поле с количеством:
     * data-cart-count=""
     */
    $('[data-cart-action="add-good"]').click(function (e) {
        e.preventDefault();

        var goodID = parseInt($(this).data('id'));
        var childID = parseInt($(this).data('child'));
        var shopID = parseInt($(this).data('shop'));

        jQuery.ajax({
            url: '/cart/add_good',
            data: ({
                id: (goodID),
                shop_good_child_id: (childID),
                shop_branch_id: (shopID),
                count: (1),
                is_result: (1),
            }),
            type: "POST",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));
                if (obj.error) {
                    alert(obj.msg);
                } else {
                    $('#basket-count').html(obj.count);
                }
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });

        return false;
    }).click(function(){
        var goodID = parseInt($(this).data('id'));

        $("#goods-img-"+goodID)
            .clone()
            .css({'position' : 'absolute', 'z-index' : '999999', top: $(this).offset().top-300, left:$(this).offset().left-100})
            .appendTo("body")
            .animate({opacity: 0.05,
                left: $("#basket-count").offset()['left'],
                top: $("#basket-count").offset()['top'],
                width: 20}, 1000, function() {
                $(this).remove();
            });

    });

    /**
     * удаление товара из корзины
     * на кнопки параметры:
     * data-cart-action="del-good" data-id="" data-child="0" data-shop=""
     */
    $('[data-cart-action="del-good"]').click(function (e) {
        e.preventDefault();

        var goodID = parseInt($(this).data('id'));
        var shopID = parseInt($(this).data('shop'));

        jQuery.ajax({
            url: '/cart/del_good',
            data: ({
                id: (goodID),
                shop_good_child_id: (0),
                shop_branch_id: (shopID),
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
        var shopID = parseInt($(this).data('shop'));
        var count = parseInt($(this).val());
        var isCountUp = parseInt($(this).data('count-up'));
        if(isCountUp == 1) {
            var price = parseFloat($(this).data('good-price'));
            var amount = parseFloat($(this).data('good-amount'));
            $(this).data('good-amount', price * count);
        }

        jQuery.ajax({
            url: '/cart/edit_good',
            data: ({
                id: (goodID),
                shop_good_child_id: (0),
                shop_branch_id: (shopID),
                count: (count),
                is_result: (0),
            }),
            type: "POST",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));
                if (obj.error) {
                    alert(obj.msg);
                }else{
                    if(isCountUp == 1) {
                        var amountNew = price * count;
                        $('[data-cart-amount="'+goodID+'"]').text(amountNew + ' тг');

                        total = $('[data-cart="total"]');
                        amount = (parseFloat(total.data('cart-total')) + amountNew - amount);
                        amount = amount.toFixed(2).replace('.00', '');
                        total.data('cart-total', amount);
                        total.text(amount +' тг');
                    }else{
                        location.reload();
                    }
                }
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });

        return false;
    });

    $('[data-action="show-big-img"]').click(function (e) {
        $('#big-goods').attr('src', $(this).attr('href'));
    });

    $('#big-goods').click(function () {
        $.fancybox.open($('[data-fancybox="gallery"]'));
    });
});