/// location.pathname
///  $('.fixed-arrows').remove();
///  var search = window.location.search.substr(1),
///      keys = {};
///  search.split('&').forEach(function(item) {
///      item = item.split('=');
///      keys[item[0]] = item[1];
///  });


/** Режим модуля */
var is_module   =   false;
var path        =   window.location.pathname.substr(1);
path.split('/').forEach(function(item) {
    if( item    ==  'smanager') {
        // console.log("Модуль найден");
        is_module   =   true;
    }
});

// displayMessage('zzz');
// console.log('zzz');
// alert('zzz');

/** Поиск по товарам */
function search_products() {
    //  var name            =   $('#products-search-name').val().toLowerCase();
    //  var category_id     =   parseInt($('#products-search-category-id').val());
    var str     =   '';
    $('.product-node').addClass('inactive');
    //  console.log( search_params );
    var is_all_visible = true;
    for(var param in search_params){
        if(search_params.hasOwnProperty(param)) {
            if(search_params[param] != null) {
                is_all_visible = false;
            }
        }
    }
    if(is_all_visible){
        $('.product-node').removeClass('inactive');
        console.log('Показать все');
    }
    else{
        for(var param in search_params){
            if(search_params.hasOwnProperty(param)) {
                if(search_params[param] != null && search_params[param] != '') {
                    var data_param  =  param.replace('_', '-');
                    if(param == 'name') {
                        str += '[data-'+ data_param + '*="' + search_params[param] + '"]'
                    }
                    else {
                        str += '[data-'+ data_param + '="' + search_params[param] + '"]'
                    }
                }
            }
        }
        var $_ob    =   $('.product-node'+str);
        $_ob.removeClass('inactive');
    }
    sortByPrice('down');
}

/**  Очистка даных ajax */
function clean_ajax_data(data) {
    var output = data
        .replace(/<script\s+type="text\/javascript"\s+src="\/assets\/\w+\/(jui\/js\/)?(jquery|jquery\.min|jquery\-ui|jquery\-ui\.min|jquery\.rating|jquery\.metadata)\.js"><\/script>/ig,'')  //
        .replace(/<link\s+rel="stylesheet"\s+type="text\/css"\s+href="\/assets\/\w+\/(jui\/css\/base|rating)\/[a-zA-Z\-\.]+\.css"\s+\/+>/ig,'');
    return output;
}

function getCookie(name) {
    var matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}
function deleteCookie(name) {
    setCookie(name, "", {
        expires: -1
    })
}
function setCookie(name, value, options) {
    options     =   options   ||    {};
    var expires = options.expires;
    if (typeof expires == "number" && expires) {
        var d   =   new Date();
        d.setTime(d.getTime() + expires * 1000);
        expires =   options.expires = d;
    }
    if (expires && expires.toUTCString) {
        options.expires = expires.toUTCString();
    }
    value   =   encodeURIComponent(value);
    var updatedCookie   =   name + "=" + value;
    for (var propName in options) {
        updatedCookie += "; " + propName;
        var propValue = options[ propName ];
        if (propValue   !==     true) {
            updatedCookie += "=" + propValue;
        }
    }
    document.cookie = updatedCookie;
}

/** Количество секунд простоя мыши, при котором пользователь считается неактивным */
var no_active_delay =   4;
/** Текущее количество секунд простоя мыши */
var now_no_active   =   0;
function activeUser() {
    /** Обнуляем счётчик простоя секундs */
    now_no_active   =   0;
}
/** Обновляем чат */
function updateChat() {
    /** Проверяем не превышен ли "предел активности" пользователя */
    if (now_no_active >= no_active_delay) {
        /** В реальности стоит убрать, а здесь дано как доказательство того, что всё работает */
        // console.log("Пользователь не активен");
        /** Рекламный блок */
        // showPiar();
        return;
    }
}

