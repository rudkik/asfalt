<?php $data = $data['view::_shop/transport/waybill/work/driver/one/work']; ?>
<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th class="width-40 text-right">№</th>
        <th class="width-105">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybillworkdriver/work'). Func::getAddURLSortBy($siteData->urlParams, 'number'); ?>" class="link-black">Путевой лист</a>
        </th>
        <th class="width-80">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybillworkdriver/work'). Func::getAddURLSortBy($siteData->urlParams, 'date'); ?>" class="link-black">Дата</a>
        </th>
        <th class="width-120">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybillworkdriver/work'). Func::getAddURLSortBy($siteData->urlParams, 'from_at'); ?>" class="link-black">Выезд</a>
        </th>
        <th class="width-120">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybillworkdriver/work'). Func::getAddURLSortBy($siteData->urlParams, 'to_at'); ?>" class="link-black">Въезд</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybillworkdriver/work'). Func::getAddURLSortBy($siteData->urlParams, 'shop_transport_id.name'); ?>" class="link-black">Транспортное средство</a>
        </th>
        <th class="width-90">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybillworkdriver/work'). Func::getAddURLSortBy($siteData->urlParams, 'shop_transport_id.number'); ?>" class="link-black">Гос. номер</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybillworkdriver/work'). Func::getAddURLSortBy($siteData->urlParams, 'transport_work_id_name'); ?>" class="link-black">Вид работ</a>
        </th>
        <?php foreach ($data->additionDatas['works'] as $child) { ?>
            <th class="text-right" style="width: 155px">
                <?php echo $child->values['name']; ?>
            </th>
        <?php } ?>
    </tr>
    <tbody id="cars">
    <?php echo $siteData->globalDatas['view::_shop/transport/waybill/work/driver/one/total-work']; ?>
    <?php
    $i = 1;
    foreach ($data->childs as $value) {
        echo str_replace('#index#', $i++, $value->str);
    }
    ?>
    <?php echo $siteData->globalDatas['view::_shop/transport/waybill/work/driver/one/total-work']; ?>
    </tbody>
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