<div id="dialog-car-edit" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Добавить машину</h4>
            </div>
            <form id="form-add-car" action="<?php echo Func::getFullURL($siteData, '/shopdefectcar/save'); ?>" method="post" >
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
                                Кол-во
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input data-type="money" data-fractional-length="3" id="quantity" name="quantity" type="phone" class="form-control" required placeholder="Введите заявленное количество продукции" value="<?php echo Func::getNumberStr($data->values['quantity'], true, 3); ?>">
                        </div>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title"></div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="span-checkbox">
                                        <input name="is_delivery" value="0" style="display: none;">
                                        <input name="is_delivery" value="0" data-id="1" type="checkbox" class="minimal">
                                        Доставка
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
                                            <input class="form-control text-number" data-type="auto-number" name="name" placeholder="Номер машины" type="text"  value="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES); ?>">
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
                                    <input class="form-control text-number" data-type="auto-number" name="name" placeholder="Номер машины" type="text"  value="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES); ?>">
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Закрыть</button>
                    <?php if($siteData->action == 'clone') { ?>
                        <input name="url" value="/weighted/shopdefectcar/index" style="display: none">
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

    $(function () {
        // меняем value в зависимости от нажатия
        $('#dialog-car-edit input[type="checkbox"], #dialog-car-edit input[type="check"], #dialog-car-edit input[type="radio"]').on('ifChecked', function (event) {
            $(this).attr('value', '1');
            $(this).attr('checked', '');
        }).on('ifUnchecked', function (event) {
            $(this).attr('value', '0');
            $(this).removeAttr('checked');
        });
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
        var s = element.valNumber();
        if (!$.isNumeric(s) || parseFloat(s) <= 0){
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

    function sendTarra() {
        var data = $('#dialog-car-edit form').serializeArray();
        var url = '/weighted/shopdefectcar/send_tarra?is_save=1';

        jQuery.ajax({
            url: url,
            data: data,
            type: "POST",
            success: function (data) {
                $('#dialog-car-edit').modal('hide');
                var obj = jQuery.parseJSON($.trim(data));
                if(obj.error == 0){
                    $('#html-entry-ok').html(obj.html);
                    $('#dialog-entry-ok').modal('show');
                }else{
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
</script>