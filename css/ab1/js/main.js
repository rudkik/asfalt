__init();
/***************** НАЧАЛО ДЛЯ ПРОСЧЕТА КЛИЕНТОВ, ДОВЕРЕННОСТЕЙ, ДОСТАВКИ И СТОИМОСТИ ПРОДУКЦИИ *****************/
/**
 * Просчет стоимости доставки
 * @param delivery - элемент типа доставки
 * @param deliveryAmount - элемент стоимости доставки
 * @param deliveryKM - элементы расстояния доставки
 * @param quantityPath - адрес веса продукции
 */
function calcDelivery(delivery, deliveryAmount, deliveryKM, quantityPath) {
    deliveryAmount.attr('readonly', '');
    deliveryKM.parent().parent().css('display', 'none');

    var deliveryID = delivery.val();
    if(deliveryID > 0){
        var option = delivery.find('option[data-id="'+deliveryID+'"]');
        if(option.data('is_treaty_price') == 1){
            deliveryAmount.val(deliveryAmount.data('amount'));
            deliveryAmount.removeAttr('readonly');
        }else{
            switch (option.data('type')){
                case 1:// Оплата за вес
                    var quantity = 0;
                    $(quantityPath).each(function (i) {
                        quantity = quantity + $(this).valNumber();
                    });
                    var quantity = Number(delivery.data('delivery-quantity'))
                        - Number(delivery.data('quantity'))
                        + quantity;
                    if(quantity < option.data('min_quantity')){
                        quantity = option.data('min_quantity');
                    }

                    deliveryAmount.valNumber(option.data('price') * quantity, 2);
                    break;
                case 2:// Оплата за вес и км
                    var quantity = 0;
                    $(quantityPath).each(function (i) {
                        quantity = quantity + $(this).valNumber();
                    });
                    var quantity = Number(delivery.data('delivery-quantity'))
                        - Number(delivery.data('quantity'))
                        + quantity;
                    if(quantity < option.data('min_quantity')){
                        quantity = option.data('min_quantity');
                    }

                    var km = deliveryKM.valNumber();

                    deliveryAmount.valNumber(option.data('price') * quantity * km, 2);
                    deliveryKM.parent().parent().css('display', 'block');
                    break;
                case 3:// Оплата за км
                    var km = deliveryKM.valNumber();

                    deliveryAmount.valNumber(option.data('price') * km, 2);
                    deliveryKM.parent().parent().css('display', 'block');
                    break;
                case 4:// Договорная цена
                    deliveryAmount.valNumber(deliveryAmount.data('amount'));
                    deliveryAmount.removeAttr('readonly');
                    break;
                default:
                    deliveryAmount.valNumber(option.data('price'), 2);
            }
        }
    }else{
        deliveryAmount.val('');
    }

    deliveryAmount.trigger('change');
}

/*
Как вызвать
initClientAttorneyPieceNew(
    $('#shop_delivery_id'),
    $('#delivery_amount'),
    $('#delivery_km'),
    'input[data-action="calc-piece"]',
    $('#total'),
    $('#car-amount'),
    $('#car-delivery-amount'),
    $('#shop_client_attorney_id'),
    $('#is_charity')
);
 */
function initClientAttorneyPieceNew(delivery, deliveryAmount, deliveryKM,
                                    quantityPath, total, carsAmount, clientAttorney, isCharity){

    // просчет доставки
    deliveryKM.change(function () {
        calcDelivery(delivery, deliveryAmount, deliveryKM, quantityPath);
    });
    delivery.change(function () {
        calcDelivery(delivery, deliveryAmount, deliveryKM, quantityPath);
    });

    deliveryAmount.change(function () {
        var amount = Number(total.data('amount')) + Number(total.data('service-amount'));
        var deliveryAmountTotal = $(this).valNumber();
        var serviceAmount = Number(total.data('service-amount'));

        if(isCharity.val() == 1){
            amount = 0;
            deliveryAmountTotal = 0;
        }

        var clientAmount = Number(clientAttorney.data('amount'));
        if(amount + serviceAmount > 0) {
            total.valNumber(amount + deliveryAmountTotal + serviceAmount, 2);
        }else{
            total.val(0);
        }

        if (clientAmount - deliveryAmountTotal - serviceAmount  - amount < 0) {
            total.attr('style', 'border-color: #d81b60;');
            carsAmount.htmlNumber(clientAmount - deliveryAmountTotal - serviceAmount  - amount, 2, ' тг');
        } else {
            total.removeAttr('style');
            carsAmount.html('');
        }
    });

    isCharity.change(function () {
        delivery.trigger('change');
    });
}

/**
 * Просчет стоимость товаров
 * @param delivery
 * @param client
 * @param clientAttorney
 * @param quantityPath
 * @param product
 * @param productPrice
 * @param carsAmount
 * @param total
 * @param isCharity
 */
function calcProductAmount(delivery, client, clientAttorney, quantityPath, product, productPrice, carsAmount,
                           total, isCharity) {
    var clientAmount = Number(clientAttorney.data('amount'));

    var baseURL = client.data('basic-url');
    var contract = $('#shop_client_contract_id').val();
    var quantity = $(quantityPath).valNumber();
    var clientID = client.val();
    var isCharityValue = isCharity.val();
    var productID = product.val();
    var date = client.data('date');
    jQuery.ajax({
        url: '/' + baseURL + '/shopproduct/get_price',
        data: ({
            'shop_product_id': productID,
            'shop_client_id': clientID,
            'shop_client_contract_id': contract,
            'is_charity': isCharityValue,
            'quantity': quantity,
            'date': date,
        }),
        type: "POST",
        success: function (data) {
            var obj = jQuery.parseJSON($.trim(data));

            var price = obj.price * 1;

            productPrice.textNumber(price, 2, ' тг');

            var amount = Number(price * quantity);
            var deliveryAmount = delivery.valNumber();
            var serviceAmount = Number(total.data('service-amount'));

            if(isCharity.val() == 1){
                deliveryAmount = 0;
            }

            if(amount + serviceAmount > 0) {
                total.valNumber(amount + deliveryAmount + serviceAmount, 2);
            }else{
                total.val(0);
            }

            if (clientAmount - deliveryAmount - serviceAmount  - amount < 0) {
                total.attr('style', 'border-color: #d81b60;');
                carsAmount.htmlNumber(clientAmount - deliveryAmount - serviceAmount - amount, 2, ' тг');
            } else {
                total.removeAttr('style');
                carsAmount.html('');
            }
        },
        error: function (data) {
            console.log(data.responseText);
        }
    });
}
/**
 Как вызвать
 initClientAttorneyNew(
 $('#shop_delivery_id'),
 $('#delivery_amount'),
 $('#delivery_km'),
 $('#shop_product_id'),
 $('#product-price'),
 '#quantity',
 $('#total'),
 $('#car-amount'),
 $('#car-delivery-amount'),
 $('[name="shop_client_id"]'),
 $('#shop_client_attorney_id'),
 $('#is_charity')
 );
 */
