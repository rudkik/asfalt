<a href="tel:<?php echo $data->values['name']; ?>" type="tel">
	<?php echo $data->values['name']; ?>
	<a target="_blank"  href="https://wa.me/<?php echo trim(str_replace('+', '', str_replace(' ', '', str_replace('(', '', str_replace(')', '', $data->values['name']))))); ?>" class="page__header__links__tel__wt">
    <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/icons/wt.png" alt="">
  </a>
</a>