<div class="inline-block">
    <h3 class="pull-left">Возврат реализации <small style="margin-right: 10px;">добавление</small></h3>
    <button type="button" class="btn bg-orange btn-flat pull-right" onclick="submitRealizationReturn('shoprealization-return');">Сохранить</button>
</div>
<form id="shoprealization-return" action="<?php echo Func::getFullURL($siteData, '/shoprealizationreturn/save'); ?>" method="post" style="padding-right: 5px;">
    <div class="row">
        <div class="col-xs-3 box-filter-right">
            <h2 class="text-right" id="total">0</h2>
            <div class="form-group" style="margin-top: 10px">
                <label>
                    Штрих-код
                </label>
                <input data-is-unique="true" data-keywords="virtual" data-action="find-barcode" data-url="/bar/shopproduction/find_barcode" name="barcode" type="tel" class="form-control" placeholder="Штрих-код">
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
            <img id="img-goods" class="box-goods-img" src="">
            <?php echo $siteData->globalDatas['view::_shop/realization/return/item/list/index'];?>
        </div>
    </div>
    <div class="row">
        <div hidden>
            <?php echo Helpers_Token::getInputTokenURL($siteData->url);?>
            <input id="is_close" name="is_close" value="1">
            <input id="is_new" name="is_new" value="1">
        </div>
    </div>
</form>
<script>
    $('[data-action="find-barcode"]').focus();
    function submitRealizationReturn(id) {
        var isError = false;

        if(!isError) {
            $('#'+id).submit();
        }
    }
</script>