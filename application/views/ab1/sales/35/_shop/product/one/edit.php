<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-9">
        <label class="span-checkbox">
            <input name="is_public" <?php if (Arr::path($data->values, 'is_public', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
            Показать
        </label>
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
        <input name="name" type="text" class="form-control" placeholder="Название" required value="<?php echo htmlspecialchars(Arr::path($data->values, 'name', ''), ENT_QUOTES);?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Название в 1С
        </label>
    </div>
    <div class="col-md-3">
        <input name="name_1c" type="text" class="form-control" placeholder="Название в 1С" value="<?php echo htmlspecialchars(Arr::path($data->values, 'name_1c', ''), ENT_QUOTES);?>">
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Название на сайте
        </label>
    </div>
    <div class="col-md-3">
        <input name="name_site" type="text" class="form-control" placeholder="Название на сайте" value="<?php echo htmlspecialchars(Arr::path($data->values, 'name_site', ''), ENT_QUOTES);?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Единица измерения
        </label>
    </div>
    <div class="col-md-3">
        <input name="unit" type="text" class="form-control" placeholder="Единица измерения" required value="<?php echo htmlspecialchars(Arr::path($data->values, 'unit', ''), ENT_QUOTES);?>">
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Цена
        </label>
    </div>
    <div class="col-md-3">
        <input data-type="money" data-fractional-length="2" name="price" type="phone" class="form-control" placeholder="Цена" required value="<?php echo Func::getPrice($siteData->currency, Arr::path($data->values, 'price', ''));?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
    </div>
    <div class="col-md-3">
        <label class="span-checkbox">
            <input name="is_packed" <?php if (Arr::path($data->values, 'is_packed', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
            Фасованный
        </label>
    </div>
    <div class="col-md-3 record-title">
        <label>
            Вес тары
        </label>
    </div>
    <div class="col-md-3">
        <input name="tare" type="text" class="form-control" placeholder="Вес тары" value="<?php echo Func::getNumberStr(Arr::path($data->values, 'tare', ''), FALSE);?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Объём (м<sup>3</sup>)
        </label>
    </div>
    <div class="col-md-3">
        <input data-type="money" data-fractional-length="3" name="volume" type="text" class="form-control" placeholder="Объём" value="<?php echo Func::getNumberStr(Arr::path($data->values, 'volume', ''), FALSE);?>">
    </div>
    <div class="col-md-3 record-title">
        <label>
            Коэффициент веса в кол-во (кг в м<sup>3</sup>)
        </label>
    </div>
    <div class="col-md-3">
        <input data-type="money" data-fractional-length="3" name="coefficient_weight_quantity" type="text" class="form-control" placeholder="Коэффициент веса в кол-во" value="<?php echo Func::getNumberStr(Arr::path($data->values, 'coefficient_weight_quantity', ''), FALSE);?>">
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