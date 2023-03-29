$(document).ready(function () {
    $('[data-cart-action="add-good"]').click(function () {
        var goodID = parseInt($(this).data('id'));
        var childID = parseInt($(this).data('child'));
        var shopID = parseInt($(this).data('shop'));
        var count = parseFloat($('input[data-cart-count="' + goodID + '"]').val());
        button = $(this);

        jQuery.ajax({
            url: '/manager/shopcart/add_good',
            data: ({
                id: (goodID),
                shop_good_child_id: (childID),
                shop_branch_id: (shopID),
                count: (count),
            }),
            type: "POST",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));
                if (obj.error) {
                    alert(obj.msg);
                } else {
                    //location.reload();
                    button.removeClass('btn-danger');
                    button.addClass('btn-info');
                }
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    });
    $('[data-cart-action="del-good"]').click(function () {
        var goodID = parseInt($(this).data('id'));
        var childID = parseInt($(this).data('child'));
        var shopID = parseInt($(this).data('shop'));

        jQuery.ajax({
            url: '/manager/shopcart/del_good',
            data: ({
                id: (goodID),
                shop_good_child_id: (childID),
                shop_branch_id: (shopID),
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

    $('[data-cart-action="set-good-count"]').change(function () {
        var goodID = parseInt($(this).data('id'));
        var childID = parseInt($(this).data('child'));
        var shopID = parseInt($(this).data('shop'));
        var count = parseFloat($(this).val());
        var isCountUp = parseInt($(this).data('count-up'));
        if(isCountUp == 1) {
            var price = parseFloat($(this).data('good-price'));
            var amount = parseFloat($(this).data('good-amount'));
            $(this).data('good-amount', price * count);
        }

        jQuery.ajax({
            url: '/manager/shopcart/edit_good',
            data: ({
                id: (goodID),
                shop_good_child_id: (childID),
                shop_branch_id: (shopID),
                count: (count),
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
    });

    initLoadimage();
});

function initLoadImageAddition() {
    $('.box-image').dmUploader({
        url: '/manager/file/loadimage',
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
        url: '/manager/file/loadimage',
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
            initLoadImageAddition();
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
