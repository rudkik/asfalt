<div class="inline-block">
    <h3 class="pull-left">Приемка продуктов <small style="margin-right: 10px;">просмотр продукции</small></h3>
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
        <div class="col-xs-12 box-body-goods padding-r-0">
            <?php echo $siteData->globalDatas['view::_shop/receive/item/list/production'];?>
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