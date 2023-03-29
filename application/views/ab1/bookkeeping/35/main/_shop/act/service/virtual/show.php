<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/bookkeeping/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <div class="tab-pane active">
                <?php
                $view = View::factory('ab1/bookkeeping/35/main/_shop/act/service/virtual/filter/show');
                $view->siteData = $siteData;
                $view->data = $data;
                echo Helpers_View::viewToStr($view);
                ?>
            </div>
            <div class="nav-tabs-custom" style="margin-bottom: 0px;">
                <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
                    <li class="pull-right">
                        <div class="box-bth-right">
                            <a href="#dialog-act-service-add" data-toggle="modal" class="btn bg-blue btn-flat">
                                <i class="fa fa-plus margin-r-5"></i>
                                Зафиксировать акт
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="body-table">
                <div class="box-body table-responsive" style="padding-top: 0px;">
                    <?php echo trim($data['view::_shop/act/service/list/virtual/show']); ?>
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
<div id="dialog-act-service-add" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Зафиксировать накладную</h4>
            </div>
            <form id="form-add-car" action="<?php echo Func::getFullURL($siteData, '/shopactservice/add'); ?>" method="get" >
                <div class="modal-body">
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Дата
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input id="date" name="date" type="datetime" date-type="date" class="form-control" value="<?php echo Helpers_DateTime::getDateTimeFormatRus(date('d.m.Y', strtotime('-1 day')));?>">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Закрыть</button>
                    <input name="date_from" value="<?php echo Request_RequestParams::getParamDateTime('date_from'); ?>" style="display: none">
                    <input name="date_to" value="<?php echo Request_RequestParams::getParamDateTime('date_to'); ?>" style="display: none">
                    <input name="shop_client_contract_id" value="<?php echo Request_RequestParams::getParamInt('shop_client_contract_id'); ?>" style="display: none">
                    <input name="shop_client_id" value="<?php echo Request_RequestParams::getParamInt('shop_client_id'); ?>" style="display: none">
                    <button type="submit" class="btn btn-primary">Зафиксировать</button>
                </div>
            </form>
        </div>
    </div>
</div>
