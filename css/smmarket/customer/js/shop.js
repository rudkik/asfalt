// Параметры поиска
var search_params     =   {
    name        : null,
    category_id : null,
    brand_id    : null,
    is_sale     : null,
    is_new      : null,
};

// displayMessage('xxx');
// console.log('xxx');
// alert('xxx');

/** По итогам */
$(document).ready( function() {

    // displayMessage('yyy');
    // console.log('yyy');
    // alert('yyy');

    imgResize();
    /** Изменение высоты блоков */
    resizeHeight();

    /** Поиск по товарам */
    $('#products-search-name').on('keypress, keyup', function(e){
        e.preventDefault();
        search_params.name = $(this).val();
        search_products();
    });
    // $('#products-search-category-id, #products-search-brand-id, #products-search-is-new, #products-search-is-sale').on('change', function(e){
    //     e.preventDefault();
    //     console.log('...');
    //     search_products();
    // });
    $('#products-search-category-id').on('change', function(e){
        e.preventDefault();
        search_params.category_id = $(this).val();
        search_products();
    });
    $('#products-search-brand-id').on('change', function(e){
        e.preventDefault();
        search_params.brand_id = $(this).val();
        search_products();
    });
    $('#products-search-is-sale').on('change', function(e){
        e.preventDefault();
        search_params.is_sale = this.checked ? $(this).val() : null;
        search_products();
    });
    $('#products-search-is-new').on('change', function(e){
        e.preventDefault();
        search_params.is_new = this.checked ? $(this).val() : null;
        search_products();
    });
    $('#products-search-reset').on('click', function(e) {
        e.preventDefault();
        document.getElementById("products-search-form-wrapper").reset();
        for(var param in search_params){
            if(search_params.hasOwnProperty(param)) {
                search_params[param] = null;
            }
        }
        search_products();
    });
    /*
        $( "#sortable" ).disableSelection();
        // Навигация нажитием стрелочек
        $('#arrow-top').click(function(e) {
            e.preventDefault();
            var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            $(document).scrollTop(scrollTop - 150);
        });
        $('#arrow-down').on('click',function(e) {
            e.preventDefault();
            var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            $(document).scrollTop(scrollTop + 150);
        });
        // console.log('ready');
        //  Сортировка по цене
        // $('.price-sort').unbind();
        $('#price-sort-up').click(function(e){
            e.preventDefault();
            console.log('up');
            // Направление
            var vector = 'up';
            sortByPrice(vector);
            // console.log(arr.join('_'));
        });
        $('#price-sort-down').on('click', function(e){
            e.preventDefault();
            console.log('down');
            // Направление
            var vector = 'down';
            sortByPrice(vector);
        });
    * */











    // console.log($.session.get("supplier_id"));
    // $('.bxslider').bxSlider();
    /** Сортировка списка */
    $('#sortable').sortable({
        update: function(event, ui){
            /** Массив */
            var arr     =  [];
            /** Перебор элементов списка */
            $("#sortable li").each(function(){
                arr.push($(this).data('id'));
            });
            /** ajax Запрос */
            $.ajax ({
                type    :   'post',
                url     :   '/customer/categoryProducts/sortable',
                data    :   {
                    data                    :   arr,
                    YII_CSRF_TOKEN          :   csrfToken
                },
                success: function(data) {
                    console.log(data);
                    // displayMessage('Отсортировано', 'info');
                },
                error: function() {
                    console.log('error!');
                }
            });
            // var sortableLinks = $("#sortable");
            // $(sortableLinks).sortable();
            // var data = $(sortableLinks).sortable('serialize');
            // var data = $('#sortable').sortable('serialize');
            // var data = $(this).sortable('serialize');
            //console.log(data);
        }
    });
    /** Остановка сортировки */
    $( "#sortable" ).disableSelection();
    /** Навигация нажитием стрелочек */
    $('#arrow-top').click(function(e) {
        e.preventDefault();
        var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        $(document).scrollTop(scrollTop - 150);
    });
    $('#arrow-down').on('click',function(e) {
        e.preventDefault();
        var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        $(document).scrollTop(scrollTop + 150);
    });
    // console.log('ready');
    /** Сортировка по цене */
    // $('.price-sort').unbind();
    $('#price-sort-up').click(function(e){
        e.preventDefault();
        console.log('up');
        /** Направление */
        var vector = 'up';
        sortByPrice(vector);
        // console.log(arr.join('_'));
    });
    $('#price-sort-down').on('click', function(e){
        e.preventDefault();
        console.log('down');
        /** Направление */
        var vector = 'down';
        sortByPrice(vector);
    });


    /** Фильтр по брэндам */
    // $('#brand_id').unbind();
    $('#brand_id').change(function(e){
        e.preventDefault();
        console.log('Фильтр брэндов');
        categoryFilter();
    });
    /** Фильтр цены */
    $('#price_filter').change(function(e){
        e.preventDefault();
        // console.log('Фильтр цены');
        categoryFilter();
    });
    function categoryFilter(){
        var brand_current       =   parseInt($('#brand_id option:selected').val());
        var price_filter        =   parseInt($('#price_filter option:selected').val());
        // console.log(brand_current + ':' + price_filter);
        $('.product-node').css({'display':'none'});
        // var brand_current   = $(this).val();
        /** Если неизвестно */
        //if(brand_id == 1)
        //    /** Отображаем все */
        //    $('.product-node').css({'display':'block'});
        //else{
        //    $('.product-node').css({'display':'none'});
        //    $('.product-node[data-brand-id="' + brand_id + '"]').css({'display':'block'});
        //}
        /** Если неизвестно */
        // if(price_filter == 1)
        //     /** Отображаем все */
        //     $('.product-node').css({'display':'block'});
        // else {
        /**  Показать все*/
        if(price_filter == 1 && brand_current == 1) {
            $('.product-node').css({'display':'block'});
            return;
        }
            $('.product-node').each(function(){
                var price       = parseInt($(this).data('price'));
                var brand_id    = parseInt($(this).data('brand-id'));

                /** Фильтровать только по брэндам */
                if(price_filter == 1 && brand_current > 1) {
                    if(brand_current == brand_id){
                        $(this).css({'display':'block'});
                    }
                }
                /** Фильтровать только по ценам */
                else if(price_filter > 1 && brand_current == 1){
                    if(price_filter == 2) {
                        if(price <= 100000) {
                            $(this).css({'display':'block'});
                        }
                    }
                    else if(price_filter == 3) {
                        if(100000 <=  price && price <= 200000) {
                            $(this).css({'display':'block'});
                        }
                    }
                    else if(price_filter == 4){
                        if(200000 <=  price && price <= 400000){
                            $(this).css({'display':'block'});
                        }
                    }
                    else if(price_filter == 5){
                        if(price >=  400000){
                            $(this).css({'display':'block'});
                        }
                    }
                }
                /** Фильтровать по брэндам и по ценам */
                else if(price_filter > 1 && brand_current > 1){
                    if(price_filter == 2) {
                        if(price <= 100000) {
                            if(brand_current == brand_id){
                                $(this).css({'display':'block'});
                            }
                        }
                    }
                    else if(price_filter == 3) {
                        if(100000 <=  price && price <= 200000) {
                            if(brand_current == brand_id){
                                $(this).css({'display':'block'});
                            }
                        }
                    }
                    else if(price_filter == 4){
                        if(200000 <=  price && price <= 400000){
                            if(brand_current == brand_id){
                                $(this).css({'display':'block'});
                            }
                        }
                    }
                    else if(price_filter == 5){
                        if(price >=  400000){
                            if(brand_current == brand_id){
                                $(this).css({'display':'block'});
                            }
                        }
                    }
                }
                // до 100 000 тенге
                // от 100 000 тенге до 200 000 тенге
                // от 200 000 тенге до 400 000 тенге
                // от 400 000 тенге и выше
            });
        // }
        /** покрасить битые картинки */
        drawEmptyImages();
    }
    /** покрасить битые картинки */
    drawEmptyImages();
    // @todo отменить для админа !!!
    /** Отменить выделение */
     if (window.getSelection) {
         window.getSelection().removeAllRanges();
     /** старый IE */
     } else {
         document.selection.empty();
     }
     /** обработчик битых ссылок */
     /// $(function(){
    /** покрасить битые картинки */
    drawEmptyImages();
    /** Битые картинки */
    // $('img').error(function(){
    //     /** Дефолтная картинка */
    //     $(this).attr('src', '/images/default.png');
    //     /** Удаление */
    //     // $(this).remove();
    //     /** Скрытие */
    //     // $(this).hide();
    // });
     // });
    /** Прокрутка вверх */
     $('.vector-keyboard-top').click(function(e) {
         e.preventDefault();
         var positionTop = $('.keyboard-wrapper').position().top;
         $('.keyboard-wrapper').css({'top':positionTop - 20});
         //var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
         //$(document).scrollTop(scrollTop - 150);
     });
    /** Прокрутка вниз */
     $('.vector-keyboard-down').on('click',function(e) {
         e.preventDefault();
         var positionTop = $('.keyboard-wrapper').position().top;
         $('.keyboard-wrapper').css({'top':positionTop + 20});
     });
     /**
      * seemless print
      * Распечатка */
     $("#printOrder").click(function(e) {
         e.preventDefault();
         createPage();
         return;
         /** Распечатка */
         // printOrder2(createPage);
         // printOrder(createPage);
     });
    /** Подключение слайдера */
     // $('.ajax-bxslider').bxSlider();


     $('#forgotDialogOpen').click(function(e) {
            e.preventDefault();
            $('#forgot-modal').modal('show');
     });
     /** Удаление уведомления */
     if($('.messages .alert').text() != '') {
         setTimeout(function(){$('.messages .alert').fadeOut('fast').remove()},5000);
     }
     /** Удалить из сравнения */
     function deleteFromCompare(obj) {
         /** id товара  */
         var product_id  = obj.data('id');
         $.ajax ({
             type    : 'post',
             url     : '/customer/compare/removeFromCompare',
             data    : {
                 id                      :   product_id,
                 YII_CSRF_TOKEN          :   csrfToken
             },
             success: function(data) {
                 console.log(data);
                 var td = $('td[data-id="' + product_id + '"]')
                 .css({background:'lightred'})
                 .delay(1000)
                 .remove();
                 displayMessage('Удалено из сравнения', 'info');
             },
             error: function() {
                 console.log('error!');
             }
         });
     }
    /** Удалить из сравнения */
     $('body').find('.deleteFromCompare').click(function(e) {
         e.preventDefault();
         // @todo
         /** Удалить из сравнения */
         deleteFromCompare($(this));
     });
    /** Открыть окно регистрации */
    $('body').find('#btn-registration').click(function(e) {
        e.preventDefault();
        console.log('РўС‹С†');
        $('#registration-modal').modal('show');
    });
    /** Показаать сообщение */
     function displayMessage(message, cssClass) {
         // console.log('displayCssClass: ' + cssClass);s
         if(!cssClass) cssClass = 'info'; // warning
         if($('.messages .alert').length)
             $('.messages .alert').text(message);
         else
             $('<div class="alert alert-' + cssClass + '">'+ message +'</div>').appendTo('.messages');
         setTimeout(function(){$('.messages .alert').fadeOut('fast').remove()},5000);
     }


    function refreshCartResultItemPrice(product_id, input_number_value) {
        var price_item        = $('span[data-name="price-item"][data-id=' + product_id + ']');
        var price_item_result = $('span[data-name="price-item-result"][data-id=' + product_id + ']');
        price_item.css({'color':'red'});
        price_item_result.css({'color':'red'});
        price_item_result_val = price_item.text() * input_number_value;
        price_item_result.text(price_item_result_val);
    }
    $(".addToCart").click(function(e) {
        e.preventDefault();
        var id              =   $(this).data('id');
        var template        =   $(this).data('template');
        var object_qty      =   $('input[data-name="qty"][data-template="'+template+'"][data-id=' + id + ']');
        var object_weight   =   $('input[data-name="weight"][data-template="'+template+'"][data-id=' + id + ']');
        qty                 =   object_qty.length       ?   object_qty.val()        :  1;
        weight              =   object_weight.length    ?   object_weight.val()   :  0;
        if(!template)       {
            displayMessage('Отсутствует шаблон\n');
            return;
        }
        if(!id) {
            displayMessage('Отсутствует код товара\n');
            return;
        }
        addToCart(id, qty, weight);
    });
    /** Выбор кол-ва ковара */
    $('.object-stepper').click(function( event ) {
        event.preventDefault();
        var action          = $(this).data('action');
        var product_id      = $(this).data('id');
        // :number
        var input_number    = $('input[data-name="qty"][data-id=' + product_id + ']');
        input_number_value  = parseInt(input_number.val());
        if(action == 'up') {
            input_number_value++;
            var color = 'lightgreen';
        }
        else {
            if(input_number_value > 1) {
                input_number_value--;
                var color = 'lightblue';
                if(input_number_value == 0)
                    var color = 'lightpink';
            }
        }
        input_number.css({'background':color});
        input_number.val(input_number_value);
        refreshCartResultItemPrice(product_id, input_number_value);
    });
     /** Удаление из корзины */
    function removeFromCart(obj) {
        var product_id  = obj.data('id');
        $.ajax ({
            type    : 'post',
            url     : '/customer/cart/removeFromCart',
            data    : {
                id                      :   product_id,
                YII_CSRF_TOKEN          :   csrfToken
            },
            success: function(data) {
                var tr = 'tr[data-id="'+product_id+'"]';
                $(tr).css({background:'lightred'});
                $(tr).remove();
                displayMessage('Удалено из корзины‹','info');
            },
            error: function() {
                alert('error!');
            }
        })
    };
    /** Удаление из корзины */
    $('.removeFromCart').click(function(e) {
        e.preventDefault();
        removeFromCart($(this));
    });
    /** Удаление из закладок */
    function removeFromBookmarks(obj) {
        var product_id = obj.data('id');
        $.ajax ({
            type:   'post',
            url:    '/customer/bookmarks/remove/',
            data: {
                id                      : product_id,
                YII_CSRF_TOKEN          : csrfToken
            },
            success : function(data) {
                var tr = 'tr[data-id="'+product_id+'"]';
                $(tr).css({background:'lightred'});
                displayMessage(data, 'success');
                $(tr).remove();
            },
            error: function() {
                // alert('error!');
            }
        })
    };
    /** Удаление из закладок */
    $('.removeFromBookmarks').click(function(e) {
        e.preventDefault();
        removeFromBookmarks($(this));
    });
    /** Добавить в закладки */
    function addToWishList(obj) {
        var product_id = obj.data('id');
        $.ajax ({
            type: 'post',
            url: '/customer/bookmarks/addToWishList',
            data: {
                id                      : product_id,
                YII_CSRF_TOKEN          : csrfToken
            },
            success: function(data) {
                console.log(data);
                if(data == 'regOnly') {
                    data                =   'Чтобы добавлять в закладки, пожалуйста зарегистрируйтесь.';
                    var alert_class     =   "alert-warning";
                }
                else
                    var alert_class     =   "alert-success";
                displayMessage(data,'info');

            },
            error: function() {
                // alert('error!');
            }
        })
    };
    /** Добавить в сравнение */
    function addToCompare(obj) {
        var product_id = obj.data('id');
        $.ajax ({
            type: 'post',
            url: '/customer/compare/addToCompare',
            data: {
                id                      : product_id,
                YII_CSRF_TOKEN          : csrfToken
            },
            success: function(data) {
                displayMessage('Добавлено к сравнению','success');
                if(!($(".compare-link").length)) {
                    $('<a href="/products/compare" class="btn btn-warning compare-link" ><span class="glyphicon glyphicon-refresh"> Сравнение</a>').prependTo($(".fixed-cart-wrapper .btn-group"));
                    // $('<li><a href="/products/compare" class="dynamic-link compare-link">Сравнение</a></li>').appendTo($(".nav-pills"));
                    // $('<a href="/products/compare" class="btn btn-default compare-link" ><span class="glyphicon glyphicon-refresh"> Сравнение</a>').appendTo($(".user-outer .btn-group"));
                }
            },
            error: function() {
                displayMessage('error!', 'danger');
            }
        })
    };
    /** Добавить в закладки */
    $('.addToWishList').click(function(e) {
        e.preventDefault();
        addToWishList($(this));
    });
    /** Добавить в сравнение */
    $('.addToCompare').click(function(e) {
        e.preventDefault();
        addToCompare($(this));
    });
    /** Только что купили */
    function onlinePurchase(text) {
        if (!Date.now) {
            Date.now = function() {
                return new Date().getTime();
            }
        }
        /** текущая дата */
        dateNow = Math.floor(Date.now() / 1000);
        $.ajax ({
            url: '/customer/products/purchase',
            type: 'post',
            data: {
                // timeNow                 : dateNow,
                YII_CSRF_TOKEN          : csrfToken
            },
            success: function(res) {
                var arr = jQuery.parseJSON(res);
                if(arr) {
                    $('<div class="purchase">' +
                        '<div class="purchase-block">' +
                        '<div class="container-fluid">' +
                        '<div class="row">' +
                        '<div class="col-lg-11 col-md-11 col-sm-11 col-xs-11">' +
                        '<span class="bold">Только что купили</span>' +
                        '</div>' +
                        '<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">' +
                        '<a class="closePurchase" href="#">' +
                        '<span class="glyphicon glyphicon glyphicon-remove"></span>' +
                        '</a>' +
                        '</div>' +
                        '</div>' +
                        '</div>'+
                        '<table class="table">' +
                        '<tr>' +
                        '<td>' +
                        '<aside>' +
                        '<a href="/products/item/id/' + arr['id'] +'">' +
                        '<img src="' + '/images/products/' + arr['id'] + '/' + arr['photo'] + '"/>' +
                        '</a>' +
                        '</aside>' +
                        '</td>' +
                        '<td>' +
                        '<h3><a href="/products/item/id/' + arr['id'] +'">' +
                        arr['name'] +
                        '</a></h3>' +
                        '</td>' +
                        '</tr>' +
                        '</table>' +
                        '</div>' +
                        '</div>')
                        .appendTo($(".content-block"));

                    setTimeout(function() {
                        $('.purchase').hide(2000)  //.delay(1000).remove()
                    },20); //20000
                }
            },
            error: function() {
                //alert("Error!");
            }
        });
    }
    /** Закрыть список покупок */
    function closePurchase() {
        $(".purchase").remove();
    }
    /** Закрыть список покупок */
    $('body').on('click', '.closePurchase', function (e) {
        e.preventDefault();
        closePurchase();
        return false;
    });

    /** Наведение на  */
     $('.cart-widget').mouseenter(function(e) {
         e.preventDefault();
         getCartList()
     })
    /** Изменение размеров */
    $(window).resize(function() {
        var w = $('.cart-widget').width() + 11;
        $('.cartPopup-block').css({
            'width' :   w
        });
        //  console.log('resize');
        resizeImages();

        resizeHeight();
        // resizeSlider();
    });
    /** Закрыть всплывашку корзины */
    function closeCartPopup() {
        $('.cartPopup').remove();
    }
    /** Закрыть всплывашку корзины */
    $('body').on('click', '.closeCartPopup', function (e) {
        e.preventDefault();
        closeCartPopup();
    });
    /** пересчитать корзину */
    function recountCart(obj) {
        var id      =   obj.data('id');
        var type    =   obj.attr('data-name');
        var qty, weight;
        if(type == 'qty'){
            qty     =   obj.val() * 1;
            weight  =   0;
            if(!(qty > 0)){
                qty = 0;
            }
        }
        else if(type == 'weight'){
            weight  =   obj.val() * 1;
            qty     =   0;
            if(!(weight > 0)){
                weight = 0;
            }
        }

        // var qty     =   type == 'qty'       ?   obj.data('qty') : 0;
        // var weight  =   type == 'weight'    ?   obj.data('weight') : 0;

        // console.log( qty + ":" + weight );
        // return false;

        $.ajax ({
            type: 'post',
            url: '/customer/cart/recount',
            data: {
                id                  :       id,
                qty                 :       qty,
                weight              :       weight,
                YII_CSRF_TOKEN      :       csrfToken
            },
            success: function(data) {
                //  displayMessage('Кол-во товаров изменено');
                if(!weight){
                    $('.price-item-result[data-id="' + id + '"]').text(parseInt($('.price-item[data-id="' + id + '"]').text()) * qty);
                    tmp = $('td[data-id="' + id + '"][data-name="amount"]');
                    tmp.text(tmp.data('price') * qty + ' тг');
                }
                else { // if(weight)
                    $('.price-item-result[data-id="' + id + '"]').text($('.price-item[data-id="' + id + '"]').text() * weight);
                }
            },
            error: function() {
                // alert('error!');
            }
        });
    }
    /** Пересчет товаров в корзине */
    $('.quantity[data-template="cart"]').change(function(){
        recountCart($(this));
    });
    /** Пересчет товаров в корзине */
    $('.quantity[data-template="cart"]').keyup(function(){
        recountCart($(this));
    });
    /** пересчитать корзину */
    function recountAttachments(obj) {

        var order_id        =     obj.data('order-id');
        var product_id      =     obj.data('object-id');

        var type    =   obj.attr('data-name');
        var qty, weight;
        if(type == 'qty'){
            qty     =   obj.val();
            weight  =   0;
        }
        else if(type == 'weight') {
            weight  =   obj.val();
            qty     =   0;
        }
        //  console.log(weight + ':' + qty);
        var qty             =     obj.val();
        //  console.log('recount:'+product_id+':'+product_count);
        //  return false;
        $.ajax ({
            type: 'post',
            url: '/sadmin/orders/recount',
            data: {
                order_id        :   order_id,
                product_id      :   product_id,
                qty             :   qty,
                weight          :   weight,
                YII_CSRF_TOKEN  :   csrfToken
            },
            success: function(data) {
                //  console.log(data);
                if(!weight){
                    var val     =   parseInt($('.price-item[data-product-id="' + product_id + '"]').text()) * qty;
                }
                else {  // if(weight)
                    var val     =   $('.price-item[data-product-id="' + product_id + '"]').text() * weight;
                }
                console.log(val);
                $('.price-item-result[data-product-id="' + product_id + '"]').text(val);
            },
            error: function() {
                // alert('error!');
            }
        });
    }
    /** Пересчет товаров в корзине */
    $('.qty[data-template="attachments"], .weight[data-template="attachments"]').change(function(){
        recountAttachments($(this));
    });
    /** Пересчет товаров в корзине */
    $('.qty[data-template="attachments"], .weight[data-template="attachments"]').keyup(function(){
        recountAttachments($(this));
    });

    /** Закрыть всплывашку корзине  */
    $('body').on('mouseleave', '.cartPopup-block', function (e){
        closeCartPopup();
    });
    /** закрыть всплывающий диалог */
    $('body').on('click', '.closeDialogPopup', function (e){
        $('.modal').modal('hide'); //show
    });
    /** Запустить интервал */
    // (function runInterval() {
    //     min = 1000 * 50; // sek * ...
    //     max = 1000 * 90;
    //     interval = Math.floor(Math.random() * (max - min + 1)) + min;
    //     setTimeout(function() {
    //         onlinePurchase(interval);
    //         runInterval();
    //     }, interval);
    // })();

    /** Подсказка */
    $('body').tooltip({
        selector: "[rel=tooltip-right]",
        placement: "right"
    });
    /** Подсказка */
    $('body').tooltip(
    {
        selector: "[rel=tooltip-left]",
        placement: "left"
    });
    /** Подсказка */
    $('body').tooltip({
        selector: "[rel=tooltip-top]",
        placement: "top"
    });
    /** Подсказка */
    $('body').tooltip({
        selector: "[rel=tooltip-bottom]",
        placement: "bottom"
    });
    /** максимальная высота */
    equalHeight();
     //  @todo
    /** Размеры фото */
    $('.photo').each(function() {
        if($(this).children("img").height() > $(this).height())
            $(this).children("img").css({'height':'100%'});
    });


    /** Список товаров */
    function getCartList() {

        /** Залипуха */
        return;

        // if($('.cartPopup').length > 0) return false;
        // $.ajax({
        //     type    : 'post',
        //     url     : '/customer/cart/getCartList',
        //     data    : {
        //         YII_CSRF_TOKEN          : csrfToken
        //     },
        //     success : function(data) {
        //         console.log(data);
        //         if(data == 'empty') {
        //             return false;
        //         }
        //         else {
        //             var cartList = $.parseJSON(data);
        //             if(!cartList) {
        //                 return false;
        //             }
        //             $('<div class="cartPopup">' +
        //                 '<div class="cartPopup-block" style="width:' + ($('.cart-widget').width() + 11) + 'px">' +
        //                 '<a href="' + link_cart + '"><div class="row cartCapPopup"></div></a>' +
        //                 '<div class="row cartHead">' +
        //                 '<div class="container-fluid">' +
        //                 '<div class="col-lg-11 col-md-11 col-sm-11 col-xs-11">' +
        //                 '</div>' +
        //                 '<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 pull-right">' +
        //                 '<a class="closeCartPopup" href="#">' +
        //                 '<span class="glyphicon glyphicon glyphicon-remove"></span>' +
        //                 '</a>' +
        //                 '</div>' +
        //                 '</div>' +
        //                 '</div>'+
        //                 '<div class="row cartPopupProducts">' +
        //                 '<div class="container-fluid">' +
        //                 '<table class="table cart-list cartTable">' +
        //                 '</table>' +
        //                 '</div>'+
        //                 '</div>'+
        //                 '<div class="row cartPopupPrice">' +
        //                 '<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">' +
        //                 '<!--<span class="bold">РўРѕРІР°СЂС‹ РІ РєРѕСЂР·РёРЅРµ:</span>-->' +
        //                 '</div>' +
        //                 '<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">' +
        //                 '<div class="cartPopupPrice-block">' +
        //                 '</div>' +
        //                 '</div>' +
        //                 '</div>' +
        //                 '<div class="row cartPopupOrderBtn">' +
        //                 '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">' +
        //                 '</div>' +
        //                 '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">' +
        //                 '<div>' +
        //                 '<a href = "'+ link_cart +'" class="btn btn-primary pull-right">Оформить заказ</a>' +
        //                 '</div>' +
        //                 '</div>' +
        //                 '</div>' +
        //                 '</div>' +
        //                 '</div>')
        //                 .appendTo($("body"));
        //             var dataList    = cartList[0];
        //             var dataPrice   = cartList[1];
        //             // alert(print_r(data,2));
        //             for(var i = 0; i < (dataList).length; i++) {
        //                 $('<tr>' +
        //                     '<td>' +
        //                     '<aside>' +
        //                     dataList[i][2] +
        //                     '</aside>' +
        //                     '</td>' +
        //                     '<td>' +
        //                     '<a href="/products/item/id/'+dataList[i][0]+'">' +
        //                     dataList[i][1] +
        //                     '</a>' +
        //                     '</td>' +
        //                     '<td>' +
        //                     '<span class="badge">x' +
        //                     dataList[i][4] +
        //                     ' </span>' +
        //                     '</td>' +
        //                     '<td>' +
        //                     dataList[i][3] +
        //                     ' С‚Рі.' +
        //                     '</td>' +
        //                     '</tr>').appendTo('.cartTable');
        //             }
        //             $('<div class="cartPopupPriceItem"><span>Стоимость: '+ dataPrice[0] +' тг.</span></div>').appendTo('.cartPopupPrice-block');
        //         }
        //     },
        //     error: function() {
        //         console.log('error!');
        //     }
        // });
    }

});



