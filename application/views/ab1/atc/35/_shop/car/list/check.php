<table class="table table-hover table-db table-tr-line" >
    <tr>
        <th class="width-120">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/check'). Func::getAddURLSortBy($siteData->urlParams, 'created_at'); ?>" class="link-black">Дата</a>
        </th>
        <th class="width-85">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/check'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Гос. номер</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/check'). Func::getAddURLSortBy($siteData->urlParams, 'shop_transport_id.name'); ?>" class="link-black">Марка + гос. номер</a>
        </th>
        <th class="width-165">
            Вид работы
        </th>
        <th class="width-140"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/car/one/check']->childs as $value) {
        echo $value->str;
    }
    ?>
</table>
