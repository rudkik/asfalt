<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Название
        </label>
    </div>
    <div class="col-md-3">
        <input type="text" class="form-control" placeholder="Название" value="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>" readonly>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Филиал
        </label>
    </div>
    <div class="col-md-3">
        <input type="text" class="form-control" placeholder="Филиал" value="<?php echo htmlspecialchars($data->getElementValue('shop_id'), ENT_QUOTES);?>" readonly>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Префикс
        </label>
    </div>
    <div class="col-md-3">
        <input name="symbol" type="text" class="form-control" placeholder="Логин" value="<?php echo htmlspecialchars($data->values['symbol'], ENT_QUOTES);?>">
    </div>
    <div class="col-md-3 record-title">
        <label>
            Длина числовой части
        </label>
    </div>
    <div class="col-md-3">
        <input name="length" type="text" class="form-control" placeholder="Длина числовой части" value="<?php echo htmlspecialchars($data->values['length'], ENT_QUOTES);?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Счетчик на начало года
        </label>
    </div>
    <div class="col-md-3">
        <input name="text" type="text" class="form-control" placeholder="Счетчик на начало года" value="<?php echo htmlspecialchars($data->values['text'], ENT_QUOTES);?>">
    </div>
    <div class="col-md-3 record-title">
        <label>
            Счетчик на данный момент
        </label>
    </div>
    <div class="col-md-3">
        <input name="number" type="text" class="form-control" placeholder="Счетчик на данный момент" value="<?php echo htmlspecialchars(Arr::path($data->additionDatas, 'number', ''), ENT_QUOTES);?>">
    </div>
</div>
<div class="row">
    <div hidden>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>
        <input name="number_old" value="<?php echo htmlspecialchars(Arr::path($data->additionDatas, 'number', ''), ENT_QUOTES);?>">
        <input name="sequence" value="<?php echo Request_RequestParams::getParamStr('sequence');?>">
    </div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>