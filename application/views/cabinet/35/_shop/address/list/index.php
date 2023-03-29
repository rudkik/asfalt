<table class="table table-hover table-db">
    <tr>
        <th class="tr-header-public">
            <span>
                <input name="set-is-public-all" type="checkbox" class="minimal" checked  href="<?php echo Func::getFullURL($siteData, '/shopaddress/save');?>">
            </span>
        </th>
        <th class="tr-header-id">
            <a href="<?php echo Func::getFullURL($siteData, '/shopaddress/index'). Func::getAddURLSortBy($siteData->urlParams, 'id'); ?>" class="link-black">ID</a>
            <a href="<?php echo Func::getFullURL($siteData, '/shopaddress/index'). Func::getAddURLSortBy($siteData->urlParams, 'id'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-numeric-<?php if (Arr::path($siteData->urlParams, 'sort_by.id', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
        <?php if ((Func::isShopMenu('shopaddress/rubric', $siteData))){ ?>
            <th class="tr-header-rubric">Рубрика</th>
        <?php } ?>
        <th>Название</th>
        <th>Адрес</th>
        <?php if(count($siteData->shop->getLanguageIDsArray()) > 1){?>
            <th class="tr-translate">Переводы</th>
        <?php } ?>
        <th class="tr-header-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/address/one/index']->childs as $value) {
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

