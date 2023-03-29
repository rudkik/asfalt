<div id="dialog-payment" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Добавить оплату</h4>
            </div>
            <form action="<?php echo Func::getFullURL($siteData, '/shoppayment/add_piece'); ?>" method="post" >
                <div class="modal-body">
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                № счета
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input name="number" type="text" class="form-control" placeholder="№ счета" disabled>
                        </div>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Сумма
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input name="amount" type="text" class="form-control integer" required placeholder="Сумма">
                        </div>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Способ оплаты
                            </label>
                        </div>
                        <div class="col-md-9">
                            <select id="payment_type_id" name="payment_type_id" class="form-control select2" style="width: 100%">
                                <?php echo $siteData->globalDatas['view::payment-type/list/list'];?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div style="display: none;">
                        <input id="modal_shop_client_id" name="shop_client_id" value="0">
                    </div>
                    <input name="shop_piece_id" value="<?php echo Request_RequestParams::getParamInt('id'); ?>" style="display: none">

                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Закрыть</button>
                    <button id="add-new-payment" type="button" class="btn btn-primary" onclick="addNewPayment('<?php echo $url; ?>')">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function addNewPayment(url){
        $('#add-new-payment').attr('disabled', '');
        var isError = false;

        var element = $('[name="amount"]');
        if (!$.isNumeric(element.valNumber()) || parseFloat(element.valNumber()) <= 0){
            element.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }

        if(!isError) {
            var formData = $('#dialog-payment form').serialize();
            formData = formData + '&json=1';
            jQuery.ajax({
                url: url,
                data: formData,
                type: "POST",
                success: function (data) {
                    var obj = jQuery.parseJSON($.trim(data));
                    if (!obj.error) {
                        $('#is_close').val(0);
                        submitPiece('shopcar');
                    }
                    $('#dialog-payment').modal('hide');
                    $('#add-new-payment').removeAttr('disabled');
                },
                error: function (data) {
                    $('#add-new-payment').attr('disabled');
                    $('#add-new-payment').removeAttr('disabled');
                }
            });
        }
    }
</script>