<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/sbyt/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <div class="tab-pane active">
                <?php $siteData->titleTop = 'История реализации'; ?>
                <?php
                $view = View::factory('ab1/sbyt/35/main/_shop/car/filter/history');
                $view->siteData = $siteData;
                $view->data = $data;
                echo Helpers_View::viewToStr($view);
                ?>
            </div>
            <a href="<?php echo Func::getFullURL($siteData, '/shopreport/car_list', array(), array_merge($_POST, $_GET)); ?>" class="btn bg-info btn-flat" style="margin-left: 15px;">Сохранить в Excel</a>
            <div class="body-table">
                <div class="box-body table-responsive" style="padding-top: 0px;">
                    <?php echo trim($data['view::_shop/car/list/history']); ?>
                </div>
            </div>
        </div>
	</div>
</div>