function initClientAttorneyNew(delivery, deliveryAmount, deliveryKM,
                               product, productPrice,
                               quantityPath, total, carsAmount,
                               client, clientAttorney, isCharity){

    // просчет доставки
    deliveryKM.change(function () {
        calcDelivery(delivery, deliveryAmount, deliveryKM, quantityPath);
    });
    delivery.change(function () {
        calcDelivery(delivery, deliveryAmount, deliveryKM, quantityPath);
    });

    $(quantityPath).change(function () {
        calcDelivery(delivery, deliveryAmount, deliveryKM, quantityPath);
    });
    product.change(function () {
        calcProductAmount(deliveryAmount, client, clientAttorney, quantityPath, product, productPrice, carsAmount, total, isCharity);
    });
    deliveryAmount.change(function () {
        calcProductAmount(deliveryAmount, client, clientAttorney, quantityPath, product, productPrice, carsAmount, total, isCharity);
    });

    isCharity.change(function () {
        calcProductAmount(deliveryAmount, client, clientAttorney, quantityPath, product, productPrice, carsAmount, total, isCharity);
    });

    delivery.trigger("change");
}

/**
 * Загрузка основных договоров клиента
 * @param shopClientID
 * @param contractEl
 * @param baseURL
 * @returns {boolean}
 */
function loadBasicContract(shopClientID, contractEl, baseURL) {
    if(contractEl == undefined || contractEl.lenght == 0){
        return false;
    }
    var v = contractEl.data('contract-id');

    // контракт
    jQuery.ajax({
        url: '/' + baseURL + '/shopclientcontract/select_options',
        data: ({
            'shop_client_id': (shopClientID),
            'is_basic': (1),
            'is_basic_text': (1),
        }),
        type: "POST",
        success: function (data) {
            contractEl.select2('destroy').empty().html(data).select2().val(0);

            if(contractEl.children('option[value="' + v + '"]').length > 0){
                contractEl.val(v).trigger('change');
            }
        },
        error: function (data) {
            console.log(data.responseText);
        }
    });
}

/**
 * Загрузка гарантийных писем клиента
 * @param shopClientID
 * @param guaranteeEl
 * @param baseURL
 * @returns {boolean}
 */
function loadGuarantee(shopClientID, guaranteeEl, baseURL) {
    if(guaranteeEl == undefined || guaranteeEl.lenght == 0){
        return false;
    }
    var v = guaranteeEl.data('guarantee-id');

    // контракт
    jQuery.ajax({
        url: '/' + baseURL + '/shopclientguarantee/select_options',
        data: ({
            'shop_client_id': (shopClientID),
            'is_basic': (1),
        }),
        type: "POST",
        success: function (data) {
            guaranteeEl.select2('destroy').empty().html(data).select2().val(0);

            if(guaranteeEl.children('option[value="' + v + '"]').length > 0){
                guaranteeEl.val(v).trigger('change');
            }
        },
        error: function (data) {
            console.log(data.responseText);
        }
    });
}

/**
 * Загрузка договор клиента
 * @param shopClientID
 * @param contractEl
 * @param baseURL
 * @returns {boolean}
 */
function loadContract(shopClientID, contractEl, baseURL) {
    if(contractEl == undefined || contractEl.lenght == 0){
        return false;
    }
    var v = contractEl.data('contract-id');

    // контракт
    jQuery.ajax({
        url: '/' + baseURL + '/shopclientcontract/json?_fields[]=number&_fields[]=from_at&_fields[]=id&_fields[]=balance_amount',
        data: ({
            'shop_client_id': (shopClientID),
        }),
        type: "POST",
        success: function (data) {
            var data = jQuery.parseJSON($.trim(data));

            var first = [];
            first['id'] = 0;

            var obj = [];
            data.push(first);

            //
            $.each(data, function (index, value) {
                obj.push(value);
            });

            var parent = contractEl.data('parent');
            if(parent == undefined || parent == ''){
                parent = contractEl.parent();
            }else {
                parent = $(parent);
            }

            contractEl.select2('destroy').empty().select2({
                dropdownParent: parent,
                data: obj,
                escapeMarkup: function(markup) {
                    return markup;
                },
                templateSelection: function(value) {
                    if(value.id == undefined){
                        return 'Данные не найдены';
                    }

                    if(value.id < 1){
                        return '<div class="select2-block-data">Без договора</div>';
                    }

                    var formatter = new Intl.DateTimeFormat("ru");
                    var now = new Date(value.from_at);
                    var from_at = formatter.format(now);

                    var s = '№' + value.number + ' от ' + from_at + '<br> Остаток: <b>'+ Intl.NumberFormat('ru-RU', {maximumFractionDigits: 2}).format(value.balance_amount).replace(',', '.') +' тг</b>';
                    return '<div class="select2-block-data">' + s + '</div>';
                },
                templateResult: function (value) {
                    if(value.id == undefined){
                        return 'Данные не найдены';
                    }

                    if(value.id < 1){
                        return '<div class="select2-block-data">Без договора</div>';
                    }

                    var formatter = new Intl.DateTimeFormat("ru");
                    var now = new Date(value.from_at);
                    var from_at = formatter.format(now);

                    var s = '№' + value.number + ' от ' + from_at + '<br> Остаток: <b>'+ Intl.NumberFormat('ru-RU', {maximumFractionDigits: 2}).format(value.balance_amount).replace(',', '.') +' тг</b>';
                    return '<div class="select2-block-data">' + s + '</div>';
                },
            });

            if(contractEl.children('option[value="' + v + '"]').length < 1){
                v = contractEl.find(':first').attr('value');
            }

            contractEl.val(v).trigger('change');
        },
        error: function (data) {
            console.log(data.responseText);
        }
    });
}

/**
 * Загрузка доверенностей клиента
 * @param shopClientID
 * @param cash
 * @param attorneyEl
 * @param baseURL
 * @returns {boolean}
 */
