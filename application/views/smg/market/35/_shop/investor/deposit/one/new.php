<div class="form-group">
    <label class="col-md-2 control-label">
        Дата вклада
    </label>
    <div class="col-md-4">
        <input name="date" type="datetime" date-type="date" class="form-control" required>
    </div>
    <label class="col-md-2 control-label">
        Сумма
    </label>
    <div class="col-md-4">
        <input name="amount" type="text" class="form-control" placeholder="Сумма" required>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Инвестор
    </label>
    <div class="col-md-10">
        <select id="shop_investor_id" name="shop_investor_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/investor/list/list']; ?>
        </select>
    </div>
</div>
<div class="row">
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>