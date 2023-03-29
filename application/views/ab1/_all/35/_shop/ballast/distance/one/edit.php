<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Название
        </label>
    </div>
    <div class="col-md-9">
        <input name="name" type="text" class="form-control" placeholder="Название" required value="<?php echo htmlspecialchars(Arr::path($data->values, 'name', ''), ENT_QUOTES);?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Расстояние (км)
        </label>
    </div>
    <div class="col-md-3">
        <input data-type="money" data-fractional-length="3" name="distance" type="text" class="form-control" placeholder="Расстояние (км)" required value="<?php echo htmlspecialchars(Arr::path($data->values, 'distance', ''), ENT_QUOTES);?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Цена за один рейс в будничный день
        </label>
    </div>
    <div class="col-md-3">
        <input data-type="money" data-fractional-length="2" name="tariff" type="text" class="form-control" placeholder="Цена за один рейс в будничный день" required value="<?php echo htmlspecialchars(Arr::path($data->values, 'tariff', ''), ENT_QUOTES);?>">
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Наценка стоимости рейса в праздничный день
        </label>
    </div>
    <div class="col-md-3">
        <input data-type="money" data-fractional-length="2" name="tariff_holiday" type="text" class="form-control" placeholder="Наценка стоимости рейса в праздничный день" required value="<?php echo htmlspecialchars(Arr::path($data->values, 'tariff_holiday', ''), ENT_QUOTES);?>">
    </div>
</div>
<div class="row">
    <div hidden>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>
        <input id="is_close" name="is_close" value="1" style="display: none">
    </div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn bg-green" data-action="form-apply">Применить</button>
        <button type="submit" class="btn btn-primary" data-action="form-save">Сохранить</button>
    </div>
</div>
