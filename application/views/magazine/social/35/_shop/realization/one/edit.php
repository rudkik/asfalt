<?php $isShow = Request_RequestParams::getParamBoolean('is_show'); ?>
<div class="inline-block">
    <h3 class="pull-left">Реализация продукции <small style="margin-right: 10px;"><?php if(!$isShow){ ?>редактирование<?php }else{?>просмотр<?php }?></small></h3>
</div>
<form id="shoprealization" action="<?php echo Func::getFullURL($siteData, '/shoprealization/save');?>" method="post" style="padding-right: 5px;">
    <div class="row">
        <div class="col-xs-3 box-filter-right">
            <h2 class="text-right" id="total"><?php echo Func::getNumberStr($data->values['amount']); ?></h2>
            <div class="form-group" style="margin-top: 10px">
                <label>
                    Штрих-код
                </label>
                <input data-is-unique="true" data-keywords="virtual" data-action="find-barcode" data-url="/bar/shopproduction/find_barcode" type="tel" class="form-control" placeholder="Штрих-код" <?php if($isShow){ ?>readonly<?php }?>>
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
                    <input data-id="shop_card_name" type="text" class="form-control" placeholder="ФИО" value="<?php echo htmlspecialchars($data->getElementValue('shop_worker_id'), ENT_QUOTES); ?>" readonly>
                    <div class="input-group-addon" id="talon"></div>
                </div>
                <input data-id="shop_card_id" name="shop_card_id" style="display: none" value="<?php echo $data->values['shop_card_id']; ?>">
            </div>
            <?php if(!$isShow){ ?>
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
            <?php }?>
        </div>
        <div class="col-xs-9 box-body-goods padding-r-0">
            <?php echo $siteData->globalDatas['view::_shop/realization/item/list/index'];?>
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

        if(!isError) {
            $('#'+id).submit();
        }
    }
</script>