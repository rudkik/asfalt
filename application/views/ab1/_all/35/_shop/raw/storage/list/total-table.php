<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoprawstorage/total'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Название</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoprawstorage/total'). Func::getAddURLSortBy($siteData->urlParams, 'shop_raw_storage_group_id.name'); ?>" class="link-black">Название группы</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoprawstorage/total'). Func::getAddURLSortBy($siteData->urlParams, 'shop_raw_id.name'); ?>" class="link-black">Сырье</a>
        </th>
        <th class="text-right width-140">
            <a href="<?php echo Func::getFullURL($siteData, '/shoprawstorage/total'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Заполненность (%)</a>
        </th>
        <th class="text-right width-150">
            <a href="<?php echo Func::getFullURL($siteData, '/shoprawstorage/total'). Func::getAddURLSortBy($siteData->urlParams, 'unit'); ?>" class="link-black">Единицы измерения</a>
        </th>
        <th class="text-right width-100">
            <a href="<?php echo Func::getFullURL($siteData, '/shoprawstorage/total'). Func::getAddURLSortBy($siteData->urlParams, 'meter'); ?>" class="link-black">Кол-во</a>
        </th>
        <th class="text-right width-100">
            <a href="<?php echo Func::getFullURL($siteData, '/shoprawstorage/total'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">Кол-во (т)</a>
        </th>
    </tr>
    <?php
    foreach ($data['view::_shop/raw/storage/one/total-table']->childs as $value) {
        echo $value->str;
    }
    ?>
</table>