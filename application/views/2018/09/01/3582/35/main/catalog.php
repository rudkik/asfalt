<link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/base/catalog.css">
<style>
    body {
        background-repeat:no-repeat;
        -webkit-background-size: 100%;
        background-size: 100%;
        background-position: right top;
        background-image: url('<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/page/bg.jpg');
    }
    @media screen and (max-width: 767px) {
        body {
            background-size: 140% auto;
            -webkit-background-size: 140% auto;
        }
    }
</style>
<main class="catalog">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h3 class="main__page__news__title section_title">Каталог техники</h3>
			</div>
			<div class="col-12">
				<div class="catalog__wrap">
					<div class="row">
						<div class="col-12" style="z-index: 3;">
							<div class="catalog__switch__wrap" id="catalog_switch">
								<?php echo trim($siteData->globalDatas['view::View_Shop_Goods\catalog-rubrikatciya']); ?>
							</div>
						</div>
					</div>
					<div class="row" id="catalog_list">
						<?php echo trim($siteData->globalDatas['view::View_Shop_Goods\catalog-produktciya']); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>