<table class="table table-hover table-db table-tr-line" >
    <tr>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/total'). Func::getAddURLSortBy($siteData->urlParams, 'exit_at'); ?>" class="link-black">Дата</a>
        </th>
        <th class="text-right" style="width: 200px">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/total'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">Вес</a>
        </th>
    </tr>
    <?php
    foreach ($data['view::_shop/car/one/total']->childs as $value) {
        echo $value->str;
    }
    ?>
</table>