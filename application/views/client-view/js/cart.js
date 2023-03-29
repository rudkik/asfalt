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
        var count = parseInt($('input[data-cart-count="'+goodID+'"]').val());

        jQuery.ajax({
            url: '/cart/add_good',
            data: ({
                id: (goodID),
                shop_good_child_id: (childID),
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
     * удаление товара из корзины
     * на кнопки параметры:
     * data-cart-action="del-good" data-id="" data-child="0" data-shop=""
     */
    $('[data-cart-action="del-good"]').click(function (e) {
        e.preventDefault();

        var goodID = parseInt($(this).data('id'));
        var childID = parseInt($(this).data('child'));
        var shopID = parseInt($(this).data('shop'));

        jQuery.ajax({
            url: '/cart/del_good',
            data: ({
                id: (goodID),
                shop_good_child_id: (childID),
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
        var childID = parseInt($(this).data('child'));
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
                shop_good_child_id: (childID),
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
});