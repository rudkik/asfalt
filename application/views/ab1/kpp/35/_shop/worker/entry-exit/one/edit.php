<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Проезд на машине
        </label>
    </div>
    <div class="col-md-3">
        <label class="span-checkbox">
            <input name="is_car" <?php if ($data->values['is_car'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
        </label>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Время входа
        </label>
    </div>
    <div class="col-md-3">
        <input name="date_entry" type="datetime"  date-type="datetime"  class="form-control" placeholder="Время входа" required value="<?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['date_entry']); ?>">
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Время выхода
        </label>
    </div>
    <div class="col-md-3">
        <input name="date_exit" type="datetime"  date-type="datetime"  class="form-control" placeholder="Время выхода" value="<?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['date_exit']); ?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i></i></sup>
            Опоздал на
        </label>
    </div>
    <div class="col-md-3">
        <input data-type="money" data-fractional-length="0" name="late_for" type="phone" class="form-control" placeholder="Опоздал на">
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i></i></sup>
            Ушел раньше на
        </label>
    </div>
    <div class="col-md-3">
        <input data-type="money" data-fractional-length="0" name="early_exit" type="phone" class="form-control" placeholder="Ушел раньше на">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Работник
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_worker_id" name="shop_worker_id" class="form-control select2" style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/worker/list/list']; ?>
        </select>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Гость
        </label>
    </div>
    <div class="col-md-3">
        <select id="guest_id" name="guest_id" class="form-control select2" style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::guest/list/list']; ?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Точка проезда
        </label>
    </div>
    <div class="col-md-9">
        <select id="shop_worker_passage_id" name="shop_worker_passage_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/worker/passage/list/list']; ?>
        </select>
    </div>
</div>
<div class="row">
    <div hidden>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>
    </div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>