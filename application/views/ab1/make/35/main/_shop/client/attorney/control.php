<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/'.$siteData->actionURLName.'/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <div class="tab-pane active">
                <?php $siteData->titleTop = 'Контроль по отгрузке клиентов'; ?>
                <?php
                $view = View::factory('ab1/'.$siteData->actionURLName.'/35/main/_shop/client/attorney/filter/control');
                $view->siteData = $siteData;
                $view->data = $data;
                echo Helpers_View::viewToStr($view);
                ?>
            </div>
            <div class="nav-tabs-custom" style="margin-bottom: 0px;">
                <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
                    <li class="pull-left header">
                        <a href="<?php echo Func::getFullURL($siteData, '/shopreport/attorney_control', array(), array(), array(), true); ?>" class="btn bg-blue btn-flat" style="margin-right: 10px">Сохранить в Excel</a>
                    </li>
                </ul>
            </div>
            <div class="body-table">
            <div class="box-body table-responsive" style="padding-top: 0px;">
                <?php echo trim($data['view::_shop/client/attorney/list/control']); ?>
            </div>
            </div>
        </div>
	</div>
</div>
