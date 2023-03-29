<div id="bill-new-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-full" style="max-width: 1200px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Добавление брони</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fa fa-close"></span>
                </button>
            </div>
            <form class="has-validation-callback" action="/pyramid/shopbill/save">
                <div class="modal-body pb0">
                    <div class="container-fluid">
                        <div class="form-group row">
                            <?php echo $siteData->globalDatas['view::_shop/bill/item/list/index']; ?>
                        </div>
                        <div class="form-group row">
                            <label for="bill-new-shop_client_id" class="col-2 col-form-label">Клиент</label>
                            <div class="col-10">
                                <div class="form-group margin-0">
                                    <div class="input-group">
                                        <select name="shop_client_id" id="bill-new-shop_client_id" class="form-control ks-select" data-parent="#bill-new-record" data-parent="#bill-new-record" data-balance="#bill-new-client-balance" style="width: 100%">
                                            <option value="0" data-id="0">Введите клиента</option>
                                            <option value="-1" data-id="-1">Новый клиент</option>
                                            <?php echo $siteData->globalDatas['view::_shop/client/list/list']; ?>
                                        </select>
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary" type="button" data-select="#bill-new-shop_client_id" data-action="add-new-panel">Добавить нового клиента</button>
                                        </span>
                                        <span id="bill-new-client-balance" class="box-balance">0 тг</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $view = View::factory('pyramid/35/_shop/client/one/new-panel');
                        $view->siteData = $siteData;
                        $view->data = $data;
                        $view->panelID = 'bill-new-client';
                        $view->selectID = 'bill-new-shop_client_id';
                        echo Helpers_View::viewToStr($view);
                        ?>
                        <div class="row">
                            <label for="bill-new-limit_time" class="col-2 col-form-label">Лимит брони </label>
                            <div class="col-10">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group margin-0">
                                            <input name="limit_time" class="form-control" placeholder="Лимит брони" id="limit_time" date-type="datetime" type="datetime" value="<?php echo date('d.m.Y H:i', strtotime('+2 days')); ?>" <?php if ($siteData->operation->getShopTableRubricID() == 2){ ?>readonly <?php } ?>>
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <div class="row">
                                            <div class="col-5">
                                                <div class="row">
                                                    <label for="discount" class="col-3 col-form-label">Скидка, %</label>
                                                    <div class="col-9">
                                                        <div class="form-group margin-0">
                                                            <input id="bill-new-discount" data-decimals="4" data-id="discount" name="discount" class="form-control money-format" id="discount" type="text">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-7">
                                                <div class="row">
                                                    <label for="bill-new-amount" class="col-3 col-form-label">Общая сумма</label>
                                                    <div class="col-9">
                                                        <div class="form-group margin-0">
                                                            <input data-id="total" id="bill-new-amount" class="form-control money-format" placeholder="Сумма" type="text" readonly>
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
                                <textarea name="text" class="form-control" placeholder="Примечание"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <?php echo str_replace('#parent-select#', 'bill-new-record', $siteData->replaceDatas['view::_shop/bill/service/list/index']); ?>
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
    <script>
        $(document).ready(function () {
            $('#bill-new-record .select2').select2({
                "language": {
                    "noResults": function(){
                        return "Клиент не найден";
                    }
                }
            }).attr('data-select2', 1);
            __initTable();



            $('#bill-new-record input[type="datetime"][date-type="datetime"]').datetimepicker({
                dayOfWeekStart : 1,
                lang:'ru',
                format:	'd.m.Y H:i',
                timepicker:true,
            });

            $('#bill-new-record form').on('submit', function(e){
                if ((($('#bill-new-amount').val() < 1) && ($('#bill-new-discount').val() != 100)) || (($('#bill-new-shop_client_id').val() < 1) && ($('#bill-new-client input[name="is_add_client"]').val() != '1'))){
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
                            $('#bill-new-record').modal('hide');
                            $('#bill-data-table').bootstrapTable('insertRow', {
                                index: 0,
                                row: obj.values
                            });
                            $that.find('input[type="text"], input[type="date"], textarea').val('');
                            $that.find('select').val('0');
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
            $('#bill-new-record form [data-id="discount"]').change(function () {
                var parent = $('#bill-new-record form');
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

            $('#bill-new-record form select[name="shop_client_id"]').change(function () {
                var id = $(this).val();

                if(id < 0){
                    var tmp = $('#bill-new-client');
                    tmp.css('display', 'block');
                    tmp.find('input[name="is_add_client"]').attr('value', 1);
                }else{
                    var tmp = $('#bill-new-client');
                    tmp.css('display', 'none');
                    tmp.find('input[name="is_add_client"]').attr('value', 0);
                }
            });
        });
    </script>
</div>