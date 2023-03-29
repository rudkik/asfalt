<div id="client-edit-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Редактирование клиента</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fa fa-close"></span>
                </button>
            </div>
            <form class="has-validation-callback" action="/ads/shopclient/save">
                <div class="modal-body pb0">
                    <div class="container-fluid">
                        <div class="row">
                            <label for="first_name" class="col-3 col-form-label">Имя</label>
                            <div class="col-9">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="form-group margin-0">
                                            <input name="first_name" data-validation="length" data-validation-length="max50" maxlength="50" class="form-control valid" placeholder="Имя" id="first_name" type="text" value="<?php echo htmlspecialchars($data->values['first_name'], ENT_QUOTES) ?>">
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <div class="row">
                                            <label for="last_name" class="col-4 col-form-label">Фамилия</label>
                                            <div class="col-8">
                                                <div class="form-group margin-0">
                                                    <input name="last_name" data-validation="length" data-validation-length="max50" maxlength="50" class="form-control valid" placeholder="Фамилия" id="last_name" type="text" value="<?php echo htmlspecialchars($data->values['last_name'], ENT_QUOTES) ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-3 col-form-label">E-mail</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="email" data-validation="length" data-validation-length="max50" maxlength="50" class="form-control valid" placeholder="E-mail" id="email" type="email" value="<?php echo htmlspecialchars($data->values['email'], ENT_QUOTES) ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone" class="col-3 col-form-label">Телефон</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="phone" data-validation="length" data-validation-length="max50" maxlength="50" class="form-control valid" placeholder="Телефон" id="phone" type="text" value="<?php echo htmlspecialchars($data->values['phone'], ENT_QUOTES) ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="delivery_amount" class="col-3 col-form-label">Стоимость доставки</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input data-decimals="2" name="delivery_amount" class="form-control money-format" placeholder="Стоимость доставки" id="delivery_amount" type="text" value="<?php echo htmlspecialchars($data->values['delivery_amount'], ENT_QUOTES) ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3 col-form-label">Удостоверение личности</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <?php $tmp = Arr::path($data->values['options'], 'file_passport_1.file', '');
                                    if(!empty($tmp)){?>
                                    <a target="_blank" href="<?php echo $tmp; ?>">1 сторона</a><br>
                                    <?php }?>
                                    <?php
                                    $tmp = Arr::path($data->values['options'], 'file_passport_2.file', '');
                                    if(!empty($tmp)){ ?>
                                        <a target="_blank" href="<?php echo $tmp; ?>">2 сторона</a><br>
                                    <?php } ?>
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
        $('#client-edit-record form').on('submit', function(e){
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
                        $('#client-edit-record').modal('hide');
                        $('#client-data-table').bootstrapTable('updateByUniqueId', {
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