<?php
$time2 = Request_RequestParams::getParamDateTime('date_to');
if(empty($time2)) {
    $time2 = date('d.m.Y', strtotime('+1 day')) . ' 06:00';
}else{
    $time2 = Helpers_DateTime::getDateTimeFormatRus($time2);
}

$time1 = Request_RequestParams::getParamDateTime('date_from');
if(empty($time1)) {
    $time1 = date('d.m.Y') . ' 06:00';
}else{
    $time1 = Helpers_DateTime::getDateTimeFormatRus($time1);
}
?>
<form id="form-filter" class="box-body no-padding padding-bottom-10px">
	<div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="date_from">Период от</label>
                        <input id="date_from" class="form-control" name="date_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="date_to">Период до</label>
                        <input id="date_to" class="form-control" name="date_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Клиент</label>
                        <?php echo trim($siteData->globalDatas['view::_shop/client/one/show-invoice']); ?>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group" style="margin-bottom: 5px">
                        <label for="shop_client_attorney_id">Выдано по</label>
                        <select data-url="/bookkeeping/shopclientattorney/json?_fields[]=number&_fields[]=amount&_fields[]=block_amount&_fields[]=from_at"
                                id="shop_client_attorney_id" name="shop_client_attorney_id" class="form-control select2" style="width: 100%;">
                            <option value="0" data-id="0">Наличные</option>
                            <?php echo trim($siteData->globalDatas['view::_shop/client/attorney/list/option']); ?>
                        </select>
                    </div>
                </div>
                <?php
                $isDelivery = Request_RequestParams::getParamBoolean('is_delivery');
                if($isDelivery !== NULL){
                ?>
                <div class="col-md-2">
                    <div class="form-group" style="margin-bottom: 5px">
                        <label for="is_delivery">Доставка</label>
                        <select id="is_delivery" name="is_delivery" class="form-control select2" style="width: 100%;">
                            <option value="0" data-id="0" <?php if(!$isDelivery){echo 'selected';} ?>>Без доставки</option>
                            <option value="1" data-id="1" <?php if($isDelivery){echo 'selected';} ?>>С доставкой</option>
                        </select>
                    </div>
                </div>
                <?php } ?>
                <div class="col-md-1">
                    <div class="form-group" style="margin-bottom: 5px">
                        <label for="product_type_id">Вид продукта</label>
                        <select id="product_type_id" name="product_type_id" class="form-control select2" style="width: 100%;">
                            <?php echo trim($siteData->globalDatas['view::product/type/list/list']); ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Остаток денег</label>
                        <input id="balance" class="form-control" type="text" value="" readonly>
                    </div>
                </div>
                <div class="col-md-8">
                    <div hidden>
                        <?php if($siteData->branchID > 0){ ?>
                            <input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
                        <?php } ?>

                        <?php if(Arr::path($siteData->urlParams, 'is_public', '') == 1){?>
                            <input id="input-status" name="is_public" value="1">
                        <?php }elseif(Arr::path($siteData->urlParams, 'is_not_public', '') == 1){?>
                            <input id="input-status" name="is_not_public" value="1">
                        <?php }elseif(Arr::path($siteData->urlParams, 'is_delete', '') == 1){?>
                            <input id="input-status" name="is_delete" value="1">
                        <?php }else{?>
                            <input id="input-status" name="" value="1">
                        <?php }?>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group pull-right">
                        <label for="input-limit-page">Кол-во записей</label>
                        <div class="input-group" style="width: 145px;">
                            <select id="input-limit-page" name="limit_page" class="form-control select2" style="width: 100%">
                                <?php $tmp = Request_RequestParams::getParamInt('limit_page'); ?>
                                <option value="25" <?php if(($tmp === NULL) || ($tmp == 25)){echo 'selected';} ?>>25</option>
                                <option value="50" <?php if($tmp == 50){echo 'selected';} ?>>50</option>
                                <option value="100" <?php if($tmp == 100){echo 'selected';} ?>>100</option>
                                <option value="200" <?php if($tmp == 200){echo 'selected';} ?>>200</option>
                                <option value="500" <?php if($tmp == 500){echo 'selected';} ?>>500</option>
                                <option value="1000" <?php if($tmp == 1000){echo 'selected';} ?>>1000</option>
                                <option value="5000" <?php if($tmp == 5000){echo 'selected';} ?>>5000</option>
                            </select>
                            <span class="input-group-btn">
                                <button type="submit" class="btn bg-orange btn-flat"><i class="fa fa-fw fa-search"></i> Поиск</button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</form>
<script>
    $('#shop_client_attorney_id').change(function (){
        var attorney = $(this).val();
        var amount = $(this).find('option[value="' + attorney + '"]').data('amount');

        if(amount === undefined){
            amount = $('#shop_client_name').data('amount');
        }
        if(amount == 'NaN'){
            amount = 0;
        }

        $('#balance').valNumber(amount, 2);
    });

    function loadShopClientAttorney (shopClientID, attorney){
        jQuery.ajax({
            url: attorney.data('url'),
            data: ({
                'shop_client_id': (shopClientID),
            }),
            type: "POST",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));

                var s = '<option value="0">Наличные</option>';
                jQuery.each(obj, function(index, value) {
                    var formatter = new Intl.DateTimeFormat("ru");

                    var now = new Date(value.from_at);
                    var from_at = formatter.format(now);

                    s = s + '<option data-amount="'+(value.amount - value.block_amount)+'" value="'+value.id+'">№'+value.number+' от ' + from_at + '</option>';
                });

                var v = attorney.val();
                attorney.html(s).val(v).trigger('change');

                var amount = attorney.find('option[value="'+v+'"]').data('amount');
                if(amount === undefined){
                    amount = $('#shop_client_name').data('amount');
                }
                if(amount == 'NaN'){
                    amount = 0;
                }

                $('#balance').valNumber(amount);
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    }

    $('#shop_client_id').select2({
        ajax: {
            url: "/bookkeeping/shopclient/json?sort_by[name]=asc&limit=50&_fields[]=name&_fields[]=bin&_fields[]=amount&_fields[]=block_amount&_fields[]=amount_cash&_fields[]=block_amount_cash",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    name_bin: params.term // условие поиска
                };
            },
            processResults: function (data, params) {
                params.page = 1;
                return {
                    results: data
                };
            },
            cache: true
        },
        escapeMarkup: function (markup) {
            return markup;
        },
        minimumInputLength: 1,
        templateResult: function (repo) {
            return repo.name + ' ('+repo.bin+')';
        },
        templateSelection: function (repo) {
            loadShopClientAttorney(repo.id, $('#shop_client_attorney_id'));

            var name = repo.name || repo.text;
            $('#shop_client_name').val(name).attr('value', name);

            if(repo.amount_cash !== undefined){
                $('#shop_client_name').data('amount', repo.amount_cash - repo.block_amount_cash).attr('data-amount', repo.amount_cash - repo.block_amount_cash);
            }
            return repo.name || repo.text;
        },
    });
</script>