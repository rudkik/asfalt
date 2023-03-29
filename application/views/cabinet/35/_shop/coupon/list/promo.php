<table id="panel-coupons" data-id="<?php echo count($data['view::shopcoupon/promo']->childs); ?>" class="table table-hover table-db margin-b-5">
    <tr>
        <?php if ((Func::isShopMenu('shopcoupon/image?type='.Request_RequestParams::getParamInt('type'), $siteData))){ ?>
        <th class="tr-header-photo">Фото</th>
        <?php }?>
        <th>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Товар / услуга
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </th>
        <th class="tr-header-price">Цена</th>
        <th class="tr-header-buttom-delete"></th>
    </tr>

    <?php
    foreach ($data['view::shopcoupon/promo']->childs as $value){
        echo $value->str;
    }
    ?>
</table>
<?php if (count($data['view::shopcoupon/promo']->childs) == 0){ ?>
    <div id="div-not-options-promo" class="contacts-list-msg text-center margin-b-5">Товары / услуги не заданы</div>
<?php }?>
<div class="text-right" data-toggle="modal" data-target="#find-promo">
    <button type="button" class="btn btn-warning" onclick="actionAddTR('body_panel_catalog', 'tr_panel_catalog', 'div-not-options-promo')"><i class="fa fa-fw fa-plus"></i> Добавить товар / услуги</button>
</div>