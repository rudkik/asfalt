// повторная инициализация
function __init() {
    $('button[data-widget="remove"]').click(function () {
        $(this).parent().parent().parent().remove();

        return false;
    });
}

$(document).ready(function () {
    __init();
    $('a[data-action="down"]').click(function () {
        tmp = $(this).parent().children('input');
        val = tmp.val() * 1 - 1;
        tmp.val(val);
        tmp.attr('value', val);

        if(tmp.data('template') == 'cart'){
            editCart(tmp);
        }

        return false;
    });

    $('a[data-action="up"]').click(function () {
        tmp = $(this).parent().children('input');
        val = tmp.val() * 1 + 1;
        tmp.val(val);
        tmp.attr('value', val);

        if(tmp.data('template') == 'cart'){
            editCart(tmp);
        }

        return false;
    });

    /** Пересчет товаров в корзине */
    $('input[data-template="cart"]').change(function(){
        editCart($(this));
    });
    /** Пересчет товаров в корзине */
    $('input[data-template="cart"]').keyup(function(){
        editCart($(this));
    });

    $('a[data-action="add-cart"]').click(function(e) {
        e.preventDefault();
        id = $(this).data('id');
        shop = $(this).data('shop');
        count = $(this).parent().parent().find('input[data-name="count"]').val();
        $.ajax ({
            type    : 'post',
            url     : '/customer/shopcart/add',
            data    : {
                id: (id),
                item_id: (0),
                count: (count),
                is_result: (1),
                shop_branch_id: (shop)
            },
            success: function(data) {
                var obj = jQuery.parseJSON($.trim(data));
                $('.cart-count').text(obj.count);
                $('.cart-price').text(obj.amount_str);
            },
            error: function() {
            }
        });
    });

    $('[data-action="set-bill-status"]').click(function(e) {
        e.preventDefault();
        id = $(this).data('id');

        $('#bill-comment').attr('style', '');

        n = $('#bill-comment [name="shop_bill_status_id"]');
        n.val(id);
        n.attr('value', id);
    });

    $('a[data-action="del-cart"]').click(function(e) {
        id = $(this).data('id');
        shop = $(this).data('shop');
        $.ajax ({
            type    : 'post',
            url     : '/customer/shopcart/del',
            data    : {
                id: (id),
                item_id: (0),
                is_result: (1),
                shop_branch_id: (shop)
            },
            success: function(data) {
                var tr = 'tr[data-id="'+id+'"]';
                $(tr).remove();

                var obj = jQuery.parseJSON($.trim(data));
                getAmountCount(obj, shop);
            },
            error: function() {
                alert('error!');
            }
        });

        return false;
    });
});

function editCart(element) {
    id = element.data('id');
    shop = element.data('shop');
    count = element.parent().parent().find('input[data-name="count"]').val();
    $.ajax ({
        type    : 'post',
        url     : '/customer/shopcart/edit',
        data    : {
            id: (id),
            item_id: (0),
            count: (count),
            is_result: (1),
            shop_branch_id: (shop),
            get_shop_id: (shop),
        },
        success: function(data) {
            var obj = jQuery.parseJSON($.trim(data));
            getAmountCount(obj, shop);
            $('[data-name="good-'+id+'"]').text(obj.current_amount_str);
        },
        error: function() {
        }
    });
}

function getAmountCount(obj, shopID){
    $('[data-name="amount-'+shopID+'"]').text(obj.amount_str);

    $('[data-name="count-'+shopID+'"]').text(obj.count);

    billMin = $('#min-bill-'+shopID).data('value');
    if(billMin > obj.amount){
        $('#apply-bill-'+shopID).attr('disabled', '');
    }else{
        $('#apply-bill-'+shopID).removeAttr('disabled');
    }
}


