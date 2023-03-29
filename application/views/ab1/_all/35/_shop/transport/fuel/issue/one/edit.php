<?php $isShow = (Request_RequestParams::getParamBoolean('is_show')) && ($siteData->operation->getOperationTypeID() == Model_OperationType::ATC_CHIEF); ?>
<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-9">
        <label class="span-checkbox">
            <input name="is_cash" <?php if (Arr::path($data->values, 'is_cash', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal" <?php if($isShow){?>disabled<?php }?>>
            За наличные
        </label>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Дата
        </label>
    </div>
    <div class="col-md-3">
        <input name="date" type="datetime"  date-type="date"  class="form-control" placeholder="Дата" required value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['date'], date('d.m.Y')); ?>" <?php if($isShow){?>disabled<?php }?>>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Количество
        </label>
    </div>
    <div class="col-md-3">
        <input data-type="money" data-fractional-length="3" name="quantity" type="phone" class="form-control" placeholder="Количество" required value="<?php echo htmlspecialchars($data->values['quantity'], ENT_QUOTES);?>" <?php if($isShow){?>disabled<?php }?>>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Филиал
        </label>
    </div>
    <div class="col-md-9">
        <select id="shop_branch_id" name="shop_branch_id" class="form-control select2" required style="width: 100%;" <?php if($isShow){?>disabled<?php }?>>
            <?php echo $siteData->globalDatas['view::_shop/branch/list/list']; ?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            ГСМ
        </label>
    </div>
    <div class="col-md-9">
        <select id="fuel_id" name="fuel_id" class="form-control select2" required style="width: 100%;" <?php if($isShow){?>disabled<?php }?>>
            <option value="" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::fuel/list/list']; ?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Поставщик
        </label>
    </div>
    <div class="col-md-9">
        <select id="shop_client_id" name="shop_client_id" class="form-control select2" required style="width: 100%;" <?php if($isShow){?>disabled<?php }?>>
            <option value="" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/client/list/list']; ?>
        </select>
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