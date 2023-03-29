<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Конкурент
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_competitor_id" name="shop_competitor_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/competitor/list/list']; ?>
        </select>
    </div>
    <div class="col-md-3 record-title">
        <label>
            Дата
        </label>
    </div>
    <div class="col-md-3">
        <input name="date" type="datetime" class="form-control" placeholder="Дата" value="<?php echo date('d-m-Y');?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Примечание
        </label>
    </div>
    <div class="col-md-9">
        <textarea name="text" class="form-control" placeholder="Примечание"></textarea>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Продукция
        </label>
    </div>
    <div class="col-md-9">
        <?php echo $siteData->globalDatas['view::_shop/competitor/price/item/list/index'];?>
    </div>
</div>

<div class="row">
    <div hidden>
        <input id="is_close" name="is_close" value="1">
    </div>
    <div class="modal-footer text-center">
        <button type="button" class="btn btn-primary" onclick="$('#is_close').val(0); submitCompetitorPrice('shopcompetitorprice');">Применить</button>
        <button type="button" class="btn btn-primary" onclick="submitCompetitorPrice('shopcompetitorprice');">Сохранить</button>
    </div>
</div>
<script>
    function submitCompetitorPrice(id) {
        var isError = false;

        var element = $('[name="shop_competitor_id"]');
        if (!$.isNumeric(element.val()) || parseInt(element.val()) < 1){
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
