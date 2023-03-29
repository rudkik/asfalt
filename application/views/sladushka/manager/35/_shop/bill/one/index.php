<li class="item">
    <div class="box-product">
        <div class="product-img">
            <img src="<?php echo Helpers_Image::getPhotoPath(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_root_id.image_path', ''), 90, 79); ?>" alt="<?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_root_id.name', ''); ?>">
        </div>
        <div class="product-info">
            <a class="product-title">Заказ №<?php echo $data->id; ?> <span class="text-red pull-right"><?php echo Func::getPriceStr($siteData->currency, $data->values['amount']);?></span></a>
            <span class="product-description"> <?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_root_id.name', 'Торговая точка'); ?></span>
            <div class="box-cart">
                <a class="text-red" href="tel:<?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_root_id.options.phone', ''); ?>"><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_root_id.options.phone', ''); ?></a>
            </div>
            <a href="<?php echo $siteData->urlBasic; ?>/manager/shopbill/edit?id=<?php echo $data->id; ?>" class="btn btn-danger btn-flat pull-right btn-cart">Просмотр</a>
            <a href="<?php echo Func::getFullURL($siteData, '/shoppaid/new', array(), array('paid_shop_id'=>$data->values['shop_root_id'], 'type'=>51666)); ?>" class="btn btn-info btn-flat pull-right btn-cart">Оплата</a>
            <a href="<?php echo Func::getFullURL($siteData, '/shopbranch/index', array(), array('id'=>$data->values['shop_root_id'], 'type'=>51658)); ?>" class="btn btn-success btn-flat pull-right btn-cart">Магазин</a>
        </div>
    </div>
</li>