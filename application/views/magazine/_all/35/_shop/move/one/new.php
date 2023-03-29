<div class="inline-block">
    <h3 class="pull-left">Перемещение продукции <small style="margin-right: 10px;">добавление</small></h3>
    <button type="button" class="btn bg-orange btn-flat pull-right" onclick="submitMove('shopmove');">Сохранить</button>
    <button type="button" class="btn bg-blue btn-flat pull-right" style="margin-right: 5px" onclick="submitMoveApply('shopmove');">Применить</button>
</div>
<form id="shopmove" action="<?php echo Func::getFullURL($siteData, '/shopmove/save'); ?>" method="post" style="padding-right: 5px;">
    <div class="row">
        <div class="col-xs-3 box-filter-right">
            <h2 class="text-right" id="total"></h2>
            <div class="form-group" style="margin-top: 10px">
                <label>
                    Штрих-код
                </label>
                <input data-is-unique="true" data-action="find-barcode" data-url="/bar/shopproduction/find_barcode" name="barcode" type="tel" class="form-control" placeholder="Штрих-код">
            </div>
            <div class="form-group">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Склад (откуда)
                </label>
                <select data-type="select2" id="shop_branch_id" name="shop_branch_id" class="form-control select2" required style="width: 100%;">
                    <option value="0" data-id="0">Выберите склад</option>
                    <?php echo $siteData->globalDatas['view::_shop/branch/list/list']; ?>
                </select>
            </div>
            <div class="form-group">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Склад (куда)
                </label>
                <select data-type="select2" id="branch_move_id" name="branch_move_id" class="form-control select2" required style="width: 100%;">
                    <option value="0" data-id="0">Выберите склад</option>
                    <?php echo $siteData->globalDatas['view::_shop/branch/list/list']; ?>
                </select>
            </div>
        </div>
        <div class="col-xs-9 box-body-goods padding-r-0">
            <?php echo $siteData->globalDatas['view::_shop/move/item/list/index'];?>
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

    function submitMove(id) {
        var isError = false;

        var element = $('[name="branch_move_id"]');
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

    function submitMoveApply(id) {
        $('#is_close').val(0).attr('value', 0);
        submitMove(id);
    }
</script>