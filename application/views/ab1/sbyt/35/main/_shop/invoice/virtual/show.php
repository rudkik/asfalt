<?php $siteData->siteTitle =  Request_RequestParams::getParamStr('shop_client_name').' - новые накладные'; ?>
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
                <div style="margin-bottom: 10px; display: inline-block; width: 100%;">
                    <h3 class="pull-left">Новые накладные клиента</h3>
                    <a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shopactservice/virtual_index', array(),
                        array(), array(), true); ?>" class="btn bg-purple btn-flat pull-right">Акты клиента</a>
                </div>
                <?php
                $view = View::factory('ab1/sbyt/35/main/_shop/invoice/virtual/filter/show');
                $view->siteData = $siteData;
                $view->data = $data;
                echo Helpers_View::viewToStr($view);
                ?>
            </div>
            <div class="nav-tabs-custom" style="margin-bottom: 0px;">
                <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
                    <li class="pull-left">
                        <div>
                            <a data-action="invoice-edit" href="<?php
                            echo Func::getFullURL($siteData, '/shopinvoice/virtual_edit',
                                array('shop_client_id' => 'shop_client_id', 'shop_client_attorney_id' => 'shop_client_attorney_id', 'shop_client_contract_id' => 'shop_client_contract_id', 'product_type_id' => 'product_type_id', 'date_from' => 'date_from', 'date_to' => 'date_to'));
                            ?>" class="btn bg-purple btn-flat">
                                <i class="fa fa-edit margin-r-5"></i>
                                Изменить доверенность
                            </a>
                        </div>
                    </li>
                    <li class="pull-right">
                        <div class="box-bth-right">
                            <a href="#dialog-invoice-add" data-toggle="modal" class="btn bg-blue btn-flat">
                                <i class="fa fa-plus margin-r-5"></i>
                                Зафиксировать накладную
                            </a>
                            <a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/calc_goods_price', array('date_from', 'date_to', 'shop_client_name', 'shop_client_id', 'shop_client_attorney_id', 'shop_client_contract_id', 'product_type_id', 'is_delivery')); ?>" data-toggle="modal" class="btn bg-purple btn-flat">
                                <i class="fa fa-calculator margin-r-5"></i>
                                Пересчитать цены
                            </a>
                            <?php if(Request_RequestParams::getParamBoolean('is_all')){?>
                                <a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/virtual_show', array('date_from', 'date_to', 'shop_client_id', 'shop_client_attorney_id', 'shop_client_contract_id', 'product_type_id', 'is_delivery')); ?>" class="btn bg-green btn-flat"><i class="fa fa-fw fa-minus"></i> Сокращено</a>
                            <?php }else{?>
                                <a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/virtual_show', array('date_from', 'date_to', 'shop_client_id', 'shop_client_attorney_id', 'shop_client_contract_id', 'product_type_id', 'is_delivery'), array('is_all' => '1')); ?>" class="btn bg-green btn-flat"><i class="fa fa-fw fa-plus"></i> Подробно</a>
                            <?php }?>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="body-table">
                <div class="box-body table-responsive" style="padding-top: 0px;">
                    <?php echo trim($data['view::_shop/invoice/list/virtual/show']); ?>
                    <?php
                    $dateFrom = Request_RequestParams::getParamDate('act.date_from', array(), FALSE, NULL, true);
                    if(empty($dateFrom)){
                        $dateFrom = Helpers_DateTime::getDateFormatRus(Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')));
                    }else{
                        $dateFrom = Helpers_DateTime::getDateFormatRus($dateFrom);
                    }
                    $dateTo = Request_RequestParams::getParamDate('act.date_to', array(), FALSE, NULL, true);
                    if(empty($dateTo)){
                        $dateTo = date('d.m.Y');
                    }else{
                        $dateTo = Helpers_DateTime::getDateFormatRus($dateTo);
                    }
                    ?>
                    <h3 style="margin-top: 40px"><a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shopactreviseitem/client', array('shop_client_id')); ?>">Акт сверки клиента</a> <?php echo $dateFrom ?> - <?php echo $dateTo; ?></h3>
                    <div class="row">
                        <form class="col-md-12">
                            <div class="row">
                                <div class="col-md-1-5">
                                    <div class="form-group">
                                        <label for="act_date_from">Период от</label>
                                        <div class="input-group" style="width: 100%;">
                                            <div class="input-group">
                                                <input id="act_date_from" class="form-control pull-right" type="datetime" date-type="date" name="act[date_from]" value="<?php echo Helpers_DateTime::getDateFormatRus($dateFrom);?>">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1-5">
                                    <div class="form-group">
                                        <label for="act_date_to">Период до</label>
                                        <div class="input-group" style="width: 100%;">
                                            <div class="input-group">
                                                <input id="act_date_to" class="form-control pull-right" type="datetime" date-type="date" name="act[date_to]" value="<?php echo Helpers_DateTime::getDateFormatRus($dateTo);?>">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div style="display: none">
                                        <?php
                                        $arr = $_GET;
                                        unset($arr['act']);
                                        echo Func::getURLParamsToInput($arr);
                                        ?>
                                    </div>
                                    <button type="submit" class="btn bg-orange btn-flat" style="margin-top: 25px;"><i class="fa fa-fw fa-search"></i> Поиск</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php echo trim($data['view::_shop/act/revise/item/list/client']); ?>
                </div>
            </div>
        </div>
	</div>
</div>
<script>
    $(function () {
        $('[data-action="invoice-edit"]').click(function () {
            var url = $(this).attr('href');
            jQuery.ajax({
                url: url,
                data: ({}),
                type: "POST",
                success: function (data) {
                    var form = $('#dialog-invoice-edit')
                    form.modal('hide');
                    form.remove();

                    $('body').append(data);

                    __init();
                    $('#dialog-invoice-edit').modal('show');
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });

            return false;
        });
    });
</script>
<div id="dialog-invoice-add" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Зафиксировать накладную</h4>
            </div>
            <form id="form-add-car" action="<?php echo Func::getFullURL($siteData, '/shopinvoice/add'); ?>" method="get" >
                <div class="modal-body">
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Дата
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input id="date" name="date" type="datetime" date-type="date" class="form-control" value="<?php echo Helpers_DateTime::getDateTimeFormatRus(Request_RequestParams::getParamDate('date_from'));?>">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Закрыть</button>
                    <input name="is_delivery" value="<?php echo floatval(Request_RequestParams::getParamBoolean('is_delivery')); ?>" style="display: none">
                    <input name="date_from" value="<?php echo Request_RequestParams::getParamDateTime('date_from'); ?>" style="display: none">
                    <input name="date_to" value="<?php echo Request_RequestParams::getParamDateTime('date_to'); ?>" style="display: none">
                    <input name="shop_client_attorney_id" value="<?php echo Request_RequestParams::getParamInt('shop_client_attorney_id'); ?>" style="display: none">
                    <input name="shop_client_contract_id" value="<?php echo Request_RequestParams::getParamInt('shop_client_contract_id'); ?>" style="display: none">
                    <input name="shop_client_id" value="<?php echo Request_RequestParams::getParamInt('shop_client_id'); ?>" style="display: none">
                    <input name="product_type_id" value="<?php echo Request_RequestParams::getParamInt('product_type_id'); ?>" style="display: none">
                    <button type="submit" class="btn btn-primary">Зафиксировать</button>
                </div>
            </form>
        </div>
    </div>
</div>