function loadAttorney(shopClientID, cash, attorneyEl, baseURL) {
    if(attorneyEl == undefined || attorneyEl.lenght == 0){
        return false;
    }

    attorneyEl.attr('data-amount-cash', cash).data('amount-cash', cash);

    var branch = attorneyEl.data('branch-id');
    if(branch > 0){
        var data = ({
            'shop_client_id': (shopClientID),
            'shop_branch_id': (branch),
            'validity': (attorneyEl.data('date')),
        });
    }else{
        var data = ({
            'shop_client_id': (shopClientID),
            'validity': (attorneyEl.data('date')),
        });
    }

    // доверенность
    jQuery.ajax({
        url: '/' + baseURL + '/shopclientattorney/json?_fields[]=name&_fields[]=to_at&_fields[]=id&_fields[]=balance&_fields[]=balance_delivery&_fields[]=shop_client_contract_id&limit=40',
        data: data,
        type: "POST",
        success: function (data) {
            var data = jQuery.parseJSON($.trim(data));

            var first = [];
            first['id'] = 0;
            first['name'] = 'Наличные';
            first['balance'] = cash;
            first['shop_client_contract_id'] = 0;

            var obj = [];
            data.push(first);

            $.each(data, function (index, value) {
                obj.push(value);
            });

            var v = attorneyEl.data('attorney-id');

            var parent = attorneyEl.data('parent');
            if(parent == undefined || parent == ''){
                parent = attorneyEl.parent();
            }else {
                parent = $(parent);
            }

            attorneyEl.select2('destroy').empty().select2({
                dropdownParent: parent,
                data: obj,
                escapeMarkup: function (markup) {
                    return markup;
                },
                templateSelection: function (value) {
                    attorneyEl.attr('data-contract-id', value.shop_client_contract_id).data('contract-id', value.shop_client_contract_id);
                    attorneyEl.attr('data-amount', value.balance).data('amount', value.balance);

                    var amount = value.balance;
                    if(value.id == attorneyEl.data('attorney-id') && attorneyEl.data('product-amount') != undefined) {
                        amount = amount + Number(attorneyEl.data('product-amount'));
                    }

                    var tmp = '<br><span data-id="amount-attorney" class="text-red"  data-amount="'+value.balance+'"> Остаток: <b style="font-size: 18px;">' + Intl.NumberFormat('ru-RU', {maximumFractionDigits: 2}).format(amount).replace(',', '.') + ' тг</b></span>';

                    if(value.balance_delivery > 0){
                        var amount = value.balance_delivery;
                        if(value.id == attorneyEl.data('attorney-id')) {
                            amount = amount + Number(attorneyEl.data('product-delivery-amount'));
                        }
                        tmp = tmp + '<br><span data-id="amount-delivery" class="text-blue"  data-amount="'+value.balance_delivery+'"> Доставка: <b style="font-size: 18px;">' + Intl.NumberFormat('ru-RU', {maximumFractionDigits: 2}).format(amount).replace(',', '.') + ' тг</b></span>';
                    }
                    var s = value.name + tmp;
                    return '<div class="select2-block-data">' + s + '</div>';
                },
                templateResult: function (value) {
                    var tmp = '<br><span data-id="amount-attorney" class="text-red"  data-amount="'+value.balance+'"> Остаток: <b style="font-size: 18px;">' + Intl.NumberFormat('ru-RU', {maximumFractionDigits: 2}).format(value.balance).replace(',', '.') + ' тг</b></span>';
                    var s = value.name + tmp;
                    return '<div class="select2-block-data">' + s + '</div>';
                },
            }).change(function () {
                var amount = Number($('[data-id="amount-attorney"]').data('amount'));
                if(amount == undefined){
                    amount = Number($(this).data('amount-cash'));
                }
                if($(this).val() == $(this).data('attorney-id')) {
                    amount = amount + Number($(this).data('product-amount'));
                }
                $(this).data('amount', amount).attr('data-amount', amount);

                // доставка
                amount = Number($('[data-id="amount-delivery"]').data('amount'));
                if(isNaN(amount)){
                    amount = 0;
                }
                $(this).data('delivery-amount', amount).attr('data-delivery-amount', amount);

                var contract = $(this).data('contract-id');
                if($($(this).data('contract')).data('contract-id') == -1 || $(this).data('attorney-id') != $(this).val()){
                    $($(this).data('contract')).val(contract).trigger('change');
                }

                var product = $($(this).data('product'));
                product.trigger("change");
            });

            if(attorneyEl.children('option[value="' + v + '"]').length < 1){
                v = attorneyEl.find(':first').attr('value');
            }
            attorneyEl.val(v).trigger('change');
        },
        error: function (data) {
            console.log(data.responseText);
        }
    });
}

/**
 * Поиск клиентов
 * @private
 */
