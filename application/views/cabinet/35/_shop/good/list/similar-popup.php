<table data-id="0" class="table table-hover table-db margin-b-5">
    <tr>
        <?php if ((Func::isShopMenu('shopgood/image?type='.Request_RequestParams::getParamInt('type'), $siteData))){ ?>
            <th class="tr-header-photo">Фото</th>
        <?php }?>
        <th>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            <?php echo SitePageData::setPathReplace('type.form_data.shop_good.fields_title.name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </th>
        <?php if (Func::isShopMenu('shopgood/price?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
            <th class="tr-header-price"><?php echo SitePageData::setPathReplace('type.form_data.shop_good.fields_title.price', SitePageData::CASE_FIRST_LETTER_UPPER); ?></th>
        <?php }?>
        <th class="tr-header-buttom-delete"></th>
    </tr>

    <?php
    foreach ($data['view::_shop/good/one/similar-popup']->childs as $value){
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
        $url = 'javascript:actionFindGoods(\'find-goods-similar-id\', \'result-goods-similar\', \'\', \''.$url.'\')';

        $view->urlData = $url;
        $view->urlAction = 'onclick';

        echo Helpers_View::viewToStr($view);
        ?>
    </div>
</div>