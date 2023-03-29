<h1><?php echo $data->values['name'];?></h1>
<div class="row">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">
                <img src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 685, 300);?>" class="img-b-goods img-responsive" alt="<?php echo htmlspecialchars($data->values['name']);?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="block-imgs">
                    <?php
                    foreach(Arr::path($data->values, 'files', array()) as $index => $file) {
                        if ($file['type'] == Model_ImageType::IMAGE_TYPE_IMAGE) {
                            ?>
                            <img src="<?php echo Helpers_Image::getPhotoPath($file['file'], 345, 170);?>" class="img-responsive" alt="<?php echo htmlspecialchars($file['title']);?>">
                            <?php
                        }
                    }?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">
                <?php if ($data->values['is_in_stock'] == 1) { ?>
                <div class="status bg-green">Есть в наличие</div>
                <?php }else{ ?>
                <div class="status bg-red">Нет в наличие</div>
                <?php } ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-hover">
                    <tbody>
                    <tr>
                        <td>Цена</td>
                        <td><?php echo Controller_SMMarket_Func::getGoodPriceStr($siteData->userShop->getShopTableCatalogID(), $siteData->currency, $data, $price, $priceOld);?></td>
                    </tr>
                    <tr>
                        <td>Поставщик</td>
                        <td><a href="/customer/shopbranch/edit?id=<?php echo $data->values['shop_id'];?>"><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_id.name', ''); ?></a></td>
                    </tr>
                    <tr>
                        <td>Категория товара</td>
                        <td><a href="/customer/shopbranch/edit?id=<?php echo $data->values['shop_id'];?>&shop_table_rubric_id=<?php echo $data->values['shop_table_rubric_id'];?>"><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_rubric_id.name', ''); ?></a></td>
                    </tr>
                    <tr>
                        <td>Артикул</td>
                        <td><?php echo $data->values['article'];?></td>
                    </tr>
                    <tr>
                        <td>Штрихкод</td>
                        <td><?php echo Arr::path($data->values['options'], 'barcode', ''); ?></td>
                    </tr>
                    <tr>
                        <td>Доставка</td>
                        <td><?php echo floatval(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_id.options.site_time_delivery', '')); ?> ч</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="block-count">
                    <a class="btn btn-default" data-action="down" href="#">-</a>
                    <input size="3" data-min-value="0" autocomplete="off" min="0" value="1" data-template="sale" data-name="count"  class="form-control">
                    <a class="btn btn-default" data-action="up" href="#">+</a>
                    <span>шт.</span>
                </div>
                <div class="buy">
                    <a class="btn btn-success"  data-id="<?php echo $data->values['id']; ?>" data-shop="<?php echo $data->values['shop_id']; ?>" data-action="add-cart">Купить</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?php echo $data->values['text'];?>
    </div>
</div>