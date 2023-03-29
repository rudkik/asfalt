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
        <input name="number" type="text" class="form-control" placeholder="Код 1С" value="<?php echo htmlspecialchars($data->values['number'], ENT_QUOTES);?>" <?php if($isShow){?>disabled<?php }?>>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Название
        </label>
    </div>
    <div class="col-md-9">
        <input name="name" type="text" class="form-control" placeholder="Название" required value="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>" <?php if($isShow){?>disabled<?php }?>>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Тип транспорта 1С
        </label>
    </div>
    <div class="col-md-3">
        <select id="transport_type_1c_id" name="transport_type_1c_id" class="form-control select2" required style="width: 100%;" <?php if($isShow){?>disabled<?php }?>>
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::transport/type1c/list/list']; ?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Вид транспорта
        </label>
    </div>
    <div class="col-md-3">
        <select id="transport_view_id" name="transport_view_id" class="form-control select2" required style="width: 100%;" <?php if($isShow){?>disabled<?php }?>>
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::transport/view/list/list']; ?>
        </select>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Вид работ
        </label>
    </div>
    <div class="col-md-3">
        <select id="transport_work_id" name="transport_work_id" class="form-control select2" style="width: 100%;" <?php if($isShow){?>disabled<?php }?>>
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::transport/work/list/list']; ?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Правило расчета выработки водителя
        </label>
    </div>
    <div class="col-md-3">
        <select id="transport_wage_id" name="transport_wage_id" class="form-control select2" required style="width: 100%;" <?php if($isShow){?>disabled<?php }?>>
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::transport/wage/list/list']; ?>
        </select>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Форма оплаты
        </label>
    </div>
    <div class="col-md-3">
        <select id="transport_form_payment_id" name="transport_form_payment_id" class="form-control select2" required style="width: 100%;" <?php if($isShow){?>disabled<?php }?>>
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::transport/form-payment/list/list']; ?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Пробег
        </label>
    </div>
    <div class="col-md-3">
        <input data-type="money" data-fractional-length="2" type="text" class="form-control" placeholder="Пробег" required value="<?php echo Func::getNumberStr($data->values['milage'], true);?>" readonly>
    </div>
    <div class="col-md-3 record-title">
        <label>
            Объем топлива
        </label>
    </div>
    <div class="col-md-3">
        <input type="text" class="form-control" placeholder="Объем топлива" required value="<?php echo htmlspecialchars($data->values['fuel_quantity'], ENT_QUOTES);?>" readonly>
    </div>
</div>
<div class="row">
    <div hidden>
        <input id="is_close" name="is_close" value="1">
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>
    </div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>