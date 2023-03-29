<table class="table table-hover table-db">
    <tr>
        <th class="tr-header-id">
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopbillitem/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'shop_good_id'); ?>" class="link-black">ID</a>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopbillitem/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'shop_good_id'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-numeric-<?php if (Arr::path($siteData->urlParams, 'sort_by.shop_good_id', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
        <th class="tr-header-photo">Фото</th>
        <th class="tr-header-article">Артикул</th>
        <th>Название</th>
        <th class="tr-header-price">Цена</th>
        <th class="tr-header-sort">Кол-во</th>
        <th class="tr-header-amount">Стоимость</th>
        <th class="tr-header-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/bill/item/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>
</table>
