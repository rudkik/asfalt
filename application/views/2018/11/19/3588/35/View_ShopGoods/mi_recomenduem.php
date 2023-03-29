<?php if (count($data['view::View_ShopGood\catalog_tovary-kategorii']->childs) > 0){?>
<h2>Мы рекомендуем купить в <?php echo Func::getStringCaseRus($siteData->city->getName(), 5); ?></h2>
<div class="row products products-row-one">
<?php 
 foreach ($data['view::View_ShopGood\catalog_tovary-kategorii']->childs as $value){
echo $value->str;
}
?>
</div>
<?php }?>