<div id="bill-edit-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-full" style="max-width: 1000px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Код брони: <b><?php echo $data->id; ?></b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fa fa-close"></span>
                </button>
            </div>
            <form class="has-validation-callback" action="/hotel/shopbill/save">
                <div class="modal-body pb0" style="padding-top: 5px;">
                    <div class="container-fluid">
                        <div class="form-group row">
                            <label for="name" class="col-2 col-form-label" style="padding-bottom: 0px;">Клиент отдохнул?</label>
                            <div class="col-10 col-form-label" style="text-align: left; padding-bottom: 0px;">
                                <input name="is_finish" value="0" style="display: none" >
                                <label class="ks-checkbox-slider ks-on-off ks-primary">
                                    <input name="is_finish" type="checkbox" value="1" <?php if($data->values['is_finish'] == 1) {echo 'checked';}?>>
                                    <span class="ks-indicator"></span>
                                    <span class="ks-on">да</span>
                                    <span class="ks-off">нет</span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <?php echo $siteData->globalDatas['view::_shop/bill/item/list/index']; ?>
                        </div>
                        <div class="form-group row">
                            <label for="bill-edit-shop_client_id" class="col-2 col-form-label">Клиент</label>
                            <div class="col-10">
                                <div class="form-group margin-0">
                                    <div class="input-group">
                                        <select name="shop_client_id" id="bill-edit-shop_client_id" class="form-control ks-select" data-parent="#bill-edit-record" data-balance="#bill-edit-client-balance" style="width: 100%">
                                            <option value="0" data-id="0">Введите клиента</option>
                                            <option value="-1" data-id="-1">Новый клиент</option>
                                            <?php echo $siteData->globalDatas['view::_shop/client/list/list']; ?>
                                        </select>
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary" type="button" data-select="#bill-edit-shop_client_id" data-action="add-edit-panel">Добавить нового клиента</button>
                                        </span>
                                        <span id="bill-edit-client-balance" class="box-balance">
                                            0 тг
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $view = View::factory('hotel/35/_shop/client/one/new-panel');
                        $view->siteData = $siteData;
                        $view->data = $data;
                        $view->panelID = 'bill-edit-client';
                        $view->selectID = 'bill-edit-shop_client_id';
                        echo Helpers_View::viewToStr($view);
                        ?>
                        <div class="row">
                            <label for="bill-new-limit_time" class="col-2 col-form-label">Лимит брони </label>
                            <div class="col-10">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group margin-0">
                                            <input name="limit_time" class="form-control" id="limit_time" date-type="datetime" type="datetime" value="<?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['limit_time']); ?>" <?php if ($siteData->operation->getShopTableRubricID() == 2){ ?>readonly <?php } ?>>
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <div class="row">
                                            <div class="col-5">
                                                <div class="row">
                                                    <label for="discount" class="col-3 col-form-label">Скидка, %</label>
                                                    <div class="col-9">
                                                        <div class="form-group margin-0">
                                                            <input id="bill-edit-discount" data-decimals="4" data-id="discount" name="discount" class="form-control money-format" id="discount" type="text" value="<?php echo Func::getNumberStr($data->values['discount'], FALSE); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-7">
                                                <div class="row">
                                                    <label for="bill-new-amount" class="col-3 col-form-label">Общая сумма</label>
                                                    <div class="col-9">
                                                        <div class="form-group margin-0">
                                                            <input data-id="total" id="bill-edit-amount" class="form-control money-format" placeholder="Сумма" type="text" value="<?php echo Func::getNumberStr($data->values['amount'], FALSE); ?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="text" class="col-2 col-form-label">Примечание</label>
                            <div class="col-10">
                                <textarea name="text" class="form-control" placeholder="Примечание"><?php echo htmlspecialchars($data->values['text'], ENT_QUOTES); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <?php echo str_replace('#parent-select#', 'bill-edit-record', $siteData->replaceDatas['view::_shop/bill/service/list/index']); ?>
                        </div>
                        <?php echo $siteData->globalDatas['view::_shop/payment/list/bill']; ?>
                    </div>
                </div>
                <div class="modal-footer" style="display: block;">
                    <div class="pull-left">
                        <div class="form-group">
                            <div class="input-group">
                                <label class="title_pay col-form-label">К оплате</label>
                                <input id="bill-edit-pay-amount" class="form-control money-format" placeholder="К оплате" type="text" value="<?php echo Func::getNumberStr($data->values['amount'] - $data->values['paid_amount'], FALSE); ?>">
                                <span class="input-group-addon">
                                    <label class="custom-control custom-checkbox ks-no-description" style="width: 110px;">
                                        <input name="shop_paid_type_id" value="903" type="checkbox" class="custom-control-input">
                                        <span class="custom-control-indicator"></span>
                                        &nbsp;Pos-терминал
                                    </label>
                                </span>
                                <span class="input-group-btn">
                                    <button data-url="/hotel/shoppayment/add?shop_bill_id=<?php echo $data->id; ?>&shop_paid_type_id=899&is_paid=1" data-action="add-payment" type="button" class="btn btn-primary">Оплатить</button>
                                    <a style="display: none" id="bill-edit-pko" data-url="/hotel/shopexcel/pko?id=" target="_blank" href="#" class="btn btn-primary">ПКО</a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="pull-right">
                        <input name="id" value="<?php echo $data->id; ?>" style="display: none">
                        <button type="button" class="btn btn-primary-outline ks-light" data-dismiss="modal">Закрыть</button>
                        <?php if(((! $data->values['is_finish']) || ($siteData->operation->getShopTableRubricID() == 1)) && ($siteData->operation->getShopTableRubricID() != 4)){ ?>
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                        <?php } ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            __initTable();

            $('#bill-edit-record .select2[name="shop_client_id"]').select2({
                "language": {
                    "noResults": function(){
                        return "Клиент не найден";
                    }
                }
            });

            $('#bill-edit-record .select2[data-id="shop_service_id"]').select2({
                "language": {
                    "noResults": function(){
                        return "Услуга не найдна";
                    }
                }
            });


            $('#bill-edit-record input[type="datetime"][date-type="datetime"]').datetimepicker({
                dayOfWeekStart : 1,
                lang:'ru',
                format:	'd.m.Y H:i',
                timepicker:true,
            });

            $('#bill-edit-record button[data-action="add-payment"]').click(function(e){
                var el = $('#bill-edit-pay-amount');
                var amount = el.val();
                var url = $(this).data('url');
                var button = $(this);

                button.css('display', 'none');

                jQuery.ajax({
                    url: url,
                    data: ({
                        'amount': (amount)
                    }),
                    type: "POST",
                    success: function (data) {
                        el.attr('readonly', '');
                        $('#bill-edit-record [name="limit_time"]').val('').attr('value', '').attr('readonly', '');

                        var obj = jQuery.parseJSON($.trim(data));
                        el = $('#bill-edit-pko');
                        el.attr('href', el.data('url')+obj.id);
                        el.css('display', 'block');
                    },
                    error: function (data) {
                        console.log(data.responseText);
                    }
                });

                return false;
            });

            $('#bill-edit-record form').on('submit', function(e){
                if ((($('#bill-edit-amount').val() < 1) && ($('#bill-edit-discount').val() != 100)) || (($('#bill-edit-shop_client_id').val() < 1) && ($('#bill-edit-client input[name="is_add_client"]').val() != '1'))){
                    return false;
                }

                e.preventDefault();
                var $that = $(this),
                    formData = new FormData($that.get(0)); // создаем новый экземпляр объекта и передаем ему нашу форму (*)
                url = $(this).attr('action')+'?json=1';

                jQuery.ajax({
                    url: url,
                    data: formData,
                    type: "POST",
                    contentType: false, // важно - убираем форматирование данных по умолчанию
                    processData: false, // важно - убираем преобразование строк по умолчанию
                    success: function (data) {
                        var obj = jQuery.parseJSON($.trim(data));
                        if (!obj.error) {
                            $('#bill-edit-record').modal('hide');
                            $('#bill-data-table').bootstrapTable('updateByUniqueId', {
                                id: obj.values.id,
                                row: obj.values
                            });

                            $that.find('input[type="text"], textarea').val('');
                            $that.find('input[type="checkbox"]').removeAttr("checked");

                            $.notify('Бронь №<b>'+obj.values.id+'</b> клиента <b>'+obj.values.shop_client_name+'</b> сохранена.');
                        }
                    },
                    error: function (data) {
                        console.log(data.responseText);
                    }
                });

                return false;
            });

            // изменение скидки
            $('#bill-edit-record form [data-id="discount"]').change(function () {
                var parent = $('#bill-edit-record form');
                var total = 0;
                parent.find('[data-id="amount"]').each(function (i) {
                    total = total + Number($(this).data('amount-tr'));
                });

                var discount = Number(parent.find('[data-id="discount"]').val());
                if (discount !== undefined) {
                    total = total / 100 * (100 - discount);
                }
                parent.find('[data-id="total"]').val(total);

                return false;
            });

            $('#bill-edit-record form select[name="shop_client_id"]').change(function () {
                var id = $(this).val();

                if(id < 0){
                    var tmp = $('#bill-edit-client');
                    tmp.css('display', 'block');
                    tmp.find('input[name="is_add_client"]').attr('value', 1);
                }else{
                    var tmp = $('#bill-edit-client');
                    tmp.css('display', 'none');
                    tmp.find('input[name="is_add_client"]').attr('value', 0);
                }
            });
        });
    </script>
</div>