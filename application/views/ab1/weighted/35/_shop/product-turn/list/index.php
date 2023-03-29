<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Продукт</a>
        </th>
        <th class="tr-header-amount">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/index'). Func::getAddURLSortBy($siteData->urlParams, 'group'); ?>" class="link-black">Группа</a>
        </th>
    </tr>
    <?php
    foreach ($data['view::_shop/product-turn/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>

</table>

