<div class="inline-block">
    <h3 class="pull-left">Приемка продуктов <small style="margin-right: 10px;">редактирование</small></h3>
    <button type="button" class="btn bg-orange btn-flat pull-right" onclick="submitReceive('shopreceive');">Сохранить</button>

    <div class="btn-group pull-right" style="margin-right: 10px">
        <a href="<?php echo Func::getFullURL($siteData, '/shopreport/receive_one', array(), array('shop_receive_id' => $data->id)); ?>" class="btn bg-info btn-flat">Сохранить в Excel</a>
        <button type="button" class="btn bg-info btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="caret"></span>
            <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu" role="menu">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopreport/receive_production_barcode_operation'). URL::query(array('shop_receive_id' => $data->id), FALSE); ?>">Штрихкоды для операторов</a></li>
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopreport/receive_production_barcode_tray'). URL::query(array('shop_receive_id' => $data->id), FALSE); ?>">Штрихкоды для лотков</a></li>
        </ul>
    </div>
</div>
<form id="shopreceive" action="<?php echo Func::getFullURL($siteData, '/shopreceive/save'); ?>" method="post" style="padding-right: 5px;">
    <div class="row">
        <div class="col-xs-3 box-filter-right">
            <div class="inline-block">
                <h4 class="pull-left" id="total-count"><?php echo Func::getNumberStr($data->values['quantity'], true, 3); ?></h4>
                <h2 class="text-right" id="total"><?php echo Func::getNumberStr($data->values['amount']); ?></h2>
            </div>
            <div class="form-group" style="margin-top: 10px">
                <label>
                    Штрих-код
                </label>
                <div class="input-group">
                    <input data-not-quantity="1" data-is-unique="0" data-keywords="virtual" id="find-barcode"  data-action="find-barcode" data-url="/bar/shopproduct/find_barcode" name="barcode" type="tel" class="form-control" placeholder="Штрих-код">
                    <div class="input-group-btn">
                        <button type="button" class="btn bg-green btn-flat" data-target="#dialog-product" onclick="addProduct();">+</button>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>
                    Название продукта
                </label>
                <select id="shop_product" class="form-control select2" style="width: 100%">
                </select>
            </div>
            <div class="form-group">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Поставщик
                </label>
                <div class="input-group">
                    <select data-type="select2" id="shop_supplier_id" name="shop_supplier_id" class="form-control select2" required style="width: 100%;">
                        <option value="0" data-id="0">Выберите поставщика</option>
                        <?php echo $siteData->globalDatas['view::_shop/supplier/list/list']; ?>
                    </select>
                    <div class="input-group-btn">
                        <button type="button" class="btn bg-green btn-flat" data-target="#dialog-supplier" onclick="addSupplier();">+</button>
                    </div>
                </div>
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
            <?php echo $siteData->globalDatas['view::_shop/receive/item/list/index'];?>
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
<?php
$view = View::factory('magazine/bar/35/_shop/product/one/modal');
$view->siteData = $siteData;
$view->data = $data;
$view->url = '/bar/shopproduct/save';
echo Helpers_View::viewToStr($view);
?>
<script>
    var barcodeProduct = '';
    $('#shop_product').select2({
        ajax: {
            url: "/bar/shopproduct/json?sort_by[name]=asc&limit=50&_fields[]=name&_fields[]=barcode",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    name_list: params.term // условие поиска
                };
            },
            processResults: function (data, params) {
                params.page = 1;
                return {
                    results: data
                };
            },
            cache: true
        },
        escapeMarkup: function (markup) {
            return markup;
        },
        minimumInputLength: 1,
        templateResult: function (repo) {
            return repo.name + ' ('+repo.barcode+')';
        },
        templateSelection: function (repo) {
            var barcode = repo.barcode;
            if(barcodeProduct != barcode) {
                barcodeProduct = barcode;

                var el = $('input[data-action="find-barcode"]');
                var url = el.data('url');
                findBarcode(barcode, url, el);
            }

            var name = repo.name || repo.text;
            $('#shop_client_name').val(name).attr('value', name);
            return repo.name || repo.text;
        },
    });
</script>
<?php
$view = View::factory('magazine/_all/35/_shop/supplier/one/modal');
$view->siteData = $siteData;
$view->data = $data;
$view->url = '/bar/shopsupplier/save';
echo Helpers_View::viewToStr($view);
?>