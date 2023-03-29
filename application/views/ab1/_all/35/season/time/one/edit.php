<?php $isShow = (Request_RequestParams::getParamBoolean('is_show')) && ($siteData->operation->getOperationTypeID() == Model_OperationType::ATC_CHIEF); ?>
<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-9">
        <label class="span-checkbox">
            <input name="is_public" value="0" style="display: none;">
            <input name="is_public" <?php if (Arr::path($data->values, 'is_public', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal" <?php if($isShow){?>disabled<?php }?>>
            Показать
        </label>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Код 1С
        </label>
    </div>
    <div class="col-md-3">
        <input name="number" type="phone" class="form-control" placeholder="Код 1С" value="<?php echo $data->values['number'];?>" <?php if($isShow){?>disabled<?php }?>>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Сезон
        </label>
    </div>
    <div class="col-md-9">
        <select id="season_id" name="season_id" class="form-control select2" required style="width: 100%;" <?php if($isShow){?>disabled<?php }?>>
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::season/list/list']; ?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Срок действия сезона от
        </label>
    </div>
    <div class="col-md-3">
        <input name="from_at" type="datetime"  date-type="date"  class="form-control" placeholder="Срок действия сезона от" required value="<?php echo Helpers_DateTime::getDateFormatRus(Helpers_DateTime::changeDateYear($data->values['from_at'], date('Y'))); ?>" <?php if($isShow){?>disabled<?php }?>>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Срок действия сезона до
        </label>
    </div>
    <div class="col-md-3">
        <input name="to_at" type="datetime"  date-type="date"  class="form-control" placeholder="Срок действия сезона до" required value="<?php echo Helpers_DateTime::getDateFormatRus(Helpers_DateTime::changeDateYear($data->values['to_at'], date('Y'))); ?>" <?php if($isShow){?>disabled<?php }?>>
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
