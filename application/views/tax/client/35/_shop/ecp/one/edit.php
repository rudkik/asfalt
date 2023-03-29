<div id="ecp-edit-record" class="modal-edit">
    <div class="modal-dialog" style="margin: 0px; max-width: 700px">
        <div class="modal-content" style="border: none">
            <form class="has-validation-callback" action="/tax/shopecp/save">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="form-group row">
                            <label class="col-3 col-form-label"></label>
                            <label class="col-9 col-form-label text-left" style="font-size: 15px;font-weight: 600;">Файл авторизации (AUTH_*)</label>
                        </div>
                        <?php if($data->id > 0){ ?>
                            <?php if(!empty($data->values['auth_file'])){ ?>
                                <div class="form-group row">
                                    <label class="col-3 col-form-label">Текущий файл</label>
                                    <div class="col-9">
                                        <div class="form-group margin-0">
                                            <fieldset class="form-group has-success">
                                                <input class="form-control form-control-success" type="text" value="<?php echo $data->values['auth_name']; ?>" readonly>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                        <div class="form-group row">
                            <label for="file_auth" class="col-3 col-form-label">Новый файл</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <div class="file-upload" data-text="Выберите файл">
                                        <input type="file" name="file_auth">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row" style="margin-bottom: 40px">
                            <label for="auth_password" class="col-3 col-form-label">Пароль</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="auth_password" data-validation="length" data-validation-length="50" maxlength="50" class="form-control valid" placeholder="Пароль" id="auth_password" type="password">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3 col-form-label"></label>
                            <label class="col-9 col-form-label text-left" style="font-size: 15px;font-weight: 600;">Файл подписи (GOSTKNCA_*)</label>
                        </div>
                        <?php if($data->id > 0){ ?>
                            <?php if(!empty($data->values['gostknca_file'])){ ?>
                                <div class="form-group row">
                                    <label class="col-3 col-form-label">Текущий файл</label>
                                    <div class="col-9">
                                        <div class="form-group margin-0">
                                            <fieldset class="form-group has-success">
                                                <input class="form-control form-control-success" type="text" value="<?php echo $data->values['gostknca_name']; ?>" readonly>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                        <div class="form-group row">
                            <label for="file_gostknca" class="col-3 col-form-label">Новый файл</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <div class="file-upload" data-text="Выберите файл">
                                        <input type="file" name="file_gostknca">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="gostknca_password" class="col-3 col-form-label">Пароль</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="gostknca_password" data-validation="length" data-validation-length="50" maxlength="50" class="form-control valid" placeholder="Пароль" id="gostknca_password" type="password">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#ecp-edit-record form').on('submit', function(e){
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

