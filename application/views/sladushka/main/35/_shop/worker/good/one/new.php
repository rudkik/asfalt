<div id="worker-good-new-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 900px">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Добавление продукцию</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fa fa-close"></span>
                </button>
            </div>
            <form class="has-validation-callback" action="/sladushka/shopworkergood/save">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <label for="date" class="col-3 col-form-label">Дата</label>
                            <div class="col-9">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="form-group margin-0">
                                            <input name="date" class="form-control" placeholder="Дата" id="date" type="datetime" value="<?php echo date('d.m.Y'); ?>">
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <div class="row">
                                            <label for="amount" class="col-3 col-form-label">Сумма</label>
                                            <div class="col-9">
                                                <div class="form-group margin-0">
                                                    <input data-id="total-all" id="worker-good-new-amount" class="form-control money-format" placeholder="Сумма" id="amount" type="text" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="worker-good-new-shop_worker_id" class="col-3 col-form-label">Сотрудник</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <div class="input-group">
                                        <select name="shop_worker_id" id="worker-good-new-shop_worker_id" class="form-control ks-select" data-parent="#worker-good-new-record" data-parent="#worker-good-new-record" style="width: 100%">
                                            <option value="0" data-id="0">Без сотрудника</option>
                                            <option value="-1" data-id="-1">Новый сотрудник</option>
                                            <?php echo $siteData->globalDatas['view::_shop/worker/list/list']; ?>
                                        </select>
                                        <span class="input-group-btn">
                                        <button class="btn btn-primary" type="button" data-select="#worker-good-new-shop_worker_id" data-action="add-new-panel">Добавить</button>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <?php echo $siteData->globalDatas['view::_shop/worker/good/item/list/index']; ?>
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

            $('#worker-good-new-record input[type="datetime"]').datetimepicker({
                dayOfWeekStart : 1,
                lang:'ru',
                format:	'd.m.Y',
                timepicker:false,
            });

            $('#worker-good-new-record form').on('submit', function(e){
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
                            $('#worker-good-new-record').modal('hide');
                            $('#worker-good-data-table').bootstrapTable('insertRow', {
                                index: 0,
                                row: obj.values
                            });

                            $.notify("Запись добавлена");
                        }
                    },
                    error: function (data) {
                        console.log(data.responseText);
                    }
                });

                return false;
            });

            $('#worker-good-new-record form select[name="shop_worker_id"]').change(function () {
                var id = $(this).val();

                if(id < 0){
                    var tmp = $('#worker-good-new-worker');
                    tmp.css('display', 'block');
                    tmp.find('input[name="is_add_worker"]').attr('value', 1);
                }else{
                    var tmp = $('#worker-good-new-worker');
                    tmp.css('display', 'none');
                    tmp.find('input[name="is_add_worker"]').attr('value', 0);
                }
            });

            $('#good-new-record .money-format').number(true, 0, '.', ' ');
        });
    </script>
</div>