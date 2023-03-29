<form action="<?php echo Func::getFullURL($siteData, '/shopclient/savelist'); ?>" method="post">
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
            <a href="<?php echo Func::getFullURL($siteData, '/shopclient/index'). Func::getAddURLSortBy($siteData->urlParams, 'id'); ?>" class="link-black">ID</a>
            <a href="<?php echo Func::getFullURL($siteData, '/shopclient/index'). Func::getAddURLSortBy($siteData->urlParams, 'id'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-numeric-<?php if (Arr::path($siteData->urlParams, 'sort_by.id', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
        <?php if ((Func::isShopMenu('shopclient/image?type='.Request_RequestParams::getParamInt('type'), $siteData))){ ?>
        <th class="tr-header-photo">Фото</th>
        <?php }?>
        <?php if(empty($editFields) || (in_array('shop_table_rubric_id', $editFields))){ ?>
        <?php if ((Func::isShopMenu('shopclient/rubric?type='.Request_RequestParams::getParamInt('type'), $siteData))){ ?>
            <th class="tr-header-rubric"><?php echo SitePageData::setPathReplace('type.form_data.shop_client.fields_title.rubric', SitePageData::CASE_FIRST_LETTER_UPPER); ?></th>
        <?php } ?>
        <?php }?>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopclient/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black"><?php echo SitePageData::setPathReplace('type.form_data.shop_client.fields_title.name', SitePageData::CASE_FIRST_LETTER_UPPER); ?></a>
            <a href="<?php echo Func::getFullURL($siteData, '/shopclient/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-alpha-<?php if (Arr::path($siteData->urlParams, 'sort_by.name', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
        <?php if(empty($editFields) || (in_array('article', $editFields))){ ?>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopclient/index'). Func::getAddURLSortBy($siteData->urlParams, 'last_name'); ?>" class="link-black"><?php echo SitePageData::setPathReplace('type.form_data.shop_client.fields_title.last_name', SitePageData::CASE_FIRST_LETTER_UPPER); ?></a>
            <a href="<?php echo Func::getFullURL($siteData, '/shopclient/index'). Func::getAddURLSortBy($siteData->urlParams, 'last_name'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-numeric-<?php if (Arr::path($siteData->urlParams, 'sort_by.last_name', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
        <?php }?>
        <?php if(empty($editFields) || (in_array('email', $editFields))){ ?>
            <th class="tr-header-price">
                <a href="<?php echo Func::getFullURL($siteData, '/shopclient/index'). Func::getAddURLSortBy($siteData->urlParams, 'email'); ?>" class="link-black"><?php echo SitePageData::setPathReplace('type.form_data.shop_client.fields_title.email', SitePageData::CASE_FIRST_LETTER_UPPER); ?></a>
                <a href="<?php echo Func::getFullURL($siteData, '/shopclient/index'). Func::getAddURLSortBy($siteData->urlParams, 'email'); ?>" class="link-blue">
                    <i class="fa fa-fw fa-sort-alpha-<?php if (Arr::path($siteData->urlParams, 'sort_by.email', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
                </a>
            </th>
        <?php }?>
        <th class="tr-header-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/client/one/index-edit']->childs as $value) {
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

