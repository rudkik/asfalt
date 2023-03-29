<div id="refund-new-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 800px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Добавление возврата</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fa fa-close"></span>
                </button>
            </div>
            <form class="has-validation-callback" action="/hotel/shoprefund/save">
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <label for="number" class="col-2 col-form-label">Номер 1С</label>
                        <div class="col-10">
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group margin-0">
                                        <input name="number" data-validation="length" data-validation-length="max12" maxlength="12" class="form-control valid" placeholder="Номер 1С" id="number" type="text">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="row">
                                        <label for="amount" class="col-4 col-form-label">Сумма</label>
                                        <div class="col-8">
                                            <div class="form-group margin-0">
                                                <input data-id="total" name="amount" class="form-control money-format" placeholder="Сумма" id="amount" type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="row">
                                        <label for="date" class="col-3 col-form-label">Дата возврата</label>
                                        <div class="col-9">
                                            <div class="form-group margin-0">
                                                <input name="date" class="form-control" id="date" type="datetime" autocomplete="off" value="<?php echo date('d.m.Y'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="refund-new-refund_type_id" class="col-2 col-form-label">Тип возврата</label>
                        <div class="col-10">
                            <div class="form-group margin-0">
                                <select id="refund-new-refund_type_id" name="refund_type_id" class="form-control ks-select" data-parent="#refund-new-record" style="width: 100%">
                                    <option value="0" data-id="0">Выберите тип возврата</option>
                                    <?php echo $siteData->globalDatas['view::refund-type/list/list'];?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="refund-new-shop_client_id" class="col-2 col-form-label">Клиент</label>
                        <div class="col-10">
                            <div class="form-group margin-0">
                                <div class="input-group">
                                    <select name="shop_client_id" id="refund-new-shop_client_id" class="form-control ks-select" data-parent="#refund-new-record" data-balance="#refund-new-client-balance" style="width: 100%">
                                        <option value="0" data-id="0">Введите клиента</option>
                                        <?php
                                        $tmp = 'data-id="'.Request_RequestParams::getParamInt('shop_client_id').'"';
                                        echo str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/client/list/list']);
                                        ?>
                                    </select>
                                    <span id="refund-new-client-balance" class="box-balance">0 тг</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="text" class="col-2 col-form-label">Примечание</label>
                        <div class="col-10">
                            <textarea name="text" class="form-control" placeholder="Примечание"></textarea>
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

        $('#refund-new-record input[type="datetime"]').datetimepicker({
            dayOfWeekStart : 1,
            lang:'ru',
            format:	'd.m.Y',
            timepicker:false,
        });

        $('#refund-new-record form').on('submit', function(e){
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
                        $('#refund-new-record').modal('hide');
                        $('#refund-data-table').bootstrapTable('insertRow', {
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