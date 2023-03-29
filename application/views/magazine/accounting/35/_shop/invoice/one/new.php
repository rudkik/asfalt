<?php
$data->additionDatas['amount'] = Arr::path($data->additionDatas, 'amount', 0);
$data->additionDatas['quantity'] = Arr::path($data->additionDatas, 'quantity', 0);
?>
<div class="inline-block">
    <h3 class="pull-left">Накладная <small style="margin-right: 10px;">добавление</small></h3>
    <?php if ($data->additionDatas['amount'] > 0){ ?>
    <button type="button" class="btn bg-orange btn-flat pull-right margin-l-10" onclick="submitInvoice('shopinvoice');">Зафиксировать</button>
    <?php } ?>
    <button type="button" class="btn bg-blue btn-flat pull-right margin-l-10" data-toggle="modal" data-target="#dialog-edit-period">Изменить период</button>
</div>
<form id="shopinvoice" action="<?php echo Func::getFullURL($siteData, '/shopinvoice/save_new'); ?>" method="post" style="padding-right: 5px;">
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <label>
                    Дата совершения оборота
                </label>
                <input name="date" type="datetime" date-type="date" class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus(Request_RequestParams::getParamDate('date_to')); ?>" readonly>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>
                    Период реализации от
                </label>
                <input name="date_from" type="text" class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus(Request_RequestParams::getParamDate('date_from')); ?>" readonly>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>
                    Период реализации до
                </label>
                <input name="date_to" type="text" class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus(Request_RequestParams::getParamDate('date_to')); ?>" readonly>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>
                    Кол-во
                </label>
                <input type="text"  class="form-control text-right" value="<?php echo Func::getNumberStr($data->additionDatas['quantity'], TRUE, 3, false); ?>" readonly>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>
                    Сумма
                </label>
                <input type="text"  class="form-control text-right" value="<?php echo Func::getNumberStr($data->additionDatas['amount'], TRUE, 2, false); ?>" readonly>
            </div>
        </div>
        <div class="col-xs-12 box-body-goods padding-r-0">
            <?php echo $siteData->globalDatas['view::_shop/realization/item/list/invoice'];?>
        </div>
    </div>
    <div class="row">
        <div hidden>
            <input id="is_close" name="is_close" value="0">
            <input id="esf_type_id" name="esf_type_id" value="<?php echo Request_RequestParams::getParamStr('esf_type_id');?>">
        </div>
    </div>
</form>
<script>
    function submitInvoice(id){
        var isError = false;

        if(!isError) {
            $('#'+id).submit();
        }
    }
</script>
<div id="dialog-edit-period" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Изменить период</h4>
            </div>
            <form action="<?php echo Func::getFullURL($siteData, '/shopinvoice/new'); ?>" method="get" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    Период реализации от
                                </label>
                                <input name="date_from" type="datetime" date-type="date" class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus(Request_RequestParams::getParamDate('date_from')); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    Период реализации до
                                </label>
                                <input name="date_to" type="datetime" date-type="date" class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus(Request_RequestParams::getParamDate('date_to')); ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input id="esf_type_id" name="esf_type_id" value="<?php echo Request_RequestParams::getParamStr('esf_type_id'); ?>" style="display: none">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary" >Загрузить</button>
                </div>
            </form>
        </div>
    </div>
</div>