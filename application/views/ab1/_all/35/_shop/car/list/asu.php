<table class="table table-hover table-db table-tr-line" >
    <thead>
    <tr>
        <th rowspan="2">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/asu'). Func::getAddURLSortBy($siteData->urlParams, 'shop_turn_place_id.name'); ?>" class="link-black">Место погрузки</a>
        </th>
        <th class="text-center" colspan="3">Кол-во</th>
    </tr>
    <tr>
        <th class="width-100 text-right"><a href="<?php echo Func::getFullURL($siteData, '/shopcar/asu'). Func::getAddURLSortBy($siteData->urlParams, 'count'); ?>" class="link-black">Машины</a></th>
        <th class="width-100 text-right"><a href="<?php echo Func::getFullURL($siteData, '/shopcar/asu'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">На погрузке</a></th>
        <th class="width-100 text-right"><a href="<?php echo Func::getFullURL($siteData, '/shopcar/asu'). Func::getAddURLSortBy($siteData->urlParams, 'total'); ?>" class="link-black">Выпущено</a></th>
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
<p style="margin-top: 5px"><b>* В очереди на погрузку нет ЖБИ</b></p>

