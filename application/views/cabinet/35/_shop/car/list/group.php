<table id="panel-group-cars" data-id="<?php echo count($data['view::_shop/car/one/group']->childs); ?>" class="table table-hover table-db margin-b-5">
    <tr>
        <?php if ((Func::isShopMenu('shopcar/image?type='.Request_RequestParams::getParamInt('type'), $siteData))){ ?>
        <th class="tr-header-photo">Фото</th>
        <?php }?>
        <th>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            <?php echo SitePageData::setPathReplace('type.form_data.shop_car.fields_title.name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </th>
        <?php if ((Func::isShopMenu('shopcar/price?type='.Request_RequestParams::getParamInt('type'), $siteData))){ ?>
            <th class="tr-header-price"><?php echo SitePageData::setPathReplace('type.form_data.shop_car.fields_title.price', SitePageData::CASE_FIRST_LETTER_UPPER); ?></th>
        <?php } ?>
        <th class="tr-header-buttom-delete"></th>
    </tr>

    <?php
    foreach ($data['view::_shop/car/one/group']->childs as $value){
        echo $value->str;
    }
    ?>
</table>
<?php if (count($data['view::_shop/car/one/group']->childs) == 0){ ?>
    <div id="div-not-options-group" class="contacts-list-msg text-center margin-b-5">Значения не заданы</div>
<?php }?>
<div class="text-right" data-toggle="modal" data-target="#find-promo">
    <button type="button" class="btn btn-warning" onclick="actionAddTR('body_panel_catalog', 'tr_panel_catalog', 'div-not-options-group')"><i class="fa fa-fw fa-plus"></i> Добавить</button>
</div>

