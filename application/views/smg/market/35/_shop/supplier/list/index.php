<table class="table table-striped table-bordered table-hover">
    <tr>
        <th rowspan="2" class="tr-header-public">
            <span>
                <input name="set-is-public-all" type="checkbox" class="minimal" checked  href="<?php Func::getFullURL($siteData, '/shopsupplier/save');?>">
            </span>
        </th>
        <th  rowspan="2" class="width-80">
            <a href="<?php echo Func::getFullURL($siteData, '/shopsupplier/index'). Func::getAddURLSortBy($siteData->urlParams, 'bin'); ?>" class="link-black">БИН</a>
        </th>
        <th  rowspan="2" class="width-170">
            <a href="<?php echo Func::getFullURL($siteData, '/shopsupplier/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Поставщик</a>
            <a href="<?php echo Func::getFullURL($siteData, '/shopsupplier/index'). Func::getAddURLSortBy($siteData->urlParams, 'name_organization'); ?>" class="link-black">Организация</a>
        </th>
        <th rowspan="2" class="width-130">
            <a href="<?php echo Func::getFullURL($siteData, '/shopsupplier/index'). Func::getAddURLSortBy($siteData->urlParams, 'phone'); ?>" class="link-black">Телефон</a>
        </th>
        <th  rowspan="2" class="width-90">
            <a href="<?php echo Func::getFullURL($siteData, '/shopsupplier/index'). Func::getAddURLSortBy($siteData->urlParams, 'bank_name'); ?>" class="link-black">Банк <br> Номер счета</a>
        </th>
        <th  rowspan="2" class="width-180">
            <a href="<?php echo Func::getFullURL($siteData, '/shopsupplier/index'). Func::getAddURLSortBy($siteData->urlParams, 'director_name'); ?>" class="link-black">Должность <br> ФИО</a>
        </th>
        <th  colspan="2" class="text-center">
            Адрес
        </th>
        <th rowspan="2" class="tr-header-buttom width-110"></th>
    </tr>
    <tr>
        <th class="">
            <a href="<?php echo Func::getFullURL($siteData, '/shopsupplier/index'). Func::getAddURLSortBy($siteData->urlParams, 'legal_address'); ?>" class="link-black">Юридический</a>
        </th>
        <th >
            <a href="<?php echo Func::getFullURL($siteData, '/shopsupplier/index'). Func::getAddURLSortBy($siteData->urlParams, 'post_address'); ?>" class="link-black">Почтовый</a>
        </th>
    </tr>
    <?php
    foreach ($data['view::_shop/supplier/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>
</table>
<?php
$view = View::factory('smg/_all/35/paginator');
$view->siteData = $siteData;

$urlParams = $siteData->urlParams;
$urlParams['page'] = '-pages-';

$shopBranchID = intval(Request_RequestParams::getParamInt('shop_branch_id'));
if($shopBranchID > 0) {
    $urlParams['shop_branch_id'] = $shopBranchID;
}

$url = str_replace('-pages-', '$page$', URL::query($urlParams, FALSE));

$view->urlData = $siteData->urlBasic.$siteData->url.$url;
$view->urlAction = 'href';

echo Helpers_View::viewToStr($view);
?>