// http://itchief.ru/lessons/bootstrap-3/bootstrap-3-modal-window
/** Рекламный блок */
function showPiar(){
    var popup       =   $('#piar-modal');
    if(popup.css('display') == 'none')
        popup.modal('show');

    var animTime    =   900;
    var modal       =   $('#modalDiv');
    var oldDiv      =   null;

    $('.someDiv').on('click', function(e){
        if(oldDiv)
            oldDiv.css('opacity', 1)
        var jthis = $(this);
        modal.css({
            'top'           :   jthis.offset().top - 68,
            'left'          :   jthis.offset().left - 10,
            'width'         :   jthis.width(),
            'height'        :   jthis.height(),
            'background'    :   jthis.css('background'),
            'opacity'       :   1,
            'display'       :   'block',
        });
        jthis.css('opacity', 0);
        var n = 0;
        modal.animate({
                'height':   400,
                'width':    400
            }, {
                duration    : 2000,
                queue       : false, // false
                specialEasing: {
                    height :    'swing', // linear
                    width:      'swing'
                },
                complete : function(){
                    console.log('Animation complete');
                },
                step: function(){
                    console.log(n++);
                    // if(n == 100)
                    //     modal.stop();

                }
            }) // queue - оередь
            //.animate({'width': 400}, { duration : 2000 , queue : true})// true - оередь
            .animate({
                'top': (window.innerHeight - 400) / 2,
                'left': (window.innerHeight - 400) / 2
            }, {
                duration    : 1000,
                // queue       : true,
                specialEasing: {
                    height :    'swing',
                    width:      'swing'
                }
            });
        oldDiv = jthis;
    });

    modal.on('click', function(e){
        $(this).fadeOut(animTime);
    });

    //  var modal       =   $('#piar-modal');
    //  var animTime    =   2000;
    //  var popup       =   $('#modalDiv');
    //  if(modal.css('display') == 'none')
    //      modal.modal('show');
    //  $('.someDiv').on('click', function(e){
    //      popup.css('top', (window.innerHeight - popup.height()) / 2);
    //      popup.css('left', (window.innerWidth - popup.width()) / 2);
    //      popup.css('background', $(e.target).css('background'));
    //      popup.fadeIn(animTime);
    //      // popup.show(animTime);
    //      // popup.css('display', 'block');
    //  });
    //  popup.on('click', function(e){
    //      // $(this).css('display','none');
    //      $(this).fadeOut(animTime);
    //      // $(this).hide(animTime);
    //  });
}


/** Client part */
//   if(!is_module){
//       /** Каждую секунду увеличиваем количество секунд простоя мыши */
//       setInterval("now_no_active++;", 1000);
//       /** Запускаем функцию updateChat() через определённый интервал */
//       setInterval("updateChat()", 1000);
//       /** Ставим обработчик на движение курсора мыши */
//       document.onmousemove = activeUser;
//   }

/** Окно */
var elem = window;
/** Обрубаем лишние события для модуля админа */
// if(!is_module) {
//     if ( elem.addEventListener ) {
//         elem.addEventListener( "wheelzoom", elem.onmousewheel = function( e ) {
//             e.preventDefault();
//         }, false );
//     }
//     else {
//         elem.onmousewheel = function( e ) {
//             window.event.returnValue = false;
//         }
//     }
// }


/** Реализация масштабирования при помощи скролинга колёсиком мыши */

/** Переменные */
var delta;
/** Объявление переменной значения зума */
var isCall = false;
if(!isCall){
    var zoom = 1;
    /** Чтобы начальное значение было присвоено 1 раз */
    isCall = true;
}

/** Функция для добавления обработчика событий */
function addHandler(object, event, handler){
    if(object.addEventListener){
        object.addEventListener(event, handler, false);
    }
    else if(object.attachEvent){
        object.attachEvent('on' + event, handler);
    }
    else {
        alert("Обработчик не поддерживается");
    }
}
/**  изменение высоты блоков*/
function resizeHeight() {

    //  console.log('resizeHeight');
    //  console.log('!!!!');
    //  return false;
    var arr     =   [
        '.product-category-item',
        '.product-category-item  header',
        '.supplier-node',
        '.sale-node header',
        '.supplier-list-item'
        //  '.slider-item img',
        //  '.slider-item',
        //  '.slider-item .slider-img',
        //  '.slider-item footer',
    ];
    var max     =   0;
    if(arr.length) {
        for(var i = 0; i < arr.length; i++){
            var nodeName = arr[i];
            if(!$(nodeName).length) {
                continue;
            }
            $(nodeName).each(function() {
                var type = $(this)[0].tagName
                // console.log(type);
                // if(type == 'IMG'){
                //     var height = Math.floor(396*$(window).width() / 2447);
                //     $('img').height(height);
                // }
                if($(this).height() > max){
                    max = $(this).height();
                }
            });
            $(nodeName).height(max); //  + 10
            max = 0;
        }
        //  var height = Math.floor(396 * $(window).width() / 2447);
        //  $('.slider-item img').height(height);
    }
}

