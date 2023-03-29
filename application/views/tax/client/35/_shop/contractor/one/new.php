<div id="contractor-new-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Добавление контрагента</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fa fa-close"></span>
                </button>
            </div>
            <form class="has-validation-callback" action="/tax/shopcontractor/save">
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="form-group row">
                        <label for="name" class="col-3 col-form-label">Государственное учреждение?</label>
                        <div class="col-9 col-form-label" style="text-align: left;">
                            <input name="is_state" value="0" style="display: none">
                            <label class="ks-checkbox-slider ks-on-off ks-primary" style="margin-top: 10px;">
                                <input name="is_state" type="checkbox" value="1">
                                <span class="ks-indicator"></span>
                                <span class="ks-on">да</span>
                                <span class="ks-off">нет</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-3 col-form-label">Название</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <textarea data-validation="length" data-validation-length="min3" name="name" class="form-control valid" placeholder="Название" ></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bin" class="col-3 col-form-label">БИН</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <input name="bin" data-validation="length" data-validation-length="12" maxlength="12" class="form-control valid" placeholder="БИН" id="bin" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="address" class="col-3 col-form-label">Адрес</label>
                        <div class="col-9">
                            <textarea name="address" class="form-control" placeholder="Адрес"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bank_id" class="col-3 col-form-label">Банк / БИК</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <select name="bank_id" id="contractor-new-bank_id" class="form-control ks-select" data-parent="#contractor-new-record" style="width: 100%">
                                    <option value="0" data-id="0">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::bank/list/list']; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="iik" class="col-3 col-form-label">ИИК</label>
                        <div class="col-9">
                            <input name="iik" class="form-control" placeholder="ИИК" id="iik" type="text">
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
            $.validate({
                modules : 'location, date, security, file',
                lang: 'ru',
                onModulesLoaded : function() {

                }
            });
            __initTable();
            $('#contractor-new-record form').on('submit', function(e){
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
                            $('#contractor-new-record').modal('hide');
                            $('#contractor-data-table').bootstrapTable('insertRow', {
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