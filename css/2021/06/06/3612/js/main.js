function addFavoriteGoods(el, e) {
    e.preventDefault();

    var goodID = parseInt(el.data('id'));
    var childID = parseInt(el.data('child'));
    var shopID = parseInt(el.data('shop'));

    jQuery.ajax({
        url: '/favorite/add_good',
        data: ({
            id: (goodID),
            shop_good_child_id: (childID),
            shop_branch_id: (shopID),
            is_result: (1),
        }),
        type: "POST",
        success: function (data) {
            var obj = jQuery.parseJSON($.trim(data));
            if (obj.error) {
                alert(obj.msg);
            } else {
                $('[data-id="favorite-count"]').html(obj.count);

                el.attr('data-favorite-action', 'del-good');
                el.unbind('click');
                el.addClass('active');
                el.click(function(e){delFavoriteGoods($(this), e)});
            }
        },
        error: function (data) {
            console.log(data.responseText);
        }
    });

    $("#goods-img-"+goodID)
        .clone()
        .css({'position' : 'absolute', 'z-index' : '999999', top: el.offset().top, left:el.offset().left-100})
        .appendTo("body")
        .animate({opacity: 0.05,
            left: $("#favorite-count").offset()['left'],
            top: $("#favorite-count").offset()['top'],
            width: 20}, 1000, function() {
            $(this).remove();
        });

    return false;
}

function delFavoriteGoods(el, e) {
    e.preventDefault();

    var goodID = parseInt(el.data('id'));
    var shopID = parseInt(el.data('shop'));

    jQuery.ajax({
        url: '/favorite/del_good',
        data: ({
            id: (goodID),
            shop_good_child_id: (0),
            shop_branch_id: (shopID),
            is_result: (1),
        }),
        type: "POST",
        success: function (data) {
            var obj = jQuery.parseJSON($.trim(data));
            if (obj.error) {
                alert(obj.msg);
            }else{
                $('[data-id="favorite-count"]').html(obj.count);

                el.attr('data-favorite-action', 'add-good');
                el.unbind('click');
                el.removeClass('active');
                el.click(function(e){addFavoriteGoods($(this), e)});
            }
        },
        error: function (data) {
            console.log(data.responseText);
        }
    });

    return false;
}

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
                    $('[data-id="basket-count"]').html(obj.count);
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
                }
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });

        return false;
    });

    $(".quantity__plus").on("click", function() {
        var quantity = this.parentNode.getElementsByClassName("quantity__number")[0].innerHTML;
        $(this).parent().find(".quantity__number1").val(quantity).trigger('change');
    });

    $(".quantity__minus").on("click", function() {
        var quantity = this.parentNode.getElementsByClassName("quantity__number")[0].innerHTML;
        $(this).parent().find(".quantity__number1").val(quantity).trigger('change');
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
                }
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });

        return false;
    });

    /**
     * добавление товара в избранное
     * на кнопки параметры:
     * data-favorite-action="add-good" data-id="" data-child="0" data-shop="0"
     */
    $('[data-favorite-action="add-good"]').click(function(e){addFavoriteGoods($(this), e)});


    /**
     * удаление товара из избранного
     * на кнопки параметры:
     * data-favorite-action="del-good" data-id="" data-child="0" data-shop=""
     */
    $('[data-favorite-action="del-good"]').click(function(e){delFavoriteGoods($(this), e)});

    $('input[data-type="mobile"]').inputmask({
        mask: "+7(799) 999 99 99"
    }).attr('autocomplete', 'off');

});