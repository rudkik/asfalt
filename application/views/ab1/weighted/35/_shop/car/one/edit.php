<div id="dialog-car-edit" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Изменить машину</h4>
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
                                    <input id="modal_shop_client_name" type="text" class="form-control typeahead" placeholder="Введите наименование клиента или его БИН/ИИН" value="<?php echo htmlspecialchars($data->getElementValue('shop_client_id'), ENT_QUOTES); ?>"  style="width: 100%" required>
                                    <input data-amount="<?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_client_id.balance', ''); ?>"
                                           data-date="<?php echo $data->values['created_at'];?>"
                                           id="modal_shop_client_id" name="shop_client_id" value="<?php echo $data->values['shop_client_id']; ?>" style="display: none;" required>
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
                                url: '/weighted/shopclient/json?name_bin=%QUERY&sort_by[name]=asc&limit=50&_fields[]=name&_fields[]=bin&_fields[]=balance_cache&_fields[]=balance',
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

                            $('#dialog-car-edit #attorney ul li a[data-id="0"]').data('amount', selected.balance_cache);
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
                                <select id="shop_product_id" name="shop_product_id" class="form-control select2" required style="width: 100%;" <?php if(($siteData->action != 'clone') && (($data->values['shop_turn_id'] >= Model_Ab1_Shop_Turn::TURN_ASU || $data->values['shop_turn_id'] == Model_Ab1_Shop_Turn::TURN_EXIT || $data->values['shop_turn_id'] == Model_Ab1_Shop_Turn::TURN_CASH_EXIT) && ($siteData->operation->getIsAdmin()))){ echo 'disabled'; }?>>
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
                            <div class="btn-group" id="attorney"  data-select="<?php echo $data->values['shop_client_attorney_id']; ?>">
                                <?php if (strpos($siteData->replaceDatas['view::_shop/client/attorney/list/list-weight'], 'data-id="'.$data->values['shop_client_attorney_id'].'"') !== FALSE){ ?>
                                <input id="shop_client_attorney_id" name="shop_client_attorney_id" value="<?php echo $data->values['shop_client_attorney_id']; ?>" style="display: none;">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><?php
                                    $attorney = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_client_attorney_id', '');
                                    if (empty($attorney)){
                                        echo 'Наличными';
                                    }else{
                                        echo $attorney['name_weight'];
                                    }
                                    ?> <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu" style="max-height: 309px;overflow-y: auto;">
                                    <li><a href="#" data-id="0" data-amount="<?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_client_id.balance', ''); ?>">Наличные</a></li>
                                    <?php echo $siteData->globalDatas['view::_shop/client/attorney/list/list-weight']; ?>
                                </ul>
                                <?php }else{ ?>
                                    <input id="shop_client_attorney_id" name="shop_client_attorney_id" value="0" style="display: none;">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Наличными <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu" style="max-height: 309px;overflow-y: auto;">
                                        <li><a href="#" data-id="0" data-amount="<?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_client_id.balance_cache', ''); ?>">Наличные</a></li>
                                        <?php echo $siteData->globalDatas['view::_shop/client/attorney/list/list-weight']; ?>
                                    </ul>
                                <?php } ?>

                            </div>
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
                            <input data-type="money" data-fractional-length="3" id="quantity" name="quantity" type="phone" class="form-control" required placeholder="Введите заявленное количество продукции" value="<?php echo Func::getNumberStr($data->values['quantity'], true, 3); ?>" <?php if($data->values['shop_turn_id'] == Model_Ab1_Shop_Turn::TURN_CASH_EXIT){echo 'readonly';} ?>>
                        </div>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                Доставка
                            </label>
                        </div>
                        <div class="col-md-9">
                            <select id="shop_delivery_id" name="shop_delivery_id" data-delivery-quantity="<?php echo $data->values['delivery_quantity']; ?>" data-quantity="<?php echo $data->values['quantity']; ?>" class="form-control select2" required style="width: 100%;">
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
                    <div class="row record-input record-list" style="display: none">
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
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="span-checkbox">
                                        <input name="is_debt" value="0" style="display: none;">
                                        <input name="is_debt" data-id="1" type="checkbox" class="minimal" <?php if (Arr::path($data->values, 'is_debt', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?>>
                                        В долг
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title"></div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="span-checkbox">
                                        <input name="options[is_not_overload]" value="0" style="display: none;">
                                        <input name="options[is_not_overload]" data-id="1" type="checkbox" class="minimal" <?php if (Arr::path($data->values, 'options.is_not_overload', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?>>
                                        Не перегружать
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if($siteData->action == 'clone') { ?>
                        <div class="row record-input record-list">
                            <div class="col-md-3 record-title"></div>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Номер машины</label>
                                            <input class="form-control text-number" name="name" data-type="auto-number" placeholder="Номер машины" type="text"  value="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Тара</label>
                                            <input class="form-control text-number" name="tarra" placeholder="Тара" type="text" value="<?php echo Request_RequestParams::getParamFloat('weight'); ?>" readonly>
                                            <input name="is_test" value="<?php echo Request_RequestParams::getParamBoolean('is_test'); ?>" style="display: none">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }else{ ?>
                        <div class="row record-input record-list">
                            <div class="col-md-3 record-title"></div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label>Номер машины</label>
                                    <input class="form-control text-number" name="name" data-type="auto-number" placeholder="Номер машины" type="text"  value="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES); ?>">
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Закрыть</button>
                    <?php if($siteData->action == 'clone') { ?>
                        <input name="url" value="/weighted/shopcar/index" style="display: none">
                        <input id="shop_turn_id" name="shop_turn_id" value="<?php echo Model_Ab1_Shop_Turn::TURN_WEIGHTED_ENTRY; ?>" style="display: none">
                        <button type="button" class="btn btn-primary" onclick="sendTarra()">Зафиксировать</button>
                    <?php }else{ ?>
                        <input name="url" value="/weighted/shopcar/exit_empty" style="display: none">
                        <input name="id" value="<?php echo $data->id; ?>" style="display: none">
                        <button type="button" class="btn btn-primary" onclick="submitCarModal('form-add-car')">Сохранить</button>
                    <?php } ?>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function _initAttorney(){
        $('#dialog-car-edit #attorney ul li a').click(function(e) {
            $('#dialog-car-edit #attorney button').html($(this).html()+' <span class="caret"></span>');

            var client = $('#dialog-car-edit #attorney input[name="shop_client_attorney_id"]');
            client.val($(this).data('id'));
            client.attr('value', $(this).data('id'));

            $('#dialog-car-edit #shop_product_id').trigger("change");
        });
    }

    $(function () {
        // меняем value в зависимости от нажатия
        $('#dialog-car-edit input[type="checkbox"], #dialog-car-edit input[type="check"], #dialog-car-edit input[type="radio"]').on('ifChecked', function (event) {
            $(this).attr('value', '1');
            $(this).attr('checked', '');
            $(this).attr('type', 'checkbox');
        }).on('ifUnchecked', function (event) {
            $(this).attr('value', '0');
            $(this).removeAttr('checked');
            $(this).attr('type', 'checkbox');
        });

        $('#dialog-car-edit #shop_product_id, #dialog-car-edit #quantity, #dialog-car-edit #delivery_km, #dialog-car-edit #shop_delivery_id').change(function () {
            var delivery = $('#dialog-car-edit #shop_delivery_id').val();

            $('#dialog-car-edit #delivery_amount').attr('readonly', '');
            $('#dialog-car-edit #delivery_km').parent().parent().css('display', 'none');
            if(delivery > 0){
                var option = $('#dialog-car-edit #shop_delivery_id option[data-id="'+delivery+'"]');
                switch (option.data('type')){
                    case <?php echo Model_Ab1_DeliveryType::DELIVERY_TYPE_WEIGHT; ?>:
                        var quantity = Number($('#dialog-car-edit #shop_delivery_id').data('delivery-quantity'))
                            - Number($('#dialog-car-edit #shop_delivery_id').data('quantity'))
                            + Number($('#dialog-car-edit #quantity').val());
                        var min = Number(option.data('min_quantity'));
                        if(quantity < min){
                            quantity = min;
                        }

                        $('#dialog-car-edit #delivery_amount').valNumber(option.data('price') * quantity, 2);
                        break;
                    case <?php echo Model_Ab1_DeliveryType::DELIVERY_TYPE_WEIGHT_AND_KM; ?>:
                        var quantity = Number($('#dialog-car-edit #shop_delivery_id').data('delivery-quantity'))
                            - Number($('#dialog-car-edit #shop_delivery_id').data('quantity'))
                            + Number($('#dialog-car-edit #quantity').val());
                        var min = Number(option.data('min_quantity'));
                        if(quantity < min){
                            quantity = min;
                        }

                        var km = $('#dialog-car-edit #delivery_km').valNumber();

                        $('#dialog-car-edit #delivery_amount').valNumber(option.data('price') * quantity * km, 2);
                        $('#dialog-car-edit #delivery_km').parent().parent().css('display', 'block');
                        break;
                    case <?php echo Model_Ab1_DeliveryType::DELIVERY_TYPE_KM; ?>:
                        var km = $('#dialog-car-edit #delivery_km').valNumber();

                        $('#dialog-car-edit #delivery_amount').valNumber(option.data('price') * km, 2);
                        $('#dialog-car-edit #delivery_km').parent().parent().css('display', 'block');
                        break;
                    case <?php echo Model_Ab1_DeliveryType::DELIVERY_TYPE_TREATY; ?>:
                        $('#dialog-car-edit #delivery_amount').val($('#dialog-car-edit #delivery_amount').data('amount'));
                        $('#dialog-car-edit #delivery_amount').removeAttr('readonly');
                        break;
                    default:
                        $('#dialog-car-edit #delivery_amount').valNumber(option.data('price'), 2);
                }
            }else{
                $('#dialog-car-edit #delivery_amount').val('');
            }

            $('#dialog-car-edit #delivery_amount').trigger('change');
        });

        $('#dialog-car-edit #quantity, #dialog-car-edit #delivery_amount').change(function () {
            var client = $('#modal_shop_client_id');
            var isQuery = client.data('is-query');
            var clientAmount = Number($('#dialog-car-edit #attorney ul li a[data-id="'+$('#shop_client_attorney_id').val()+'"]').data('amount'));

            if(isQuery == 1) {
            }else{
                var product = $('#dialog-car-edit #shop_product_id').val();
                var price = $('#dialog-car-edit #shop_product_id option[data-id="' + product + '"]').data('price');
            }

            var quantity = $('#dialog-car-edit #quantity').valNumber();

            var amount = Number(price * quantity);
            amount = amount + $('#dialog-car-edit #delivery_amount').valNumber();
            if(amount > 0) {
                $('#dialog-car-edit #amount').valNumber(amount, 2);
            }else{
                $('#dialog-car-edit #amount').val(0);
            }

            if(clientAmount < amount){
                $('#dialog-car-edit #quantity').attr('style', 'border-color: #d81b60;');
            }else{
                $('#dialog-car-edit #quantity').removeAttr('style');
            }
        });

        $('#dialog-car-edit #shop_product_id').change(function () {
            var product = $('#dialog-car-edit #shop_product_id').val();
            var price = $('#dialog-car-edit #shop_product_id option[data-id="' + product + '"]').data('price');

            if(price > 0){
                var clientAmount = Number($('#dialog-car-edit #attorney ul li a[data-id="'+$('#shop_client_attorney_id').val()+'"]').data('amount'));
                price = clientAmount / price;
                if(price < 0){
                    price = 0;
                }
            }else{
                price = 0;
            }

            $('#dialog-car-edit #client-amount').textNumber(price, 3, ' т');

            $('#dialog-car-edit #quantity').trigger("change");
        });

        _initAttorney();

        $('#modal_shop_client_id').change(function () {
            var client = $('#modal_shop_client_id');

            var clientID = client.val();
            if(client.data('old') != clientID){

                $('#dialog-car-edit #attorney button').html('Наличные');
                $('#dialog-car-edit #shop_client_attorney_id').val(0);
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

                    $('#dialog-car-edit #attorney').html(s);
                    _initAttorney();

                    $('#dialog-car-edit #shop_product_id').trigger("change");
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

    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    });
    //$('input[type="checkbox"].minimal').attr('type', 'check');

    $('#shop_product_id').trigger("change");

    function sendTarra() {
        var isError = false;
        var element = $('#dialog-car-edit [name="shop_client_id"]');
        if (!$.isNumeric(element.val()) || parseInt(element.val()) < 1){
            element.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }

        var element = $('#dialog-car-edit [name="shop_product_id"]');
        if (!$.isNumeric(element.val()) || parseInt(element.val()) < 1){
            element.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }

        var element = $('#dialog-car-edit [name="quantity"]');
        var s = element.valNumber();
        if (!$.isNumeric(s) || parseFloat(s) <= 0){
            element.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }

        var element = $('#dialog-car-edit [name="name"]');
        if (element.val() == ''){
            element.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }

        if(!isError) {
            var data = $('#dialog-car-edit form').serializeArray();
            if ($('#dialog-entry-start').data('type') == <?php echo Model_Ab1_Shop_Move_Car::TABLE_ID?>) {
                var url = '/weighted/shopmovecar/send_tarra?is_save=1';
            } else if ($('#dialog-entry-start').data('type') == <?php echo Model_Ab1_Shop_Defect_Car::TABLE_ID?>) {
                var url = '/weighted/shopdefectcar/send_tarra?is_save=1';
            } else {
                if ($('#dialog-entry-start').data('type') == <?php echo Model_Ab1_Shop_Lessee_Car::TABLE_ID?>) {
                    var url = '/weighted/shoplesseecar/send_tarra?is_save=1';
                } else {
                    var url = '/weighted/shopcar/send_tarra?is_save=1';
                }
            }

            jQuery.ajax({
                url: url,
                data: data,
                type: "POST",
                success: function (data) {
                    $('#dialog-car-edit').modal('hide');
                    var obj = jQuery.parseJSON($.trim(data));
                    if (obj.error == 0) {
                        $('#html-entry-ok').html(obj.html);
                        $('#dialog-entry-ok').modal('show');
                    } else {
                        alert(obj.msg);
                    }
                },
                error: function (data) {
                    $('#dialog-car-edit').modal('hide');
                    $('#dialog-entry-error input[name="name"]').val(name);
                    $('#dialog-entry-error').modal('show');
                    $('#dialog-entry-error').data('id', id);

                    console.log(data.responseText);
                }
            });
        }
    }
</script>