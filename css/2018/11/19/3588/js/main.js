function addCart(id, shopID){
    jQuery.ajax({
        url : "/cart/add",
        data : ({
            id : (id),
            shop_good_child_id: (0),
            count : (1),
            is_result: (true),
            url: ('show-cart'),
            shop_branch_id: (shopID),
        }),
        // dataType : "JSON",
        type : "POST",
        success : function(data) {
            $('#cart-data').html(data);
        },
        error : function(data) {

        }
    });
}
function delCart(id, shopID) {
    jQuery.ajax({
        url : "/cart/del",
        data : ({
            id : (id),
            shop_good_child_id: (0),
            is_result: (false),
            shop_branch_id: (shopID)
        }),
        type : "POST",
        success : function(data) {
            window.location.reload();
        },
        error : function(data) {

        }
    });
}
function addSelectGood(id) {
    tmp = $('#add-select-goods');
    jQuery.ajax({
        url : "/user/edit",
        data: 'options_add[select-goods.'+id+']='+id+'&is_result=0',
        type : "POST",
        success : function(data) {
            tmp.text('Товар добавлен в избраннoе');
        },
        error : function(data) {

        }
    });
}

function editCart(id, shopID, count) {
    jQuery.ajax({
        url : "/cart/edit",
        data : ({
            id : (id),
            shop_good_child_id: (0),
            shop_branch_id: (shopID),
            count : (count),
            is_result: (false)
        }),
        type : "POST",
        success : function(data) {
            window.location.reload();
        },
        error : function(data) {

        }
    });
}
$(document).ready(function () {
    $('[data-action="count-minus"]').click(function () {
        el = $(this).parent().parent().children('input[name="count"]');
        count = el.val() * 1 - 1;
        shopID = el.data('shop');
        id = el.data('id');
        editCart(id, shopID, count);

        return false;
    });

    $('[data-action="count-plus"]').click(function () {
        el = $(this).parent().parent().children('input[name="count"]');
        count = el.val() * 1 + 1;
        shopID = el.data('shop');
        id = el.data('id');
        editCart(id, shopID, count);

        return false;
    });

    $('[data-action="count-edit"]').change(function () {
        el = $(this);
        count = el.val() * 1;
        shopID = el.data('shop');
        id = el.data('id');
        editCart(id, shopID, count);

        return false;
    });

    $('img.preload-product').myPreloadImg();

    $('[data-action="btn-buy"]').on("click",function(){
        id = $(this).attr("data-id");

        $("#goods-img-"+id)
            .clone()
            .css({'position' : 'absolute', 'z-index' : '11100', top: $(this).offset().top-300, left:$(this).offset().left-100})
            .appendTo("body")
            .animate({opacity: 0.05,
                left: $("#cart-data").offset()['left'],
                top: $("#cart-data").offset()['top'],
                width: 20}, 1000, function() {
                $(this).remove();
            });

    });
});

(function($){
    $.fn.myPreloadImg = function(options){
        // параметры плагина
        options = $.extend({
            preloaderImg: "/img/file-not-found/file_not_found-245x245.png" // путь до прелоадера
        }, options);

        // действия после загрузки картинки
        function finish_load(){
            // убираем прелоадер,
            // выводим картинку
            // и удаляем однопиксельную картинку
            var elementImg = $(this);
            var imgSrc = $(this).attr('img_src');
            elementImg.attr('src', imgSrc);
            elementImg.attr('img_src', '');
            $('img').each(function(){
                if($(this).attr('img_src') == elementImg.attr('src')){
                    $(this).attr('src', elementImg.attr('src'));
                    elementImg.remove();
                }
            });
        }

        // действия при вызове плагина
        var make = function(){
            var element = $(this);
            var imgSrc = element.attr('src');
            element.attr('img_src', imgSrc);
            element.attr('src', options.preloaderImg);
            // создаем пиксель и прячем его с глаз долой :)
            // пока картинка не прогрузится
            var hideImg = $('<img>', {
                src: imgSrc,
                style: 'position: absolute; top: -1px; left: -1px; width: 1px;'
            });
            $('body').append(hideImg);
            // указываем, что делать, когда спрятанная картинка прогрузится
            hideImg.bind('load', finish_load);
        };

        // метод myTestCarusel вернет объект jQuery обратно
        return this.each(make);
    };
})(jQuery);