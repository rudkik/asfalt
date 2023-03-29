var elementFocus = $('[data-action="find-barcode"]');
__init();

var isFindBarcode = false;
var isFindCard = false;

/**
 * Поиск продукции по штрихкоду
 * @param barcode
 * @param url
 * @param el - поле ввода штрихкода
 */
function findBarcode(barcode, url, el){
    if(barcode == ''){
        return false;
    }

    if(el.data('is-unique')) {
        var tr = $('tr[data-barcode="' + barcode + '"]');
        if (tr.length == 1) {
            tr.parent().prepend(tr);

            var quantityEl = tr.find('[data-id="quantity"]');
            if (quantityEl.length < 1 || quantityEl.get(0).localName != 'input') {
                quantityEl = tr.find('[data-id="count"]');
            }

            var quantity = Number(quantityEl.val()) + 1;
            if (quantityEl.get(0).localName == 'input') {
                quantityEl.val(quantity).attr('value', quantity);
            } else {
                quantityEl.text(quantity).attr('value', quantity);
            }

            // проверяем были просчеты у элементов таблицы
            var root = tr.find('input[data-action="tr-multiply"], select[data-action="tr-multiply"]');
            if (root.length > 0) {
                root.first().trigger('change');
            }

            // нумерация
            $('#products [data-id="index"]').each(function (i, el) {
                $(this).html(i + 1);
            });
            el.val('');
            return true;
        }
    }

    isFindBarcode = true;
    jQuery.ajax({
        url: url,
        data: ({
            barcode: (barcode),
        }),
        type: "POST",
        success: function (data) {
            isFindBarcode = false;
            var obj = jQuery.parseJSON($.trim(data));
            if(obj.is_find){
                el.val('').attr('value', '');

                var tr = addElement('new-product', 'products', false);
                tr.find('[data-id="shop_product_name"]').text(obj.values.name);
                tr.find('[data-id="shop_product_id"]').val(obj.values.id).attr('value', obj.values.id);
                tr.find('[data-id="unit"]').text(obj.values.unit);
                tr.attr('data-barcode', obj.values.barcode);
                tr.find('[data-id="barcode"]').text(obj.values.barcode);
                tr.find('[data-id="img-status"]').attr('data-img', obj.values.image_path != '' && obj.values.image_path != null);

                // заменяем в ссылке id продукта
                var element = tr.find('[href*="#shop_product_id#"]');
                if(element.length > 0) {
                    element.each(function () {
                        $(this).attr('href', $(this).attr('href').replace('#shop_product_id#', obj.values.id));
                    });
                }

                if(el.data('not-quantity') != 1) {
                    if (obj.values.quantity !== undefined) {
                        if (el.data('is-coefficient') == 1) {
                            obj.values.quantity = (obj.values.quantity / obj.values.coefficient_revise).toFixed(3);
                        }

                        var element = tr.find('[data-id="quantity"]');
                        if (element.length > 0) {
                            if (element.get(0).localName == 'input') {
                                element.attr('value', obj.values.quantity).val(obj.values.quantity);
                            } else {
                                element.attr('value', obj.values.quantity).text(obj.values.quantity);
                            }
                        }
                    }
                }

                if(obj.values.price !== undefined) {
                    s = obj.values.price.replace(',', '.').replace('.00', '');
                    var element = tr.find('[data-id="price"]');
                    if(element.length > 0) {
                        if (element.get(0).localName == 'input') {
                            element.attr('value', s).val(s);
                        } else {
                            element.attr('value', s).text(s);
                        }
                    }
                }

                if(obj.values.price_average !== undefined) {
                    s = obj.values.price_average.toString().replace(',', '.').replace('.00', '');
                    var element = tr.find('[data-id="price_average"]');
                    if(element.length > 0) {
                        if (element.get(0).localName == 'input') {
                            element.attr('value', s).val(s);
                        } else {
                            element.attr('value', s).text(s);
                        }
                    }
                }

                if(obj.values.price_purchase !== undefined) {
                    var s = obj.values.price_purchase.replace(',', '.').replace('.00', '');
                    var element = tr.find('[data-id="price_purchase"]');
                    if(element.length > 0) {
                        if (element.get(0).localName == 'input') {
                            element.attr('value', s).val(s);
                        } else {
                            element.attr('value', s).text(s);
                        }
                    }
                }

                if(obj.values.price_cost !== undefined) {
                    var s = obj.values.price_cost.replace(',', '.').replace('.00', '');
                    var element = tr.find('[data-id="price_cost"]');
                    if(element.length > 0) {
                        if (element.get(0).localName == 'input') {
                            element.attr('value', s).val(s);
                        } else {
                            element.attr('value', s).text(s);
                        }
                    }
                }
                tr.find('[data-id="quantity"]').trigger('change');

                // остаток
                if(el.data('not-quantity') != 1) {
                    if (obj.values.stock !== undefined) {
                        tr.attr('data-stock', obj.values.stock);
                        if (obj.values.stock < 1) {
                            tr.addClass('b-red');
                        }

                        var element = tr.find('[data-id="stock"]');
                        if (element.length > 0) {
                            if (element.get(0).localName == 'input') {
                                element.attr('value', obj.values.stock).val(obj.values.stock);
                            } else {
                                element.attr('value', obj.values.stock).text(obj.values.stock);
                            }
                        }
                    }
                }

                __init();

                // проверяем были просчеты у элементов таблицы
                var root = tr.find('input[data-action="tr-multiply"], select[data-action="tr-multiply"]');
                if(root.length > 0){
                    root.first().trigger('change');
                }

                // картинка товара
                var goodsImg = $('#img-goods');
                if(goodsImg.length > 0 && obj.values.image_path != ''){
                    goodsImg.attr('src', obj.values.image_path);
                }

                // нумерация
                $('#products [data-id="index"]').each(function (i, el) {
                    $(this).html(i + 1);
                });
            }
        },
        error: function (data) {
            isFindBarcode = false;
            console.log(data.responseText);
        }
    });
}

