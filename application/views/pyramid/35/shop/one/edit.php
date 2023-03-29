<div id="shop-edit-record" class="modal-edit">
    <div class="modal-dialog" style="margin: 0px; max-width: 700px">
        <div class="modal-content" style="border: none">
            <form class="has-validation-callback" action="/pyramid/shop/save">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="form-group row">
                            <label for="requisites-company" class="col-3 col-form-label">Юридическое название</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="requisites[company]" data-validation="length" data-validation-length="max250" maxlength="250" class="form-control valid" placeholder="Юридическое название" id="requisites-company" type="text" value="<?php echo htmlspecialchars(Arr::path($data->values, 'requisites.company', Arr::path($data->values, 'requisites.company_name', '')), ENT_QUOTES);?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="requisites-bin" class="col-3 col-form-label">БИН</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="requisites[bin]" data-validation="length" data-validation-length="12" maxlength="12" class="form-control valid" placeholder="БИН" id="requisites-bin" type="text" value="<?php echo htmlspecialchars(Arr::path($data->values, 'requisites.bin', ''), ENT_QUOTES);?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="requisites-address" class="col-3 col-form-label">Юридическое адрес</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="requisites[address]" data-validation="length" data-validation-length="max250" maxlength="250" class="form-control valid" placeholder="Юридическое адрес" id="requisites-address" type="text" value="<?php echo htmlspecialchars(Arr::path($data->values, 'requisites.address', ''), ENT_QUOTES);?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="shop-edit-bank_id" class="col-3 col-form-label">Банк / БИК</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <select name="requisites[bank_id]" id="shop-edit-bank_id" class="form-control ks-select" data-parent="#shop-edit-record" style="width: 100%">
                                        <option value="0" data-id="0">Без значения</option>
                                        <?php echo $siteData->globalDatas['view::bank/list/list']; ?>
                                    </select>
                                </div>
                                <input id="shop-edit-bik" name="requisites[bik]" data-validation="length" data-validation-length="max8" maxlength="8" class="form-control valid" placeholder="БИК" type="text" value="<?php echo htmlspecialchars(Arr::path($data->values, 'requisites.bik', ''), ENT_QUOTES);?>" style="display: none">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="requisites-account_number" class="col-3 col-form-label">ИИК</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="requisites[account_number]" data-validation="length" data-validation-length="max250" maxlength="250" class="form-control valid" placeholder="ИИК" id="requisites-account_number" type="text" value="<?php echo htmlspecialchars(Arr::path($data->values, 'requisites.account_number', ''), ENT_QUOTES);?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="requisites-director" class="col-3 col-form-label">ФИО директора</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="requisites[director]" data-validation="length" data-validation-length="max250" maxlength="250" class="form-control valid" placeholder="ФИО директора" id="requisites-director" type="text" value="<?php echo htmlspecialchars(Arr::path($data->values, 'requisites.director', ''), ENT_QUOTES);?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="requisites-director_post" class="col-3 col-form-label">Должность директора</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="requisites[director_post]" data-validation="length" data-validation-length="max250" maxlength="250" class="form-control valid" placeholder="Должность директора" id="requisites-director_post" type="text" value="<?php echo htmlspecialchars(Arr::path($data->values, 'requisites.director_post', 'директор'), ENT_QUOTES);?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="requisites-accountant" class="col-3 col-form-label">ФИО бухгалтера</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="requisites[accountant]" data-validation="length" data-validation-length="max250" maxlength="250" class="form-control valid" placeholder="ФИО бухгалтера" id="requisites-accountant" type="text" value="<?php echo htmlspecialchars(Arr::path($data->values, 'requisites.accountant', ''), ENT_QUOTES);?>">
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
        $('#shop-edit-record form').on('submit', function(e){
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
        $.validate({
            modules : 'location, date, security, file',
            lang: 'ru',
            onModulesLoaded : function() {

            }
        });

        $('#shop-edit-bank_id').change(function () {
            var bik = $(this).find('option:selected').data('bik');
            $('#shop-edit-bik').val(bik).attr('value', bik);
        });
    });
</script>

