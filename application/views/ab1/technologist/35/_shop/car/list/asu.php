<table class="table table-hover table-db table-tr-line" >
    <thead>
    <tr>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/asu'). Func::getAddURLSortBy($siteData->urlParams, 'shop_turn_place_id.name'); ?>" class="link-black">Место погрузки</a>
        </th>
        </th>
        <th class="width-120">Кол-во</th>
        <th style="width: 141px" class="text-right">Количество в условных единицах</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($data['view::_shop/car/one/asu']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
</table>

