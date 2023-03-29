<div class="inline-block">
    <h3 class="pull-left">Списание <small style="margin-right: 10px;">редактирование</small></h3>
    <button type="button" class="btn bg-orange btn-flat pull-right" onclick="submitRealization('shoprealization');">Сохранить</button>
    <button type="button" class="btn bg-blue btn-flat pull-right" style="margin-right: 5px" onclick="submitRealizationApply('shoprealization');">Применить</button>
    <a href="<?php echo Func::getFullURL($siteData, '/shopreport/act_write_off', array(), array('shop_realization_id' => $data->values['id'])); ?>" class="btn bg-info btn-flat pull-right" style="margin-right: 10px">Акт списания</a>
    <a href="<?php echo Func::getFullURL($siteData, '/shopreport/realization_write_off', array(), array('shop_realization_id' => $data->values['id'])); ?>" class="btn bg-info btn-flat pull-right" style="margin-right: 10px">Сохранить в Excel</a>
</div>
<?php
$view = View::factory('magazine/_all/35/fiscal-registrar');
$view->siteData = $siteData;
$view->data = $data;
echo Helpers_View::viewToStr($view);
?>
<form id="shoprealization" action="<?php echo Func::getFullURL($siteData, '/shoprealization/save'); ?>" method="post" style="padding-right: 5px;">
    <div class="row">
        <div class="col-xs-3 box-filter-right b-purple">
            <h2 class="text-right" id="total-count"><?php echo Func::getNumberStr($data->values['quantity'], true, 3); ?></h2>
            <div class="form-group" style="margin-top: 10px">
                <label>
                    Штрих-код
                </label>
                <input data-is-unique="true" data-keywords="virtual" data-action="find-barcode" data-url="/bar/shopproduction/find_barcode" type="tel" class="form-control" placeholder="Штрих-код">
            </div>
            <div class="form-group">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Виды списания
                </label>
                <select data-type="select2" id="shop_write_off_type_id" name="shop_write_off_type_id" class="form-control select2" required style="width: 100%;">
                    <option value="0" data-id="0">Выберите </option>
                    <?php echo $siteData->globalDatas['view::_shop/write-off/type/list/list']; ?>
                </select>
            </div>
            <div class="form-group">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Сотрудник
                </label>
                <input data-keywords="virtual" data-type="card-number" data-action="find-card-number" data-url="/bar/shopcard/find_barcode" type="tel" class="form-control" placeholder="Номер карты">
            </div>
            <div class="form-group">
                <div class="input-group">
                    <input data-id="shop_card_name" type="text" class="form-control" placeholder="ФИО" value="<?php echo htmlspecialchars($data->getElementValue('shop_worker_id'), ENT_QUOTES); ?>">
                    <div class="input-group-addon" id="talon"></div>
                </div>
                <input data-id="shop_card_id" name="shop_card_id" style="display: none" value="<?php echo $data->values['shop_card_id']; ?>">
            </div>
            <div class="keyboard">
                <div class="box-center">
                    <div class="tree-row">
                        <div class="line">
                            <div data-action="keyboard-key" class="key"><span>7</span></div>
                            <div data-action="keyboard-key" class="key"><span>8</span></div>
                            <div data-action="keyboard-key" class="key"><span>9</span></div>
                        </div>
                        <div class="line">
                            <div data-action="keyboard-key" class="key"><span>4</span></div>
                            <div data-action="keyboard-key" class="key"><span>5</span></div>
                            <div data-action="keyboard-key" class="key"><span>6</span></div>
                        </div>
                        <div class="line">
                            <div data-action="keyboard-key" class="key"><span>1</span></div>
                            <div data-action="keyboard-key" class="key"><span>2</span></div>
                            <div data-action="keyboard-key" class="key"><span>3</span></div>
                        </div>
                        <div class="line">
                            <div data-action="keyboard-key" class="key btn-hor-double"><span>0</span></div>
                            <div data-action="keyboard-key" class="key"><span>.</span></div>
                        </div>
                    </div>
                    <div class="one-row">
                        <div class="line">
                            <div data-action="keyboard-backspace" class="key btn-ver-double"><span>←</span></div>
                        </div>
                        <div class="line">
                            <div data-action="keyboard-enter" class="key btn-ver-double"><span>Enter</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-9 box-body-goods padding-r-0">
            <?php echo $siteData->globalDatas['view::_shop/realization/item/list/write-off/index'];?>
        </div>
    </div>
    <div class="row">
        <div hidden>
            <?php echo Helpers_Token::getInputTokenURL($siteData->url);?>
            <?php if($siteData->action != 'clone') { ?>
                <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
            <?php } ?>
            <input id="is_close" name="is_close" value="1">
        </div>
    </div>
</form>
<script>
    $('[data-action="find-barcode"]').focus();
    function submitRealization(id) {
        var isError = false;

      /*  var element = $('[data-id="shop_card_name"]');
        if (element.val() == ''){
            element.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }*/

        if(!isError) {
            $('#'+id).submit();
        }
    }

    function submitRealizationApply(id) {
        $('#is_close').val(0).attr('value', 0);
        submitRealization(id);
    }
</script>