<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-3">
        <label class="span-checkbox">
            <input name="is_storage" <?php if (Arr::path($data->values, 'is_storage', '0') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
            Склад?
        </label>
    </div>
    <div class="col-md-3 record-title"></div>
    <div class="col-md-3">
        <label class="span-checkbox">
            <input name="is_move" <?php if (Arr::path($data->values, 'is_move', '0') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
            Возможна ли перевозка машинами?
        </label>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-3">
        <label class="span-checkbox">
            <input name="is_balance" <?php if (Arr::path($data->values, 'is_balance', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
            Учитывать остатки?
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
            Сокращенное название
        </label>
    </div>
    <div class="col-md-9">
        <input name="text" type="text" class="form-control" placeholder="Сокращенное название" required value="<?php echo htmlspecialchars(Arr::path($data->values, 'text', ''), ENT_QUOTES);?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Подразделение
        </label>
    </div>
    <div class="col-md-9">
        <select id="shop_subdivision_id" name="shop_subdivision_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo trim($siteData->globalDatas['view::_shop/subdivision/list/list']); ?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Место хранения
        </label>
    </div>
    <div class="col-md-9">
        <select id="shop_heap_id" name="shop_heap_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo trim($siteData->globalDatas['view::_shop/heap/list/list']); ?>
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
