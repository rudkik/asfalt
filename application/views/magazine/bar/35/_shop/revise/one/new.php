<div class="inline-block">
    <h3 class="pull-left">Ревизия <small style="margin-right: 10px;">добавление</small></h3>
    <button type="button" class="btn bg-orange btn-flat pull-right" onclick="submitRevise('shoprevise');">Сохранить</button>
</div>
<form id="shoprevise" action="<?php echo Func::getFullURL($siteData, '/shoprevise/save'); ?>" method="post" style="padding-right: 5px;">
    <div class="row">
        <div class="col-xs-3 box-filter-right">
            <h2 class="text-right" id="total"></h2>
            <div class="form-group" style="margin-top: 10px">
                <label>
                    Штрих-код
                </label>
                <div class="input-group">
                    <input data-is-unique="true" data-is-coefficient="1" data-action="find-barcode" data-url="/bar/shopproduct/find_barcode?is_stock=1" name="barcode" type="tel" class="form-control" placeholder="Штрих-код">
                    <div class="input-group-btn">
                        <button type="button" class="btn bg-green btn-flat" data-toggle="modal" data-target="#dialog-product">+</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-9 box-body-goods padding-r-0">
            <?php echo $siteData->globalDatas['view::_shop/product/list/revise'];?>
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

    function submitRevise(id) {
        var isError = false;
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