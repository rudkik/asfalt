<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/' . $siteData->actionURLName . '/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <?php if(Request_RequestParams::getParamInt('shop_client_contract_item_id') > 0){ ?>
                <?php echo trim($data['view::_shop/client/contract/item/one/show']); ?>
            <?php }elseif(Request_RequestParams::getParamInt('shop_client_contract_id') > 0){ ?>
                <?php echo trim($data['view::_shop/client/contract/one/show']); ?>
            <?php }elseif(Request_RequestParams::getParamInt('shop_client_id') > 0){ ?>
                <?php echo trim($data['view::_shop/client/one/show']); ?>
            <?php }elseif(Request_RequestParams::getParamInt('shop_client_attorney_id') > 0){ ?>
                <?php echo trim($data['view::_shop/client/attorney/one/show']); ?>
            <?php }elseif(Request_RequestParams::getParamInt('shop_product_price_id') > 0){ ?>
                <?php echo trim($data['view::_shop/product/price/one/show']); ?>
            <?php }else{ ?>
                <?php echo trim($data['view::_shop/client/balance/day/one/show']); ?>
            <?php } ?>
            <div class="body-table">
                <div class="box-body table-responsive" style="padding-top: 0px;">
                    <?php echo trim($data['view::_shop/car/item/list/index']); ?>
                </div>
            </div>
        </div>
	</div>
</div>
