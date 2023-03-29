<div class="col-md-3 goods">
    <div class="block-goods">
        <?php if($data->values['system_is_discount']){ ?>
            <div class="status-new">
                <img class="img-responsive" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/goods/discount.png" alt="Скидка">
                <label class="discount-title" style="">скидка</label>
                <?php if($data->values['system_discount'] > 0){ ?>
                    <label class="discount" style=""><?php echo Func::getNumberStr($data->values['system_discount']); ?>%</label>
                <?php }else{ ?>
                    <label class="discount" style="">%</label>
                <?php } ?>
            </div>
        <?php }elseif($data->values['good_select_type_id'] == 3723){ ?>
            <div class="status-new">
                <img class="img-responsive" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/goods/new.png" alt="Новинка">
            </div>
        <?php } ?>
        <a href="/customer/shopgood/edit?id=<?php echo $data->values['id']; ?>&shop_branch_id=<?php echo $data->values['shop_id']; ?>"><img class="img-goods img-responsive" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 312, 207); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES); ?>"></a>
        <div class="goods-info">
            <h4><a href="/customer/shopbranch/edit?id=<?php echo $data->values['shop_id']; ?>"><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_id.name', ''); ?></a></h4>
            <h3><a href="/customer/shopgood/edit?id=<?php echo $data->values['id']; ?>&shop_branch_id=<?php echo $data->values['shop_id']; ?>"><?php echo $data->values['name']; ?></a></h3>
            <p class="price"><?php echo Controller_SMMarket_Func::getGoodPriceStr($siteData->shop->getShopTableCatalogID(), $siteData->currency, $data, $price, $priceOld); ?></p>
            <span class="delivery"><?php echo Func::getCountElementStrRus(floatval(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_id.options.site_time_delivery', 0)), 'часов', 'час', 'часа'); ?></span>
            <div class="block-count">
                <div class="block-center">
                    <a class="btn btn-default" data-action="down" href="#">-</a>
                    <input size="3" data-min-value="0" autocomplete="off" min="0" value="0" data-name="count" class="form-control">
                    <a class="btn btn-default" data-action="up" href="#">+</a>
                    <span><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_unit_type_id.name', ''); ?></span>
                </div>
            </div>
            <div class="buy">
                <a class="btn btn-success" data-id="<?php echo $data->values['id']; ?>" data-shop="<?php echo $data->values['shop_id']; ?>" data-action="add-cart">В корзину</a>
            </div>
        </div>
    </div>
</div>