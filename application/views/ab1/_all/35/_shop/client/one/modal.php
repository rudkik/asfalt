<div id="dialog-client" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Добавить клиента</h4>
            </div>
            <form action="<?php echo Func::getFullURL($siteData, '/shopclient/save'); ?>" method="post" >
                <div class="modal-body">
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Название
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input data-unique="true" data-field="name_full" data-href="/cash/shopclient/json" data-message="Такое название уже есть в базе данных" name="name" type="text" class="form-control" placeholder="Название" required>
                        </div>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Название 1C
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input name="name_1с" type="text" class="form-control" placeholder="Название 1C" required>
                        </div>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Тип организации
                            </label>
                        </div>
                        <div class="col-md-9">
                            <select id="organization_type_id" name="organization_type_id" class="form-control select2" required style="width: 100%;">
                                <option value="0" data-id="0">Без значения</option>
                                <?php echo $siteData->globalDatas['view::organizationtype/list/list']; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                КАТО
                            </label>
                        </div>
                        <div class="col-md-9">
                            <select id="kato_id" name="kato_id" class="form-control select2" required style="width: 100%;">
                                <option value="0" data-id="0">Без значения</option>
                                <?php echo $siteData->globalDatas['view::kato/list/list']; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                БИН/ИИН
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input data-unique="true" data-field="bin_full" data-href="/cash/shopclient/json" data-message="Такой БИН/ИИН уже есть в базе данных" name="bin" type="text" class="form-control" placeholder="БИН/ИИН" maxlength="12">
                        </div>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                Мобильный телефон
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input data-type="mobile" data-unique="true" data-field="mobile_full" data-href="/cash/shopclient/json" data-message="Такой мобильный телефон уже есть в базе данных" name="mobile" type="text" class="form-control" placeholder="Мобильный телефон" maxlength="23">
                        </div>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                Адрес
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input name="address" type="text" class="form-control" placeholder="Адрес">
                        </div>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                № счета
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input name="account" type="text" class="form-control" placeholder="№ счета" maxlength="20">
                        </div>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                БИК
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input name="bik" type="text" class="form-control" placeholder="БИК" maxlength="12">
                        </div>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                Банк
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input name="bank" type="text" class="form-control" placeholder="Банк">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-primary" onclick="addNewClient('<?php echo $url; ?>')">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function addNewClient(url){
        var isError = false;

        var element = $('#dialog-client [name="name"]');
        if ($.trim(element.val()) == ''){
            element.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }

        var element = $('#dialog-client [name="organization_type_id"]');
        if (!$.isNumeric(element.val()) || parseInt(element.val()) < 1){
            element.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }
        var $isBin = element.find('option[data-id="'+element.val()+'"]').data('is_bin');

        var element = $('#dialog-client [name="bin"]');
        if ($isBin && ($.trim(element.val()) == '')){
            element.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }

        if(!isError) {
            var formData = $('#dialog-client form').serialize();
            formData = formData + '&json=1';
            jQuery.ajax({
                url: url,
                data: formData,
                type: "POST",
                success: function (data) {
                    var obj = jQuery.parseJSON($.trim(data));
                    if (!obj.error) {
                        var name = obj.values.name;
                        if (obj.values.bin != '') {
                            name = name + ' - ' + obj.values.bin;
                        }

                        var client = $('#shop_client_id');
                        client.data('cache', 0).attr('data-cache', 0);
                        var newOption = new Option(obj.values.name, obj.values.id, false, false);
                        client.append(newOption).trigger('change');

                        $('#dialog-client').modal('hide');
                    }
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });
        }
    }
</script>