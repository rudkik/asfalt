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
    .page__header__links__list__item:after, .page__header__links__list__item:before {
        background-color: #0090C0;
    }
    .page__header__links__list__item:hover {
        color: #0090C0;
    }
</style>
<main class="about">
	<div class="container">
		<?php echo trim($siteData->globalDatas['view::View_Shop_News\about-statya']); ?>
	</div>
</main>