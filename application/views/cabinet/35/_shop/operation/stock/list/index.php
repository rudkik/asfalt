<table class="table table-hover table-db">
    <tr>
        <?php if(Request_RequestParams::getParamInt('is_branch')){ ?>
            <th class="tr-header-rubric">Компания</th>
        <?php } ?>
        <th class="tr-header-id">
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopoperationstock/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'id'); ?>" class="link-black">№</a>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopoperationstock/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'id'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-numeric-<?php if (Arr::path($siteData->urlParams, 'sort_by.id', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
        <th class="tr-header-date">
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopoperationstock/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'is_close'); ?>" class="link-black">Статус</a>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopoperationstock/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'is_close'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-numeric-<?php if (Arr::path($siteData->urlParams, 'sort_by.is_close', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
        <th class="tr-header-date">
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopoperationstock/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'paid_at'); ?>" class="link-black"><?php echo SitePageData::setPathReplace('type.form_data.shop_operation_stock.fields_title.created_at', SitePageData::CASE_FIRST_LETTER_UPPER); ?></a>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopoperationstock/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'paid_at'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-numeric-<?php if (Arr::path($siteData->urlParams, 'sort_by.created_at', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
        <?php if ((Func::isShopMenu('shopoperationstock/shop_operation_id?type='.Request_RequestParams::getParamInt('type'), $siteData))){ ?>
            <th class="tr-header-rubric"><?php echo SitePageData::setPathReplace('type.form_data.shop_operation_stock.fields_title.shop_operation_id', SitePageData::CASE_FIRST_LETTER_UPPER); ?></th>
        <?php } ?>
        <?php if ((Func::isShopMenu('shopoperationstock/name?type='.Request_RequestParams::getParamInt('type'), $siteData))){ ?>
            <th>
                <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopoperationstock/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black"><?php echo SitePageData::setPathReplace('type.form_data.shop_operation_stock.fields_title.name', SitePageData::CASE_FIRST_LETTER_UPPER); ?></a>
                <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopoperationstock/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-blue">
                    <i class="fa fa-fw fa-sort-alpha-<?php if (Arr::path($siteData->urlParams, 'sort_by.name', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
                </a>
            </th>
        <?php } ?>
        <th class="tr-header-amount">
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopoperationstock/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'amount_first'); ?>" class="link-black">Первоначальная стоимость</a>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopoperationstock/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'amount_first'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-numeric-<?php if (Arr::path($siteData->urlParams, 'sort_by.amount_first', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
        <th class="tr-header-amount">
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopoperationstock/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'amount'); ?>" class="link-black">Стоимость</a>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopoperationstock/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'amount'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-numeric-<?php if (Arr::path($siteData->urlParams, 'sort_by.amount', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
        <th class="tr-header-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/operation/stock/one/index']->childs as $value) {
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