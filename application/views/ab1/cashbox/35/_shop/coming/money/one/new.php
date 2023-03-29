<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            № приходника
        </label>
    </div>
    <div class="col-md-3">
        <input name="number" type="text" class="form-control" placeholder="№ приходника" value="" disabled>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Касса
        </label>
    </div>
    <div class="col-md-9">
        <div class="input-group">
            <select id="shop_cashbox_id" name="shop_cashbox_id" class="form-control select2" required style="width: 100%;">
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/cashbox/list/list']; ?>
            </select>
        </div>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Сумма
        </label>
    </div>
    <div class="col-md-9">
        <input data-type="money" data-fractional-length="2" name="amount" type="text" class="form-control input-amount" placeholder="Сумма" required>
    </div>
</div>
<div class="row">
    <div hidden>
        <input id="is_close" name="is_close" value="1">
    </div>
    <div class="modal-footer text-center">
        <button type="button" class="btn btn-primary pull-right" onclick="submitComingMoney('shopcomingmoney');">Сохранить</button>
        <button type="button" class="btn btn-primary pull-right" onclick="$('#is_close').val(0); submitComingMoney('shopcomingmoney');">Применить</button>
    </div>
</div>
<script>
    function submitComingMoney(id) {
        var isError = false;

        var element = $('[name="amount"]');
        if (!$.isNumeric(element.valNumber()) || parseFloat(element.valNumber()) <= 0){
            element.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }

        if(!isError) {
            $('#'+id).submit();
        }
    }
</script>