function initLoadImageAddition() {
    $('.box-image').dmUploader({
        url: '/supplier/file/loadimage',
        dataType: 'json',
        maxFileSize: 10 * 1024 * 1014,
        allowedTypes: 'image/*',
        onBeforeUpload: function (id) {
            output = $(this).find('.box-body ul li');
            output.html('<img src="/css/_component/loadimage_v2/loader.gif">').show();
        },
        onUploadSuccess: function (id, response) {
            output = $(this).find('.box-body ul li');

            if (response.type == "message") {
                output.html('<span class="error">Ошибка загрузки.</span><br><span class="text-red">' + response.data.txt + '</span>');
            }else{
                if (response.type == "upload") {
                    output.html('<img src="' + response.data.url + '">');

                    input =  $(this).find('input[data-id="file-url"]');
                    input.attr('value', response.data.file);
                    input.val(response.data.file);

                    input =  $(this).find('input[data-id="file-name"]');
                    input.attr('value', response.data.file_name);
                    input.val(response.data.file_name);

                    input =  $(this).find('input[data-id="file-id"]');
                    input.attr('value', 0);
                    input.val(0);
                }else{
                    output.html('')
                }
            }
        },
        onUploadError: function (id, message) {
            output = $(this).find('.box-body ul li');
            output.html('<span class="error">Ошибка загрузки.</span><br><span class="text-red">' + "Файл: " + id + " не загрузился: " + message + '</span>');
        },
        onFileTypeError: function (file) {
            output = $(this).find('.box-body ul li');
            output.html('<span class="error">Ошибка загрузки.</span><br><span class="text-red">Загружать можно только PNG и JPEG.</span>');
        },
        onFileSizeError: function (file) {
            output = $(this).find('.box-body ul li');
            output.html('<span class="error">Ошибка загрузки.</span><br><span class="text-red">Файл слишком большой (максимальный размер 10МБ).</span>');
        },
        onFallbackMode: function (message) {
            output = $(this).find('.box-body ul li');
            output.html('<span class="error">Ошибка загрузки.</span><br><span class="text-red">Ваш браузер не поддерживается.</span>');
        }
    });

    $('a[class="dropzone-del"]').click(function () {
        $(this).parent().attr('hidden', 'hidden');
        $(this).parent().find('div input[data-id="file-isdel"]').attr('value', '1');

        return false;
    });
}

function initLoadimage() {
    initLoadImageAddition();

    $('div[name="add-images"]').dmUploader({
        url: '/supplier/file/loadimage',
        dataType: 'json',
        maxFileSize: 10 * 1024 * 1014,
        allowedTypes: 'image/*',
        onBeforeUpload: function (id) {
            postfix = $(this).data('postfix');

            output = $('#sort-images' + postfix);

            index = $('#sort-images' + postfix + ' > div').length + 1;

            panel = $.trim(
                $('#add-image-panel' + postfix).html()
                    .replace('<!--', '')
                    .replace('-->', '')
                    .replace('#column#', output.attr('column'))
                    .replace('#name#', 'div-image-' + postfix + id)
                    .replace(/#index#/g, index)
            );
            output.append(panel).show();

            output = $('div[name="div-image-' + postfix + id + '"] .box-body ul li');
            output.html('<img src="/css/_component/loadimage_v2/loader.gif">').show();
            __init()
        },
        onUploadSuccess: function (id, response) {
            postfix = $(this).data('postfix');
            output = $('div[name="div-image-' + postfix + id + '"] .box-body ul li');

            if (response.type == "message") {
                output.html('<span class="error">Ошибка загрузки.</span><br><span class="text-red">' + response.data.txt + '</span>');
            }else{
                if (response.type == "upload") {
                    output.html('<img src="' + response.data.url + '">');

                    input =  $('div[name="div-image-' + postfix + id + '"] input[data-id="file-url"]');
                    input.attr('value', response.data.file);
                    input.val(response.data.file);

                    input =  $('div[name="div-image-' + postfix + id + '"] input[data-id="file-name"]');
                    input.attr('value', response.data.file_name);
                    input.val(response.data.file_name);

                }else{
                    output.html('')
                }
            }
            $('div[name="div-image-' + id + '"]').removeAttr('name');
        },
        onUploadError: function (id, message) {
            postfix = $(this).data('postfix');
            output = $('div[name="div-image-' + postfix + id + '"] .box-body ul li');
            output.html('<span class="error">Ошибка загрузки.</span><br><span class="text-red">' + "Файл: " + id + " не загрузился: " + message + '</span>');
        },
        onFileTypeError: function (file) {
            output = $('div[name="div-image-' + postfix + id + '"] .box-body ul li');
            output.html('<span class="error">Ошибка загрузки.</span><br><span class="text-red">Загружать можно только PNG и JPEG.</span>');
        },
        onFileSizeError: function (file) {
            postfix = $(this).data('postfix');
            output = $('div[name="div-image-' + postfix + id + '"] .box-body ul li');
            output.html('<span class="error">Ошибка загрузки.</span><br><span class="text-red">Файл слишком большой (максимальный размер 10МБ).</span>');
        },
        onFallbackMode: function (message) {
            postfix = $(this).data('postfix');
            output = $('div[name="div-image-' + postfix + id + '"] .box-body ul li');
            output.html('<span class="error">Ошибка загрузки.</span><br><span class="text-red">Ваш браузер не поддерживается.</span>');
        }
    });
}
