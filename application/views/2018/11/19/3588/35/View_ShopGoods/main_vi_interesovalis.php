<?php if (count($data['view::View_ShopGood\catalog_tovary-kategorii']->childs) > 0){?>
<h2>Вы интересовались</h2>
<div class="row products products-row-one">
	<?php 
	 foreach ($data['view::View_ShopGood\catalog_tovary-kategorii']->childs as $value){
	echo $value->str;
	}
	?>
</div>
<?php }?>