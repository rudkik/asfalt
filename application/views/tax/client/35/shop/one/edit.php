<div id="shop-edit-record" class="modal-edit">
    <div class="modal-dialog" style="margin: 0px; max-width: 700px">
        <div class="modal-content" style="border: none">
            <form class="has-validation-callback" action="/tax/shop/save">
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
                            <label for="shop-edit-shop_bank_account_id" class="col-3 col-form-label">Основной банковский счет</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <select name="requisites[shop_bank_account_id]" id="shop-edit-shop_bank_account_id" class="form-control ks-select" data-parent="#shop-edit-record" style="width: 100%">
                                        <option value="0" data-id="0">Без значения</option>
                                        <?php echo $siteData->globalDatas['view::_shop/bank/account/list/list']; ?>
                                    </select>
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
                        <div class="form-group row">
                            <label for="shop-edit-organization_type_id" class="col-3 col-form-label">Форма организации</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <select name="requisites[organization_type_id]" id="shop-edit-organization_type_id" class="form-control ks-select" data-parent="#shop-edit-record" style="width: 100%">
                                        <option value="0" data-id="0">Без значения</option>
                                        <?php echo $siteData->globalDatas['view::organizationtype/list/list']; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="shop-edit-organization_tax_type_id" class="col-3 col-form-label">Режим налогоблажения</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <select name="requisites[organization_tax_type_id]" id="shop-edit-organization_tax_type_id" class="form-control ks-select" data-parent="#shop-edit-record" style="width: 100%">
                                        <option value="0" data-id="0">Без значения</option>
                                        <?php echo $siteData->globalDatas['view::organizationtaxtype/list/list']; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="shop-edit-authority_id" class="col-3 col-form-label">Код налогового органа</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <select name="requisites[authority_id]" id="shop-edit-authority_id" class="form-control ks-select" data-parent="#shop-edit-record" style="width: 100%">
                                        <option value="0" data-id="0">Без значения</option>
                                        <?php echo $siteData->globalDatas['view::authority/list/list']; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="shop-edit-akimat_id" class="col-3 col-form-label">БИН аппарата акимов</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <select name="requisites[akimat_id]" id="shop-edit-akimat_id" class="form-control ks-select" data-parent="#shop-edit-record" style="width: 100%">
                                        <option value="0" data-id="0">Без значения</option>
                                        <?php echo $siteData->globalDatas['view::akimat/list/list']; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="shop-edit-is_resident" class="col-3 col-form-label">Резидент</label>
                            <div class="col-9 col-form-label" style="text-align: left;">
                                <input name="requisites[is_resident]" value="0" style="display: none">
                                <label class="ks-checkbox-slider ks-on-off ks-primary" style="margin-top: 10px;">
                                    <input name="requisites[is_resident]" type="checkbox" value="1" <?php if(Arr::path($data->values, 'requisites.is_resident', '') == 1) {echo 'checked';}?>>
                                    <span class="ks-indicator"></span>
                                    <span class="ks-on">да</span>
                                    <span class="ks-off">нет</span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="shop-edit-is_resident" class="col-3 col-form-label">Компания состоит на учет по НДС?</label>
                            <div class="col-9 col-form-label" style="text-align: left;">
                                <input name="requisites[is_nds]" value="0" style="display: none">
                                <label class="ks-checkbox-slider ks-on-off ks-primary" style="margin-top: 10px;">
                                    <input name="requisites[is_nds]" type="checkbox" value="1" <?php if(Arr::path($data->values, 'requisites.is_nds', '') == 1) {echo 'checked';}?>>
                                    <span class="ks-indicator"></span>
                                    <span class="ks-on">да</span>
                                    <span class="ks-off">нет</span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="requisites-nds_number" class="col-3 col-form-label">Номер документа</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="requisites[nds_number]" data-validation="length" data-validation-length="max250" maxlength="250" class="form-control valid" placeholder="Номер документа" id="requisites-nds_number" type="text" value="<?php echo htmlspecialchars(Arr::path($data->values, 'requisites.nds_number', ''), ENT_QUOTES);?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="requisites-nds_series" class="col-3 col-form-label">Серия</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="requisites[nds_series]" data-validation="length" data-validation-length="max250" maxlength="250" class="form-control valid" placeholder="Серия" id="requisites-nds_series" type="text" value="<?php echo htmlspecialchars(Arr::path($data->values, 'requisites.nds_series', ''), ENT_QUOTES);?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="requisites-nds_date" class="col-3 col-form-label">Дата</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="requisites[nds_date]" class="form-control" id="requisites-nds_date" type="datetime" autocomplete="off" value="<?php echo Helpers_DateTime::getDateFormatRus(Arr::path($data->values, 'requisites.nds_date', ''));?>">
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
        __initTable();

        $('#shop-edit-record input[type="datetime"]').datetimepicker({
            dayOfWeekStart : 1,
            lang:'ru',
            format:	'd.m.Y',
            timepicker:false,
        }).inputmask({
            mask: "99.99.9999"
        });

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
    });
</script>