function resizeImages() {
    //  console.log('resizeImages');
    var arr     =   [
        '.slider-img img',
        //  '.supplier-list-item img'
    ];
    for(var i = 0; i < arr.length; i++){
        var images  =   $(arr[i]);
        if(!images) {
            return false;
        }
        console.log( 'images: ' + images.length );
        images.each( function() {
            //  , .slider-img
            //  console.log($(window).width());
            //  if (window.matchMedia('(max-width: 767px)').matches) {
            var width   =   $(this).width(),
                height  =   $(this).height(),
                maxWidth,
                maxHeight,
                ratio;
            // col-xs col-sm
            if ($(window).width() < 970) { // 970px

                if($(window).width() < 750) {
                    maxWidth    =   100;
                    maxHeight   =   100;
                }
                else {
                    maxWidth    =   150;
                    maxHeight   =   150;
                }
            }
            else {
                maxWidth    =   250;
                maxHeight   =   250;
            }
            var newWidth, newHeight;
            //  если ширина равна высоте
            if( width   ==  height ) {
                ratio       =   'square';
                newWidth    =   maxWidth;
                newHeight   =   maxWidth;
            }
            else {
                if( width   >   height ) {
                    ratio   =   maxWidth    /   width;
                    if(!ratio) {
                        console.log('ratio error..._1_');
                    }
                    newWidth    =   maxWidth;
                    newHeight   =   height * ratio;
                    newHeight   =   newHeight.toFixed(0); // 0  // 1
                }
                //  если высота картинки больше максимума
                else {
                    ratio       =   maxHeight / height;
                    console.log('ratio = ' + maxHeight + ' / ' + height);
                    if( !ratio ) {
                        console.log('ratio error..._2_');
                    }
                    newHeight   =   maxHeight;
                    newWidth    =   width * ratio;
                    newWidth    =   newWidth.toFixed(0); // 0   // 1
                }
            }
            //  console.log( 'ratio: '   + ratio );
            //  console.log( 'maxWidth: '   + maxWidth  + '; maxHeight: '  + maxHeight  + ';');
            //  console.log( 'width: '      + width     + '; height: '     + height     + ' ;');
            //  console.log( 'newWidth: '   + newWidth  + '; newHeight: '     + newHeight     + ' ;');
            //  console.log( 'maxWidth: '   + maxWidth );
            //  console.log( 'width: '      + width );
            //  console.log( 'maxHeight: '  + maxHeight );
            //  console.log( 'height: '     + height );
            //  console.log('______________________________________');
            $(this).css("width",    newWidth);
            $(this).css("height",   newHeight);
        });
    }
}

function resizeSlider() {
    var list    =   $('.slick-list');
    var max     =   0;
    list.each(function(e) {
        var height  =   $(this).height();
        $(this).closest('.slider-block').height( height );
    });
}

/** Изменение размера картинки*/
function imgResize() {
    //  $('.photo img').each(function() {
    $('.supplier-list-item img').each(function() {
        var width   =   $(this).width();
        var height  =   $(this).height();
        if(width > height) {
            $(this).css({
                width:'80%',
                height: 'auto'
            });
        }
        else {
            $(this).css({
                height:'100%',
                width: 'auto'
            });
        }
    })
}


function sortByPrice(vector){
    var output = null;
    console.log(vector);
    if(!vector){
        displayMessage('Направление не определено.');
        return false;
    }
    var arr = [];
    var product_node_name = '.content-block > .product-node';
    $(product_node_name).each(function(){
        /** Если в массив не добавлен ни один элемент */
        // if(!(arr.length))
        /** Добавляем первый элемент */
        // arr.unshift($(this).data('price'));
        // arr.unshift(parseFloat($(this).data('price')));
        arr.unshift(parseInt($(this).data('price')));
        /** Последующие элементы */
        // shift - dl begin
        // pop - del end
    });
    console.log(arr);
    /** Цены по возрастанию */
    if(vector == 'up') {
        output = arr.sort(sDecrease)
    }
    /** Цены по убыванию */
    else {
        output = arr.sort(sIncrease)
    }
    // console.log(output);
    var node = null;
    for(var i = 0; i < arr.length; i++) {
        node = $(product_node_name + '[data-price="' + arr[i] + '"]');
        // console.log(product_node_name + '"[data-price="' + arr[i] + '"]');
        node.prependTo('.content-block');
        // $(node).remove();
    }
    /** покрасить битые картинки */
    drawEmptyImages();
}







/**
 * seemless print
 * Распечатка */
