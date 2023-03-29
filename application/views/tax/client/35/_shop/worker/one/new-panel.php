<div id="<?php echo $panelID; ?>" class="form-group row" style="display: none">
    <input name="is_add_worker" value="0" style="display: none">
    <div class="col-12 ks-panels-column-section">
        <div class="card panel ks-widget ks-widget-followers">
            <div class="card-header">
                Новый сотрудник
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
                                <input name="shop_worker[name]" data-validation="length" data-validation-length="max250" maxlength="250" class="form-control" placeholder="ФИО" id="name" type="text">
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
                        <label for="position" class="col-3 col-form-label">Должность</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <input name="shop_worker[position]" class="form-control" placeholder="Должность" id="position" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="date_of_birth" class="col-3 col-form-label">Дата рождения</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <input name="shop_worker[date_of_birth]" class="form-control" placeholder="Дата рождения" id="date_of_birth" type="datetime" data-type="date" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="iin" class="col-3 col-form-label">ИИН</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <input name="shop_worker[iin]" data-validation="length" data-validation-length="12" maxlength="12" class="form-control" placeholder="ИИН" id="iin" type="text">
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
                                <input name="shop_person[date_from]" class="form-control" placeholder="Дата выдачи" id="date_from" type="datetime" data-type="date" autocomplete="off">
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
                    <div class="form-group row">
                        <label for="date_work_from" class="col-3 col-form-label">Дата началы работы</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <input name="shop_person[date_work_from]" class="form-control" id="date_work_from" type="datetime" data-type="date" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="wage_basic" class="col-3 col-form-label">Оклад</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <input name="shop_person[wage_basic]" class="form-control" id="wage_basic" type="text">
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
        __initTable();
    });
</script>