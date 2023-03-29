<div class="inline-block">
    <h3 class="pull-left">Возврат продуктов поставщику <small style="margin-right: 10px;">добавление</small></h3>
    <button type="button" class="btn bg-orange btn-flat pull-right" onclick="submitReturn('shopreturn');">Сохранить</button>
</div>
<form id="shopreturn" action="<?php echo Func::getFullURL($siteData, '/shopreturn/save'); ?>" method="post" style="padding-right: 5px;">
    <div class="row">
        <div class="col-xs-3 box-filter-right">
            <h2 class="text-right" id="total">0</h2>
            <div class="form-group" style="margin-top: 10px">
                <label>
                    Штрих-код
                </label>
                <input data-is-unique="true" data-action="find-barcode" data-url="/bar/shopproduct/find_barcode" name="barcode" type="tel" class="form-control" placeholder="Штрих-код">
            </div>

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
        <div class="col-xs-9 box-body-goods padding-r-0">
            <?php echo $siteData->globalDatas['view::_shop/return/item/list/index'];?>
        </div>
    </div>
    <div class="row">
        <div hidden>
            <?php echo Helpers_Token::getInputTokenURL($siteData->url);?>
            <input id="is_close" name="is_close" value="1">
        </div>
    </div>
</form>
<script>

    function submitReturn(id) {
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