<div id="<?php echo $panelID; ?>" class="form-group row" style="display: none">
    <input name="is_add_worker" value="0" style="display: none">
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
                                <input name="shop_worker[name]" data-validation="length" data-validation-length="max250" maxlength="250" class="form-control" placeholder="ФИО" id="name" type="text">
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
                        <label for="date_of_birth" class="col-3 col-form-label">Дата рождения</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <input name="shop_worker[date_of_birth]" class="form-control" placeholder="Дата рождения" id="date_of_birth" type="datetime">
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