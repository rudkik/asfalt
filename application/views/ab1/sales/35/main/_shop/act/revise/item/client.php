<?php $siteData->siteTitle = 'Акт сверок клиента'; ?>
<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/sales/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <div class="tab-pane active">
                <?php $siteData->titleTop = 'Акт сверок клиента'; ?>
                <?php
                $view = View::factory('ab1/sales/35/main/_shop/act/revise/item/filter/client');
                $view->siteData = $siteData;
                $view->data = $data;
                echo Helpers_View::viewToStr($view);
                ?>
            </div>
                <div class="nav-tabs-custom" style="margin-bottom: 0px;">
                    <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
                        <li>
                            <a href="<?php echo Func::getFullURL($siteData, '/shopreport/act_revise_one', array('shop_client_id', 'date_from', 'date_to', 'is_add_virtual_invoice'), array()); ?>" class="btn bg-info btn-flat" style="margin-right: 10px">Сохранить в Excel</a>
                        </li>
                    </ul>
                </div>
            <div class="body-table">
                <div class="box-body table-responsive" style="padding-top: 0px;">
                    <?php echo trim($data['view::_shop/act/revise/item/list/client']); ?>
                </div>
            </div>
        </div>
	</div>
</div>
