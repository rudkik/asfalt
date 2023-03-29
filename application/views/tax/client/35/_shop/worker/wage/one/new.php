<div id="worker-wage-new-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 900px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Добавление зарплаты</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fa fa-close"></span>
                </button>
            </div>
            <form class="has-validation-callback" action="/tax/shopworkerwage/save">
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="form-group row">
                        <label for="is_owner" class="col-3 col-form-label">Владелец компании?</label>
                        <div class="col-9 col-form-label text-left" style="text-align: left;">
                            <input name="is_owner" value="0" style="display: none">
                            <label class="ks-checkbox-slider ks-on-off ks-primary">
                                <input name="is_owner" type="checkbox" value="1">
                                <span class="ks-indicator"></span>
                                <span class="ks-on">да</span>
                                <span class="ks-off">нет</span>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <label for="number" class="col-3 col-form-label">Месяц</label>
                        <div class="col-9">
                            <div class="row">
                                <div class="col-5">
                                    <div class="form-group margin-0">
                                        <?php $month = intval(date('m')); ?>
                                        <select name="month" id="worker-wage-new-month" class="form-control ks-select" data-parent="#worker-wage-new-record" style="width: 100%">
                                            <option value="1" data-id="1" <?php if($month == 1){echo 'selected';} ?>>Январь</option>
                                            <option value="2" data-id="2" <?php if($month == 2){echo 'selected';} ?>>Февраль</option>
                                            <option value="3" data-id="3" <?php if($month == 3){echo 'selected';} ?>>Март</option>
                                            <option value="4" data-id="4" <?php if($month == 4){echo 'selected';} ?>>Апрель</option>
                                            <option value="5" data-id="5" <?php if($month == 5){echo 'selected';} ?>>Май</option>
                                            <option value="6" data-id="6" <?php if($month == 6){echo 'selected';} ?>>Июнь</option>
                                            <option value="7" data-id="7" <?php if($month == 7){echo 'selected';} ?>>Июль</option>
                                            <option value="8" data-id="8" <?php if($month == 8){echo 'selected';} ?>>Август</option>
                                            <option value="9" data-id="9" <?php if($month == 9){echo 'selected';} ?>>Сентябрь</option>
                                            <option value="10" data-id="10" <?php if($month == 10){echo 'selected';} ?>>Октябрь</option>
                                            <option value="11" data-id="11" <?php if($month == 11){echo 'selected';} ?>>Ноябрь</option>
                                            <option value="12" data-id="12" <?php if($month == 12){echo 'selected';} ?>>Декабрь</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-7">
                                    <div class="row">
                                        <label for="year" class="col-3 col-form-label">Год</label>
                                        <div class="col-9">
                                            <div class="form-group margin-0">
                                                <input name="year" data-validation="length" data-validation-length="4" maxlength="4" class="form-control" placeholder="Год" id="date" type="text" value="<?php echo date('Y'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="worker-wage-new-shop_worker_id" class="col-3 col-form-label">Сотрудник</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <div class="input-group">
                                    <select name="shop_worker_id" id="worker-wage-new-shop_worker_id" class="form-control ks-select" data-parent="#worker-wage-new-record" data-parent="#worker-wage-new-record" style="width: 100%">
                                        <option value="0" data-id="0">Выберите сотрудника</option>
                                        <option value="-1" data-id="-1">Новый сотрудник</option>
                                        <?php echo $siteData->globalDatas['view::_shop/worker/list/list']; ?>
                                    </select>
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="button" data-select="#worker-wage-new-shop_worker_id" data-action="add-new-panel">Добавить</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $view = View::factory('tax/client/35/_shop/worker/one/new-panel');
                    $view->siteData = $siteData;
                    $view->data = $data;
                    $view->panelID = 'worker-wage-new-worker';
                    $view->selectID = 'worker-wage-new-shop_worker_id';
                    echo Helpers_View::viewToStr($view);
                    ?>
                    <div class="form-group row">
                        <label for="worker-wage-new-worker_status_id" class="col-3 col-form-label">Статус</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <select name="worker_status_id" id="worker-wage-new-worker_status_id" class="form-control ks-select" data-parent="#worker-wage-new-record" style="width: 100%">
                                    <option value="0" data-id="0">Без статуса</option>
                                    <?php echo $siteData->globalDatas['view::workerstatus/list/list']; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="wage" class="col-3 col-form-label">Зарплата</label>
                        <div class="col-9">
                            <input name="wage" class="form-control money-format" placeholder="Зарплата" id="wage" type="text">
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

            $('#worker-wage-new-record form').on('submit', function(e){
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
                            $('#worker-wage-new-record').modal('hide');
                            $('#worker-wage-data-table').bootstrapTable('insertRow', {
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

            $('#worker-wage-new-record form select[name="shop_worker_id"]').change(function () {
                var id = $(this).val();

                if(id < 0){
                    var tmp = $('#worker-wage-new-worker');
                    tmp.css('display', 'block');
                    tmp.find('input[name="is_add_worker"]').attr('value', 1);
                }else{
                    var tmp = $('#worker-wage-new-worker');
                    tmp.css('display', 'none');
                    tmp.find('input[name="is_add_worker"]').attr('value', 0);
                }
            });
        });
    </script>
</div>