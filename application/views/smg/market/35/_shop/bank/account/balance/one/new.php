<div class="form-group">
    <label class="col-md-2 control-label">
        Дата
    </label>
    <div class="col-md-4">
        <input name="date" type="datetime"  date-type="date"  class="form-control" placeholder="Дата" value="<?php echo date('%d.%m.%Y'); ?>">
    </div>
    <label class="col-md-2 control-label">
        Сумма
    </label>
    <div class="col-md-4">
        <input name="amount" type="text" class="form-control" placeholder="Сумма"   >
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Компания
    </label>
    <div class="col-md-4">
        <select id="shop_company_id" name="shop_company_id" class="form-control select2"  style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/company/list/list']; ?>
        </select>
    </div>
    <label class="col-md-2 control-label">
        Номер счёта
    </label>
    <div class="col-md-4">
        <select id="shop_bank_account_id" name="shop_bank_account_id" class="form-control select2"  style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/bank/account/list/list']; ?>
        </select>
    </div>
</div>
<div class="row">
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>