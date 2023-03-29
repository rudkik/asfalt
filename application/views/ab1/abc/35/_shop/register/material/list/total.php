<?php $additionDatas = $data['view::_shop/register/material/one/total']->additionDatas; ?>
<table class="table table-hover table-db table-tr-line" >
    <tr class="table-header">
        <th rowspan="2">
            <a href="<?php echo Func::getFullURL($siteData, '/shopregistermaterial/total'). Func::getAddURLSortBy($siteData->urlParams, 'shop_material_id.name'); ?>" class="link-black">Материал</a>
        </th>
        <th class="text-center" colspan="<?php echo count($additionDatas['daughters']) + 1;?>">Завоз материалов</th>
        <th rowspan="2" class="text-right width-110" style="hyphens: none;">
            <a href="<?php echo Func::getFullURL($siteData, '/shopregistermaterial/total'). Func::getAddURLSortBy($siteData->urlParams, 'total_make'); ?>" class="link-black">Расход на производство</a>
        </th>
        <th class="text-center" colspan="<?php echo count($additionDatas['receivers']) + 1;?>">Вывоз материалов</th>
        <th rowspan="2" class="text-right width-110">
            <a href="<?php echo Func::getFullURL($siteData, '/shopregistermaterial/total'). Func::getAddURLSortBy($siteData->urlParams, 'total_side'); ?>" class="link-black">Побочное производство</a>
        </th>
        <th rowspan="2" class="text-right width-100">
            <a href="<?php echo Func::getFullURL($siteData, '/shopregistermaterial/total'). Func::getAddURLSortBy($siteData->urlParams, 'total_realization'); ?>" class="link-black">Реализация</a>
        </th>
        <th rowspan="2" class="text-right width-90">
            <a href="<?php echo Func::getFullURL($siteData, '/shopregistermaterial/total'). Func::getAddURLSortBy($siteData->urlParams, 'total'); ?>" class="link-black">Остатки</a>
        </th>
    </tr>
    <tr class="table-header">
        <?php foreach ($additionDatas['daughters'] as $key => $child){ ?>
            <th class="text-right width-80">
                <a href="<?php echo Func::getFullURL($siteData, '/shopregistermaterial/total'). Func::getAddURLSortBy($siteData->urlParams, 'daughters.'.$key); ?>" class="link-black"><?php echo $child['name']; ?></a>
            </th>
        <?php } ?>
        <th class="text-right width-90 total" style="hyphens: none;">
            <a href="<?php echo Func::getFullURL($siteData, '/shopregistermaterial/total'). Func::getAddURLSortBy($siteData->urlParams, 'total_daughter'); ?>" class="link-black">Итого приход</a>
        </th>
        <?php foreach ($additionDatas['receivers'] as $key => $child){ ?>
            <th class="text-right width-90">
                <a href="<?php echo Func::getFullURL($siteData, '/shopregistermaterial/total'). Func::getAddURLSortBy($siteData->urlParams, 'receivers.'.$key); ?>" class="link-black"><?php echo $child['name']; ?></a>
            </th>
        <?php } ?>
        <th class="text-right width-110">
            <a href="<?php echo Func::getFullURL($siteData, '/shopregistermaterial/total'). Func::getAddURLSortBy($siteData->urlParams, 'total_receiver'); ?>" class="link-black">Итого вывоз</a>
        </th>
    </tr>
    <?php
    foreach ($data['view::_shop/register/material/one/total']->childs as $value) {
        echo $value->str;
    }
    ?>

</table>
<div class="col-md-12 padding-top-5px">
    <?php
    $view = View::factory('ab1/_all/35/paginator');
    $view->siteData = $siteData;

    $urlParams = array_merge($siteData->urlParams, $_GET, $_POST);
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
</div>

