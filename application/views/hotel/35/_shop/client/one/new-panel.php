<div id="<?php echo $panelID; ?>" class="form-group row" style="display: none">
    <input name="is_add_client" value="0" style="display: none">
    <div class="col-12 ks-panels-column-section">
        <div class="card panel ks-widget ks-widget-followers">
            <div class="card-header">
                Новый клиент <span class="required">*</span>
                <div class="ks-controls">
                    <a data-panel="#<?php echo $panelID; ?>" data-select="#<?php echo $selectID; ?>" data-action="close-add-panel" href="#" class="ks-control">
                        <span class="ks-icon fa fa-close"></span>
                    </a>
                </div>
            </div>
            <div class="card-block ks-scrollable" data-height="236" style="padding: 0px;">
                <div class="ks-wrapper">
                    <div class="form-group row">
                        <label for="name" class="col-3 col-form-label">ФИО <span class="required">*</span></label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <input name="shop_client[name]" data-validation="length" data-validation-length="min3" maxlength="250" class="form-control valid" placeholder="ФИО" id="name" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="phone" class="col-3 col-form-label">Телефон <span class="required">*</span></label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <input name="shop_client[phone]" data-validation="length" data-validation-length="max50" maxlength="50" class="form-control valid" placeholder="Телефон" id="phone" type="phone">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="phone" class="col-3 col-form-label">E-mail</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <input name="shop_client[email]" class="form-control valid" placeholder="E-mail" id="email" type="email">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bin" class="col-3 col-form-label">БИН</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <input name="bin" data-validation="length" data-validation-length="max12" maxlength="12" class="form-control" placeholder="БИН" id="bin" type="text">
                            </div>
                        </div>
                    </div>
                    <div id="<?php echo $panelID; ?>-btn-company" class="card-footer">
                        <button class="btn btn-primary" type="button" onclick="addCompany()">Юридическое лицо</button>
                    </div>
                    <div id="<?php echo $panelID; ?>-company" style="display: none">
                        <div class="form-group row">
                            <label for="<?php echo $panelID; ?>-bank_id" class="col-3 col-form-label">Банк / БИК</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <select name="bank_id" id="<?php echo $panelID; ?>-bank_id" class="form-control ks-select" data-parent="#<?php echo $panelID; ?>" style="width: 100%">
                                        <option value="0" data-id="0">Без значения</option>
                                        <?php echo $siteData->globalDatas['view::bank/list/list']; ?>
                                    </select>
                                </div>
                                <input id="<?php echo $panelID; ?>-bik" name="bik" data-validation="length" data-validation-length="max8" maxlength="8" class="form-control valid" placeholder="БИК" type="text" style="display: none">
                                <input id="<?php echo $panelID; ?>-bank" name="bank" data-validation="length" data-validation-length="max100" maxlength="100" class="form-control" placeholder="Банк" id="bank" style="display: none">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="account" class="col-3 col-form-label">№ счета</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="account" data-validation="length" data-validation-length="max50" maxlength="50" class="form-control" placeholder="№ счета" id="account" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="address" class="col-3 col-form-label">Адрес</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="address" data-validation="length" data-validation-length="max250" maxlength="250" class="form-control" placeholder="Адрес" id="address" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="text" class="col-3 col-form-label">Примечание</label>
                            <div class="col-9">
                                <textarea name="shop_contractor[text]" class="form-control" placeholder="Примечание"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#<?php echo $panelID; ?>-bank_id').change(function () {
            var bik = $(this).find('option:selected').data('bik');
            $('#<?php echo $panelID; ?>-bik').val(bik).attr('value', bik);

            var name = $(this).find('option:selected').data('name');
            $('#<?php echo $panelID; ?>-bank').val(name).attr('value', name);
        });
    });
    function addCompany() {
        $('#<?php echo $panelID; ?>-company').css('display', 'block');
        $('#<?php echo $panelID; ?>-btn-company').css('display', 'none');
    }
</script>