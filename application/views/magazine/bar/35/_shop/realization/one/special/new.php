<div class="inline-block">
    <h3 class="pull-left">Реализация спецпродукции <small style="margin-right: 10px;">добавление</small></h3>
    <button id="button-save" type="button" class="btn bg-orange btn-flat pull-right" onclick="submitRealization('shoprealization');">Сохранить</button>
</div>
<form id="shoprealization" action="<?php echo Func::getFullURL($siteData, '/shoprealization/save'); ?>" method="post" style="padding-right: 5px;">
    <div class="row">
        <div class="col-xs-3 box-filter-right b-green">
            <h2 class="text-right" id="total-count">0</h2>
            <div class="form-group" style="margin-top: 10px">
                <label>
                    Штрих-код
                </label>
                <input data-is-unique="true" data-keywords="virtual" data-action="find-barcode" data-url="/bar/shopproduction/find_barcode?is_special=1" name="barcode" type="tel" class="form-control" placeholder="Штрих-код">
            </div>
            <div class="form-group">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Сотрудник
                </label>
                <input data-keywords="virtual" data-type="card-number" data-action="find-card-number" data-url="/bar/shopcard/find_barcode" type="tel" class="form-control" placeholder="Номер карты" required>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <input data-id="shop_card_name" type="text" class="form-control" placeholder="ФИО">
                    <div class="input-group-addon" id="talon"></div>
                </div>
                <input data-id="shop_card_id" name="shop_card_id" style="display: none">
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
            <?php echo $siteData->globalDatas['view::_shop/realization/item/list/special/index'];?>
        </div>
    </div>
    <div class="row">
        <div hidden>
            <?php echo Helpers_Token::getInputTokenURL($siteData->url);?>
            <input id="is_close" name="is_close" value="1">
            <input id="is_special" name="is_special" value="1">
        </div>
    </div>
</form>
<script>
    $('[data-action="find-barcode"]').focus();
    function submitRealization(id) {
        var isError = false;

        var element = $('[data-id="shop_card_name"]');
        if (element.val() == ''){
            element.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }

        var quantity = 0;
        $('[data-id="quantity"]').each(function () {
            quantity = quantity + Number($(this).val());
        });

        if(Number($('#talon').attr('value')) < quantity * 2){
            alert('Количество талонов меньше реализации.');
            isError = true;
        }

        if(!isError) {
            $('#'+id).submit();
        }
    }
</script>