<table data-id="0" class="table table-hover table-db margin-b-5">
    <tr>
        <th class="tr-header-photo">Фото</th>
        <th>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Товар / услуга
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </th>
        <th class="tr-header-price">Цена</th>
        <th class="tr-header-buttom-delete"></th>
    </tr>

    <?php
    foreach ($data['view::_shop/car/one/promo-popup-gift']->childs as $value){
        echo $value->str;
    }
    ?>
</table>

<div class="row">
    <div class="col-md-12">
        <?php
        $view = View::factory('cabinet/35/paginator');
        $view->siteData = $siteData;

        $urlParams = $siteData->urlParams;
        $urlParams['page'] = '-pages-';

        $shopBranchID = intval(Request_RequestParams::getParamInt('shop_branch_id'));
        if($shopBranchID > 0) {
            $urlParams['shop_branch_id'] = $shopBranchID;
        }

        $url = $siteData->urlBasic.$siteData->url.str_replace('-pages-', '$page$', URL::query($urlParams, FALSE));
        $url = 'javascript:actionFindCars(\'find-cars-gift-id\', \'result-cars-gift\', \'\', \''.$url.'\')';

        $view->urlData = $url;
        $view->urlAction = 'href';

        echo Helpers_View::viewToStr($view);
        ?>
    </div>
</div>