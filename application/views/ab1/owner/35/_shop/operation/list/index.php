<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th class="tr-header-public">
            <span>
                <input name="set-is-public-all" type="checkbox" class="minimal" checked  href="<?php echo Func::getFullURL($siteData, '/shopoperation/save');?>">
            </span>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopoperation/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">ФИО</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopoperation/index'). Func::getAddURLSortBy($siteData->urlParams, 'email'); ?>" class="link-black">E-mail</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopoperation/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_worker_id'); ?>" class="link-black">Работник</a>
        </th>
        <th class="tr-header-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/operation/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>

</table>

