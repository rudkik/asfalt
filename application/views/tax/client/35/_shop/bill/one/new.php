<div id="bill-new-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Добавление договора</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fa fa-close"></span>
                </button>
            </div>
            <form class="has-validation-callback" action="/tax/shopbill/save">
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <label for="number" class="col-3 col-form-label">Сумма</label>
                        <div class="col-9">
                            <div class="row">
                                <div class="col-5">
                                    <div class="form-group margin-0">
                                        <input name="amount" class="form-control money-format" placeholder="Сумма" id="amount" type="text">
                                    </div>
                                </div>
                                <div class="col-7">
                                    <div class="row">
                                        <label for="date" class="col-4 col-form-label">Дата</label>
                                        <div class="col-8">
                                            <div class="form-group margin-0">
                                                <input name="date" class="form-control" placeholder="Дата" id="date_from" type="datetime" autocomplete="off" value="<?php echo date('d.m.Y');?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="shop_contractor_id" class="col-3 col-form-label">Контрагент</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <select name="shop_contractor_id" id="shop_contractor_id" class="form-control ks-select" data-parent="#bill-new-record" style="width: 100%">
                                    <option value="0" data-id="0">Без контрагента</option>
                                    <?php echo $siteData->globalDatas['view::_shop/contractor/list/list']; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bill_type_id" class="col-3 col-form-label">Вид операции</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <select name="bill_type_id" id="bill_type_id" class="form-control ks-select" data-parent="#bill-edit-record" style="width: 100%" <?php if ($isRead){ echo 'disabled';} ?>>
                                    <option value="0" data-id="0">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::billtype/list/list']; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="text" class="col-3 col-form-label">Примечание</label>
                        <div class="col-9">
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
    <script>
        $(document).ready(function () {
            __initTable();

            $('#bill-new-record input[type="datetime"]').datetimepicker({
                dayOfWeekStart : 1,
                lang:'ru',
                format:	'd.m.Y',
                timepicker:false,
            }).inputmask({
                mask: "99.99.9999"
            });

            $('#bill-new-record form').on('submit', function(e){
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
</div>