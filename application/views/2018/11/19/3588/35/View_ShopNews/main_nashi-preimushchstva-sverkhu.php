<?php
$shopGoodIDs = MySession::getSession($siteData->shopID, 'view_shop_good_ids');
if(empty($shopGoodIDs)) {
    $_GET['shop_good_id'] = 999;
}else {
    $_GET['shop_good_id'] = $shopGoodIDs;
}
?>
<?php if(count($data['view::View_ShopNew\main_nashi-preimushchstva-sverkhu']->childs) > 0){?>
    <div class="header header-advantages">
        <div class="container">
            <div class="advantages">
                <div class="box-advantages">
                    <div class="row">
                        <?php
                        foreach ($data['view::View_ShopNew\main_nashi-preimushchstva-sverkhu']->childs as $value){
                            echo $value->str;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>