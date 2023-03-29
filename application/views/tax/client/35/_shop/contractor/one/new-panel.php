<div id="<?php echo $panelID; ?>" class="form-group row" style="display: none">
    <input name="is_add_contractor" value="0" style="display: none">
    <div class="col-12 ks-panels-column-section">
        <div class="card panel ks-widget ks-widget-followers">
            <div class="card-header">
                Новый контрагент
                <div class="ks-controls">
                    <a data-panel="#<?php echo $panelID; ?>" data-select="#<?php echo $selectID; ?>" data-action="close-add-panel" href="#" class="ks-control">
                        <span class="ks-icon fa fa-close"></span>
                    </a>
                </div>
            </div>
            <div class="card-block ks-scrollable" data-height="236" style="padding: 0px;">
                <div class="ks-wrapper">
                    <div class="form-group row">
                        <label for="name" class="col-3 col-form-label">Название</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <input name="shop_contractor[name]" data-validation="length" data-validation-length="min3" maxlength="250" class="form-control valid" placeholder="Название" id="name" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bin" class="col-3 col-form-label">БИН</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <input name="shop_contractor[bin]" data-validation="length" data-validation-length="12" maxlength="12" class="form-control valid" placeholder="БИН" id="bin" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="bik" class="col-3 col-form-label">БИК</label>
                        <div class="col-9">
                            <div class="row">
                                <div class="col-5">
                                    <div class="form-group margin-0">
                                        <input name="shop_contractor[bik]" data-validation="length" data-validation-length="8" maxlength="8" class="form-control" placeholder="БИК" id="bin" type="text">
                                    </div>
                                </div>
                                <div class="col-7">
                                    <div class="row">
                                        <label for="iik" class="col-3 col-form-label">ИИК</label>
                                        <div class="col-9">
                                            <input name="shop_contractor[iik]" class="form-control" placeholder="ИИК" id="iik" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="address" class="col-3 col-form-label">Адрес</label>
                        <div class="col-9">
                            <textarea name="shop_contractor[address]" class="form-control" placeholder="Адрес"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>