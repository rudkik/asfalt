<div id="dialog-defect-car" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Добавить машину</h4>
            </div>
            <form id="form-add-defect-car" action="<?php echo Func::getFullURL($siteData, '/shopdefectcar/save'); ?>" method="post" >
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
                        <div class="col-md-3 record-title"></div>
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="span-checkbox">
                                        <input name="is_delivery" value="0" style="display: none;">
                                        <input name="is_delivery" value="0" type="checkbox" class="minimal">
                                        Доставка
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="span-checkbox">
                                        <input name="options[is_not_overload]" value="0" style="display: none;">
                                        <input name="options[is_not_overload]" value="0" type="checkbox" class="minimal">
                                        Не перегружать
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input id="shop_turn_id" name="shop_turn_id" value="<?php echo Model_Ab1_Shop_Turn::TURN_WEIGHTED_ENTRY; ?>" style="display: none">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-primary" onclick="submitDefectCarModal('form-add-defect-car')">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function submitDefectCarModal(id) {
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
</script>