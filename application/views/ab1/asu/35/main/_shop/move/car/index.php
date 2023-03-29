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
                        <h3 class="pull-left" style="margin-right: 20px;">История перемещения</h3>
                    </div>
                    <div class="col-md-6 text-right">
                        <?php if (($siteData->replaceDatas['view::car_sum'] !== '')){ ?>
                            Всего: <b class="text-red"><?php echo $siteData->globalDatas['view::car_sum']; ?></b> т
                        <?php } ?>
                    </div>
                </div>
                <?php
                $view = View::factory('ab1/asu/35/main/_shop/move/car/filter');
                $view->siteData = $siteData;
                $view->data = $data;
                echo Helpers_View::viewToStr($view);
                ?>
            </div>
            <div class="body-table">
                <div class="box-body table-responsive" style="padding-top: 0px;">
                    <?php echo trim($data['view::_shop/move/car/list/index']); ?>
                </div>
            </div>
        </div>
	</div>
</div>
