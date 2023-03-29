<div id="payment-new-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 800px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Добавление платежного поручения</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fa fa-close"></span>
                </button>
            </div>
            <form class="has-validation-callback" action="/pyramid/shoppayment/save">
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="form-group row">
                        <label for="name" class="col-2 col-form-label">Оплачено?</label>
                        <div class="col-10 col-form-label" style="text-align: left;">
                            <input name="is_paid" value="0" style="display: none">
                            <label class="ks-checkbox-slider ks-on-off ks-primary">
                                <input name="is_paid" type="checkbox" value="1">
                                <span class="ks-indicator"></span>
                                <span class="ks-on">да</span>
                                <span class="ks-off">нет</span>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <label for="number" class="col-2 col-form-label">Номер</label>
                        <div class="col-10">
                            <div class="row">
                                <div class="col-4">
                                    <input name="number" data-validation="length" data-validation-length="max12" maxlength="12" class="form-control valid" placeholder="Номер" id="number" type="text">
                                </div>
                                <div class="col-8">
                                    <div class="row">
                                        <label class="col-4 col-form-label">Плательщик</label>
                                        <div class="col-8">
                                            <div class="form-group margin-0">
                                                <input name="name" data-validation="length" data-validation-length="max250" maxlength="250" class="form-control valid" placeholder="Плательщик" id="name" type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="number" class="col-2 col-form-label">Код брони</label>
                        <div class="col-10">
                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group margin-0">
                                        <input id="payment-new-shop_bill_id" data-client="#payment-new-shop_client_id" name="shop_bill_id" data-validation="length" data-validation-length="max12" maxlength="12" class="form-control valid bills typeahead" placeholder="Код брони" id="shop_bill_id" type="text">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="row">
                                        <label for="amount" class="col-4 col-form-label">Сумма</label>
                                        <div class="col-8">
                                            <div class="form-group margin-0">
                                                <input id="payment-new-amount" data-id="total" name="amount" class="form-control money-format" placeholder="Сумма" id="amount" type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="row">
                                        <label for="paid_at" class="col-5 col-form-label">Дата оплаты</label>
                                        <div class="col-7">
                                            <div class="form-group margin-0">
                                                <input name="paid_at" class="form-control" id="paid_at" type="datetime" autocomplete="off" value="<?php echo date('d.m.Y'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="payment-new-shop_client_id" class="col-2 col-form-label">Клиент</label>
                        <div class="col-10">
                            <div class="form-group margin-0">
                                <div class="input-group">
                                    <select id="payment-new-shop_client_id" name="shop_client_id" id="payment-new-shop_client_id" class="form-control ks-select" data-parent="#payment-new-record" data-balance="#payment-new-client-balance" style="width: 100%">
                                        <option value="0" data-id="0">Введите клиента</option>
                                        <?php
                                        $tmp = 'data-id="'.Request_RequestParams::getParamInt('shop_client_id').'"';
                                        echo str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/client/list/list']);
                                        ?>
                                    </select>
                                    <span id="payment-edit-client-balance" class="box-balance">0 тг</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="number" class="col-2 col-form-label"></label>
                        <div class="col-10">
                            <div class="row">
                                <div class="col-4">
                                </div>
                                <div class="col-8">
                                    <div class="row">
                                        <label class="col-4 col-form-label">Способ оплаты</label>
                                        <div class="col-8">
                                            <div class="form-group margin-0">
                                                <select id="payment-new-shop_paid_id" name="shop_paid_type_id" class="form-control ks-select" data-parent="#payment-new-record" style="width: 100%">
                                                    <option value="0" data-id="0">Выберите способ оплаты</option>
                                                    <?php echo $siteData->globalDatas['view::_shop/paid-type/list/list'];?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary-outline ks-light" data-dismiss="modal">Закрыть</button>
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        __initTable();

        $('#payment-new-record input[type="datetime"]').datetimepicker({
            dayOfWeekStart : 1,
            lang:'ru',
            format:	'd.m.Y',
            timepicker:false,
        });

        $('#payment-new-record form').on('submit', function(e){
            if (($('#payment-new-amount').val() < 1) || ($('#payment-new-shop_client_id').val() < 1)
                || ($('#payment-new-shop_paid_id').val() < 1) || ($('#payment-new-shop_bill_id').val() < 1)){
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
                        $('#payment-new-record').modal('hide');
                        $('#payment-data-table').bootstrapTable('insertRow', {
                            index: 0,
                            row: obj.values
                        });
                        $that.find('input[type="text"], input[type="date"], textarea').val('');
                        $that.find('select').val('0');
                        $that.find('input[type="checkbox"]').removeAttr("checked");

                        $.notify("Запись сохранена");
                    }
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });

            return false;
        });
    });
</script>