<div id="task-edit-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Редактирование оператора</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fa fa-close"></span>
                </button>
            </div>
            <form class="has-validation-callback" action="/nur-bookkeeping/shoptask/save">
                <div class="modal-body pb0">
                    <div class="container-fluid">
                        <div class="form-group row">
                            <label for="shop_table_rubric_id" class="col-3 col-form-label">Вид оператора</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <select name="shop_table_rubric_id" id="task-new-shop_table_rubric_id" class="form-control ks-select" data-parent="#task-edit-record" style="width: 100%">
                                        <option value="1" data-id="1" <?php if($data->values['shop_table_rubric_id'] == 1) {echo 'selected';}?>>Администратор</option>
                                        <option value="2" data-id="2" <?php if($data->values['shop_table_rubric_id'] == 2) {echo 'selected';}?>>Оператор Кара Далы</option>
                                        <option value="3" data-id="3" <?php if($data->values['shop_table_rubric_id'] == 3) {echo 'selected';}?>>Оператор Асфальтобетон</option>
                                        <option value="4" data-id="4" <?php if($data->values['shop_table_rubric_id'] == 4) {echo 'selected';}?>>Просмотр</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-3 col-form-label">ФИО</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="name" data-validation="length" data-validation-length="max250" maxlength="250" class="form-control" placeholder="ФИО" id="name" type="text" value="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-3 col-form-label">E-mail</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="email" data-validation="length" data-validation-length="max250" maxlength="250" class="form-control" placeholder="E-mail" id="email" type="email" value="<?php echo htmlspecialchars($data->values['email'], ENT_QUOTES); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-3 col-form-label">Пароль</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="password" class="form-control" placeholder="Пароль" id="password" type="password">
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

        $('#task-edit-record form').on('submit', function(e){
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
                        $('#task-edit-record').modal('hide');
                        $('#task-data-table').bootstrapTable('updateByUniqueId', {
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