$(document).ready(function () {
    /**
     * Для формы с полем поиска штрих-кода отключаем сохранение по нажатию на Enter
     * Параметры:
     * Подключение:
     */
    $('[name="barcode"]').keydown(function(event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });

    /**
     * Для формы с полем поиска штрих-кода отключаем сохранение по нажатию на Enter
     * Параметры:
     * data-action="save-db"
     * data-url="Ссылка для сохранения"
     * name="Название поля для сохранения"
     * Подключение:
     */
    $('[data-action="save-db"]').change(function(event) {
        var url = $(this).data('url');
        var name = $(this).attr('name');
        var value = $(this).val();

        var data = {};
        data[name] = value;
        jQuery.ajax({
            url: url,
            data: data,
            type: "POST",
            success: function (data) {
            },
            error: function (data) {
                isFindBarcode = false;
                console.log(data.responseText);
            }
        });
    });

    /**
     * Поиск продукции по шрихкоду
     * Параметры:
     * data-action="find-barcode"
     * data-url="Где запрашивать продукцию"
     * Подключение:
     */
    $('input[data-action="find-barcode"]:not([data-find-barcode="1"])').keydown(function(event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            var el = $(this);
            var barcode = $(this).val().replace('_', '');
            var url = $(this).data('url');
            if(!isFindBarcode) {
                findBarcode(barcode, url, el);
            }
            return false;
        }
    }).bind('paste', function(e) {
        var el = $(this);
        var barcode = $(this).val().replace('_', '');
        var url = $(this).data('url');
        if(!isFindBarcode) {
            findBarcode(barcode, url, el);
        }
    }).attr('data-find-barcode', 1).attr('autocomplete', 'off');

    /**
     * Виртуальная клавиатура
     */
    var key;
    $('[data-action="keyboard-key"]').click(function(){
        key = $(this).find('span').text();
        elementFocus.val(elementFocus.val() + key).focus().trigger('change');
    });
    $('[data-action="keyboard-backspace"]').click(function(){
        var val = elementFocus.val();
        elementFocus.val(val.substr(0, val.length - 1) ).focus().trigger('change');
    });
    $('[data-action="keyboard-enter"]').click(function(){
        if(!isFindBarcode && elementFocus.data('action') == 'find-barcode') {
            var el = elementFocus;
            var barcode = el.val().replace('_', '');
            var url = el.data('url');

            findBarcode(barcode, url, el);
        }
        if(!isFindCard && elementFocus.data('action') == 'find-card-number') {
            var el = elementFocus;
            var barcode = el.val().replace('_', '');
            var url = el.data('url');
            findCard(barcode, url, el);
        }
    });

    /**
     * Поиск карты по штрихкоду или номеру
     * @param barcode
     * @param url
     * @param el - поле ввода штрихкода
     */
    function findCard(barcode, url, el){
        if(barcode == ''){
            return false;
        }

        isFindCard = true;
        jQuery.ajax({
            url: url,
            data: ({
                barcode_number: (barcode),
            }),
            type: "POST",
            success: function (data) {
                isFindCard = false;
                var obj = jQuery.parseJSON($.trim(data));
                if(obj.is_find){
                    el.val('').attr('value', '');

                    $('[data-id="shop_card_name"]').val(obj.values.name).attr('value', obj.values.name);
                    $('[data-id="shop_card_id"]').val(obj.values.id).attr('value', obj.values.id);
                    $('#talon').html('Талоны: <b>' + obj.values.quantity_balance + '</b>')
                        .attr('value', obj.values.quantity_balance)
                        .attr('value-amount', obj.values.amount_balance);
                }
            },
            error: function (data) {
                isFindCard = false;
                console.log(data.responseText);
            }
        });
    }

    /**
     * Поиск карты по штрихкоду или номеру
     * Параметры:
     * data-action="find-barcode"
     * data-url="Где запрашивать продукцию"
     * Подключение:
     */
    $('input[data-action="find-card-number"]:not([data-find-card="1"])').keydown(function(event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            var el = $(this);
            var barcode = $(this).val().replace('_', '');
            var url = $(this).data('url');
            if(!isFindCard) {
                findCard(barcode, url, el);
            }
            return false;
        }
    }).bind('paste', function(e) {
        var el = $(this);
        var barcode = $(this).val().replace('_', '');
        var url = $(this).data('url');
        if(!isFindCard) {
            findCard(barcode, url, el);
        }
    }).attr('data-find-card', 1).attr('autocomplete', 'off');


    // удаление записи в таблицы
    $('table td li.tr-remove a:not([href=""]):not([href="#"]):not([data-tr-remove="1"])').click(function () {
        var url = $(this).attr('href');

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
                    console.log(data.responseText);
                }
            });
            return false;
        }
    }).attr('data-tr-remove', '1');

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
                console.log(data.responseText);
            }
        });
        return false;
    });

    // в таблице сохранения активный / неактивный
    $('input[name="set-is-public-all"]').on('ifChecked', function (event) {
        isPublic = 1;
        url = $(this).attr('href');

        arr = {};
        $(this).parent().parent().parent().parent().parent().parent().find('input[name="set-is-public"]').each(function (i) {
            id = $(this).data('id');
            arr[id] = {'is_public':  isPublic, 'id': id};

            $(this).val(1);
            $(this).attr('checked', 'checked');
            $(this).parent().addClass('checked');
        });
        arr = {'shop_goods': arr, 'json': 1};

        jQuery.ajax({
            url: url,
            data: (arr),
            type: "POST",
            success: function (data) {
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    }).on('ifUnchecked', function (event) {
        isPublic = 0;
        url = $(this).attr('href');

        arr = {};
        $(this).parent().parent().parent().parent().parent().parent().find('input[name="set-is-public"]').each(function (i) {
            id = $(this).data('id');
            arr[id] = {'is_public':  isPublic, 'id': id};

            $(this).val(0);
            $(this).removeAttr('checked');
            $(this).parent().removeClass('checked');
        });
        arr = {'shop_goods': arr, 'json': 1};

        jQuery.ajax({
            url: url,
            data: (arr),
            type: "POST",
            success: function (data) {
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
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
                console.log(data.responseText);
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
                console.log(data.responseText);
            }
        });
    });

    $('[data-action="show-big"]').dblclick(function () {
        var id = $(this).data('id');
        var type = $(this).data('type');

        var url = $(this).data('src');

        if((url === undefined) || (url == '')) {
            url = '/weighted/shopcar/get_images';
            if (type == 91) {
                url = '/weighted/shopmovecar/get_images';
            } else {
                if (type == 77) {
                    url = '/weighted/shopcartomaterial/get_images';
                }
            }
        }

        jQuery.ajax({
            url: url,
            data: ({
                id: (id),
            }),
            type: "POST",
            success: function (data) {
                $('#dialog-images').modal('hide');
                $('#dialog-images').remove();
                $('body').append(data);
                $('#dialog-images').modal('show');
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    });

    // восстановление записи в таблицы
    $('[data-acton="fiscal-print"]').click(function (e) {
        e.preventDefault();

        var a = $(this);
        a.css('display', 'none');

        var url = $(this).attr('href');
        var parent = $(this).closest('tr');
        jQuery.ajax({
            url: url,
            data: ({}),
            type: "POST",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));
                parent.find('[data-id="fiscal"]').text(obj.values.fiscal_check);

                if(!obj.fiscal.status){
                    a.css('display', 'block');
                }
            },
            error: function (data) {
                console.log(data.responseText);
                a.css('display', 'block');
            }
        });
        return false;
    });
});

function __initLoadPhoto() {
    $('[data-action="load-photo-click"]:not([data-load-photo-click="1"])').on('click', function(){
        $(this).parent().find('input[data-action="load-photo"][type=file]').click();
    }).attr('data-load-photo-click', 1);

    // заполняем переменную данными, при изменении значения поля file
    $('input[data-action="load-photo"][type=file]:not([data-load-photo="1"])').on('change', function(){
        // заполняем объект данных файлами в подходящем для отправки формате
        var data = new FormData();
        $.each(this.files, function( key, value ){
            data.append( 'file', value );
        });
        data.append('shop_product_id', $(this).data('id'));

        var input = $(this);
        // AJAX запрос
        $.ajax({
            url         : '/bar/shopproduction/add_image',
            type        : 'POST', // важно!
            data        : data,
            cache       : false,
            dataType    : 'json',
            processData : false,
            contentType : false,
            success: function( respond, status, jqXHR ){
                input.parent().find('[data-id="img-status"]').attr('data-img', 'true');
            },
            error: function( jqXHR, status, errorThrown ){
                console.log( 'ОШИБКА AJAX запроса: ' + status, jqXHR );
            }
        });
    }).attr('data-load-photo', 1);
}

function __init() {
    __initBasic();
    __initLoadPhoto();

    /**
     * Перемножить значение input b select[option[data-price=""]] в строки таблицы tr
     * Параметры:
     * data-action="tr-multiply" data-total="ID суммы всех tr" data-parent-count="На какой количество родителей подняться" - для каждого элемента учавствующего в умножении
     * data-id="total" - элемента для вывода результата одной tr data-round="Не обязательное округление кратное числу (5)"
     * Подключение:
     */
    $('[data-action="tr-multiply"]:not([data-tr-multiply="1"])').change(function () {
        var n = Number($(this).data('parent-count'));
        var parent = $(this);
        for (var i = 0; i < n; i++) {
            parent = parent.parent();
        }

        var round = $(this).data('round');

        var amount = 1;
        parent.find('[data-action="tr-multiply"]').each(function (i, el) {
            if (el.localName == 'select') {
                amount = amount * Number($(this).find('option[value="' + $(this).val() + '"]').data('price'));
            } else {
                if (el.localName == 'input') {
                    amount = amount * Number($(this).val());
                } else {
                    amount = amount * Number($(this).attr('value'));
                }
            }
        });
        if (round > 0) {
            amount = (roundNumber(amount / round, 0)).toFixed() * round;
        }

        var amountStr = Intl.NumberFormat('ru-RU', {maximumFractionDigits: 2}).format(amount).replace(',', '.').replace('.00', '');
        var total = parent.find('[data-id="total"]');
        total.attr('value', amount).text(amountStr).val(amount).trigger('change');

        var amount = 0;
        parent.parent().find('[data-id="total"]').each(function () {
            var s = Number($(this).attr('value'));
            if (s > 0) {
                amount = amount + s;
            }
        });
        amountStr = Intl.NumberFormat('ru-RU', {maximumFractionDigits: 2}).format(amount).replace(',', '.').replace('.00', '');
        $($(this).data('total')).attr('value', amount).text(amountStr).val(amount).trigger('change');

        var stock = parent.data('stock');
        if (stock !== undefined) {
            var quantity = parent.find('[data-id="quantity"]').val();
            if (Number(stock) - Number(quantity) < -0.0001) {
                parent.addClass('b-red');
                parent.find('[data-id="quantity"]').data('stock-error', 1);
                $('#button-save').attr('disabled', '');
            } else {
                parent.removeClass('b-red');
                parent.find('[data-id="quantity"]').data('stock-error', 0);

                $('#button-save').removeAttr('disabled');
                parent.parent().find('[data-id="quantity"]').each(function () {
                    if ($(this).data('stock-error') == 1) {
                        $('#button-save').attr('disabled', '');
                    }
                });
            }
        }

    }).attr('data-tr-multiply', 1);

    $('[data-action="tr-edit-total"]:not([data-tr-edit-total="1"])').change(function () {
        var n = Number($(this).data('parent-count'));
        var parent = $(this);
        for (var i = 0; i < n; i++) {
            parent = parent.parent();
        }

        var amount = 0;
        parent.parent().find('[data-id="total"]').each(function () {
            var s = Number($(this).val());
            if (s > 0) {
                amount = amount + s;
            }
        });
        var amountStr = Intl.NumberFormat('ru-RU', {maximumFractionDigits: 2}).format(amount).replace(',', '.').replace('.00', '');
        $($(this).data('total')).attr('value', amount).text(amountStr).val(amount).trigger('change');

    }).attr('data-tr-edit-total', 1);

    /**
     * Узнаем на какой элементе фокус
     */
    $('input[data-keywords="virtual"]:not([data-input-focus="1"])').focus(function () {
        elementFocus = $(this);
    }).attr('data-input-focus', 1);

    /**
     * Считаем общее количество
     * Параметры:
     * id="products" - родитель элементов, которые нужно сложить
     * data-id="quantity" - элементы которые необходимо сложить
     * id="total-count" - элемента для вывода результата
     * Подключение:
     */
    $('#products [data-id="quantity"]:not([data-products-count="1"])').change(function () {
        // количество
        var count = 0;
        $('#products [data-id="quantity"]').each(function (i, el) {
            count = count + Number($(this).val());
        });
        $('#total-count').attr('value', count).text(count).val(count).trigger('change');
    }).attr('data-products-count', 1);

    /**
     * Задаем формат для штрихкода
     * Параметры:
     * data-type="barcode"
     * Подключение:
     <script src="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/jquery-number/jquery.number.js"></script>
     */
    $('input[data-type="barcode"]:not([data-type-barcode="1"])').inputmask({
        mask: "9999999999999"
    }).attr('maxlength', 13).attr('data-type-barcode', 1);

    /**
     * Узнаем результат остатка в строки таблицы tr
     * Параметры:
     * data-action="diff" data-parent-count="На какой количество родителей подняться" - для каждого элемента количества
     * data-id="count" - элемента количества введеного
     * data-id="quantity_actual" - текущее количество
     * data-id="diff" - элемента для вывода результата одной tr
     * Подключение:
     */
    $('[data-action="diff"]:not([data-tr-diff="1"])').change(function () {
        var n = Number($(this).data('parent-count'));
        var parent = $(this);
        for (i = 0; i < n; i++) {
            parent = parent.parent();
        }

        var quantity = parent.find('[data-id="quantity"]').attr('value').replace(',', '.');
        var count = parent.find('[data-id="count"]').val().replace(',', '.');
        var diff = Number(count) - Number(quantity);
        if (diff === NaN) {
            diff = '';
        } else {
            diff = Intl.NumberFormat('ru-RU', {maximumFractionDigits: 3}).format(diff).replace(',', '.');
        }

        parent.find('[data-id="diff"]').text(diff).data('value', diff);
    }).attr('data-tr-diff', 1);


    /**
     * При первом клике выделять все значение
     */
    $('input:not([data-input-focus="1"])').focus(function () {
        if (this.value == this.defaultValue) {
            this.select();
        }
    }).attr('data-input-focus', 1);

    /**
     * Сохранение новых строчек ревизии
     * Параметры:
     * data-active-save="receive"
     * Подключение:
     */
    $('[data-active-save="receive"]:not([data-active-save-receive="1"])').change(function (event) {
        var parent = $(this).parents('tr')
        jQuery.ajax({
            url: '/bar/shopreceive/save_basic',
            data: ({
                shop_product_id: parent.find('[data-id="shop_product_id"]').val(),
                price: parent.find('[data-id="price_purchase"]').val(),
                quantity: parent.find('[data-id="quantity"]').val(),
                is_public: 0,
            }),
            type: "POST",
            success: function (data) {
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    }).attr('data-active-save-receive', 1);

    $('[data-action="shop_client"]:not([data-action-shop_client="1"])').each(function () {
        var queryClient = '';
        var select = $(this);

        var parent = select.data('parent');
        if (parent == undefined || parent == '') {
            parent = select.parent();
        } else {
            parent = $(parent);
        }

        var basicUrl = $(this).data('basic-url');

        select.select2({
            dropdownParent: parent,
            placeholder: 'Выберите значение',
            allowClear: true,
            language: 'ru',
            ajax: {
                url: function (params) {
                    queryClient = params.term;
                    return '/' + basicUrl + '/shopclient/json?sort_by[name]=asc&limit=50&_fields[]=name&_fields[]=bin&_fields[]=bin&_fields[]=mobile&name_bin=' + params.term;
                },
                dataType: 'json',
                delay: 50,
                processResults: function (data, params) {
                    params.page = 1;
                    return {
                        results: data
                    };
                },
                cache: true
            },
            escapeMarkup: function (markup) {
                return markup;
            },
            minimumInputLength: 1,
            templateResult: function (repo, container) {
                if (repo.name == undefined) {
                    return 'Данные не найдены';
                }

                var name = repo.name;

                if (repo.bin != '') {
                    name = name + ' (' + repo.bin + ')';
                }
                if (repo.mobile != '') {
                    name = name + ' ' + repo.mobile;
                }
                var term = queryClient
                    .replace(/\\/g, '\\')
                    .replace(/\//g, '\\/')
                    .replace(/\[/g, '\\[')
                    .replace(/\]/g, '\\]')
                    .replace(/\(/g, '\\(')
                    .replace(/\)/g, '\\)')
                    .replace(/\{/g, '\\{')
                    .replace(/\}/g, '\\}')
                    .replace(/\?/g, '\\?')
                    .replace(/\+/g, '\\+')
                    .replace(/\*/g, '\\*')
                    .replace(/\|/g, '\\|')
                    .replace(/\./g, '\\.')
                    .replace(/\^/g, '\\^')
                    .replace(/\$/g, '\\$');
                name = name.replace(new RegExp(term, 'ig'), '<b>$&</b>');
                return name;
            },
            templateSelection: function (repo, container) {
                var name = repo.name || repo.text;
                return name;
            },
        }).change(function () {
            var basicURL = $(this).data('basic-url');

            var client = $(this).val();
        }).attr('data-action-shop_client', '1');

        // получение выделенного элемента
        var shopClientID = select.data('value');
        if (shopClientID > 0) {
            jQuery.ajax({
                url: '/' + select.data('basic-url') + '/shopclient/json?sort_by[name]=asc&limit=50&_fields[]=name&_fields[]=bin&_fields[]=bin&id=' + shopClientID,
                type: "POST",
                success: function (data) {
                    var data = jQuery.parseJSON($.trim(data));

                    $.each(data, function (index, value) {
                        var newOption = new Option(value.name, value.id, false, false);
                        select.append(newOption).val(shopClientID).trigger('change');
                    });
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });
        }

        if (select.val() > 0) {
            select.trigger('change');
        }
    });
}

function _initMain() {
    __init();
}