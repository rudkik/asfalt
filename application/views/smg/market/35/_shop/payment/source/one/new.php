<div class="form-group">
    <label class="col-md-2 control-label">
        Дата
    </label>
    <div class="col-md-4">
        <input name="date" type="datetime" date-type="date" class="form-control" required>
    </div>
    <label class="col-md-2 control-label">
        № документа
    </label>
    <div class="col-md-4">
        <input name="number" type="text" class="form-control" placeholder="№ документа">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Сумма
    </label>
    <div class="col-md-4">
        <input name="amount" type="text" class="form-control" placeholder="Сумма" required>
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
        <input name="kpn" type="text" class="form-control" placeholder="КПН">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Назначение платежа
    </label>
    <div class="col-md-10">
        <textarea name="text" rows="5" placeholder="Назначение платежа" class="form-control"></textarea>
    </div>
</div>
<div class="row">
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>