<?php $groupBy = Request_RequestParams::getParamArray('group_by'); ?>

<table class="table table-hover table-db">
    <tr>
        <?php if($groupBy === NULL){ ?>
            <th class="tr-header-id">
                <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopreport/branch/return<?php echo Func::getAddURLSortBy($siteData->urlParams, 'id'); ?>" class="link-black">№</a>
                <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopreport/branch/return<?php echo Func::getAddURLSortBy($siteData->urlParams, 'id'); ?>" class="link-blue">
                    <i class="fa fa-fw fa-sort-numeric-<?php if (Arr::path($siteData->urlParams, 'sort_by.id', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
                </a>
            </th>
            <th class="tr-header-date">
                <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopreport/branch/return<?php echo Func::getAddURLSortBy($siteData->urlParams, 'paid_at'); ?>" class="link-black"><?php echo SitePageData::setPathReplace('type.form_data.shop_return.fields_title.created_at', SitePageData::CASE_FIRST_LETTER_UPPER); ?></a>
                <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopreport/branch/return<?php echo Func::getAddURLSortBy($siteData->urlParams, 'paid_at'); ?>" class="link-blue">
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
        <?php if(($groupBy === NULL) || (array_search('shop_root_id', $groupBy) !== FALSE)){ ?>
            <?php if ((Func::isShopMenu('shopreturn/shop_root_id?type='.Request_RequestParams::getParamInt('type'), $siteData))){ ?>
                <th><?php echo SitePageData::setPathReplace('type.form_data.shop_return.fields_title.shop_root_id', SitePageData::CASE_FIRST_LETTER_UPPER); ?></th>
            <?php } ?>
        <?php } ?>
        <?php if(($groupBy === NULL) || (array_search('name', $groupBy) !== FALSE)){ ?>
            <?php if ((Func::isShopMenu('shopreturn/name?type='.Request_RequestParams::getParamInt('type'), $siteData))){ ?>
                <th>
                    <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopreturn/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black"><?php echo SitePageData::setPathReplace('type.form_data.shop_return.fields_title.name', SitePageData::CASE_FIRST_LETTER_UPPER); ?></a>
                    <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopreturn/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-blue">
                        <i class="fa fa-fw fa-sort-alpha-<?php if (Arr::path($siteData->urlParams, 'sort_by.name', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
                    </a>
                </th>
            <?php } ?>
        <?php } ?>
        <?php if(($groupBy === NULL) || (array_search('create_user_id', $groupBy) !== FALSE)){ ?>
            <th class="tr-header-rubric"><?php echo SitePageData::setPathReplace('type.form_data.shop_return.fields_title.create_user_id', SitePageData::CASE_FIRST_LETTER_UPPER); ?></th>
        <?php } ?>
        <th class="tr-header-amount">
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopreturn/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'amount'); ?>" class="link-black">Стоимость</a>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopreturn/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'amount'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-numeric-<?php if (Arr::path($siteData->urlParams, 'sort_by.amount', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
    </tr>
    <?php
    foreach ($data['view::_report/shop/return/one/branch/return']->childs as $value) {
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

