<!-- Строка  -->
<div class="col-md-2">

</div>

<!-- Клиент  -->
<div class="col-md-2">
    <div class="form-group">
        <label for="exampleInputEmail1"> Клиент</label>
        <select data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1" data-value="<?php echo Request_RequestParams::getParamInt('shop_client_id');?>"
                id="shop_client_id" name="shop_client_id" class="form-control select2" style="width: 100%">
        </select>
    </div>
</div>

<!-- Вывод списка выбора  -->
<div class="col-md-3">
    <div class="form-group">
        <label for="shop_transport_company_id">Транспортная компания</label>
        <select id="shop_transport_company_id" name="shop_transport_company_id" class="form-control select2" required style="width: 100%;">
            <?php $tmp = Request_RequestParams::getParamInt('shop_delivery_department_id'); ?>
            <option value="-1" data-id="-1" <?php if($tmp === NULL || $tmp < 0){echo 'selected';} ?>>Выберите значение</option>
            <option value="0" data-id="0" <?php if($tmp == 0 && $tmp !== NULL){echo 'selected';} ?>>Без значения</option>
            <?php
            $tmp = 'data-id="'.$tmp.'"';
            echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/transport/company/list/list']));
            ?>
        </select>
    </div>
</div>

<!-- Вывод числовых+текстовых значений  -->
<div class="col-md-2">
    <div class="form-group">
        <label for="exampleInputEmail1">счета</label>
        <input id="input-name" class="form-control" name="number" placeholder="счета" maxlength="20" value="<?php echo htmlspecialchars(Arr::path($siteData->urlParams, 'number', ''), ENT_QUOTES);?>" type="text">
    </div>
</div>

<!-- Вывод числовых+текстовых значений  -->
<div class="col-md-3">
    <div class="form-group">
        <label for="exampleInputEmail1">Заявка</label>
        <input id="shop_bid_id" class="form-control" name="shop_bid_id" value="<?php echo Arr::path($siteData->urlParams, 'shop_bid_id', '');?>" type="text">
    </div>
</div>

<!-- Дата и время  -->
<div class="col-md-2">
    <div class="form-group">
        <label for="exampleInputEmail1">Дата</label>
        <input name="date" type="datetime"  date-type="datetime"  class="form-control" placeholder="Дата счета фактуры" value="<?php echo Arr::path($siteData->urlParams, 'date', '');?>">
    </div>
</div>

<!-- Дата -->
<div class="col-md-2">
    <div class="form-group">
        <label for="exampleInputEmail1">Дата</label>
        <input name="date" type="datetime"  date-type="date"  class="form-control" placeholder="Дата" value="<?php echo Arr::path($siteData->urlParams, 'date', '');?>">
    </div>
</div>