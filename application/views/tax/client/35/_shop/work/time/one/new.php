<div id="work-time-new-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 900px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Добавление зарплаты</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fa fa-close"></span>
                </button>
            </div>
            <form class="has-validation-callback" action="/tax/shopworktime/save">
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="form-group row">
                        <label for="work-time-new-shop_worker_id" class="col-3 col-form-label">Сотрудник</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <div class="input-group">
                                    <select name="shop_worker_id" id="work-time-new-shop_worker_id" class="form-control ks-select" data-parent="#work-time-new-record" data-parent="#work-time-new-record" style="width: 100%">
                                        <option value="0" data-id="0">Выберите сотрудника</option>
                                        <option value="-1" data-id="-1">Новый сотрудник</option>
                                        <?php echo $siteData->globalDatas['view::_shop/worker/list/list']; ?>
                                    </select>
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="button" data-select="#work-time-new-shop_worker_id" data-action="add-new-panel">Добавить</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $view = View::factory('tax/client/35/_shop/worker/one/new-panel');
                    $view->siteData = $siteData;
                    $view->data = $data;
                    $view->panelID = 'work-time-new-worker';
                    $view->selectID = 'work-time-new-shop_worker_id';
                    echo Helpers_View::viewToStr($view);
                    ?>
                    <div class="form-group row">
                        <label for="work-time-new-work_time_type_id" class="col-3 col-form-label">Статус</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <select name="work_time_type_id" id="work-time-new-work_time_type_id" class="form-control ks-select" data-parent="#work-time-new-record" style="width: 100%">
                                    <option value="0" data-id="0">Без статуса</option>
                                    <?php echo $siteData->globalDatas['view::work-time-type/list/list']; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="wage" class="col-3 col-form-label">Период</label>
                        <div class="col-9">
                            <input type="text" name="period" value="" class="form-control ks-daterange">
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

            $('#work-time-new-record .ks-daterange').daterangepicker({
                showDropdowns: false,
                timePicker:false,
                locale: {
                    format: 'DD.MM.YYYY',
                    applyLabel: 'Принять',
                    cancelLabel: 'Отмена',
                    invalidDateLabel: 'Выберите дату',
                    daysOfWeek: ['Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс', 'Пн'],
                    monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
                    firstDay: 1
                }
            });

            $('#work-time-new-record form').on('submit', function(e){
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
                            $('#work-time-new-record').modal('hide');
                            $('#work-time-data-table').bootstrapTable('insertRow', {
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

            $('#work-time-new-record form select[name="shop_worker_id"]').change(function () {
                var id = $(this).val();

                if(id < 0){
                    var tmp = $('#work-time-new-worker');
                    tmp.css('display', 'block');
                    tmp.find('input[name="is_add_worker"]').attr('value', 1);
                }else{
                    var tmp = $('#work-time-new-worker');
                    tmp.css('display', 'none');
                    tmp.find('input[name="is_add_worker"]').attr('value', 0);
                }
            });
        });
    </script>
</div>