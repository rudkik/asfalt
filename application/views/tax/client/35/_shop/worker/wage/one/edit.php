<div id="worker-wage-edit-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 900px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Редактирование зарплаты</h5>
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
                                    <input name="is_owner" type="checkbox" value="1" <?php if($data->values['is_owner'] == 1) {echo 'checked';}?>>
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
                                            <?php $month = intval(Helpers_DateTime::getMonth($data->values['date'])); ?>
                                            <select name="month" id="worker-wage-edit-month" class="form-control ks-select" data-parent="#worker-wage-edit-record" style="width: 100%">
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
                                                    <input name="year" data-validation="length" data-validation-length="4" maxlength="4" class="form-control" placeholder="Год" id="date" type="text" value="<?php echo Helpers_DateTime::getYear($data->values['date']); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="worker-wage-edit-shop_worker_id" class="col-3 col-form-label">Сотрудник</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <div class="input-group">
                                        <select name="shop_worker_id" id="worker-wage-edit-shop_worker_id" class="form-control ks-select" data-parent="#worker-wage-edit-record" data-parent="#worker-wage-edit-record" style="width: 100%">
                                            <option value="0" data-id="0">Выберите сотрудника</option>
                                            <option value="-1" data-id="-1">Новый сотрудник</option>
                                            <?php echo $siteData->globalDatas['view::_shop/worker/list/list']; ?>
                                        </select>
                                        <span class="input-group-btn">
                                        <button class="btn btn-primary" type="button" data-select="#worker-wage-edit-shop_worker_id" data-action="add-edit-panel">Добавить</button>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $view = View::factory('tax/client/35/_shop/worker/one/new-panel');
                        $view->siteData = $siteData;
                        $view->data = $data;
                        $view->panelID = 'worker-wage-edit-worker';
                        $view->selectID = 'worker-wage-edit-shop_worker_id';
                        echo Helpers_View::viewToStr($view);
                        ?>
                        <div class="form-group row">
                            <label for="worker-wage-edit-worker_status_id" class="col-3 col-form-label">Статус</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <select name="worker_status_id" id="worker-wage-edit-worker_status_id" class="form-control ks-select" data-parent="#worker-wage-edit-record" style="width: 100%">
                                        <option value="0" data-id="0">Без статуса</option>
                                        <?php echo $siteData->globalDatas['view::workerstatus/list/list']; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="wage" class="col-3 col-form-label">Зарплата</label>
                            <div class="col-9">
                                <input name="wage" class="form-control money-format" placeholder="Зарплата" id="wage" type="text" value="<?php echo Func::getNumberStr($data->values['wage_basic'], FALSE); ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input name="id" value="<?php echo $data->id; ?>" style="display: none">
                    <button type="button" class="btn btn-primary-outline ks-light" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            __initTable();

            $('#worker-wage-edit-record form').on('submit', function(e){
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
                            $('#worker-wage-edit-record').modal('hide');
                            $('#worker-wage-data-table').bootstrapTable('updateByUniqueId', {
                                id: obj.values.id,
                                row: obj.values
                            });

                            $that.find('input[type="text"], textarea').val('');
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

            $('#worker-wage-edit-record form select[name="shop_contractor_id"]').change(function () {
                var id = $(this).val();

                if(id < 0){
                    var tmp = $('#worker-wage-edit-contractor');
                    tmp.css('display', 'block');
                    tmp.find('input[name="is_add_contractor"]').attr('value', 1);
                }else{
                    var tmp = $('#worker-wage-edit-contractor');
                    tmp.css('display', 'none');
                    tmp.find('input[name="is_add_contractor"]').attr('value', 0);
                }
            });
        });
    </script>
</div>