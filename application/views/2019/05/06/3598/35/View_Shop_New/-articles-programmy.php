<div class="col-md-4 box-meditation popular">
    <div class="box-top">
        Популярное
    </div>
    <div class="box-title">
        <h3><?php echo Func::getGoodPriceStr($siteData->currency, $data, $price, $priceOld); ?></h3>
        <h4><?php echo $data->values['name']; ?></h4>
    </div>
    <div class="box-body">
        <div class="info"><?php echo Arr::path($data->values['options'], 'info', ''); ?></div>
        <button class="btn btn-flat btn-green">Заказать</button>
    </div>
    <img class="arrow-top" src="img/arrow-top.png">
</div>