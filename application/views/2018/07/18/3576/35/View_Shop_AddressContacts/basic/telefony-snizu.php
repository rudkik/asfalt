<div class="contact">
    <div class="media-left">
        <img class="" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/phone-b.png">
    </div>
    <div class="media-body">
        <?php 
		 foreach ($data['view::View_Shop_AddressContact\basic\telefony-snizu']->childs as $value){
		echo $value->str;
		}
		?>
    </div>
</div>