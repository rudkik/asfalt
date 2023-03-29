<form action="<?php echo Func::getFullURL($siteData, '/shopcalendar/savelist'); ?>" method="post">
    <div class="modal-footer">
        <a href="#" class="btn btn-primary pull-left" data-toggle="modal" data-target="#modal-replace">Заменить</a>
        <a href="#" class="btn btn-primary pull-left" data-toggle="modal" data-target="#modal-load-images">Загрузить изображения</a>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
    <?php $editFields = Request_RequestParams::getParamArray('edit_fields', array(), array()); ?>
<table id="edit-list" class="table table-hover table-db">
    <tr>
        <th class="tr-header-public">
            <span>
                <input name="is_public" type="checkbox" class="minimal" checked disabled>
            </span>
        </th>
        <th class="tr-header-id">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcalendar/index'). Func::getAddURLSortBy($siteData->urlParams, 'id'); ?>" class="link-black">ID</a>
            <a href="<?php echo Func::getFullURL($siteData, '/shopcalendar/index'). Func::getAddURLSortBy($siteData->urlParams, 'id'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-numeric-<?php if (Arr::path($siteData->urlParams, 'sort_by.id', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
        <?php if ((Func::isShopMenu('shopcalendar/image?type='.Request_RequestParams::getParamInt('type'), $siteData))){ ?>
        <th class="tr-header-photo">Фото</th>
        <?php }?>
        <?php if(empty($editFields) || (in_array('article', $editFields))){ ?>
        <th class="tr-header-price">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcalendar/index'). Func::getAddURLSortBy($siteData->urlParams, 'article'); ?>" class="link-black"><?php echo SitePageData::setPathReplace('type.form_data.shop_calendar.fields_title.article', SitePageData::CASE_FIRST_LETTER_UPPER); ?></a>
            <a href="<?php echo Func::getFullURL($siteData, '/shopcalendar/index'). Func::getAddURLSortBy($siteData->urlParams, 'article'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-alpha-<?php if (Arr::path($siteData->urlParams, 'sort_by.article', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
        <?php }?>
        <?php if(empty($editFields) || (in_array('shop_table_rubric_id', $editFields))){ ?>
        <?php if ((Func::isShopMenu('shopcalendar/rubric?type='.Request_RequestParams::getParamInt('type'), $siteData))){ ?>
            <th class="tr-header-rubric"><?php echo SitePageData::setPathReplace('type.form_data.shop_calendar.fields_title.rubric', SitePageData::CASE_FIRST_LETTER_UPPER); ?></th>
        <?php } ?>
        <?php }?>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopcalendar/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black"><?php echo SitePageData::setPathReplace('type.form_data.shop_calendar.fields_title.name', SitePageData::CASE_FIRST_LETTER_UPPER); ?></a>
            <a href="<?php echo Func::getFullURL($siteData, '/shopcalendar/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-alpha-<?php if (Arr::path($siteData->urlParams, 'sort_by.name', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
        <?php if ((Func::isShopMenu('shopcalendar/date_from?type='.Request_RequestParams::getParamInt('type'), $siteData))){ ?>
            <th class="tr-header-date">
                <a href="<?php echo Func::getFullURL($siteData, '/shopcalendar/index'). Func::getAddURLSortBy($siteData->urlParams, 'date_from'); ?>" class="link-black"><?php echo SitePageData::setPathReplace('type.form_data.shop_calendar.fields_title.date_from', SitePageData::CASE_FIRST_LETTER_UPPER); ?></a>
                <a href="<?php echo Func::getFullURL($siteData, '/shopcalendar/index'). Func::getAddURLSortBy($siteData->urlParams, 'date_from'); ?>" class="link-blue">
                    <i class="fa fa-fw fa-sort-alpha-<?php if (Arr::path($siteData->urlParams, 'sort_by.date_from', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
                </a>
            </th>
        <?php } ?>
        <?php if ((Func::isShopMenu('shopcalendar/date_to?type='.Request_RequestParams::getParamInt('type'), $siteData))){ ?>
            <th class="tr-header-date">
                <a href="<?php echo Func::getFullURL($siteData, '/shopcalendar/index'). Func::getAddURLSortBy($siteData->urlParams, 'date_to'); ?>" class="link-black"><?php echo SitePageData::setPathReplace('type.form_data.shop_calendar.fields_title.date_to', SitePageData::CASE_FIRST_LETTER_UPPER); ?></a>
                <a href="<?php echo Func::getFullURL($siteData, '/shopcalendar/index'). Func::getAddURLSortBy($siteData->urlParams, 'date_to'); ?>" class="link-blue">
                    <i class="fa fa-fw fa-sort-alpha-<?php if (Arr::path($siteData->urlParams, 'sort_by.date_to', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
                </a>
            </th>
        <?php } ?>
        <th class="tr-header-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/calendar/one/index-edit']->childs as $value) {
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

    <div class="modal-footer">
        <div hidden>
            <?php echo Func::getURLParamsToInput($_GET, 'request');?>

            <input name="type" value="<?php echo Request_RequestParams::getParamInt('type');?>">
            <input name="is_group" value="<?php echo intval(Request_RequestParams::getParamInt('is_group'));?>">
            <input name="data_language_id" value="<?php echo $siteData->dataLanguageID; ?>">
            <?php if($siteData->branchID > 0){ ?>
                <input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
            <?php } ?>
            <?php if($siteData->superUserID > 0){ ?>
                <input name="shop_id" value="<?php echo $siteData->shopID; ?>">
            <?php } ?>
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</form>
<style>
    .input-group-btn button.btn-info.btn-flat{
        padding: 6px;
    }
</style>

