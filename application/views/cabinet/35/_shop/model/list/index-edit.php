<form action="<?php echo Func::getFullURL($siteData, '/shopmodel/savelist'); ?>" method="post">
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
            <a href="<?php echo Func::getFullURL($siteData, '/shopmodel/index_edit'). Func::getAddURLSortBy($siteData->urlParams, 'id'); ?>" class="link-black">ID</a>
            <a href="<?php echo Func::getFullURL($siteData, '/shopmodel/index_edit'). Func::getAddURLSortBy($siteData->urlParams, 'id'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-numeric-<?php if (Arr::path($siteData->urlParams, 'sort_by.id', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
        <?php if ((Func::isShopMenu('shopmodel/image?type='.Request_RequestParams::getParamInt('type'), array(), $siteData))){ ?>
        <th class="tr-header-photo">Фото</th>
        <?php }?>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopmodel/index_edit'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Название</a>
            <a href="<?php echo Func::getFullURL($siteData, '/shopmodel/index_edit'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-alpha-<?php if (Arr::path($siteData->urlParams, 'sort_by.name', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
        <th class="tr-header-rubric">
            <a href="<?php echo Func::getFullURL($siteData, '/shopmodel/index_edit'). Func::getAddURLSortBy($siteData->urlParams, 'shop_mark_name'); ?>" class="link-black">Марка</a>
            <a href="<?php echo Func::getFullURL($siteData, '/shopmodel/index_edit'). Func::getAddURLSortBy($siteData->urlParams, 'shop_mark_name'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-numeric-<?php if (Arr::path($siteData->urlParams, 'sort_by.shop_mark_name', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
        <th class="tr-header-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/model/one/index-edit']->childs as $value) {
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

