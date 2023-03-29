<link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/base/about.css">
<style>
    body {
        background-repeat:no-repeat;
        -webkit-background-size: 100%;
        background-size: 100%;
        background-position: right top;
        background-image: url('<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/page/bg_sky.jpg');
    }
    @media screen and (max-width: 767px) {
        body {
            background-size: 140% auto;
            -webkit-background-size: 140% auto;
        }
    }
</style>
<main class="about">
	<div class="container">
		<?php echo trim($siteData->globalDatas['view::View_Shop_New\addition-statya']); ?>
	</div>
</main>