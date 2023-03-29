<div class="form-group">
    <label class="col-md-2 control-label">
        Дата
    </label>
    <div class="col-md-4">
        <input name="date" type="datetime"  date-type="date"  class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['date']); ?>" required>
    </div>
    <label class="col-md-2 control-label">
        № документа
    </label>
    <div class="col-md-4">
        <input name="number" type="text" class="form-control" placeholder="№ документа" value="<?php echo htmlspecialchars($data->values['number'], ENT_QUOTES); ?>">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Сумма
    </label>
    <div class="col-md-4">
        <input name="amount" type="text" class="form-control" placeholder="Сумма" value="<?php echo Func::getNumberStr($data->values['amount'], ENT_QUOTES); ?>" required>
    </div>
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        № счета
    </label>
    <div class="col-md-4">
        <select data-type="select2" id="shop_bank_account_id" name="shop_bank_account_id" class="form-control select2"  style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/bank/account/list/list']; ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        Компания
    </label>
    <div class="col-md-4">
        <select data-type="select2" id="shop_company_id" name="shop_company_id" class="form-control select2"  style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/company/list/list']; ?>
        </select>
    </div>
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        Источник
    </label>
    <div class="col-md-4">
        <select data-type="select2" id="shop_source_id" name="shop_source_id" class="form-control select2"  style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/source/list/list']; ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        КПН
    </label>
    <div class="col-md-4">
        <input name="kpn" type="text" class="form-control" placeholder="КПН" value="<?php echo htmlspecialchars($data->values['kpn'], ENT_QUOTES); ?>">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        Вид коммисии
    </label>
    <div class="col-md-10">
        <select data-type="select2" id="shop_commission_source_type_id" name="shop_commission_source_type_id" class="form-control select2"  style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/commission/source/type/list/list']; ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Назначение платежа
    </label>
    <div class="col-md-10">
        <textarea name="text" rows="5" placeholder="Назначение платежа" class="form-control"><?php echo htmlspecialchars($data->values['text'], ENT_QUOTES);?></textarea>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Товары
    </label>
    <div class="col-md-10">
        <?php
        $view = View::factory('smg/market/35/_shop/bill/item/list/commission-source-total');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
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
