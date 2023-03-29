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
                <?php $siteData->titleTop = 'Сформированные накладные'; ?>
                <?php
                $view = View::factory('ab1/sales/35/main/_shop/invoice/filter');
                $view->siteData = $siteData;
                $view->data = $data;
                echo Helpers_View::viewToStr($view);
                ?>
            </div>
            <div class="nav-tabs-custom" style="margin-bottom: 0px;">
                <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
                    <li class="pull-left">
                        <div class="btn-group">
                            <a href="#" class="btn bg-info btn-flat">Выдать клиенту</a>
                            <button type="button" class="btn bg-info btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php echo Func::getFullURL($siteData, '/shopreport/invoice_print_list', array(), array_merge($_POST, $_GET, array('is_issued' => true))); ?>">Накладные для печати</a></li>
                                <li><a href="<?php echo Func::getFullURL($siteData, '/shopreport/act_service_print_list', array(), array_merge($_POST, $_GET, array('is_issued' => true))); ?>">Акты для печати</a></li>
                                <li><a href="<?php echo Func::getFullURL($siteData, '/shopreport/act_service_print_registry', array(), array_merge($_POST, $_GET, array('is_issued' => true))); ?>">Реестры для печати</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="pull-left">
                        <div class="btn-group" style="margin-left: 10px;">
                            <a href="#" class="btn bg-green btn-flat">Печать</a>
                            <button type="button" class="btn bg-green btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php echo Func::getFullURL($siteData, '/shopreport/invoice_print_list', array(), array_merge($_POST, $_GET)); ?>">Накладные для печати</a></li>
                                <li><a href="<?php echo Func::getFullURL($siteData, '/shopreport/act_service_print_list', array(), array_merge($_POST, $_GET)); ?>">Акты для печати</a></li>
                                <li><a href="<?php echo Func::getFullURL($siteData, '/shopreport/act_service_print_registry', array(), array_merge($_POST, $_GET)); ?>">Реестры для печати</a></li>
                            </ul>
                        </div>
                    </li>
                    <?php if(Request_RequestParams::getParamInt('shop_client_id') > 0 && Request_RequestParams::getParamDate('date_from_equally') != null){ ?>
                        <li class="pull-left" style="margin-right: 10px;">
                            <span>
                                <a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/received_from_client', array(), array_merge($_POST, $_GET)); ?>" class="btn bg-blue btn-flat">Получено от клиента</a>
                            </span>
                        </li>
                        <li class="pull-left" style="margin-right: 10px;">
                            <span>
                                <a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/give_to_bookkeeping', array(), array_merge($_POST, $_GET)); ?>" class="btn bg-orange btn-flat">Сдано в бухгалтерию</a>
                            </span>
                        </li>
                    <?php } ?>
                    <li class="<?php if(Request_RequestParams::getParamBoolean('is_send_esf')){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/index', array(), array('is_send_esf' => 1));?>" data-id="is_not_public">ЭСФ</a></li>
                    <li class="<?php if(Request_RequestParams::getParamBoolean('is_last_day')){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/index', array(), array('is_last_day' => 1));?>" data-id="is_public">К сдаче ЭСФ</a></li>
                    <li class="<?php if((!Request_RequestParams::getParamBoolean('is_send_esf')) && (!Request_RequestParams::getParamBoolean('is_last_day'))){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/index', array(), array('is_public_ignore' => 1));?>">Текущие <i class="fa fa-fw fa-info text-blue"></i></a></li>
                </ul>
            </div>
            <div class="body-table">
                <div class="box-body table-responsive" style="padding-top: 0px;">
                    <?php echo trim($data['view::_shop/invoice/list/index']); ?>
                </div>
            </div>
        </div>
	</div>
</div>
