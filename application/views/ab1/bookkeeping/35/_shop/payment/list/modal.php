<div id="dialog-select-payment" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Выбрать оплату</h4>
            </div>
            <div class="modal-body">
                <table class="table table-hover table-db table-tr-line" >
                    <thead>
                    <tr>
                        <th class="tr-header-date">Дата</th>
                        <th class="tr-header-price">№ документа</th>
                        <th class="width-120">Сумма</th>
                        <th style="width: 71px;"></th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <input name="shop_car_id" value="<?php echo Request_RequestParams::getParamInt('id'); ?>" style="display: none">

                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
<script>
    function showSelectPayment(){
        $('#dialog-select-payment').modal('show');
        var client = $('#shop_client_id').val();
        jQuery.ajax({
            url: '/bookkeeping/shoppayment/list',
            data: ({
                shop_client_id: (client),
            }),
            type: "POST",
            success: function (data) {
                $('#dialog-select-payment table tbody').html(data);
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    }
    function selectPayment(id, number, url){
        $('#shop_payment_id').val(id);
        $('#shop_payment_id').attr('value', id);
        $('#send-payment').attr('style', '');
        $('#send-payment label a').attr('href', url);
        $('#send-payment label a').text('№' + number);
        $('#dialog-select-payment').modal('hide');
    }
    function deleteSelectPayment(){
        $('#shop_payment_id').val(0);
        $('#shop_payment_id').attr('value', 0);
        $('#send-payment').attr('style', 'display:none;');
    }
</script>