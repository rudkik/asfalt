<?php $isShow = (Request_RequestParams::getParamBoolean('is_show')) && ($siteData->operation->getOperationTypeID() == Model_OperationType::ATC_CHIEF); ?>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Номер
        </label>
    </div>
    <div class="col-md-3">
        <input name="number" type="text" class="form-control" placeholder="Номер" value="<?php echo htmlspecialchars($data->values['number'], ENT_QUOTES);?>" <?php if($isShow){?>disabled<?php }?>>
    </div>
    <div class="col-md-3 record-title">
        <label>
            Дата
        </label>
    </div>
    <div class="col-md-3">
        <input name="created_at" type="datetime" date-type="datetime" class="form-control" value="<?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['created_at']);?>" <?php if($isShow){?>disabled<?php }?>>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Транспортное средство
        </label>
    </div>
    <div class="col-md-9">
        <select id="shop_transport_mark_id" name="shop_transport_mark_id" class="form-control select2" required style="width: 100%;" <?php if($isShow){?>disabled<?php }?>>
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/transport/mark/list/list']; ?>
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
        <input data-type="money" data-fractional-length="2" name="milage" type="text" class="form-control" placeholder="Пробег" value="<?php echo Func::getNumberStr($data->values['milage'], true);?>" <?php if($isShow){?>disabled<?php }?>>
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
        <?php echo $siteData->globalDatas['view::_shop/transport/sample/fuel/item/list/index'];?>
        <div class="modal-footer text-center">
            <button type="button" class="btn btn-danger" onclick="addElement('new-fuel', 'fuels', true);" <?php if($isShow){?>disabled<?php }?> >Добавить ГСМ</button>
        </div>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Комментарий
        </label>
    </div>
    <div class="col-md-9">
        <textarea name="text" class="form-control" placeholder="Примечание" <?php if($isShow){?>disabled<?php }?>><?php echo htmlspecialchars($data->values['text'], ENT_QUOTES);?></textarea>
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