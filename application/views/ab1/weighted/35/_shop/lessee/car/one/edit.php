<div id="dialog-car-edit" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Изменить машину</h4>
            </div>
            <form id="form-add-car" action="<?php echo Func::getFullURL($siteData, '/shoplesseecar/save'); ?>" method="post" >
                <div class="modal-body">
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Клиент
                            </label>
                        </div>
                        <div class="col-md-9">
                            <select id="shop_client_id" name="shop_client_id" class="form-control select2" style="width: 100%">
                                <?php echo $siteData->globalDatas['view::_shop/client/list/list'];?>
                            </select>
                        </div>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Продукт
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="input-group">
                                <select id="shop_product_id" name="shop_product_id" class="form-control select2" required style="width: 100%;" <?php if(($siteData->action != 'clone') && ((($data->values['shop_turn_id'] == Model_Ab1_Shop_Turn::TURN_EXIT) || (($data->values['shop_turn_id'] == Model_Ab1_Shop_Turn::TURN_CASH_EXIT))) && (!$siteData->operation->getIsAdmin()))){ echo 'disabled'; }?>>
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
                            <input data-type="money" data-fractional-length="3" id="quantity" name="quantity" type="phone" class="form-control" required placeholder="Введите заявленное количество продукции" value="<?php echo Func::getNumberStr($data->values['quantity'], true, 3); ?>" <?php if($data->values['shop_turn_id'] == Model_Ab1_Shop_Turn::TURN_CASH_EXIT){echo 'readonly';} ?>>
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
                        <input name="url" value="/weighted/shoplesseecar/index" style="display: none">
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
        s = element.valNumber();
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