<?php
$name = Arr::path($data->values, 'name', '');
if(!empty($name)){
?>
    <div class="text-center" style="width: 100%">
        <h4><span class="text-red"><?php echo $name; ?></span></h4>
        <a href="<?php echo $siteData->urlBasic; ?>/manager/shopcart/save_return?type=52317" class="btn btn-danger btn-flat pull-left">Оформить возврат</a>
        <a href="<?php echo $siteData->urlBasic; ?>/manager/shopcart/save_bill?type=51662" class="btn btn-danger btn-flat pull-right">Оформить заказ</a>
        <a href="<?php echo $siteData->urlBasic; ?>/manager/shopcart/save_operation_stock?type=53943" class="btn btn-danger btn-flat pull-right">Оформить склад</a>
    </div>
<?php }else{ ?>
    <a href="<?php echo Func::getFullURL($siteData, '/shopbranch/index', array(), array('type'=>'51658')); ?>" data-action="cart-add" class="btn btn-info btn-flat">Выбрать магазин</a>
<?php } ?>

