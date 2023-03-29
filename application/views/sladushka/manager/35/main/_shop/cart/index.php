<div class="row">
    <div class="col-md-12">
        <h3 class="pull-left">Корзина</h3>
        <a href="<?php echo Func::getFullURL($siteData, '/shopbranch/index', array(), array('type'=>'51658')); ?>" data-action="cart-add" class="btn btn-info btn-flat pull-right">Выбрать магазин</a>
    </div>
</div>
<ul class="products-list product-list-in-box">
	<?php echo trim($data['view::_shop/cart/list/index']); ?>
</ul>
<h3 style="margin: 0px;text-align: right;"><span>Итого: </span><label class="text-red" data-cart="total" data-cart-total="<?php echo $siteData->globalDatas['view::shopcart_amount']; ?>"><?php echo $siteData->globalDatas['view::shopcart_amount_str']; ?></label></h3>

<?php echo trim($data['view::_shop/branch/one/cart']); ?>
<script>
	$('[data-action="input-plus"]').click(function(e) {
		e.preventDefault();
		input = $(this).parent().parent().children('input[data-action="amount"]');
		n = parseFloat(input.val()) + parseFloat($(this).data('value'));
		if(n >= 0){
			input.val(n);
			input.change();
		}
	});
</script>
