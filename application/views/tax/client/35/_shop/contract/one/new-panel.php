<div id="<?php echo $panelID; ?>" class="form-group row" style="display: none">
    <input name="is_add_contract" value="0" style="display: none">
    <div class="col-12 ks-panels-column-section">
        <div class="card panel ks-widget ks-widget-followers">
            <div class="card-header">
                Новый договор
                <div class="ks-controls">
                    <a data-panel="#<?php echo $panelID; ?>" data-select="#<?php echo $selectID; ?>" data-action="close-add-panel" href="#" class="ks-control">
                        <span class="ks-icon fa fa-close"></span>
                    </a>
                </div>
            </div>
            <div class="card-block ks-scrollable" data-height="236" style="padding: 0px;">
                <div class="ks-wrapper">
                    <div class="form-group row">
                        <label for="nomer" class="col-3 col-form-label">Номер</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <input name="shop_contract[number]" data-validation="length" data-validation-length="max50" maxlength="50" class="form-control valid" placeholder="Номер" id="number" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="date_from" class="col-3 col-form-label">Дата начала</label>
                        <div class="col-9">
                            <div class="row">
                                <div class="col-5">
                                    <div class="form-group margin-0">
                                        <input name="shop_contract[date_from]" class="form-control valid" placeholder="Дата начала" id="date_from" type="datetime" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-7">
                                    <div class="row">
                                        <label for="date_to" class="col-4 col-form-label" style="padding-top: 0px;">Дата окончания</label>
                                        <div class="col-8">
                                            <div class="form-group margin-0">
                                                <input name="shop_contract[date_to]" class="form-control valid" placeholder="Дата окончания" id="date_to" type="datetime" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
        }).inputmask({
            mask: "99.99.9999"
        });
    });
</script>