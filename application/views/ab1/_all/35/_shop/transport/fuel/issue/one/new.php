<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-9">
        <label class="span-checkbox">
            <input name="is_cash" value="0" type="checkbox" class="minimal">
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
        <input name="date" type="datetime"  date-type="date"  class="form-control" value="<?php echo date('d.m.Y'); ?>" required>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Количество
        </label>
    </div>
    <div class="col-md-3">
        <input data-type="money" data-fractional-length="3" name="quantity" type="phone" class="form-control" placeholder="Количество" required>
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
        <select id="shop_branch_id" name="shop_branch_id" class="form-control select2" required style="width: 100%;">
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
        <select id="fuel_id" name="fuel_id" class="form-control select2" required style="width: 100%;">
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
        <select id="shop_client_id" name="shop_client_id" class="form-control select2" required style="width: 100%;">
            <option value="" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/client/list/list']; ?>
        </select>
    </div>
</div>
<div class="row">
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>