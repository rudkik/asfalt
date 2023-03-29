<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/asu/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="pull-left" style="margin-right: 20px;">Очередь на погрузку</h3>
                    </div>
                    <div class="col-md-6 text-right">
                        Сделано: <b><?php echo $siteData->globalDatas['view::car_sum']; ?></b> т
                    </div>
                </div>
            </div>
            <div class="body-table">
            <div class="box-body table-responsive" style="padding-top: 0px; padding-bottom: 200px;">
                <?php echo trim($data['view::_shop/car/list/shipment']); ?>
            </div>
            </div>
        </div>
	</div>
</div>
