<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Клиент
        </label>
    </div>
    <div class="col-md-9">
        <select id="shop_client_id" name="shop_client_id" class="form-control select2" style="width: 100%">
            <?php echo $siteData->globalDatas['view::_shop/client/list/list'];?>
        </select>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    № автомобиля
                </label>
            </div>
            <div class="col-md-9">
                <input name="name" id="name" data-type="auto-number" type="text" class="form-control" placeholder="Введите гос. номер автомобиля" required>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    Талон клиента
                </label>
            </div>
            <div class="col-md-9">
                <input name="ticket" type="text" class="form-control" required placeholder="Введите номер талона" >
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Продукт
                </label>
            </div>
            <div class="col-md-9">
                <div class="input-group">
                    <select id="shop_product_id" name="shop_product_id" class="form-control select2" required style="width: 100%;">
                        <option value="0" data-id="0">Без значения</option>
                        <?php echo $siteData->globalDatas['view::_shop/product/list/list']; ?>
                    </select>
                    <span class="input-group-btn"> <a class="btn btn-flat box-amount-p"><span id="product-price" class="text-navy" style="font-size: 16px;"></span></a></span>
                </div>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Кол-во
                </label>
            </div>
            <div class="col-md-9">
                <input data-type="money" data-fractional-length="3" id="quantity" name="quantity" type="phone" class="form-control" placeholder="Введите заявленное количество продукции" required>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div hidden>
        <input id="shop_payment_id" name="shop_payment_id" value="0">
        <input id="shop_turn_id" name="shop_turn_id" value="<?php echo Model_Ab1_Shop_Turn::TURN_WEIGHTED_ENTRY; ?>">
        <input id="is_close" name="is_close" value="1">
    </div>
    <div class="modal-footer text-center">
        <button type="button" class="btn btn-primary" onclick="$('#is_close').val(0); submitCar('shoplesseecar');">Применить</button>
        <button type="button" class="btn btn-primary" onclick="submitCar('shoplesseecar');">Сохранить</button>
    </div>
</div>
<script>
    function submitCar(id) {
        var isError = false;

        var element = $('[name="shop_client_id"]');
        if (!$.isNumeric(element.val()) || parseInt(element.val()) < 1){
            element.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }

        var element = $('[name="shop_product_id"]');
        if (!$.isNumeric(element.val()) || parseInt(element.val()) < 1){
            element.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }

        var element = $('[name="name"]');
        if ($.trim(element.val()) == ''){
            element.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }

        var element = $('[name="quantity"]');
        var s = element.valNumber();
        if (!$.isNumeric(s) || parseFloat(s) <= 0){
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