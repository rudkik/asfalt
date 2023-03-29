<table class="table table-hover table-db table-tr-line" >
    <tr>
        <th class="width-45">№</th>
        <th class="width-80">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/ttn'). Func::getAddURLSortBy($siteData->urlParams, 'date'); ?>" class="link-black">Дата</a>
        </th>
        <th class="width-110">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/ttn'). Func::getAddURLSortBy($siteData->urlParams, 'id'); ?>" class="link-black">№ накладной</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/ttn'). Func::getAddURLSortBy($siteData->urlParams, 'daughter'); ?>" class="link-black">Поставщик <br>(грузоотправитель)</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/ttn'). Func::getAddURLSortBy($siteData->urlParams, 'receiver'); ?>" class="link-black">Перевозчик <br>(автопредприятия)</a>
        </th>
        <th class="width-80">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/ttn'). Func::getAddURLSortBy($siteData->urlParams, 'number'); ?>" class="link-black">№ а/маш.</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/ttn'). Func::getAddURLSortBy($siteData->urlParams, 'heap_daughter'); ?>" class="link-black">Грузополучатель <br>пункт погрузки</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/ttn'). Func::getAddURLSortBy($siteData->urlParams, 'heap_receiver'); ?>" class="link-black">Пункт разгрузки</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/ttn'). Func::getAddURLSortBy($siteData->urlParams, 'product'); ?>" class="link-black">Наименование товара <br>(груза)</a>
        </th>
        <th class="width-90 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/ttn'). Func::getAddURLSortBy($siteData->urlParams, 'brutto'); ?>" class="link-black">Вес брутто</a>
        </th>
        <th class="width-90 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/ttn'). Func::getAddURLSortBy($siteData->urlParams, 'netto'); ?>" class="link-black">Вес нетто</a>
        </th>
        <th class="width-90 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/ttn'). Func::getAddURLSortBy($siteData->urlParams, 'tare'); ?>" class="link-black">Вес тары</a>
        </th>
        <th style="width: 104px;"></th>
    </tr>
    <?php
    $i = 0;
    foreach ($data['view::_shop/car/one/ttn']->childs as $value) {
        $i++;
        echo str_replace('#index#', $i, $value->str);
    }
    ?>
</table>
