<table class="table table-hover table-db">
    <tr>
        <th class="tr-header-id">
            <a href="<?php echo Func::getFullURL($siteData, '/shopgoodtooperation/index'). Func::getAddURLSortBy($siteData->urlParams, 'id'); ?>" class="link-black">ID</a>
            <a href="<?php echo Func::getFullURL($siteData, '/shopgoodtooperation/index'). Func::getAddURLSortBy($siteData->urlParams, 'id'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-numeric-<?php if (Arr::path($siteData->urlParams, 'sort_by.id', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
        <th class="tr-header-photo">Фото</th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopgoodtooperation/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_good_id'); ?>" class="link-black">Товар</a>
            <a href="<?php echo Func::getFullURL($siteData, '/shopgoodtooperation/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_good_id'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-alpha-<?php if (Arr::path($siteData->urlParams, 'sort_by.shop_good_id', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopgoodtooperation/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_operation_id'); ?>" class="link-black">Оператор</a>
            <a href="<?php echo Func::getFullURL($siteData, '/shopgoodtooperation/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_operation_id'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-alpha-<?php if (Arr::path($siteData->urlParams, 'sort_by.shop_operation_id', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
        <th class="tr-header-price">
            <a href="<?php echo Func::getFullURL($siteData, '/shopgoodtooperation/index'). Func::getAddURLSortBy($siteData->urlParams, 'price'); ?>" class="link-black">Цена</a>
            <a href="<?php echo Func::getFullURL($siteData, '/shopgoodtooperation/index'). Func::getAddURLSortBy($siteData->urlParams, 'price'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-numeric-<?php if (Arr::path($siteData->urlParams, 'sort_by.price', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
        <th class="tr-header-buttom" style="width: 195px;"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/good/to/operation/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>

</table>
<div class="col-md-12 padding-t-5">
    <?php
    $view = View::factory('cabinet/35/paginator');
    $view->siteData = $siteData;
    echo Helpers_View::viewToStr($view);
    ?>
</div>