function printOrder2(htmlPage) {
    displayMessage('Отправлено на печать');
    var w = window.open("about:blank");
    w.document.write(htmlPage);
    w.document.close();
    w.print();
    w.close();
}
/** Печать заказа */
function printOrder(htmlPage) {
    // @todo вытащить картинку (в представлении)
    $('#canvas-print-wrapper').css({'display':'block'});
    var canvas  = $('body').find('#canvas-print-wrapper canvas:first-child');
    var dataURL = canvas[0].toDataURL();
    // @todo отправить bait код Айбару
    var dataURL = canvas[0].toDataURL();
    // @todo вариант с vertix
        //  $.ajax({
        //      type: "GET",
        //      dataType : 'jsonp',
        //      crossDomain: true,
        //      asynth: true,
        //      contentType: "application/json; charset=utf-8",
        //      url: "http://localhost:8080",
        //      headers: { "Access-Control-Allow-Origin" : "*"},
        //      data: {
        //          imgBase64         :   dataURL,
        //          YII_CSRF_TOKEN    :   csrfToken
        //      },
        //      error: function() {
        //          console.log('nein');
        //      },
        //  }).done(function(data,  status, xhr)
        //  {
        //      displayMessage('На печать');
        //      $('#canvas-print-wrapper').css({'display':'none'});
        //      console.log('saved:' +  "\n" + data);
        //      с(xhr.getResponseHeader('Location'));
        //  });

    // @todo Вариант с сохранением картикнки

        // $.ajax({
        //     type: "POST",
        //     url: "/orders/saveCheck",
        //     data:{
        //         imgBase64         :   dataURL,
        //         YII_CSRF_TOKEN    :   csrfToken
        //         }
        // }).done(function(data) {
        //     displayMessage('На печать');
        //     $('#canvas-print-wrapper').css({'display':'none'});
        //     console.log('saved:' +  "\n" + data);
        // });
    // }

    //  if(canvasWrapper.hasChildNodes())
    //  {
    //      var canvas = canvasWrapper.firstChild; // childNodes[0];
    //      console.log(canvas.tagName);
    //  }
    //  else
    //      console.log("Потомки не найдены");
    //  canvas.style.marginTop = "-50px";

}
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
/** Создать страницу */
function createPage() {
    /** Список товаров заказа*/
    $('.print-list').css({'display':'block'});
    var content = $('.print-list').html();
    var output =
        "<html>" +
            "<header>" +
                "<title></title>" +
            "</header>" +
            "<body>"
                +'<div style="text-align:center;">'
                    + content
                +"</div>"
                +"<div>success</div>"
            + "</body>"
        +"</html>";
    $('.print-list').css({'display':'none'});
    console.log(output);
    return output;
}
/** Функции сортировки */
/** По возрастанию */
function sIncrease(i, ii) {
    if (i > ii)
        return 1;
    else if (i < ii)
        return -1;
    else
        return 0;
}
/** По убыванию */
function sDecrease(i, ii) {
    if (i > ii)
        return -1;
    else if (i < ii)
        return 1;
    else
        return 0;
}


