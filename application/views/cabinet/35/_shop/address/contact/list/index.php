<table class="table table-hover table-db">
    <tr>
        <th class="tr-header-public">
            <span>
                <input name="set-is-public-all" type="checkbox" class="minimal" checked  href="<?php echo Func::getFullURL($siteData, '/shopaddresscontact/save');?>">
            </span>
        </th>
        <th class="tr-header-id">
            <a href="<?php echo Func::getFullURL($siteData, '/shopaddresscontact/index'). Func::getAddURLSortBy($siteData->urlParams, 'id'); ?>" class="link-black">ID</a>
            <a href="<?php echo Func::getFullURL($siteData, '/shopaddresscontact/index'). Func::getAddURLSortBy($siteData->urlParams, 'id'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-numeric-<?php if (Arr::path($siteData->urlParams, 'sort_by.id', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
        <?php if ((Func::isShopMenu('shopaddresscontact/city', $siteData))){ ?>
            <th class="tr-header-rubric">
                <a href="<?php echo Func::getFullURL($siteData, '/shopaddresscontact/index'). Func::getAddURLSortBy($siteData->urlParams, 'article'); ?>" class="link-black">Страна/город</a>
                <a href="<?php echo Func::getFullURL($siteData, '/shopaddresscontact/index'). Func::getAddURLSortBy($siteData->urlParams, 'article'); ?>" class="link-blue">
                    <i class="fa fa-fw fa-sort-alpha-<?php if (Arr::path($siteData->urlParams, 'sort_by.article', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
                </a>
            </th>
        <?php } ?>
        <?php if ((Func::isShopMenu('shopaddresscontact/rubric', $siteData))){ ?>
            <th class="tr-header-rubric">Рубрика</th>
        <?php } ?>
        <th class="tr-header-rubric">Вид контакта</th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopaddresscontact/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Контакт</a>
            <a href="<?php echo Func::getFullURL($siteData, '/shopaddresscontact/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-alpha-<?php if (Arr::path($siteData->urlParams, 'sort_by.name', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
        <?php if ((Func::isShopMenu('shopaddresscontact/text', $siteData))
            || (Func::isShopMenu('shopaddresscontact/text-html', $siteData))){ ?>
            <th class="tr-header-rubric">Примечание</th>
        <?php } ?>
        <th class="tr-header-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/address/contact/one/index']->childs as $value) {
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

