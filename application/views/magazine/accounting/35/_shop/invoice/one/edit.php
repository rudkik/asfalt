<div class="inline-block">
    <h3 class="pull-left">Накладная <small style="margin-right: 10px;">редактирование</small></h3>
    <a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/edit_gtd', array('id' => 'id'));?>" class="btn bg-blue btn-flat pull-left margin-l-10">
        ЭСФ
    </a>
    <?php if($data->values['is_calc_esf'] == 0){ ?>
        <a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/save_new', array('id' => 'id'), array('is_esf' => true, 'url' => '/accounting/shopinvoice/edit_gtd?id='.$data->id));?>" class="btn bg-red btn-flat pull-right margin-l-10">
            Пересчитать ЭСФ
        </a>
    <?php } ?>
    <?php if($data->values['is_import_esf'] == 0){ ?>
        <button type="button" class="btn bg-orange btn-flat pull-right margin-l-10" onclick="submitinvoice('shopinvoice');">Сохранить</button>
    <?php } ?>
    <a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/save_new', array('id' => 'id'), array('url' => '/accounting/shopinvoice/edit?id='.$data->id));?>" class="btn bg-blue btn-flat pull-right margin-l-10">
        Пересчитать накладную
    </a>
    <a href="<?php echo Func::getFullURL($siteData, '/shopxml/save_invoice_esf', array('id' => 'id'));?>" class="btn bg-purple btn-flat pull-right margin-l-10">
        <i class="fa fa-fw fa-download"></i>
        Экспортировать
    </a>
    <button type="button" class="btn bg-purple btn-flat pull-right margin-l-10" data-toggle="modal" data-target="#dialog-import">
        <i class="fa fa-fw fa-upload"></i>
        Импортировать
    </button>
    <?php if(Request_RequestParams::getParamBoolean('is_not_group')){?>
        <a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/edit', array('id' => 'id'), array('is_not_group' => false));?>" class="btn bg-green btn-flat pull-right margin-l-10">
            Сокращено
        </a>
    <?php }else{?>
        <a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/edit', array('id' => 'id'), array('is_not_group' => true));?>" class="btn bg-green btn-flat pull-right margin-l-10">
            Подробно
        </a>
    <?php }?>
</div>
<form id="shopinvoice" action="<?php echo Func::getFullURL($siteData, '/shopinvoice/save'); ?>" method="post" style="padding-right: 5px;">
    <div class="row">
        <div class="col-md-1-5">
            <div class="form-group">
                <label>
                    Номер
                </label>
                <input name="number" type="text" class="form-control" placeholder="Номер" value="<?php echo $data->values['number']; ?>" <?php if($data->values['is_import_esf'] == 1){?>readonly<?php }?>>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>
                    Дата совершения оборота
                </label>
                <input name="date" type="datetime" date-type="date" class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['date']); ?>" <?php if($data->values['is_import_esf'] == 1){?>readonly<?php }?>>
            </div>
        </div>
        <div class="col-md-1-5">
            <div class="form-group">
                <label>
                    Период реализации от
                </label>
                <input name="date_from" type="text" class="form-control" value="<?php $tmp = Request_RequestParams::getParamDate('date_from'); if($tmp !== NULL){echo Helpers_DateTime::getDateFormatRus($tmp);}else{echo Helpers_DateTime::getDateFormatRus($data->values['date_from']);} ?>" readonly>
            </div>
        </div>
        <div class="col-md-1-5">
            <div class="form-group">
                <label>
                    Период реализации до
                </label>
                <input name="date_to" type="text" class="form-control" value="<?php $tmp = Request_RequestParams::getParamDate('date_to'); if($tmp !== NULL){echo Helpers_DateTime::getDateFormatRus($tmp);}else{echo Helpers_DateTime::getDateFormatRus($data->values['date_to']);} ?>" readonly>
            </div>
        </div>
        <div class="col-md-1-5"></div>
        <div class="col-md-1-5">
            <div class="form-group">
                <label>
                    Кол-во
                </label>
                <input type="text"  class="form-control text-right" value="<?php echo Func::getNumberStr($data->values['quantity'], TRUE, 3, false); ?>" readonly>
            </div>
        </div>
        <div class="col-md-1-5">
            <div class="form-group">
                <label>
                    Сумма
                </label>
                <input type="text"  class="form-control text-right" value="<?php echo Func::getNumberStr($data->values['amount'], TRUE, 2, false); ?>" readonly>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 box-body-goods padding-r-0">
            <table class="table-input table table-hover table-db table-tr-line" data-action="table-select">
                <tr class="bg-light-blue-active">
                    <th class="width-75">Приемка</th>
                    <th class="width-30 text-right">№</th>
                    <th>Продукция</th>
                    <th class="width-100 text-right">Кол-во</th>
                    <th class="width-100 text-right">Цена</th>
                    <th class="width-100 text-right">Сумма</th>
                </tr>
                <tbody id="products">
                <?php echo $siteData->globalDatas['view::_shop/invoice/item/list/invoice'];?>
                <tr>
                    <td colspan="3" class="bg-light-blue-active b-green text-right">Итого</td>
                    <td class="bg-light-blue-active b-green text-right"><?php echo Func::getNumberStr($data->values['quantity'], TRUE, 3, FALSE); ?></td>
                    <td class="bg-light-blue-active b-green text-right">x</td>
                    <td class="bg-light-blue-active b-green text-right"><?php echo Func::getNumberStr($data->values['amount'], TRUE, 2, FALSE); ?></td>
                </tr>
                </tbody>
            </table>
            <style>
                .icheckbox_minimal-blue.checked.disabled {
                    background-position: -40px 0 !important;
                }
            </style>
        </div>
    </div>
    <div class="row">
        <div hidden>
            <?php if($siteData->action != 'clone') { ?>
                <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
            <?php } ?>
            <input id="is_close" name="is_close" value="1">
        </div>
    </div>
</form>
<script>
    function submitinvoice(id) {
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
            <form action="<?php echo Func::getFullURL($siteData, '/shopinvoice/edit'); ?>" method="get" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    Период реализации от
                                </label>
                                <input name="date_from" type="datetime" date-type="date" class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['date_from']); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    Период реализации до
                                </label>
                                <input name="date_to" type="datetime" date-type="date" class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['date_to']); ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input name="id" value="<?php echo $data->id; ?>" style="display: none">
                    <input id="esf_type_id" name="esf_type_id" value="<?php echo $data->values['esf_type_id']?>" style="display: none">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Загрузить</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="dialog-import" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Импорт файла ЭСФ</h4>
            </div>
            <form action="<?php echo Func::getFullURL($siteData, '/shopinvoice/import_esf'); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label>
                            Файл
                        </label>
                        <div class="file-upload" data-text="Выберите файл">
                            <input type="file" name="file" multiple>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input name="id" value="<?php echo $data->id; ?>" style="display: none">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Загрузить</button>
                </div>
            </form>
        </div>
    </div>
</div>