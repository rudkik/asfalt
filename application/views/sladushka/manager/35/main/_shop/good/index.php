<h3>Продукция</h3>
<div class="row">
    <div class="col-md-12">
        <form class="box-find" action="/manager/shopgood/index" method="get">
            <div class="input-group">
                <input name="name" class="form-control" placeholder="Название">
                <div class="input-group-btn">
                    <input name="type" value="51657" style="display: none">
                    <button type="submit" class="btn btn-success">Поиск</button>
                </div>
            </div>
        </form>
    </div>
</div>
<ul class="products-list product-list-in-box">
	<?php echo trim($data['view::_shop/good/list/index']); ?>
</ul>
<script>
	$('[data-action="input-plus"]').click(function(e) {
		e.preventDefault();
		input = $(this).parent().parent().children('input[data-action="amount"]');
		n = parseFloat(input.val()) + parseFloat($(this).data('value'));
		if(n >= 0){
			input.val(n);
		}
	});
</script>
