function addPhone(panelID, panelAdd){
    index = $('#' + panelID).data('index') * 1 ;
    $('#' + panelID).append($('#' + panelAdd).html().replace('<!--', '').replace('-->', '').replace(/#index#/g, index + $('#' + panelID).children('div').length));
    $('#' + panelID).data('index', index);
    __init();
}

// повторная инициализация
function __init() {
    $('button[data-widget="remove"]').click(function () {
        $(this).parent().parent().parent().remove();

        return false;
    });
}

$(document).ready(function () {
    __init();
    $('a[data-action="phone-delete"]').click(function () {
        $(this).parent().parent().remove();

        return false;
    });

    /** Пересчет товаров в корзине */
    $('input[data-action="count-edit"]').change(function(){
        editBill($(this));
    });
    /** Пересчет товаров в корзине */
    $('input[data-action="count-edit"]').keyup(function(){
        editBill($(this));
    });

    $('input[data-action="price-edit"]').change(function(){
        editBill($(this));
    });
    /** Пересчет товаров в корзине */
    $('input[data-action="price-edit"]').keyup(function(){
        editBill($(this));
    });

    $('a[data-action="down"]').click(function () {
        tmp = $(this).parent().children('input');
        val = tmp.val() * 1 - 1;
        tmp.val(val);
        tmp.attr('value', val);
        editBill(tmp);

        return false;
    });

    $('a[data-action="up"]').click(function () {
        tmp = $(this).parent().children('input');
        val = tmp.val() * 1 + 1;
        tmp.val(val);
        tmp.attr('value', val);

        editBill(tmp);


        return false;
    });

    $('a[data-action="goods-delete"]').click(function () {
        tmp = $(this).parent().parent().find('input[data-action="count-edit"]');
        tmp.val(0);
        tmp.attr('value', 0);

        editBill(tmp);


        return false;
    });

    $('[data-action="set-bill-status"]').click(function(e) {
        e.preventDefault();
        id = $(this).data('id');

        $('#bill-comment').attr('style', '');

        n = $('#bill-comment [name="shop_bill_status_id"]');
        n.val(id);
        n.attr('value', id);
    });

    // удаление записи в таблицы
    $('table td li.tr-remove a').click(function () {
        url = $(this).attr('href');

        if(url != '') {
            var s = $(this).parent().parent();
            jQuery.ajax({
                url: url,
                data: ({
                    is_main: (1),
                    json: (1),
                }),
                type: "POST",
                success: function (data) {
                    s.removeClass('delete');
                    s.addClass('un-delete');
                },
                error: function (data) {

                }
            });
            return false;
        }
    });

    // восстановление записи в таблицы
    $('table td li.tr-un-remove a').click(function () {
        url = $(this).attr('href');

        var s = $(this).parent().parent();
        jQuery.ajax({
            url: url,
            data: ({
                is_main: (1),
                is_undel: (1),
                json: (1),
            }),
            type: "POST",
            success: function (data) {
                s.removeClass('un-delete');
                s.addClass('delete');
            },
            error: function (data) {

            }
        });
        return false;
    });

    // в таблице сохранения активный / неактивный
    $('input[name="set-is-public"]').on('ifChecked', function (event) {
        isPublic = 1;
        url = $(this).attr('href');

        jQuery.ajax({
            url: url,
            data: ({
                is_public: (isPublic),
                json: (1),
            }),
            type: "POST",
            success: function (data) {
            },
            error: function (data) {

            }
        });
    }).on('ifUnchecked', function (event) {
        isPublic = 0;
        url = $(this).attr('href');

        jQuery.ajax({
            url: url,
            data: ({
                is_public: (isPublic),
                json: (1),
            }),
            type: "POST",
            success: function (data) {
            },
            error: function (data) {

            }
        });
    });

    // в таблице сохранения активный / неактивный
    $('input[name="set-is-active"]').on('ifChecked', function (event) {
        isActive = 1;
        url = $(this).attr('href');

        jQuery.ajax({
            url: url,
            data: ({
                is_active: (isPublic),
                json: (1),
            }),
            type: "POST",
            success: function (data) {
            },
            error: function (data) {

            }
        });
    }).on('ifUnchecked', function (event) {
        isActive = 0;
        url = $(this).attr('href');

        jQuery.ajax({
            url: url,
            data: ({
                is_active: (isActive),
                json: (1),
            }),
            type: "POST",
            success: function (data) {
            },
            error: function (data) {

            }
        });
    });

    // в таблице сохранения новинка
    $('input[name="set-is-new"]').on('ifChecked', function (event) {
        data = $(this).data('id');
        url = $(this).attr('href');

        jQuery.ajax({
            url: url,
            data: ({
                good_select_type_id: (data),
                json: (1),
            }),
            type: "POST",
            success: function (data) {
            },
            error: function (data) {

            }
        });
    }).on('ifUnchecked', function (event) {
        data = 0;
        url = $(this).attr('href');

        jQuery.ajax({
            url: url,
            data: ({
                good_select_type_id: (data),
                json: (1),
            }),
            type: "POST",
            success: function (data) {
            },
            error: function (data) {

            }
        });
    });

    // меняем value в зависимости от нажатия
    $('input[type="checkbox"], input[type="radio"]').on('ifChecked', function (event) {
        $(this).attr('value', $(this).data('id'));
        $(this).attr('checked', '');
    }).on('ifUnchecked', function (event) {
        $(this).attr('value', '0');
        $(this).removeAttr('checked');
    });

    initLoadimage();
});

function editBill(element, price, id) {
    amount = 0;
    $('#list-goods > tr').each(function (i) {
        price = $(this).find('input[data-action="count-edit"]').val();
        count = $(this).find('input[data-action="price-edit"]').val();

        $(this).find('[data-name="goods-amount"]').text((price * count) + ' тг');

        amount = amount + (price * count);
    });

    $('.price').text(amount + ' тг');
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