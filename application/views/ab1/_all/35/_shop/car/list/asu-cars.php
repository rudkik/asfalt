<table class="table table-hover table-db table-tr-line" >
    <thead>
    <tr>
        <th style="width: 50px">№</th>
        <th class="width-100">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/asu_cars'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">№ авто</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/asu_cars'). Func::getAddURLSortBy($siteData->urlParams, 'shop_client_id.name'); ?>" class="link-black">Клиент</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/asu_cars'). Func::getAddURLSortBy($siteData->urlParams, 'shop_product_id.name'); ?>" class="link-black">Продукт</a>
        </th>
        <th style="width: 141px" class="text-right">Количество в условных единицах</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $i = 0;
    foreach ($data['view::_shop/car/one/asu-cars']->childs as $value) {
        $i++;
        echo str_replace('#index#', $i, $value->str);
    }
    ?>
    </tbody>
</table>