function sortByPrice(vector){
    var output = null;
    console.log(vector);
    if(!vector) {
        displayMessage('Направление не определено.');
        return false;
    }
    var arr                 =   [];
    var product_node_name   =   '.product-node';
    $(product_node_name).each(function() {
        /** Если в массив не добавлен ни один элемент */
        // if(!(arr.length))
            /** Добавляем первый элемент */
            // arr.unshift($(this).data('price'));
            // arr.unshift(parseFloat($(this).data('price')));

            console.log('price: ' + $(this).data('price'));

            arr.unshift(parseInt($(this).data('price')));
        /** Последующие элементы */
        // shift - dl begin
        // pop - del end
    });
    console.log(arr);
    /** Цены по возрастанию */
    if(vector == 'up') {
        output = arr.sort(sDecrease)
    }
    /** Цены по убыванию */
    else {
        output = arr.sort(sIncrease)
    }
    // console.log(output);
    var node = null;
    for(var i = 0; i < arr.length; i++) {
        node = $(product_node_name + '[data-price="' + arr[i] + '"]');
        // console.log(product_node_name + '"[data-price="' + arr[i] + '"]');
        node.prependTo('.content-block');
        // $(node).remove();
    }
    /** покрасить битые картинки */
    drawEmptyImages();
}
/** покрасить битые картинки */
function drawEmptyImages() {
    /*$('img').error(function(){
        $(this).attr('src', '/images/default.png');
    });
    // $('img').error(function(){
    //     /** Дефолтная картинка */
    //     $(this).attr('src', '/images/default.png');
    //     /** Удаление */
    //     // $(this).remove();
    //     /** Скрытие */
    //     // $(this).hide();
    // });
}
/** Добавить в корзину */
function addToCart(object_id, qty, weight) {

    // console.log( qty + ":" + weight );
    // return false;

    $.ajax ({
        type    :   'post',
        url     :   '/customer/cart/addToCart',
        data    :   {
            id              :   object_id,
            qty           :   qty,
            weight          :   weight,
            YII_CSRF_TOKEN  :   csrfToken
        },
        success: function(data) {
            // console.log('ajax ' + data);
            // console.log('price: ' + price);
            if(data == '-1') {
                displayMessage('Нельзя делать один заказ сразу для двух поставщиков');
                return;
            }
            else if(data == '-2') {
                displayMessage('Невозможно закахзать упраздненный товар');
                return;
            }
            else if(data == '-3') {
                displayMessage('Чтобы сделать заказ, Вам необходимо авторизоваться в системе', 'warning');
                return;
            }
            else {
                price = data;
                $('.cart-count').text(parseInt($('.cart-count').text()) + parseInt(qty));
                $('.cart-price').text(parseInt($('.cart-price').text()) + parseInt(price));
                $('#cart_confirm').modal('show');
            }
            // console.log('ok : ' + qty + ':' + price);
        },
        error: function() {
            console.log('error!');
        }
    });
}
/** распечатка */
function print_r( array, return_val ) {
    var output = "", pad_char = " ", pad_val = 4;
    var formatArray = function (obj, cur_depth, pad_val, pad_char) {
        if(cur_depth > 0)
            cur_depth++;
        var base_pad = repeat_char(pad_val*cur_depth, pad_char);
        var thick_pad = repeat_char(pad_val*(cur_depth+1), pad_char);
        var str = "";
        if(typeof obj=='object' || typeof obj=='array' || (obj.length>0 && typeof obj!='string' && typeof obj!='number')) {
            if(!(typeof obj=='object' || typeof obj=='array'))str = '\n'+obj.toString()+'\n';
            str += '[\n';//"Array\n" + base_pad + "(\n";
            for(var key in obj) {
                if(typeof obj[key]=='object' || typeof obj[key]=='array' || (obj.length>0 && typeof obj!='string' && typeof obj!='number')) {
                    str += thick_pad + ""+key+": "+((!(typeof obj=='object' || typeof obj=='array'))?'\n'+obj[key]+'\n':'')+formatArray(obj[key], cur_depth+1, pad_val, pad_char)+'\n';
                } else {
                    str += thick_pad + ""+key+": " + obj[key] + "\n";
                }
            }
            str += base_pad + "]\n";
        } else {
            str = obj.toString();
        };
        return str;
    };
    var repeat_char = function (len, char) {
        var str = "";
        for(var i=0; i < len; i++) { str += char; };
        return str;
    };
    output = formatArray(array, 0, pad_val, pad_char);
    return output;
}

/** максимальная высота */
function equalHeight() {
    var h = 0;
    $('.category > div > div').each(function(){
        if($(this).height() > h)
            h = $(this).height();
    });
    $('.category > div > div').height(h);
}


/** Фиксированое меню при скроллинге вниз */
// $(function() {
//     /** высота шапки */
//     var h_hght  = $('.outer').height();
//     // var h_hght  = 150;
//     /** отступ когда шапка уже не видна */
//     var h_mrg   =  100; // $('header.header').height();
//     // var h_mrg   = 0;
//     // console.log(h_hght + ':'+h_mrg);
//     $(function(){
//         var elem    = $('#outer');
//         var top     = $(this).scrollTop();
//         if(top > h_hght){
//             elem.css('top', h_mrg);
//         }
//         $(window).scroll(function(){
//             top = Math.floor($(this).scrollTop() * 10)/10;
//             // console.log(top + ':' + h_mrg + ':' + h_hght);
//             if (top < h_mrg) {
//                 // if (top + h_mrg < h_hght) {
//                 elem.find('.navbar').removeClass('navbar-fixed-top').css({'background':'none'});
//                 // elem.css({'position':'relative'});
//             } else {
//                 elem.find('.navbar').addClass('navbar-fixed-top').css({'background':'rgba(255, 255, 255, 1)'});
//                 // elem.css({'position':'fixed'});
//             }
//         });
//     });
// });
