<div id="dialog-car" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Добавить машину</h4>
            </div>
            <form id="form-add-car" action="<?php echo Func::getFullURL($siteData, '/shopcar/save'); ?>" method="post" >
                <div class="modal-body">
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Клиент
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="input-group">
                                <div class="box-typeahead">
                                    <input id="modal_shop_client_name" type="text" class="form-control typeahead" placeholder="Введите наименование клиента или его БИН/ИИН" style="width: 100%" required>
                                    <input id="modal_shop_client_id" name="shop_client_id" value="0" style="display: none;" required>
                                </div>
                                <span class="input-group-btn"> <a class="btn btn-flat"><b id="client-amount" class="text-navy"></b></a></span>
                            </div>
                        </div>
                    </div>
                    <script>
                        var bestPictures = new Bloodhound({
                            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
                            queryTokenizer: Bloodhound.tokenizers.whitespace,
                            remote: {
                                url: '/weighted/shopclient/json?name_bin=%QUERY&sort_by[name]=asc&limit=50&_fields[]=name&_fields[]=bin&_fields[]=balance&_fields[]=balance_cache',
                                wildcard: '%QUERY'
                            }
                        });

                        field = $('#modal_shop_client_name.typeahead');
                        field.typeahead({
                            hint: true,
                            highlight: true,
                            minLength: 1
                        }, {
                            name: 'best-pictures',
                            display: 'name',
                            source: bestPictures,
                            templates: {
                                empty: [
                                    '<div class="empty-message">Клиент не найден</div>'
                                ].join('\n'),
                                suggestion: Handlebars.compile('<div>{{name}} – {{bin}}</div>')
                            }
                        });
                        field.on('keypress', function(e) {
                            if(e.which == 13) {
                                $(this).parent().parent().find(".tt-suggestion:first-child").trigger('click');
                            }
                        });
                        field.on('change', function() {
                            client = $('#modal_shop_client_id');
                            if(client.data('name') != $(this).val()){
                                client.attr('value', '');
                                client.val('');
                                $(this).parent().addClass('has-error');
                            }else{
                                $(this).parent().removeClass('has-error');
                            }
                        });
                        field.on('typeahead:select', function(e, selected) {
                            $(this).parent().removeClass('has-error');

                            var client = $('#modal_shop_client_id');
                            client.data('name', selected.name);
                            client.data('amount', selected.balance_cache);
                            client.attr('value', selected.id);

                            $('#attorney ul li a[data-id="0"]').data('amount', selected.balance_cache);
                            client.val(selected.id).trigger("change");
                        });
                    </script>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Продукт
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="input-group">
                                <select id="shop_product_id" name="shop_product_id" class="form-control select2" required style="width: 100%;">
                                    <option value="0" data-id="0">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::_shop/product/list/list']; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Доверенность
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="btn-group" id="attorney">
                                <input id="shop_client_attorney_id" name="shop_client_attorney_id" value="0" style="display: none;">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Наличными <span class="caret"></span></button>
                                <ul class="dropdown-menu" role="menu" style="max-height: 309px;overflow-y: auto;">
                                    <li><a href="#" data-id="0" data-amount="0">Наличные</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                Водитель
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input name="shop_driver_name" type="text" class="form-control" placeholder="Водитель">
                        </div>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                № автомобиля
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input name="name" id="name-modal" data-type="auto-number" type="text" class="form-control" placeholder="Введите гос. номер автомобиля" required>
                        </div>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Кол-во
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input data-type="money" data-fractional-length="3" id="quantity" name="quantity" type="phone" class="form-control" required placeholder="Введите заявленное количество продукции">
                        </div>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                Талон клиента
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input id="ticket" name="ticket" type="text" class="form-control" required placeholder="Введите номер талона клиента">
                        </div>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                Доставка
                            </label>
                        </div>
                        <div class="col-md-9">
                            <select id="shop_delivery_id" name="shop_delivery_id" class="form-control select2" required style="width: 100%;">
                                <option value="0" data-id="0">Без доставки</option>
                                <?php echo $siteData->globalDatas['view::_shop/delivery/list/list']; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                Расстояние (км)
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input data-type="money" data-fractional-length="3" id="delivery_km" name="delivery_km" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="row record-input record-list"  style="display: none">
                        <div class="col-md-3 record-title">
                            <label>
                                Стоимость доставки
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input data-type="money" data-fractional-length="2" id="delivery_amount" name="delivery_amount" type="text" class="form-control" data-amount="0" >
                        </div>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title"></div>
                        <div class="col-md-3">
                            <label class="span-checkbox">
                                <input name="is_debt" value="0" type="text" style="display: none">
                                <input name="is_debt" value="0" data-id="1" type="checkbox" class="minimal">
                                В долг
                            </label>
                        </div>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title"></div>
                        <div class="col-md-3">
                            <label class="span-checkbox">
                                <input name="options[is_not_overload]" value="0" type="text" style="display: none">
                                <input name="options[is_not_overload]" value="0" data-id="1" type="checkbox" class="minimal">
                                Не перегружать
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input id="shop_turn_id" name="shop_turn_id" value="<?php echo Model_Ab1_Shop_Turn::TURN_WEIGHTED_ENTRY; ?>" style="display: none">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-primary" onclick="submitCarModal('form-add-car')">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function _initAttorney(){
        $('#attorney ul li a').click(function(e) {
            $('#attorney button').html($(this).html()+' <span class="caret"></span>');

            var client = $('#attorney input[name="shop_client_attorney_id"]');
            client.val($(this).data('id'));
            client.attr('value', $(this).data('id'));

            $('#shop_product_id').trigger("change");
        });
    }

    $(function () {
        // меняем value в зависимости от нажатия
        $('#dialog-car input[type="checkbox"], #dialog-car input[type="check"]').on('ifChecked', function (event) {
            $(this).attr('value', '1');
            $(this).attr('checked', '');
            $(this).attr('type', 'checkbox');
            var name = $(this).attr('name');
            if (name != undefined){
                $(this).parent().parent().children('input[name="'+name+'"][type="text"]').attr('value', 1);
            }
        }).on('ifUnchecked', function (event) {
            $(this).attr('value', '0');
            $(this).removeAttr('checked');
            $(this).attr('type', 'checkbox');
            var name = $(this).attr('name');
            if (name != undefined){
                $(this).parent().parent().children('input[name="'+name+'"][type="text"]').attr('value', 0);
            }
        });
        $('#shop_product_id, #quantity, #delivery_km, #shop_delivery_id').change(function () {
            var delivery = $('#shop_delivery_id').val();

            $('#delivery_amount').attr('readonly', '');
            $('#delivery_km').parent().parent().css('display', 'none');
            if(delivery > 0){
                var option = $('#shop_delivery_id option[data-id="'+delivery+'"]');
                switch (option.data('type')){
                    case <?php echo Model_Ab1_DeliveryType::DELIVERY_TYPE_WEIGHT; ?>:
                        var quantity = Number($('#quantity').val());
                        var min = Number(option.data('min_quantity'));
                        if(quantity < min){
                            quantity = min;
                        }

                        $('#delivery_amount').valNumber(option.data('price') * quantity, 2);
                        break;
                    case <?php echo Model_Ab1_DeliveryType::DELIVERY_TYPE_WEIGHT_AND_KM; ?>:
                        var quantity = Number($('#quantity').val());
                        var min = Number(option.data('min_quantity'));
                        if(quantity < min){
                            quantity = min;
                        }

                        var km = $('#delivery_km').valNumber();

                        $('#delivery_amount').valNumber(option.data('price') * quantity * km, 2);
                        $('#delivery_km').parent().parent().css('display', 'block');
                        break;
                    case <?php echo Model_Ab1_DeliveryType::DELIVERY_TYPE_KM; ?>:
                        var km = $('#delivery_km').valNumber();

                        $('#delivery_amount').valNumber(option.data('price') * km, 2);
                        $('#delivery_km').parent().parent().css('display', 'block');
                        break;
                    case <?php echo Model_Ab1_DeliveryType::DELIVERY_TYPE_TREATY; ?>:
                        $('#delivery_amount').val($('#delivery_amount').data('amount'));
                        $('#delivery_amount').removeAttr('readonly');
                        break;
                    default:
                        $('#delivery_amount').valNumber(option.data('price'), 2);
                }
            }else{
                $('#delivery_amount').val('');
            }

            $('#delivery_amount').trigger('change');
        });

        $('#quantity, #delivery_amount').change(function () {
            var client = $('#modal_shop_client_id');
            var isQuery = client.data('is-query');
            var clientAmount = Number($('#attorney ul li a[data-id="'+$('#shop_client_attorney_id').val()+'"]').data('amount'));

            if(isQuery == 1) {
            }else{
                var product = $('#shop_product_id').val();
                var price = $('#shop_product_id option[data-id="' + product + '"]').data('price');
            }

            var quantity = $('#quantity').valNumber();

            var amount = Number(price * quantity);
            amount = amount + $('#delivery_amount').valNumber();
            if(amount > 0) {
                $('#amount').valNumber(amount, 2);
            }else{
                $('#amount').val(0);
            }

            if(clientAmount < amount){
                $('#amount').attr('style', 'border-color: #d81b60;');
            }else{
                $('#amount').removeAttr('style');
            }
        });

        $('#shop_product_id').change(function () {
            var product = $('#shop_product_id').val();
            var price = $('#shop_product_id option[data-id="' + product + '"]').data('price');

            if(price > 0){
                price = Number($('#attorney ul li a[data-id="'+$('#shop_client_attorney_id').val()+'"]').data('amount')) / price;

                if(price < 0){
                    price = 0;
                }
            }else{
                price = 0;
            }

            $('#client-amount').textNumber(price, 3, ' т');

            $('#quantity').trigger("change");
        });

        _initAttorney();

        $('#modal_shop_client_id').change(function () {
            var client = $('#modal_shop_client_id');

            var clientID = client.val();
            if(client.data('old') != clientID){

                $('#attorney button').html('Наличные');
                $('#shop_client_attorney_id').val(0);
                client.data('old', clientID);
            }

            jQuery.ajax({
                url: '/weighted/shopclientattorney/json',
                data: ({
                    '_fields': ('*'),
                    'shop_client_id': (clientID),
                }),
                type: "POST",
                success: function (data) {
                    var obj = jQuery.parseJSON($.trim(data));

                    var s = '';
                    var isFirst = true;
                    jQuery.each(obj, function(index, value) {
                        var formatter = new Intl.DateTimeFormat("ru");

                        var now = new Date(value.from_at);
                        var from_at = formatter.format(now);

                        var now = new Date(value.to_at);
                        var to_at = formatter.format(now);

                        var str = '';
                        var current = new Date();
                        if (current.getDate() > now){
                            str = ' class="attorney-finish"';
                        }else {
                            if (isFirst) {
                                s = s + '<input id="shop_client_attorney_id" name="shop_client_attorney_id" value="' + value.id + '" style="display: none;">'
                                    + '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">' + value.name_weight + ' <span class="caret"></span></button>'
                                    + '<ul class="dropdown-menu" role="menu" style="max-height: 309px;overflow-y: auto;">';

                                s = s + '<li><a href="#" data-id="0" data-amount="' + (client.data('amount')) + '">Наличные</a></li>';
                                isFirst = false;
                            }
                            s = s + '<li' + str + '><a href="#" data-id="' + value.id + '" data-amount="' + (value.balance) + '"><div' + str + '>' + value.name_weight + '</div></a></li>';
                        }
                    });
                    if (s == ''){
                        s = s + '<input id="shop_client_attorney_id" name="shop_client_attorney_id" value="0" style="display: none;">'
                            + '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Наличные <span class="caret"></span></button>'
                            + '<ul class="dropdown-menu" role="menu" style="max-height: 309px;overflow-y: auto;">';

                        s = s + '<li><a href="#" data-id="0" data-amount="' + (client.data('amount')) + '">Наличные</a></li>';
                    }
                    s = s + '</ul>';

                    $('#attorney').html(s);
                    _initAttorney();

                    $('#shop_product_id').trigger("change");
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });
        });

        $('#shop_delivery_id').trigger("change");
    });

    function submitCarModal(id) {
        var isError = false;

        var element = $('#'+id+' [name="shop_client_id"]');
        if (!$.isNumeric(element.val()) || parseInt(element.val()) < 1){
            element.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }

        var element = $('#'+id+' [name="shop_product_id"]');
        if (!$.isNumeric(element.val()) || parseInt(element.val()) < 1){
            element.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }

        var element = $('#'+id+' [name="quantity"]');
        var val = element.valNumber();
        if (!$.isNumeric(val) || parseFloat(val) <= 0){
            element.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }

        var element = $('#'+id+' [name="name"]');
        if ($.trim(element.val()) == ''){
            element.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }

        if(!isError) {
            $('#'+id).submit();
        }
    }
</script>