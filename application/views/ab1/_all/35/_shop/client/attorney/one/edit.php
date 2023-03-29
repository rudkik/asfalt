<?php $isShow = Request_RequestParams::getParamBoolean('is_show'); ?>
<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-9">
        <label class="span-checkbox">
            <input name="is_public" <?php if (Arr::path($data->values, 'is_public', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal" <?php if($isShow){ ?>disabled<?php } ?>>
            Активная
        </label>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Номер доверенности
        </label>
    </div>
    <div class="col-md-3">
        <input id="number" name="number" type="text" class="form-control" placeholder="Номер доверенности" value="<?php echo Arr::path($data->values, 'number', ''); ?>" <?php if($isShow){ ?>readonly<?php } ?> required>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label style="margin-top: -3px;">
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Общая сумма доверенности
        </label>
    </div>
    <div class="col-md-3">
        <input id="amount_total" type="text" class="form-control" placeholder="Общая сумма доверенности" value="<?php echo Func::getNumberStr(Arr::path($data->values, 'amount', ''));?>" readonly required>
    </div>
    <div class="col-md-6">
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label style="margin-top: -3px;">
                    Использовано по доверенности
                </label>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" placeholder="Использовано по доверенности" value="<?php echo Func::getNumberStr(Arr::path($data->values, 'block_amount', 0) - Arr::path($data->values, 'block_delivery_amount', 0));?>" readonly>
            </div>
            <div class="col-md-3 record-title">
                <label style="margin-top: -3px;">
                    Использованая сумма доставки
                </label>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" placeholder="Использованая сумма доставки" value="<?php echo Func::getNumberStr(Arr::path($data->values, 'block_delivery_amount', ''));?>" readonly>
            </div>
        </div>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Клиент
        </label>
    </div>
    <div class="col-md-9">
        <select data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1"
                id="shop_client_id" name="shop_client_id" class="form-control select2" style="width: 100%" <?php if($isShow){ ?>disabled<?php } ?> required>
            <option value="<?php echo $data->values['shop_client_id']; ?>" selected><?php echo htmlspecialchars($data->getElementValue('shop_client_id'), ENT_QUOTES); ?></option>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Договор
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_client_contract_id" name="shop_client_contract_id" data-contract-id="<?php echo $data->values['shop_client_contract_id']; ?>" class="form-control select2" style="width: 100%;" <?php if($isShow){echo 'disabled';}?>>
            <option value="0" data-id="0">Без договора</option>
            <?php echo $siteData->globalDatas['view::_shop/client/contract/list/list']; ?>
        </select>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Доверительное лицо
        </label>
    </div>
    <div class="col-md-3">
        <input id="client_name" name="client_name" type="text" class="form-control" placeholder="Доверительное лицо" value="<?php echo htmlspecialchars(Arr::path($data->values, 'client_name', ''), ENT_QUOTES);?>"<?php if($isShow){ ?>readonly<?php } ?>>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Начало доверенности
        </label>
    </div>
    <div class="col-md-3">
        <input name="from_at" type="datetime" date-type="date" class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus(Arr::path($data->values, 'from_at', ''));?>" <?php if($isShow){echo 'readonly';}?> required>
    </div>
    <div class="col-md-3 record-title">
        <label>
            Окончание доверенности
        </label>
    </div>
    <div class="col-md-3">
        <input name="to_at" type="datetime" date-type="date" class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus(Arr::path($data->values, 'to_at', ''));?>" <?php if($isShow){echo 'readonly';}?>>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Примечание
        </label>
    </div>
    <div class="col-md-9">
        <textarea name="text" class="form-control" placeholder="Примечание" <?php if($isShow){echo 'readonly';}?>><?php echo htmlspecialchars(Arr::path($data->values, 'text', ''), ENT_QUOTES);?></textarea>
    </div>
</div>
<div class="row record-input record-list" style="margin-top: 30px">
    <div class="col-md-3 record-title">
        <h3 class="pull-right">
            Продукция
        </h3>
    </div>
    <div class="col-md-9">
        <?php echo $siteData->globalDatas['view::_shop/client/attorney/item/list/item'];?>
    </div>
</div>
<div class="row">
    <div hidden>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>
    </div>
    <div class="modal-footer text-center">
        <?php if(!$isShow){?>
            <button type="submit" class="btn bg-green" data-action="form-apply">Применить</button>
            <button type="submit" class="btn btn-primary" data-action="form-save">Сохранить</button>
        <?php }?>
        <a href="<?php echo Func::getFullURL($siteData, '/shopclientattorney/index?is_public_ignore=1'); ?>" class="btn btn-primary">Закрыть</a>
    </div>
</div>