<table class="table table-hover table-db table-tr-line" >
    <tr>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopmaterialstorage/total'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Название</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopmaterialstorage/total'). Func::getAddURLSortBy($siteData->urlParams, 'shop_material_id.name'); ?>" class="link-black">Материал</a>
        </th>
        <th class="text-right width-140">
            <a href="<?php echo Func::getFullURL($siteData, '/shopmaterialstorage/total'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Заполненность (%)</a>
        </th>
        <th class="text-right width-150">
            <a href="<?php echo Func::getFullURL($siteData, '/shopmaterialstorage/total'). Func::getAddURLSortBy($siteData->urlParams, 'unit'); ?>" class="link-black">Единицы измерения</a>
        </th>
        <th class="text-right width-100">
            <a href="<?php echo Func::getFullURL($siteData, '/shopmaterialstorage/total'). Func::getAddURLSortBy($siteData->urlParams, 'meter'); ?>" class="link-black">Кол-во</a>
        </th>
        <th class="text-right width-100">
            <a href="<?php echo Func::getFullURL($siteData, '/shopmaterialstorage/total'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">Кол-во (т)</a>
        </th>
    </tr>
    <?php
    foreach ($data['view::_shop/material/storage/one/total-table']->childs as $value) {
        echo $value->str;
    }
    ?>

</table>