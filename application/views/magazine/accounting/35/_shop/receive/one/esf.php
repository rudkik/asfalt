<?php
$esf = new Helpers_ESF_Unload_Invoice();
$arr = json_decode($data->values['esf'], TRUE);
if(is_array($arr)) {
    $esf->loadToArray($arr);
}
?>
<div class="inline-block">
    <h3 class="pull-left">ЭСФ <small style="margin-right: 10px;">редактирование</small></h3>
    <button type="button" class="btn bg-orange btn-flat pull-right margin-l-10" onclick="submitReceive('shopreceive');">Сохранить</button>
    <button type="button" class="btn bg-blue btn-flat pull-right margin-l-10" data-toggle="modal" data-target="#dialog-load-esf">Загрузить ЭСФ</button>
</div>
<form id="shopreceive" action="<?php echo Func::getFullURL($siteData, '/shopreceive/save_esf'); ?>" method="post" style="padding-right: 5px;">
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Дата совершения оборота
                </label>
                <input name="date" type="datetime" date-type="date" class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['date']);?>">
            </div>
        </div>
        <div class="col-md-1">
            <div class="form-group">
                <label style="width: 100%;height: 23px;"> </label>
                <label class="span-checkbox">
                    <input name="is_nds" <?php if (Arr::path($data->values, 'is_nds', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
                    НДС
                </label>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Номер счет-фактуры
                </label>
                <input name="esf_number" type="text" class="form-control" placeholder="Номер счет-фактуры" value="<?php echo htmlspecialchars($data->values['esf_number'], ENT_QUOTES);?>">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Дата выписки
                </label>
                <input name="esf_date" type="datetime" date-type="date" class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['esf_date']);?>">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Вид счет-фактуры
                </label>
                <select data-type="select2" id="esf_type_id" name="esf_type_id" class="form-control select2" required style="width: 100%;">
                    <option value="0" data-id="0">Выберите вид счет-фактуры</option>
                    <?php echo $siteData->globalDatas['view::esf-type/list/list']; ?>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Поставщик
                </label>
                <select data-type="select2" id="shop_supplier_id" name="shop_supplier_id" class="form-control select2" required style="width: 100%;">
                    <option value="0" data-id="0">Выберите поставщика</option>
                    <?php echo $siteData->globalDatas['view::_shop/supplier/list/list']; ?>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>
                    Номер ЭСФ
                </label>
                <input type="text" class="form-control" placeholder="Номер ЭСФ" value="<?php echo htmlspecialchars($esf->getRegistrationNumber(), ENT_QUOTES);?>" readonly>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>
                    Сумма НДС ЭСФ
                </label>
                <input type="text" class="form-control" placeholder="Сумма" value="<?php echo Func::getNumberStr($esf->getProducts()->getNDSAmount(), true, 2, false);?>" readonly>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>
                    Сумма
                </label>
                <input type="text" class="form-control" placeholder="Сумма" value="<?php echo Func::getNumberStr($data->values['amount'], true, 2, false);?>" readonly>
            </div>
        </div>
        <?php
        /** @var Helpers_ESF_Unload_Product $child */
        foreach ($esf->getProducts()->getValues() as $child){
            if($child->getShopReceiveItemID() > 0){
                $esf->getProducts()->removeElement($child);
            }
        }

        $esf->getProducts()->sortByKey();
        ?>
        <div class="col-xs-<?php if(!$siteData->operation->getIsAdmin() && $esf->getProducts()->isEmpty()){echo 12;}else{echo 8;} ?> box-body-goods">
            <table class="table-input table table-hover table-db table-tr-line" data-action="table-select">
                <tr>
                    <th class="bg-light-blue-active text-center" colspan="4" style="width: 50%">Приёмка</th>
                    <th class=" text-center" colspan="5" style="width: 50%">ЭСФ</th>
                </tr>
                <tr>
                    <th class="bg-light-blue-active" style="width: 50%">Продукт</th>
                    <th class="width-70 text-right bg-light-blue-active">Кол-во</th>
                    <th class="width-80 text-right bg-light-blue-active">Цена</th>
                    <th class="width-80 text-right bg-light-blue-active">Сумма</th>
                    <th style="width: 50%">Продукт</th>
                    <th class="width-80 text-right">Кол-во</th>
                    <th class="width-80 text-right">Цена</th>
                    <th class="width-80 text-right">Сумма</th>
                    <th class="width-30"></th>
                </tr>
                <tbody id="products">
                <?php echo $siteData->globalDatas['view::_shop/receive/item/list/esf'];?>
                <?php
                $esf = new Helpers_ESF_Unload_Invoice();
                $arr = json_decode($data->values['esf'], TRUE);
                if(is_array($arr)) {
                    $esf->loadToArray($arr);
                }
                ?>
                <tr>
                    <td class="bg-light-blue-active b-green text-left">Итого</td>
                    <td class="text-right bg-light-blue-active b-green">
                        <?php echo Func::getNumberStr($data->values['quantity'], TRUE, 3, FALSE); ?>
                    </td>
                    <td class="text-center bg-light-blue-active b-green">x</td>
                    <td class="text-right bg-light-blue-active b-green"><?php echo Func::getNumberStr($data->values['amount'], TRUE, 2, FALSE); ?></td>
                    <td class="bg-light-blue-active b-green"></td>
                    <td class="text-right bg-light-blue-active b-green"><?php echo Func::getNumberStr($esf->getProducts()->getQuantity(), TRUE, 3, FALSE); ?></td>
                    <td class="text-center bg-light-blue-active b-green">x</td>
                    <td class="text-right bg-light-blue-active b-green"><?php echo Func::getNumberStr($esf->getProducts()->getAmount(), TRUE, 2, FALSE); ?></td>
                    <td class="bg-light-blue-active b-green"></td>
                </tr>
                </tbody>
            </table>
        </div>
        <?php if($siteData->operation->getIsAdmin() || $esf->getProducts()->isNotProcessed()){ ?>
        <div class="col-xs-4 box-body-goods pull-right">
            <h4>Нераспределенные товары</h4>
            <table class="table-input table table-hover table-db table-tr-line" data-action="table-select">
                <tr>
                    <th>Продукт</th>
                    <th class="width-70 text-right">Кол-во</th>
                    <th class="width-70 text-right">Цена</th>
                    <th class="width-70 text-right">Сумма</th>
                </tr>
                <tbody id="esf-products">
                <?php
                /** @var Helpers_ESF_Unload_Product $child */
                foreach ($esf->getProducts()->getValues() as $child) {
                    if($child->getShopReceiveItemID() < 1){
                    ?>
                    <tr data-hash="<?php echo $child->getHash(); ?>">
                        <td data-id="name"><?php echo $child->getName(); ?></td>
                        <td data-id="quantity" class="text-right"><?php echo round($child->getQuantity(), 4); ?></td>
                        <td data-id="price" class="text-right"><?php echo round($child->getPrice(), 2); ?></td>
                        <td data-id="amount" class="text-right"><?php echo round($child->getAmount(), 2); ?></td>
                    </tr>
                <?php }} ?>
                </tbody>
            </table>

            <script>
                $(function () {
                    /**
                     * Элемент который нужно перемещать
                     * @param elements
                     */
                    function iniDraggableESFProducts(elements) {
                        elements.each(function () {
                            var eventObject = {
                                title: $.trim($(this).text())
                            };
                            $(this).data('eventObject', eventObject);
                            $(this).css('cursor', 'pointer');
                            $(this).draggable({
                                zIndex: 1070,
                                revert: true,
                                revertDuration: 0
                            });

                        });
                    }

                    /**
                     * Элемент куда нужно перемещать
                     * @param elements
                     */
                    function iniDroppableProducts(elements) {
                        elements.each(function () {
                            $(this).droppable({
                                drop: function( event, ui ) {
                                    var draggable = ui.draggable;

                                    var hash = $(draggable).data('hash');
                                    var name = $(draggable).find('[data-id="name"]').html();
                                    var quantity = $(draggable).find('[data-id="quantity"]').html();
                                    var price = $(draggable).find('[data-id="price"]').html();
                                    var amount = $(draggable).find('[data-id="amount"]').html();

                                    // меняем местами, если уже установлен продукт ЭСФ
                                    var hashTo = $(this).data('hash');
                                    if(hashTo == ''){
                                        $(draggable).remove();
                                    }else{
                                        $(draggable).data('hash', hashTo);
                                        $(draggable).find('[data-id="name"]').html($(this).find('[data-id="name"]').html());
                                        $(draggable).find('[data-id="quantity"]').html($(this).find('[data-id="quantity"]').html());
                                        $(draggable).find('[data-id="price"]').html($(this).find('[data-id="price"]').html());
                                        $(draggable).find('[data-id="amount"]').html($(this).find('[data-id="amount"]').html());
                                    }

                                    $(this).attr('data-hash', hash).data('hash', hash);
                                    $(this).find('[data-id="name"]').html(name);
                                    $(this).find('[data-id="quantity"]').html(quantity);
                                    $(this).find('[data-id="price"]').html(price);
                                    $(this).find('[data-id="amount"]').html(amount);
                                    $(this).find('[data-id="hash_esf"]').val(hash).attr('value', hash);

                                    if(Number($(this).data('quantity')) != Number(quantity)){
                                        $(this).find('[data-id="quantity"]').addClass('tr-red');
                                    }else{
                                        $(this).find('[data-id="quantity"]').removeClass('tr-red');
                                    }

                                    if(Number($(this).data('price')) != Number(price)){
                                        $(this).find('[data-id="price"]').addClass('tr-red');
                                    }else{
                                        $(this).find('[data-id="price"]').removeClass('tr-red');
                                    }
                                }
                            });

                        });
                    }

                    /**
                     * Элемент поиск подходящих
                     * @param elements
                     */
                    function iniFindESFProducts(elements) {
                        elements.each(function () {
                            $(this).click(function(event){
                                event.preventDefault();

                                // удаляем подстветку
                                $('#products tr span.highlight').each(function(){
                                    $(this).after($(this).html()).remove();
                                });
                                $('#products tr .highlight').each(function(){
                                    $(this).removeClass('highlight');
                                });

                                // разбитие по словам
                                var words = $(this).find('[data-id="name"]').text().split(' ');
                                // поиск по названию
                                $('#products tr [data-id="shop_product_name"]').each(function (i, valueFind) {
                                    $.each(words, function (index, term) {
                                        if(term.length > 2) {
                                            term = term
                                                .replace(/\\/g, '\\')
                                                .replace(/\//g, '\\/')
                                                .replace(/\[/g, '\\[')
                                                .replace(/\]/g, '\\]')
                                                .replace(/\(/g, '\\(')
                                                .replace(/\)/g, '\\)')
                                                .replace(/\{/g, '\\{')
                                                .replace(/\}/g, '\\}')
                                                .replace(/\?/g, '\\?')
                                                .replace(/\+/g, '\\+')
                                                .replace(/\*/g, '\\*')
                                                .replace(/\|/g, '\\|')
                                                .replace(/\./g, '\\.')
                                                .replace(/\^/g, '\\^')
                                                .replace(/\$/g, '\\$');

                                            $(valueFind).html($(valueFind).html().replace(new RegExp(term, 'ig'), '<span class="highlight">$&</span>')); // выделяем найденные фрагменты
                                        }
                                    });
                                });

                                // поиск по количеству и цене
                                var quantity = Number($(this).find('[data-id="quantity"]').html());
                                var price = Number($(this).find('[data-id="price"]').html());
                                $('#products tr').each(function () {
                                    var isT = false;
                                    if(Number($(this).data('quantity')) == quantity){
                                        $(this).find('[data-id="original-quantity"]').addClass('highlight');
                                        isT = true;
                                    }

                                    if(Number($(this).data('price')) == price){
                                        $(this).find('[data-id="original-price"]').addClass('highlight');
                                        isT = isT && true;
                                    }else {
                                        isT = false;
                                    }

                                    if(isT){
                                        $(this).find('[data-id="total"]').addClass('highlight');
                                    }

                                });
                            });
                        });
                    }
                    
                    /**
                     * Удаление связи ЭСФ и продукции
                     * @param elements
                     */
                    function iniDeleteESFProducts(elements) {
                        elements.each(function () {
                            $(this).click(function(event){
                                event.preventDefault();

                                var parent = $(this).parents('tr');
                                var hash = parent.data('hash');
                                if(hash == ''){
                                    return;
                                }

                                parent.find('[data-id="quantity"]').removeClass('tr-red');
                                parent.find('[data-id="price"]').removeClass('tr-red');

                                var name = parent.find('[data-id="name"]').html();
                                var quantity = parent.find('[data-id="quantity"]').html();
                                var price = parent.find('[data-id="price"]').html();
                                var amount = parent.find('[data-id="amount"]').html();

                                parent.attr('data-hash', '').data('hash', '');
                                parent.find('[data-id="name"]').html('');
                                parent.find('[data-id="quantity"]').html('');
                                parent.find('[data-id="price"]').html('');
                                parent.find('[data-id="amount"]').html('0');
                                parent.find('[data-id="hash_esf"]').val('').attr('value', '');

                                var html =
                                    '<tr data-hash="'+hash+'">'
                                        + '<td data-id="name">'+name+'</td>'
                                        + '<td data-id="quantity" class="text-right">'+quantity+'</td>'
                                        + '<td data-id="price" class="text-right">'+price+'</td>'
                                        + '<td data-id="amount" class="text-right">'+amount+'</td>'
                                    '</tr>';
                                html = $(html);

                                $('#esf-products').prepend(html);

                                iniDraggableESFProducts(html);
                                iniFindESFProducts(html);
                            });
                        });
                    }

                    iniDeleteESFProducts($('[data-action="delete-esf"]'));

                    iniDroppableProducts($('#products tr'));
                    iniDraggableESFProducts($('#esf-products tr'));
                    iniFindESFProducts($('#esf-products tr'));
                });
            </script>
        </div>
        <?php } ?>
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
    function addProduct() {
        var form = $('#dialog-product');

        form.find('[name="name"]').val('');
        form.find('[name="barcode"]').val($('#find-barcode').val());
        form.modal('show');
    }

    function submitReceive(id) {
        var isError = false;

        var element = $('[name="shop_supplier_id"]');
        if (!$.isNumeric(element.val()) || parseInt(element.val()) < 1){
            element.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }

        if(!isError) {
            $('#'+id).submit();
        }
    }
</script>
<div id="dialog-load-esf" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Загрузить файл ЭСФ</h4>
            </div>
            <form action="<?php echo Func::getFullURL($siteData, '/shopreceive/load_esf'); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label>
                            Файл
                        </label>
                        <div class="file-upload" data-text="Выберите файл">
                            <input type="file" name="file">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input name="id" value="<?php echo Request_RequestParams::getParamInt('id'); ?>" style="display: none">

                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary" >Загрузить</button>
                </div>
            </form>
        </div>
    </div>
</div>