function __initClient() {
    $('[data-action="shop_client"]:not([data-action-shop_client="1"])').each(function () {
        var queryClient = '';
        var select = $(this);

        var parent = select.data('parent');
        if(parent == undefined || parent == ''){
            parent = select.parent();
        }else {
            parent = $(parent);
        }

        var basicUrl =  $(this).data('basic-url');

        select.select2({
            dropdownParent: parent,
            placeholder: 'Выберите значение',
            allowClear: true,
            language: 'ru',
            ajax: {
                url: function (params) {
                    queryClient = params.term;
                    return '/' + basicUrl + '/shopclient/json?sort_by[name]=asc&limit=50&_fields[]=name&_fields[]=bin&_fields[]=bin&_fields[]=mobile&_fields[]=balance&_fields[]=balance_cache&name_bin=' + params.term;
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
                if(repo.name == undefined){
                    return 'Данные не найдены';
                }

                var name = repo.name;

                if(repo.bin != ''){
                    name = name + ' (' + repo.bin + ')';
                }
                if(repo.mobile != '') {
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
                select.attr('data-cache', repo.balance_cache).data('cache', repo.balance_cache);
                select.attr('data-is-invoice-print', repo.bin != '').data('is-invoice-print', repo.bin != '');

                if(repo.balance != undefined) {
                    if (repo.balance > 0 || select.data('less-zero') == false) {
                        $('#client-amount').textNumber(repo.balance, 2, ' тг');
                    } else {
                        $('#client-amount').text('0 тг');
                    }
                }

                var name = repo.name || repo.text;
                return name;
            },
        }).change(function () {
            var basicURL = $(this).data('basic-url');

            var client = $(this).val();
            var balance_cache = $(this).data('cache');


            if($(this).data('client') != $(this).val()){
                $($(this).data('contract')).data('contract-id', -1);
            }

            $($(this).data('contract')).each(function () {
                loadContract(client, $(this), basicURL);
            });

            $($(this).data('attorney')).each(function () {
                loadAttorney(client, balance_cache, $(this), basicURL);
            });
        }).attr('data-action-shop_client', '1');

        // получение выделенного элемента
        var shopClientID = select.data('value');
        if(shopClientID > 0){
            jQuery.ajax({
                url: '/' + select.data('basic-url') + '/shopclient/json?sort_by[name]=asc&limit=50&_fields[]=name&_fields[]=bin&_fields[]=bin&_fields[]=balance&_fields[]=balance_cache&id=' + shopClientID,
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

        if(select.val() > 0){
            select.trigger('change');
        }
    });
}

/**
 * Просчет стоимости штучного товара
 * @private
 */
function __initProductPiece() {
    $('[data-action="calc-piece"]:not([data-calc-piece="1"])').change(function () {
        var parent = $(this).parent().parent();

        var product = parent.find('select').val();
        if(product * 1 > 0) {
            var client = $('#shop_client_id');
            var baseURL = client.data('basic-url');

            var date = client.data('date');
            client = client.val();
            var contract = $('#shop_client_contract_id').val();
            var isCharity = $('#is_charity').val();
            var quantity = parent.find('input[data-action="calc-piece"]').valNumber();
            jQuery.ajax({
                url: '/' + baseURL + '/shopproduct/get_price',
                data: ({
                    'shop_product_id': product,
                    'shop_client_id': client,
                    'shop_client_contract_id': contract,
                    'is_charity': isCharity,
                    'quantity': quantity,
                    'date': date,
                }),
                type: "POST",
                success: function (data) {
                    var obj = jQuery.parseJSON($.trim(data));

                    var price = obj.price * 1;

                    var amount = Number((price * quantity).toFixed(2));
                    parent = parent.find('input[data-id="amount"]');

                    var total = Number($('#total').data('amount')) - Number(parent.data('amount')) + amount;
                    $('#total').val(total + Number($('#total').data('service-amount')));
                    $('#total').data('amount', total);
                    parent.val(amount);
                    parent.data('amount', amount);

                    $('#shop_delivery_id').trigger('change');
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });
        }else{
            amount = 0 ;
            parent = parent.find('input[data-id="amount"]');

            var total = $('#total').data('amount') * 1 - parent.data('amount') + amount;
            total = total.toFixed(2).replace('.00', '');
            $('#total').valNumber(total);
            $('#total').data('amount', total);
            parent.valNumber(amount);
            parent.data('amount', amount);
            parent.attr('disabled', '');

            $('#shop_delivery_id').trigger('change');
        }
    }).attr('data-calc-piece', '1');
}

/***************** КОНЕЦ ДЛЯ ПРОСЧЕТА КЛИЕНТОВ, ДОВЕРЕННОСТЕЙ, ДОСТАВКИ И СТОИМОСТИ ПРОДУКЦИИ *****************/

/**
 * Просчет стоимости дополнительных услуг
 * @private
 */
function __initAdditionService() {
    $('[data-action="calc-addition-service"]:not([data-calc-addition-service="1"])').change(function () {
        var parent = $(this).parent().parent();

        var product = parent.find('select').val();
        if(product * 1 > 0) {
            var client = $('#shop_client_id');
            var baseURL = client.data('basic-url');

            var date = client.data('date');
            client = client.val();
            var contract = $('#shop_client_contract_id').val();
            var isCharity = $('#is_charity').val();
            var quantity = parent.find('input[data-action="calc-addition-service"]').valNumber();
            jQuery.ajax({
                url: '/' + baseURL + '/shopproduct/get_price',
                data: ({
                    'shop_product_id': product,
                    'shop_client_id': client,
                    'shop_client_contract_id': contract,
                    'is_charity': isCharity,
                    'quantity': quantity,
                    'date': date,
                }),
                type: "POST",
                success: function (data) {
                    var obj = jQuery.parseJSON($.trim(data));

                    var price = obj.price * 1;

                    var amount = Number((price * quantity).toFixed(2));
                    parent = parent.find('input[data-id="amount"]');

                    var total = Number($('#total').data('service-amount')) - Number(parent.data('amount')) + amount;
                    $('#total').valNumber(total + Number($('#total').data('amount')), 2);
                    $('#total').data('service-amount', total);
                    parent.valNumber(amount, 2);
                    parent.data('amount', amount);

                    $('#shop_delivery_id').trigger('change');
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });
        }else{
            amount = 0 ;
            parent = parent.find('input[data-id="amount"]');

            var total = $('#total').data('amount') * 1 - parent.data('amount') + amount;
            total = total.toFixed(2).replace('.00', '');
            $('#total').valNumber(total);
            $('#total').data('amount', total);
            parent.valNumber(amount);
            parent.data('amount', amount);
            parent.attr('disabled', '');

            $('#shop_delivery_id').trigger('change');
        }

    }).attr('data-calc-addition-service', '1');
}

/**
 * Проверка на заполняемость обязательных полей
 * @param form
 * @returns {boolean}
 */
function checkRequired(form) {
    var isError = false;

    form.find('input[required]').each(function () {
        var s = $(this).val();
        if ($(this).data('type') == 'money') {
            s = $(this).valNumber();
        }

        if ($.isNumeric(s)) {
            if (parseFloat(s) <= 0) {
                $(this).parent().addClass('has-error');
                isError = true;
            } else {
                $(this).parent().removeClass('has-error');
            }
        }else{
            if (s == '') {
                $(this).parent().addClass('has-error');
                isError = true;
            } else {
                $(this).parent().removeClass('has-error');
            }

        }
    });

    form.find('textarea[required]').each(function () {
        var s = $(this).val();
        if (s == '') {
            $(this).parent().addClass('has-error');
            isError = true;
        } else {
            $(this).parent().removeClass('has-error');
        }
    });


    form.find('select[required]').each(function () {
        var s = $(this).val();
        if ($.isNumeric(s)) {
            if (parseFloat(s) <= 0) {
                $(this).parent().addClass('has-error');
                isError = true;
            } else {
                $(this).parent().removeClass('has-error');
            }
        }else{
            if (s == '') {
                $(this).parent().addClass('has-error');
                isError = true;
            } else {
                $(this).parent().removeClass('has-error');
            }

        }
    });

    return isError == false;
}

$(document).ready(function () {
    __init();

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
        $(this).parent().parent().parent().parent().parent().parent().find('input[name="set-is-public"]').each(function (i) {
            $(this).val(1);
            $(this).attr('checked', 'checked');
            $(this).parent().addClass('checked');

            $(this).trigger('ifChecked');
        });
    }).on('ifUnchecked', function (event) {
        $(this).parent().parent().parent().parent().parent().parent().find('input[name="set-is-public"]').each(function (i) {
            $(this).val(0);
            $(this).removeAttr('checked');
            $(this).parent().removeClass('checked');

            $(this).trigger('ifUnchecked');
        });
    });

    // в таблице сохранения активный / неактивный
    $('input[name="set-is-check-invoice"]').on('ifChecked', function (event) {
        var url = $(this).attr('href');

        jQuery.ajax({
            url: url,
            data: ({
                is_check_invoice: (1),
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
        var url = $(this).attr('href');

        jQuery.ajax({
            url: url,
            data: ({
                is_check_invoice: (0),
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

    // выделенные строки таблицы
    $('table.table-db > tbody > tr +tr').click(function (e) {
        if(e.shiftKey){
            current = $(this).parent().find('tr.current');
            if(current.length == 0){
                $(this).addClass('selected');
            }else{
                $(this).parent().find('tr.selected').removeClass('selected');

                currentIndex = current.index() - 1;
                thisIndex = $(this).index() - 1;

                var items = $(this).parent().children('tr +tr');
                if(thisIndex >= currentIndex){
                    for(var i = currentIndex; i <= thisIndex; i++){
                        item = items[i];
                        item.className = 'selected';
                    }
                }else{
                    for(var i = currentIndex; i >= thisIndex; i--){
                        item = items[i];
                        item.className = 'selected';
                    }
                }
            }
        }else {
            if (e.ctrlKey) {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                } else {
                    $(this).addClass('selected');
                }
            } else {

                $(this).parent().find('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        }

        $(this).parent().find('tr.current').removeClass('current');
        $(this).addClass('current');
    });

    // переводит чекбок в обычный инпут
     //$('input[type="checkbox"].minimal').attr('type', 'check');

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

    // событие применить форму
    $('[data-action="form-apply"]').click(function (e) {
        e.preventDefault();

        var form = $(this).closest('form');
        form.find('[name="is_close"]').val(0);
        if(checkRequired(form)) {
            form.submit();
        }
    });

    // событие сохранить форму
    $('[data-action="form-save"]').click(function (e) {
        e.preventDefault();

        var form = $(this).closest('form');
        form.find('[name="is_close"]').val(1);
        if(checkRequired(form)) {
            form.submit();
        }
    });

    // событие сохранить и создать форму
    $('[data-action="form-duplicate"]').click(function (e) {
        e.preventDefault();

        var form = $(this).closest('form');
        form.find('[name="is_close"]').val(1);
        form.find('[name="is_duplicate"]').val(1);
        if(checkRequired(form)) {
            form.submit();
        }
    });



    /**
     * Делаем прокрутку таблицы
     * Параметры:
     * data-action="fixed"
     * Подключение:
     */
    var tableOriginal1 = $('[data-action="fixed"]');
    if (tableOriginal1.length == 1) {
        var tableNew = $('<table class="table table-hover table-db table-tr-line" data-id="_table-head"> <thead data-id="_head"> </thead></table>');
        var headers = tableOriginal1.find('tr');
        if (headers.length >= 2) {
            var table2 = $('<div class="scroll-table-body"> </div>');

            var tableFixed = function() {
                var headerFirst = $('<tr>' + headers.first().html() +'</tr>');
                var headerTwo =  headers.first();
                headerTwo.before(headerFirst);

                headerTwo.find('th').each(function () {
                    var width = $(this).width();

                    var maxWidth = parseFloat($(this).css('max-width'));
                    if(width > maxWidth){
                        width = maxWidth;
                    }
                    var minWidth = parseFloat($(this).css('min-width'));
                    if(width < minWidth){
                        width = minWidth;
                    }

                    $(this).attr('style', 'width: ' + width + 'px;');
                });
                tableOriginal1.css('width', '100%');
                $('.scroll-table-body > table, [data-action="fixed"], [data-id="_table-head"]').css('table-layout', 'fixed');

                tableNew.find('[data-id="_head"]').html('<tr>' + headerTwo.html() + '</tr>');

                tableOriginal1.before(tableNew);

                headerTwo.find('th').each(function () {
                    $(this).html('');
                });

                tableOriginal1.after(table2);
                table2.append(tableOriginal1);

                headerFirst.attr('style', 'display: none');

                var thsNew = tableNew.find('th');
                var thsTwo = headerTwo.find('th');
                var isStart = false;
                $(window).resize(function () {
                    if(isStart){
                        return;
                    }
                    isStart = true;

                    $('.scroll-table-body > table, [data-action="fixed"], [data-id="_table-head"]').css('table-layout', 'auto');
                    headerFirst.removeAttr('style');

                    var height = $(window).height() - tableOriginal1.offset().top - $('[data-id="paginator"]').height() - 65;
                    if (height > 230) {
                        table2.css('height', height + 'px');
                        tableNew.width(tableOriginal1.width());
                    } else {
                        table2.css('height', 'auto');
                    }

                    var i = 0;
                    headerFirst.find('th').each(function () {
                        var width = $(this).width();

                        var maxWidth = parseFloat($(this).css('max-width'));
                        if (width > maxWidth) {
                            width = maxWidth;
                        }
                        var minWidth = parseFloat($(this).css('min-width'));
                        if (width < minWidth) {
                            width = minWidth;
                        }

                        thsTwo.eq(i).attr('style', 'width: ' + width + 'px;');
                        thsNew.eq(i).attr('style', 'width: ' + width + 'px;');

                        i = i + 1;
                    });
                    headerFirst.attr('style', 'display: none');

                    $('.scroll-table-body > table, [data-action="fixed"], [data-id="_table-head"]').css('table-layout', 'fixed');

                    isStart = false;
                });
                $(window).trigger('resize');
            }
            setTimeout(tableFixed, 5);
        }
    }

    /**
     * Делаем прокрутку таблицы
     * Параметры:
     * data-action="fixed-table"
     * Подключение:
     */
    var tableOriginal2 = $('[data-action="fixed-table"]');
    if (tableOriginal2.length == 1) {
        var tableNew = $('<div class="box-fixed-header"><table class="table table-hover table-db table-tr-line" data-id="_table-head"> <thead data-id="_head"> </thead></table></div>');
        var headers = tableOriginal2.find('tr');
        if (headers.length >= 2) {
            var table2 = $('<div class="scroll-table-body"> </div>');

            var tableFixed = function() {
                var headerFirst = $('<tr>' + headers.first().html() +'</tr>');
                var headerTwo =  headers.first();
                headerTwo.before(headerFirst);

                headerTwo.find('th').each(function () {
                    var width = $(this).width();

                    var maxWidth = parseFloat($(this).css('max-width'));
                    if(width > maxWidth){
                        width = maxWidth;
                    }
                    var minWidth = parseFloat($(this).css('min-width'));
                    if(width < minWidth){
                        width = minWidth;
                    }

                    $(this).attr('style', 'width: ' + width + 'px;');
                });
                tableOriginal2.css('width', '100%');
                $('.scroll-table-body > table, [data-action="fixed"], [data-id="_table-head"]').css('table-layout', 'fixed');

                tableNew.find('[data-id="_head"]').html('<tr>' + headerTwo.html() + '</tr>');

                tableOriginal2.before(tableNew);

                headerTwo.find('th').each(function () {
                    $(this).html('');
                });

                tableOriginal2.after(table2);
                table2.append(tableOriginal2);

                headerFirst.attr('style', 'display: none');

                var thsNew = tableNew.find('th');
                var thsTwo = headerTwo.find('th');
                var isStart = false;
                var y = tableNew.offset().top;
                $(window).resize(function () {
                    if(isStart){
                        return;
                    }
                    isStart = true;

                    $('.scroll-table-body > table, [data-action="fixed"], [data-id="_table-head"]').css('table-layout', 'auto');
                    headerFirst.removeAttr('style');


                    var i = 0;
                    headerFirst.find('th').each(function () {
                        var width = $(this).width();

                        var maxWidth = parseFloat($(this).css('max-width'));
                        if (width > maxWidth) {
                            width = maxWidth;
                        }
                        var minWidth = parseFloat($(this).css('min-width'));
                        if (width < minWidth) {
                            width = minWidth;
                        }

                        thsTwo.eq(i).attr('style', 'width: ' + width + 'px;');
                        thsNew.eq(i).attr('style', 'width: ' + width + 'px;');

                        i = i + 1;
                    });
                    headerFirst.attr('style', 'display: none');

                    $('.scroll-table-body > table, [data-action="fixed"], [data-id="_table-head"]').css('table-layout', 'fixed');

                    tableNew.css('min-width', tableOriginal2.width());
                    tableNew.find('table').css('width', tableOriginal2.width());
                    isStart = false;
                });

                $(window).trigger('resize');

                $(window).scroll(function() {
                    if($(window).scrollTop() >= y - tableNew.height()){
                        tableNew.css('position', 'fixed');
                    }else{
                        tableNew.css('position', 'inherit');
                    }
                });
                $(window).trigger('scroll');
            }

            setTimeout(tableFixed, 5);
        }
    }
});

/**
 * Меняем русские буквы на эквивалет английских по клавиши
 * @param el
 * @param text
 * @param offset
 */
function insertTextAtCursor(el, text, offset) {
    var val = el.value, endIndex, range, doc = el.ownerDocument;
    if (typeof el.selectionStart == "number"
        && typeof el.selectionEnd == "number") {
        endIndex = el.selectionEnd;
        el.value = val.slice(0, endIndex) + text + val.slice(endIndex);
        el.selectionStart = el.selectionEnd = endIndex + text.length+(offset?offset:0);
    } else if (doc.selection != "undefined" && doc.selection.createRange) {
        el.focus();
        range = doc.selection.createRange();
        range.collapse(false);
        range.text = text;
        range.select();
    }
}

function __init(){
    /**
     * Задаем фотмат поля
     * Параметры:
     * data-type="money"
     * data-fractional-length="2" - длина дробной части
     * Подключение:
     <script src="<?php echo $siteData->urlBasic; ?>/css/_component/format-money.js"></script>
     */
    $('input[data-type="money"]:not([data-type-money="1"])').attr('data-type-money', '1').priceFormat();

    __initClient();
    __initProductPiece();
    __initAdditionService();

    /**
     * Получаем список допсоглашений договора
     * Параметры:
     * data-action="show-tr-contract" data-id="id основного договора" data-url="ссылка для получения допсоглашения"
     * Подключение:
     */
    $('[data-action="show-tr-contract"]:not([data-show-tr-contract="1"])').click(function () {
        var id = $(this).data('id');
        if($(this).data('show') != 1){
            var tr = $(this).closest('tr');
            var url = $(this).data('url');
            jQuery.ajax({
                url: (url),
                data: ({
                    'basic_shop_client_contract_id': (id),
                    'is_basic': (false),
                }),
                type: "POST",
                success: function (data) {
                    tr.after(data);
                    __init();
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });

            $(this).data('show', 1);
            $(this).addClass('fa-minus');
            $(this).removeClass('fa-plus');
        }else{
            $('[data-basic="' + id + '"]').remove();

            $(this).data('show', 0);
            $(this).removeClass('fa-minus');
            $(this).addClass('fa-plus');
        }
    }).attr('data-show-tr-contract', 1);

    /**
     * Поле сумма, разбиввание по разрядам 100 000
     * Параметры:
     * data-type="number" date-decimals="Количество цифр после запятой"
     * Подключение:
     <script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/input-mask/jquery.inputmask.js"></script>
     */
    var fields = $('input[data-type="number"]:not([data-type-number="1"])');
    fields.each(function (i) {
        var decimals = $(this).data('decimals');
        if(decimals == undefined){
            decimals = 0;
        }

        $(this).number(true, decimals, '.', ' ').attr('data-type-number', 1);
    });

    // в таблице сохранения активный / неактивный
    $('input[data-action="set-checkbox"]:not([data-set-is-public="1"]), input[name="set-is-public"]:not([data-set-is-public="1"])').on('ifChecked', function (event) {
        var isPublic = 1;
        var url = $(this).attr('href');

        var field = $(this).data('field');
        if(field == undefined || field == ''){
            field = 'is_public';
        }
        var data = {};
        data['json'] = 1;
        data[field] = isPublic;

        jQuery.ajax({
            url: url,
            data: data,
            type: "POST",
            success: function (data) {
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    }).on('ifUnchecked', function (event) {
        var isPublic = 0;
        var url = $(this).attr('href');

        var field = $(this).data('field');
        if(field == undefined || field == ''){
            field = 'is_public';
        }
        var data = {};
        data['json'] = 1;
        data[field] = isPublic;

        jQuery.ajax({
            url: url,
            data: data,
            type: "POST",
            success: function (data) {
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    }).attr('data-set-is-public', 1);

    // двойной клин на элементе таблицы
    $('[data-unique="true"]:not([data-unique-focus="1"])').focusout(function () {
        var parent = $(this).parent();
        parent.children('[data-id="error"]').remove();

        var value = $(this).val();
        if(value == ''){
            return true;
        }

        var href = $(this).data('href');
        var field = $(this).data('field');
        var message = $(this).data('message');
        var data = {};
        data[field] = value;
        data['limit'] = 1;

        jQuery.ajax({
            url: href,
            data: data,
            type: "GET",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));

                jQuery.each(obj, function (index, value) {
                    parent.append('<label data-id="error" class="text-red">'+message+'</label>');
                    return false;
                });
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });

    }).attr('data-unique-focus', 1);


    /**
     * Стилизация поля checkbox и radio
     * Параметры:
     * class="minimal" type="checkbox" | type="radio" (data-value="Значение отличное от 1")
     * Подключение:
     <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/iCheck/all.css">
     <script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/iCheck/icheck.min.js"></script>
     */
    $('input[type="radio"].minimal:not([data-checkbox-minimal="1"])').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    }).on('ifChecked', function (event) {
        $(this).trigger('change');
    }).on('ifUnchecked', function (event) {
        $(this).trigger('change');
    }).attr('data-checkbox-minimal', 1);

    $('input[type="checkbox"].minimal:not([data-checkbox-minimal="1"])').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    }).on('ifChecked', function (event) {
        var value = $(this).data('value');
        if(value === undefined){
            value = 1;
        }
        $(this).attr('value', value);
        $(this).attr('checked', '');

        var name = $(this).attr('name');
        if (name !== undefined){
            $(this).parent().parent().children('input[name="'+name+'"][type="text"]').attr('value', value);
        }
        $(this).trigger('change');
    }).on('ifUnchecked', function (event) {
        $(this).attr('value', '0');
        $(this).removeAttr('checked');
        var name = $(this).attr('name');
        if (name !== undefined){
            $(this).parent().parent().children('input[name="'+name+'"][type="text"]').attr('value', 0);
        }
        $(this).trigger('change');
    }).attr('data-checkbox-minimal', 1);
    // переводит чекбок в обычный инпут
    $('input[type="checkbox"].minimal:not([data-not-check="1"])').attr('type', 'check');

    // двойной клин на элементе таблицы
    $('[data-action="db-click-edit"]:not([data-db-click-edit="1"])').dblclick(function () {
        var href = $(this).find('a[data-name="edit"]').attr('href');
        window.location.href = href;

    }).attr('data-db-click-edit', 1);

    // выбираем новый файл
    $('.file-upload input[type="file"]:not([data-change-file-upload="1"])').change(function () {
        s = '';
        for(i = 0; i < this.files.length; i++){
            s = s + this.files[i].name + '; '
        }
        p = $(this).parent().attr('data-text', s);

    }).attr('data-change-file-upload', 1);

    // Меняем русские буквы на эквивалет английских по клавиши для номеров машин
    $('input[data-type="auto-number"]:not([date-auto-number="1"])').keydown(function(e) {
        if ((e.ctrlKey == false) && (e.altKey == false)) {
            if (e.keyCode > 64 && e.keyCode < 91) {
                insertTextAtCursor(this, String.fromCharCode(e.keyCode));
                e.preventDefault();
                return false;
            }
        }
    }).css('text-transform', 'uppercase').attr('date-auto-number', 1);

    /**
     * Поле сумма, разбиввание по разрядам 100 000
     * Параметры:
     * type="datetime" [date-type="date|time|datetime"
     * Подключение:
     <link type="text/css" rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/datetime_v2/build/jquery.datetimepicker.min.css"/>
     <script src="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/moment/moment.js"></script>
     <script src="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/datetime_v2/build/jquery.datetimepicker.full.min.js"></script>
     <script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/input-mask/jquery.inputmask.js"></script>
     */
    var fields = $('input[type="datetime"][date-type="date"], input[type="datetime"]:not([date-type])');
    fields.each(function (i) {
        var minDate = $(this).attr('date-min');
        $(this).datetimepicker({
            dayOfWeekStart: 1,
            lang: 'ru',
            format: 'd.m.Y',
            timepicker: false,
            scrollMonth:false,
            minDate: minDate
        }).keydown(function(event) {
            var code = event.keyCode;

            if (
                code == 46 || // delete
                code == 8 || // backspace
                code == 9 || // tab
                code == 27 || // ecs
                event.ctrlKey === true || // все что вместе с ctrl
                event.metaKey === true ||
                event.altKey === true || // все что вместе с alt
                (code >= 112 && code <= 123) || // F1 - F12
                (code >= 35 && code <= 39)) // end, home, стрелки
            {
                return;

            }

            if(this.selectionStart == this.selectionEnd ) {
                this.setSelectionRange(this.selectionStart, this.selectionStart + 1);
            }
        }).inputmask({
            mask: "99.99.9999"
        }).attr('autocomplete', 'off');
    });

    $('input[type="datetime"][date-type="datetime"]').datetimepicker({
        dayOfWeekStart: 1,
        lang: 'ru',
        format: 'd.m.Y H:i',
        timepicker: true,
        scrollMonth:false,
    }).keydown(function(event) {
        var code = event.keyCode;

        if (
            code == 46 || // delete
            code == 8 || // backspace
            code == 9 || // tab
            code == 27 || // ecs
            event.ctrlKey === true || // все что вместе с ctrl
            event.metaKey === true ||
            event.altKey === true || // все что вместе с alt
            (code >= 112 && code <= 123) || // F1 - F12
            (code >= 35 && code <= 39)) // end, home, стрелки
        {
            return;

        }

        if(this.selectionStart == this.selectionEnd ) {
            this.setSelectionRange(this.selectionStart, this.selectionStart + 1);
        }
    }).inputmask({
        mask: "99.99.9999 99:99"
    }).attr('autocomplete', 'off');

    $('input[type="datetime"][date-type="time"]').datetimepicker({
        lang: 'ru',
        format: 'H:i',
        datepicker: false,
        scrollMonth:false,
    }).keydown(function(e) {
        if(this.selectionStart == this.selectionEnd ) {
            this.setSelectionRange(this.selectionStart, this.selectionStart + 1);
        }
    }).inputmask({
        mask: "99:99"
    }).attr('autocomplete', 'off');

    $('input[data-type="mobile"]').inputmask({
        mask: "+7(799) 999 99 99"
    }).attr('autocomplete', 'off');


    // исчитаем сумму товаров
    $('[data-action="calc"]').change(function () {
        var parent = $(this).parent().parent();

        var product = parent.find('select').val();
        if(product * 1 > 0) {
            var price = parent.find('select').find('option[data-id="' + product + '"]').data('price') * 1;

            var quantity = parent.find('input[data-action="calc"]').valNumber();
            var amount = Number((price * quantity).toFixed(2));

            parent = parent.find('input[data-id="amount"]');

            var total = $('#total').data('amount') * 1 - parent.data('amount') + amount;
            $('#total').valNumber(total);
            $('#total').data('amount', total);
            parent.valNumber(amount);
            parent.data('amount', amount);

            if (price > 0){
                parent.attr('disabled', '');
            }else{
                parent.removeAttr('disabled');
            }
        }else{
            amount = 0 ;
            parent = parent.find('input[data-id="amount"]');

            var total = $('#total').data('amount') * 1 - parent.data('amount') + amount;
            total = total.toFixed(2).replace('.00', '');
            $('#total').valNumber(total);
            $('#total').data('amount', total);
            parent.valNumber(amount);
            parent.data('amount', amount);
            parent.attr('disabled', '');
        }
    });

    // исчитаем сумму товаров
    $('[data-action="calc-payment-product"]:not([data-calc-payment="1"])').change(function () {
        var parent = $(this).parent().parent();

        var product = parent.find('select').val();
        if(product * 1 > 0) {
            var client = $('#shop_client_id');
            var baseURL = client.data('basic-url');

            var date = $('#current').val();
            if(date == '' || date == undefined){
                date = client.data('date');
            }

            client = client.val();
            var contract = $('#shop_client_contract_id').val();
            jQuery.ajax({
                url: '/' + baseURL + '/shopproduct/get_price',
                data: ({
                    'shop_product_id': product,
                    'shop_client_id': client,
                    'shop_client_contract_id': contract,
                    'is_new_payment': true,
                    'date': date,
                }),
                type: "POST",
                success: function (data) {
                    var obj = jQuery.parseJSON($.trim(data));

                    var price = obj.price * 1;
                    parent.find('input[data-id="price"]').valNumber(String(price).replace('.00', ''));

                    var quantity = parent.find('input[data-id="quantity"]').valNumber();
                    var amount = Number((price * quantity).toFixed(0));

                    parent = parent.find('input[data-id="amount"]');
                    if(price == 0){
                        amount = Number(parent.data('amount'));
                    }

                    var total = $('#total').data('amount') * 1 - parent.data('amount') + amount;
                    $('#total').valNumber(total, 0);
                    $('#total').data('amount', total);
                    parent.valNumber(amount, 0);
                    parent.data('amount', amount);

                    if (price > 0){
                        parent.attr('disabled', '');
                    }else{
                        parent.removeAttr('disabled');
                    }
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });
        }else{
            amount = 0 ;
            parent = parent.find('input[data-id="amount"]');

            var total = $('#total').data('amount') * 1 - parent.data('amount') + amount;
            total = total.toFixed(2).replace('.00', '');
            $('#total').valNumber(total);
            $('#total').data('amount', total);
            parent.valNumber(amount);
            parent.data('amount', amount);
            parent.attr('disabled', '');
        }
    }).attr('data-calc-payment', '1');

    $('[data-action="calc-payment"]:not([data-calc-payment="1"])').change(function () {
        var parent = $(this).closest('tr');

        var product = parent.find('select').val();
        if(product * 1 > 0) {
            var client = $('#shop_client_id');
            var baseURL = client.data('basic-url');

            var price = parent.find('input[data-id="price"]').valNumber();

            var quantity = parent.find('input[data-id="quantity"]').valNumber();
            var amount = Number((price * quantity).toFixed(0));

            parent = parent.find('input[data-id="amount"]');
            if(price == 0){
                amount = Number(parent.data('amount'));
            }

            var total = $('#total').data('amount') * 1 - parent.data('amount') + amount;
            $('#total').valNumber(total, 0);
            $('#total').data('amount', total);
            parent.valNumber(amount, 0);
            parent.data('amount', amount);

            if (price > 0){
                parent.attr('disabled', '');
            }else{
                parent.removeAttr('disabled');
            }
        }else{
            amount = 0 ;
            parent = parent.find('input[data-id="amount"]');

            var total = $('#total').data('amount') * 1 - parent.data('amount') + amount;
            total = total.toFixed(2).replace('.00', '');
            $('#total').valNumber(total);
            $('#total').data('amount', total);
            parent.valNumber(amount);
            parent.data('amount', amount);
            parent.attr('disabled', '');
        }
    }).attr('data-calc-payment', '1');

    $('input[data-action="amount-edit"][data-id="amount"]').change(function () {
        var amount = $(this).valNumber();

        var total = $('#total').data('amount') * 1 - $(this).data('amount') + amount;
        $('#total').valNumber(total);
        $('#total').data('amount', total);
        $(this).valNumber(amount);
        $(this).data('amount', amount);
    });

    // исчитаем сумму товаров при удалении записи
    $('[data-action="remove-tr"]:not([data-remove-tr="1"])').click(function (e) {
        var n = Number($(this).data('parent-count'));
        var parent = $(this);
        for (i = 0; i < n; i++){
            parent = parent.parent();
        }

        parent.find('input[data-action="calc"], input[data-action="calc-piece"]').val(0).trigger('change');

        var n = Number($(this).data('row'));
        if(n > 0) {
            for (i = 1; i < n; i++) {
                parent.next().remove();
            }
        }

        parent.remove();

        return false;
    }).attr('data-remove-tr', 1);

    var fields = $('select.select2:not([data-action-select2="1"]):not([data-select-2="1"])');
    fields.each(function (i) {
        var parent = $(this).data('parent');
        if(parent == undefined || parent == ''){
            $(this).select2({});
        }else {
            parent = $(parent);
            $(this).select2({
                dropdownParent: parent
            });
        }

        $(this).attr('data-select-2', 1);
    });

    /**
     * Сохранение поля в базу данных
     * Параметры:
     * data-action="save-field"
     * href="ссылка для сохранения"
     * data-field="Поле которое нужно сохранить"
     * data-id="ID записи"
     * data-parent="Родитель"
     * data-edit-field-1="Поле которое необходимо изменить"
     * ...
     * data-edit-field-n="Поле которое необходимо изменить"
     * Подключение:
     */
    $('input[data-action="save-field"]:not([data-save-field="1"])').change(function (event) {
        var element = $(this);
        var field = $(this).data('field');
        var url = $(this).attr('href');
        var id = Number($(this).data('id'));
        if(field != '' && url != '' && id > 0) {
            var value = $(this).val();

            var parent = $(this).data('parent');
            if(parent != '' && parent != undefined){
                parent = $(this).closest(parent);
            }else{
                parent = '';
            }

            var data = {};
            data['json'] = 1;
            data[field] = value;
            data['id'] = id;

            jQuery.ajax({
                url: url,
                data: data,
                type: "POST",
                success: function (data) {
                    if(parent != ''){
                        var obj = jQuery.parseJSON($.trim(data));

                        for(var i = 1; i < 100; i++){
                            var name = $(element).attr('data-edit-field-' + String(i));
                            if(name == '' || name == undefined){
                                break;
                            }

                            parent.find('[name="'+name+'"], [data-id="'+name+'"]').each(function (i, el) {
                                if (el.localName == 'select' || el.localName == 'input') {
                                    $(el).val(obj[name]).trigger('change');
                                } else {
                                    $(el).text(obj[name]);
                                }
                            });
                        }
                    }

                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });
        }
    }).attr('data-save-field', 1);

}
function addElement(from, to, isLast, $isPrevLast, replaceIndex){
    if(replaceIndex == '' || replaceIndex == undefined){
        replaceIndex = '#index#';
    }

    var index = $('#'+from).data('index') * 1 + 1;
    $('#'+from).data('index', index);

    var html =
        $('#'+from).html()
            .replaceAll('<!--', '')
            .replaceAll('-->', '')
            .replaceAll('#--', '<!--')
            .replaceAll('--#', '-->')
            .replaceAll(replaceIndex, index);

    if(isLast){
        var total = $('#'+to).find('[data-id="table-total"]');
        if(total.length > 0){
            total.before(html);
        }else{
            $('#'+to).append(html);
        }
    }else{
        $('#'+to).prepend(html);
    }

    __init();
}

function addMessageBox(message) {
    delMessageBox();

    var html = '<div id="box-message" class="alert alert-danger alert-dismissable">'
         + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'
         + message
         + '</div>';
    $('.tab-content').prepend(html);
}
function delMessageBox() {
    $('#box-message').remove();
}

$(function() {
    $(window).scroll(function() {
        if($(this).scrollTop() != 0) {
            $('#toTop').fadeIn();
        } else {
            $('#toTop').fadeOut();
        }
    });
    $('#toTop').click(function() {
        $('body,html').animate({scrollTop:0},800);
    });
});