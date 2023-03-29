<div class="inline-block">
    <h3 class="pull-left">Перемещение продукции <small style="margin-right: 10px;">редактирование</small></h3>
    <button type="button" class="btn bg-orange btn-flat pull-right" onclick="submitMove('shopmove');">Сохранить</button>
    <button type="button" class="btn bg-blue btn-flat pull-right" style="margin-right: 5px" onclick="submitMoveApply('shopmove');">Применить</button>
    <div class="btn-group pull-right" style="margin-right: 10px">
        <button type="button" class="btn bg-info btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            Сохранить в Excel
            <span class="caret" style="margin-left: 5px;"></span>
            <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu" role="menu">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopreport/move_one', array(), array('shop_move_id' => $data->id, 'shop_branch_id' => $data->values['shop_id'])); ?>"> Перемещение</a></li>
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopreport/move_invoice', array(), array('shop_move_id' => $data->id, 'shop_branch_id' => $data->values['shop_id'])); ?>"> Накладная</a></li>
        </ul>
    </div>
</div>
<form id="shopmove" action="<?php echo Func::getFullURL($siteData, '/shopmove/save'); ?>" method="post" style="padding-right: 5px;">
    <div class="row">
        <div class="col-xs-3 box-filter-right">
            <h2 class="text-right" id="total"></h2>
            <div class="form-group" style="margin-top: 10px">
                <label>
                    Штрих-код
                </label>
                <input data-is-unique="true" data-action="find-barcode" data-url="/bar/shopproduction/find_barcode" type="tel" class="form-control" placeholder="Штрих-код">
            </div>
            <div class="form-group">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Склад (откуда)
                </label>
                <input name="shop_branch_id"  value="<?php echo $data->values['shop_id'];?>" style="display: none">
                <select data-type="select2" id="shop_branch_id" class="form-control select2" required style="width: 100%;" disabled>
                    <option value="0" data-id="0">Выберите склад</option>
                    <?php
                    $tmp = 'data-id="'.$data->values['shop_id'].'"';
                    echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/branch/list/list']));
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Склад (куда)
                </label>
                <select data-type="select2" id="branch_move_id" name="branch_move_id" class="form-control select2" required style="width: 100%;">
                    <option value="0" data-id="0">Выберите склад</option>
                    <?php
                    $tmp = 'data-id="'.$data->values['branch_move_id'].'"';
                    echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/branch/list/list']));
                    ?>
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
            <?php if($siteData->action != 'clone') { ?>
                <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
            <?php } ?>
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