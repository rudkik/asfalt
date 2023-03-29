<div id="contract-edit-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Редактирование договора</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fa fa-close"></span>
                </button>
            </div>
            <form class="has-validation-callback" action="/tax/shopcontract/save">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="form-group row">
                            <label for="number" class="col-3 col-form-label">Номер</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="number" data-validation="length" data-validation-length="max50" maxlength="50" class="form-control valid" placeholder="Номер" id="number" type="text" value="<?php echo htmlspecialchars($data->values['number'], ENT_QUOTES);?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="shop_contractor_id" class="col-3 col-form-label">Контрагент</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <select name="shop_contractor_id" id="shop_contractor_id" class="form-control ks-select" data-parent="#contract-edit-record" style="width: 100%">
                                        <option value="0" data-id="0">Без контрагента</option>
                                        <?php echo $siteData->globalDatas['view::_shop/contractor/list/list']; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="date_from" class="col-3 col-form-label">Дата начала</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="date_from" class="form-control" placeholder="Дата начала" id="date_from" type="datetime" autocomplete="off" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['date_from']);?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="date_to" class="col-3 col-form-label">Дата окончания</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="date_to" class="form-control" placeholder="Дата окончания" id="date_to" type="datetime" autocomplete="off" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['date_to']);?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-3 col-form-label">Категория договора</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="view" data-validation="length" data-validation-length="max50" maxlength="50" class="form-control valid" placeholder="на оказание услуг" id="view" type="text" value="<?php echo htmlspecialchars($data->values['view'], ENT_QUOTES);?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="text" class="col-3 col-form-label">Примечание</label>
                            <div class="col-9">
                                <textarea name="text" class="form-control" placeholder="Примечание"><?php echo htmlspecialchars($data->values['text'], ENT_QUOTES);?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary-outline ks-light" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                    <input name="id" value="<?php echo $data->id; ?>" style="display: none">
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $.validate({
                modules : 'location, date, security, file',
                lang: 'ru',
                onModulesLoaded : function() {

                }
            });
            __initTable();

            $('#contract-edit-record input[type="datetime"]').datetimepicker({
                dayOfWeekStart : 1,
                lang:'ru',
                format:	'd.m.Y',
                timepicker:false,
            }).inputmask({
                mask: "99.99.9999"
            });

            $('#contract-edit-record form').on('submit', function(e){
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
                            $('#contract-edit-record').modal('hide');
                            $('#contract-data-table').bootstrapTable('updateByUniqueId', {
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
        });
    </script>
</div>