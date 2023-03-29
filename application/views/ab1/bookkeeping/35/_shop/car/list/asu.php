<table class="table table-hover table-db table-tr-line" >
    <tr>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_turn_place_id.name'); ?>" class="link-black">Место погрузки</a>
        </th>
        </th>
        <th class="width-120">Кол-во</th>
        <th class="tr-header-amount">Тонн</th>
    </tr>
    <?php
    foreach ($data['view::_shop/car/one/asu']->childs as $value) {
        echo $value->str;
    }
    ?>
</table>

