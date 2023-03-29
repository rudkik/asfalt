<div class="ks-plan ks-info">
    <div class="ks-header">
        <h5 class="ks-name"><?php echo Arr::path($data->values['options'], 'title', '');?></h5>
        <div class="ks-discount">
            <?php if (!Func::_empty(Arr::path($data->values['options'], 'discount', 0))){?>
                Скидка <?php echo Arr::path($data->values['options'], 'discount', 0);?>%
            <?php }?>
        </div>
        <div class="ks-price">
            <div class="ks-amount"><?php echo Func::getNumberStr($data->values['price'], TRUE, 0);?></div>
            <div class="ks-currency">тг</div>
            <div class="ks-period"><?php echo Arr::path($data->values['options'], 'period', '');?></div>
        </div>
    </div>
    <div class="ks-body">
        <ul class="ks-list ks-success" style="display: none">
            <li>Access to all templates</li>
            <li>Full customization</li>
            <li>Exporting to PDF</li>
            <li>Custom URL online preview</li>
            <li>Color themes</li>
        </ul>
        <form action="<?php echo $siteData->urlBasic; ?>/tax/shopbill/add" method="get">
            <input name="shop_good_id" value="<?php echo $data->values['id'];?>" style="display: none">
            <button type="submit"  class="btn btn-info btn-block">Оплатить</button>
        </form>
    </div>
</div>