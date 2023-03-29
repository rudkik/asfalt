<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-9">
        <label class="span-checkbox">
            <input name="is_public" value="0" style="display: none">
            <input name="is_public" <?php if (Arr::path($data->values, 'is_public', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
            Показать
        </label>
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
        <div class="input-group">
            <select data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1"
                    id="shop_client_id" name="shop_client_id" class="form-control select2" style="width: 100%">
                <option value="<?php echo $data->values['shop_client_id']; ?>" selected><?php echo htmlspecialchars($data->getElementValue('shop_client_id'), ENT_QUOTES); ?></option>
            </select>
            <span class="input-group-btn">
                <a href="" class="btn bg-purple btn-flat" data-toggle="modal" data-target="#dialog-client"><i class="fa fa-fw fa-plus"></i> Добавить</a>
            </span>
        </div>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Начало
        </label>
    </div>
    <div class="col-md-3">
        <input name="from_at" type="datetime" date-type="date" class="form-control" placeholder="Начало" required value="<?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds(Arr::path($data->values, 'from_at', ''));?>">
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Окончание
        </label>
    </div>
    <div class="col-md-3">
        <input name="to_at" type="datetime" date-type="date" class="form-control" placeholder="Окончание" required value="<?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds(Arr::path($data->values, 'to_at', ''));?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Цены
        </label>
    </div>
    <div class="col-md-9">
        <?php echo $siteData->globalDatas['view::_shop/product-price/list/index']; ?>
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