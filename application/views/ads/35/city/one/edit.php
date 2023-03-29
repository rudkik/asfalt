<div id="city-edit-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Редактирование области</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fa fa-close"></span>
                </button>
            </div>
            <form class="has-validation-callback" action="/ads/city/save">
                <div class="modal-body pb0">
                    <div class="container-fluid">
                        <div class="form-group row">
                            <label for="name" class="col-3 col-form-label">Название</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="name" data-validation="length" data-validation-length="max250" maxlength="250" class="form-control valid" placeholder="Название" id="name" type="text" value="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES) ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="city-edit-land_id" class="col-3 col-form-label">Страна</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <select name="land_id" id="city-edit-land_id" class="form-control ks-select" data-parent="#city-edit-record" style="width: 100%">
                                        <option value="0" data-id="0">Без значения</option>
                                        <?php echo $siteData->globalDatas['view::land/list/list']; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="city-edit-region_id" class="col-3 col-form-label">Область</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <select name="region_id" id="city-edit-region_id" class="form-control ks-select" data-parent="#city-edit-record" style="width: 100%">
                                        <option value="0" data-id="0">Без значения</option>
                                        <?php echo $siteData->globalDatas['view::region/list/list']; ?>
                                    </select>
                                </div>
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
</div>
<script>
    $(document).ready(function () {
        __initTable();
        $.validate({
            modules : 'location, date, security, file',
            lang: 'ru',
            onModulesLoaded : function() {

            }
        });
        $('#city-edit-record form').on('submit', function(e){
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
                        $('#city-edit-record').modal('hide');
                        $('#city-data-table').bootstrapTable('updateByUniqueId', {
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

        $('#city-edit-record form select[name="land_id"]').change(function () {
            var id = $(this).val();

            if (id > 0) {
                jQuery.ajax({
                    url: '/ads/region/list',
                    data: ({
                        'land_id': (id),
                    }),
                    type: "POST",
                    success: function (data) {
                        var tmp = $('#city-edit-record form select[name="region_id"]');
                        var s = tmp.val();
                        tmp.html('<option value="0" data-id="0">Без значения</option>' + data);
                        tmp.val(s);
                    },
                    error: function (data) {
                        console.log(data.responseText);
                    }
                });
            }else{
                var tmp = $('#city-edit-record form select[name="region_id"]');
                var s = tmp.val();
                tmp.html('<option value="0" data-id="0">Без значения</option>');
                tmp.val(s);
            }
        });
    });
</script>