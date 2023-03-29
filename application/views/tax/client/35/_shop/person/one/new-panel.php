<div id="<?php echo $panelID; ?>" class="form-group row" style="display: none">
    <input name="is_add_person" value="0" style="display: none">
    <div class="col-12 ks-panels-column-section">
        <div class="card panel ks-widget ks-widget-followers">
            <div class="card-header">
                Новая персона
                <div class="ks-controls">
                    <a data-panel="#<?php echo $panelID; ?>" data-select="#<?php echo $selectID; ?>" data-action="close-add-panel" href="#" class="ks-control">
                        <span class="ks-icon fa fa-close"></span>
                    </a>
                </div>
            </div>
            <div class="card-block ks-scrollable" data-height="236" style="padding: 0px;">
                <div class="ks-wrapper">
                    <div class="form-group row">
                        <label for="name" class="col-3 col-form-label">ФИО</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <input name="shop_person[name]" data-validation="length" data-validation-length="max250" maxlength="250" class="form-control" placeholder="ФИО" id="name" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name_d" class="col-3 col-form-label">ФИО в дательном падеже</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <input name="shop_person[name_d]" data-validation="length" data-validation-length="max250" maxlength="250" class="form-control" placeholder="ФИО в дательном падеже" id="name_d" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="number" class="col-3 col-form-label">№ удостоверения личности</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <input name="shop_person[number]" data-validation="length" data-validation-length="max50" maxlength="50" class="form-control" placeholder="№ удостоверения личности" id="number" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="date_from" class="col-3 col-form-label">Дата выдачи</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <input name="shop_person[date_from]" class="form-control" placeholder="Дата выдачи" id="date_from" type="datetime">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="issued_by" class="col-3 col-form-label">Кем выдано</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <input name="shop_person[issued_by]" data-validation="length" data-validation-length="max250" maxlength="250" class="form-control" placeholder="Кем выдано" id="issued_by" type="text">
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
        $('#<?php echo $panelID; ?> input[type="datetime"]').datetimepicker({
            dayOfWeekStart : 1,
            lang:'ru',
            format:	'd.m.Y',
            timepicker:false,
        });
    });
</script>