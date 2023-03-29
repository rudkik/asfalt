<table class="table table-hover table-db">
    <tr>
        <th class="tr-header-public">
            <span>
                <input name="set-is-public-all" type="checkbox" class="minimal" checked  href="<?php echo Func::getFullURL($siteData, '/shopmessagechat/save');?>">
            </span>
        </th>
        <?php if ((Func::isShopMenu('shopmessagechat/table/id?type='.Request_RequestParams::getParamInt('type'), $siteData))){ ?>
            <th class="tr-header-id">
                <a href="<?php echo Func::getFullURL($siteData, '/shopmessagechat/index'). Func::getAddURLSortBy($siteData->urlParams, 'id'); ?>" class="link-black">ID</a>
                <a href="<?php echo Func::getFullURL($siteData, '/shopmessagechat/index'). Func::getAddURLSortBy($siteData->urlParams, 'id'); ?>" class="link-blue">
                    <i class="fa fa-fw fa-sort-numeric-<?php if (Arr::path($siteData->urlParams, 'sort_by.id', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
                </a>
            </th>
        <?php }?>
        <?php if ((Func::isShopMenu('shopmessagechat/table/image?type='.Request_RequestParams::getParamInt('type'), $siteData))){ ?>
            <th class="tr-header-photo">Фото</th>
        <?php }?>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopmessagechat/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black"><?php echo SitePageData::setPathReplace('type.form_data.shop_messagechat.fields_title.name', SitePageData::CASE_FIRST_LETTER_UPPER); ?></a>
            <a href="<?php echo Func::getFullURL($siteData, '/shopmessagechat/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-alpha-<?php if (Arr::path($siteData->urlParams, 'sort_by.name', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
        <?php if ((Func::isShopMenu('shopmessagechat/table/rubric?type='.Request_RequestParams::getParamInt('type'), $siteData))){ ?>
            <th class="tr-header-rubric"><?php echo SitePageData::setPathReplace('type.form_data.shop_messagechat.fields_title.rubric', SitePageData::CASE_FIRST_LETTER_UPPER); ?></th>
        <?php } ?>
        <?php if ((Func::isShopMenu('shopmessagechat/table/unit?type='.Request_RequestParams::getParamInt('type'), $siteData))){ ?>
            <th class="tr-header-rubric"><?php echo SitePageData::setPathReplace('type.form_data.shop_messagechat.fields_title.unit', SitePageData::CASE_FIRST_LETTER_UPPER); ?></th>
        <?php } ?>
        <?php if ((Func::isShopMenu('shopmessagechat/table/select?type='.Request_RequestParams::getParamInt('type'), $siteData))){ ?>
            <th class="tr-header-rubric"><?php echo SitePageData::setPathReplace('type.form_data.shop_messagechat.fields_title.select', SitePageData::CASE_FIRST_LETTER_UPPER); ?></th>
        <?php } ?>
        <?php if ((Func::isShopMenu('shopmessagechat/table/brand?type='.Request_RequestParams::getParamInt('type'), $siteData))){ ?>
            <th class="tr-header-rubric"><?php echo SitePageData::setPathReplace('type.form_data.shop_messagechat.fields_title.brand', SitePageData::CASE_FIRST_LETTER_UPPER); ?></th>
        <?php } ?>
        <th class="tr-header-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/message/chat/one/index']->childs as $value) {
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

