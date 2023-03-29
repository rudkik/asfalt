<table class="table table-hover table-db table-tr-line">
    <tr>
        <th class="width-85">
            <a href="<?php echo Func::getFullURL($siteData, '/shoprealization/index'). Func::getAddURLSortBy($siteData->urlParams, 'created_at'); ?>" class="link-black">Дата</a>
        </th>
        <th style="width: 116px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shoprealization/index'). Func::getAddURLSortBy($siteData->urlParams, 'fiscal_check'); ?>" class="link-black">№ чека</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoprealization/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_worker_id'); ?>" class="link-black">Сотрудник</a>
        </th>
        <th class="tr-header-amount text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shoprealization/index'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">Кол-во</a>
        </th>
        <th class="tr-header-amount text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shoprealization/index'). Func::getAddURLSortBy($siteData->urlParams, 'amount'); ?>" class="link-black">Сумма</a>
        </th>
        <th class="width-120"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/realization/one/special/index']->childs as $value) {
        echo $value->str;
    }
    ?>

</table>
<div class="col-md-12 padding-top-5px">
    <?php
    $view = View::factory('magazine/bar/35/paginator');
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
</div>
<script>
    $('[data-action="set-special"]').click(function (e) {
        e.preventDefault();

        var a = $(this);
        var special = $(this).data('special');
        var id = $(this).data('id');
        var url = $(this).attr('href');
        jQuery.ajax({
            url: url,
            type: "POST",
            success: function (data) {
                if(special == <?php echo Model_Magazine_Shop_Realization::SPECIAL_TYPE_PRODUCT; ?>){
                    a.data('special', <?php echo Model_Magazine_Shop_Realization::SPECIAL_TYPE_BASIC; ?>);
                    a.attr('href', '<?php echo Func::getFullURL($siteData, '/shoprealization/edit_type'); ?>?id=' + id + '&is_special=' + <?php echo Model_Magazine_Shop_Realization::SPECIAL_TYPE_BASIC; ?>);
                    a.text('Перенести в реализацию');
                }

                if(special == <?php echo Model_Magazine_Shop_Realization::SPECIAL_TYPE_BASIC; ?>) {
                    a.data('special', <?php echo Model_Magazine_Shop_Realization::SPECIAL_TYPE_PRODUCT; ?>);
                    a.attr('href', '<?php echo Func::getFullURL($siteData, '/shoprealization/edit_type'); ?>?id=' + id + '&is_special=' + <?php echo Model_Magazine_Shop_Realization::SPECIAL_TYPE_PRODUCT; ?>);
                    a.text('Перенести в спецпродукт');
                }
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    });
</script>