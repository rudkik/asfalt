<?php $isShow = (Request_RequestParams::getParamBoolean('is_show')) && !$siteData->operation->getIsAdmin(); ?>
<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-9">
        <label class="span-checkbox">
            <input name="is_public" value="0" style="display: none">
            <input name="is_public" <?php if (Arr::path($data->values, 'is_public', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal" <?php if($isShow){ ?>disabled<?php } ?>>
            Показать
        </label>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Место погрузки
        </label>
    </div>
    <div class="col-md-9">
        <select id="shop_turn_place_id" name="shop_turn_place_id" class="form-control select2" required style="width: 100%;" <?php if($isShow){ ?>disabled<?php } ?>>
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/turn/place/list/list']; ?>
        </select>
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
            Нормы
        </label>
    </div>
    <div class="col-md-9">
        <?php echo $siteData->globalDatas['view::_shop/product/turn-place/item/list/index']; ?>
    </div>
</div>
<?php if(!$isShow){ ?>
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

<?php } ?>