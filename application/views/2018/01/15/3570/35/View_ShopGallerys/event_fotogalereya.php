<?php if (count($data['view::View_ShopGallery\event_fotogalereya']) > 0){?>
<section class="tz-portfolio-wrapper">
    <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
        <div class="tz-gallary">
            <h3>
                <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/images/check.png" alt="Images"><br>
                <a> Гарелея </a>
            </h3>
            <div class="tz-gallery-images">
                <button class="tz-cources-prev">
                    <i class="fa fa-angle-left"></i>
                </button>
                <button class="tz-cources-next">
                    <i class="fa fa-angle-right"></i>
                </button>
                <ul class="tz-gallery-wrapper">
					<?php 
					 foreach ($data['view::View_ShopGallery\event_fotogalereya']->childs as $value){
					echo $value->str;
					}
					?>
                </ul>
            </div>
        </div>
    </div>
</section>
<?php }?>