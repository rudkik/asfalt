<?php $groupBy = Request_RequestParams::getParamArray('group_by'); ?>

<table class="table table-hover table-db">
    <tr>
        <?php if($groupBy === NULL){ ?>

            <th class="tr-header-date">
                <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopreport/branch/paid<?php echo Func::getAddURLSortBy($siteData->urlParams, 'paid_at'); ?>" class="link-black"><?php echo SitePageData::setPathReplace('type.form_data.shop_paid.fields_title.created_at', SitePageData::CASE_FIRST_LETTER_UPPER); ?></a>
                <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopreport/branch/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'paid_at'); ?>" class="link-blue">
                    <i class="fa fa-fw fa-sort-numeric-<?php if (Arr::path($siteData->urlParams, 'sort_by.created_at', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
                </a>
            </th>
        <?php }elseif((array_search('created_at_date', $groupBy) !== FALSE)){ ?>
            <th class="tr-header-date">Дата</th>
        <?php }elseif((array_search('created_at_year', $groupBy) !== FALSE)){ ?>
            <th class="tr-header-date">Год</th>
        <?php }elseif((array_search('created_at_month', $groupBy) !== FALSE)){ ?>
            <th class="tr-header-date">Год</th>
            <th class="tr-header-date">Месяц</th>
        <?php }?>
        <?php if(($groupBy === NULL) || (array_search('paid_shop_id', $groupBy) !== FALSE)){ ?>
            <?php if ((Func::isShopMenu('shoppaid/paid_shop_id?type='.Request_RequestParams::getParamInt('type'), $siteData))){ ?>
                <th><?php echo SitePageData::setPathReplace('type.form_data.shop_paid.fields_title.paid_shop_id', SitePageData::CASE_FIRST_LETTER_UPPER); ?></th>
            <?php }?>
        <?php }?>
        <?php if(($groupBy === NULL) || (array_search('shop_operation_id', $groupBy) !== FALSE)){ ?>
            <?php if ((Func::isShopMenu('shoppaid/shop_operation_id?type='.Request_RequestParams::getParamInt('type'), $siteData))){ ?>
                <th>
                    <a href="<?php echo Func::getFullURL($siteData, '/shopreport/branch/paid'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black"><?php echo SitePageData::setPathReplace('type.form_data.shop_paid.fields_title.shop_operation_id', SitePageData::CASE_FIRST_LETTER_UPPER); ?></a>
                    <a href="<?php echo Func::getFullURL($siteData, '/shopreport/branch/paid'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-blue">
                        <i class="fa fa-fw fa-sort-numeric-<?php if (Arr::path($siteData->urlParams, 'sort_by.name', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
                    </a>
                </th>
            <?php }?>
        <?php }?>
        <?php if(($groupBy === NULL) || (array_search('shop_paid_type_id', $groupBy) !== FALSE)){ ?>
            <?php if ((Func::isShopMenu('shoppaid/shop_paid_type_id?type='.Request_RequestParams::getParamInt('type'), $siteData))){ ?>
                <th><?php echo SitePageData::setPathReplace('type.form_data.shop_paid.fields_title.shop_paid_type_id', SitePageData::CASE_FIRST_LETTER_UPPER); ?></th>
            <?php }?>
        <?php }?>
        <?php if(($groupBy === NULL) || (array_search('paid_type_id', $groupBy) !== FALSE)){ ?>
            <?php if ((Func::isShopMenu('shoppaid/paid_type_id?type='.Request_RequestParams::getParamInt('type'), $siteData))){ ?>
                <th><?php echo SitePageData::setPathReplace('type.form_data.shop_paid.fields_title.paid_type_id', SitePageData::CASE_FIRST_LETTER_UPPER); ?></th>
            <?php }?>
        <?php }?>
        <th class="tr-header-amount">
            <a href="<?php echo Func::getFullURL($siteData, '/shopreport/branch/paid'). Func::getAddURLSortBy($siteData->urlParams, 'amount'); ?>" class="link-black">Сумма</a>
            <a href="<?php echo Func::getFullURL($siteData, '/shopreport/branch/paid'). Func::getAddURLSortBy($siteData->urlParams, 'amount'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-numeric-<?php if (Arr::path($siteData->urlParams, 'sort_by.amount', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
    </tr>
    <?php
    foreach ($data['view::_report/shop/paid/one/branch/paid']->childs as $value) {
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

