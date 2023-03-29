<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Период от
        </label>
    </div>
    <div class="col-md-3">
        <input name="from_at" type="datetime"  date-type="date"  class="form-control" required value="<?php echo Helpers_DateTime::getDateTimeFormatRus('from_at'); ?>">
    </div>
    <div class="col-md-3 record-title">
        <label>
            Период до
        </label>
    </div>
    <div class="col-md-3">
        <input name="to_at" type="datetime"  date-type="date"  class="form-control" value="<?php echo Helpers_DateTime::getDateTimeFormatRus('to_at'); ?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Работник
        </label>
    </div>
    <div class="col-md-9">
        <select id="shop_worker_id" name="shop_worker_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/worker/list/list']; ?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Вид прогула
        </label>
    </div>
    <div class="col-md-9">
        <select id="miss_type_id" name="miss_type_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::miss-type/list/list']; ?>
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