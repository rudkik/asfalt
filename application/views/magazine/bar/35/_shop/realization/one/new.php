<div class="inline-block">
    <h3 class="pull-left">Реализация продукции <small style="margin-right: 10px;">добавление</small></h3>
    <button id="button-save" type="button" class="btn bg-orange btn-flat pull-right" onclick="submitRealization('shoprealization');">Сохранить</button>
</div>
<form id="shoprealization" action="<?php echo Func::getFullURL($siteData, '/shoprealization/save'); ?>" method="post" style="padding-right: 5px;">
    <div class="row">
        <div class="col-xs-3 box-filter-right">
            <h2 class="text-right" id="total">0</h2>
            <div class="form-group">
                <input data-keywords="virtual" data-action="surrender" type="tel" class="form-control" placeholder="Деньги от клиента">
            </div>
            <h4 class="text-right"><span>Сдача:</span> <label id="surrender"></label></h4>
            <div class="form-group" style="margin-top: 10px">
                <label>
                    Штрих-код
                </label>
                <input data-is-unique="true" data-keywords="virtual" data-action="find-barcode" data-url="/bar/shopproduction/find_barcode" name="barcode" type="tel" class="form-control" placeholder="Штрих-код">
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
                    <input data-id="shop_card_name" type="text" class="form-control" placeholder="ФИО" readonly>
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
            <img id="img-goods" class="box-goods-img" src="">
            <?php echo $siteData->globalDatas['view::_shop/realization/item/list/index'];?>
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
    var is_data_changed = true;
    $('[data-action="find-barcode"]').focus();
    function submitRealization(id) {
        var isError = false;

        var amount = 0;
        $('[data-id="total"]').each(function () {
            amount = amount + Number($(this).attr('value'));
        });

        if(Number($('#talon').attr('value-amount')) < amount){
            alert('У сотрудника лимит на покупку составляет: ' + $('#talon').attr('value-amount') + ' тг.');
            isError = true;
        }

        is_data_changed = isError;
        if(!isError) {
            $('#'+id).submit();
        }
    }

    function calcSurrender() {
        var amount = Number($('#total').val());
        var surrender = Number($('[data-action="surrender"]').val());
        amount = amount - surrender;
        if (amount > 0) {
            amount = '';
        } else {
            amount = Intl.NumberFormat('ru-RU', {maximumFractionDigits: 2}).format(amount * -1).replace(',', '.').replace('.00', '');
        }
        $('#surrender').text(amount);
    }

    $('[data-action="surrender"]').keyup(function(event) {
        calcSurrender();
    }).change(function(event) {
        calcSurrender();
    });
    $('#total').change(function(event) {
        calcSurrender();
    });

    window.onbeforeunload = function (e) {
        var amount = 0;
        $('[data-id="total"]').each(function () {
            amount = amount + Number($(this).attr('value'));
        });

        if(is_data_changed && amount > 0){
            // Ловим событие для Interner Explorer
            var e = e || window.event;
            var myMessage= "Вы действительно хотите покинуть страницу, не сохранив данные?";
            // Для Internet Explorer и Firefox
            if (e) {
                e.returnValue = myMessage;
            }
            // Для Safari и Chrome
            return myMessage;
        }
    };
</script>