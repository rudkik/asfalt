<style><?php echo file_get_contents($siteData->urlBasic.'/css/'.$siteData->shopShablonPath.'/base/main_page.css'); ?></style>
<style>
	.main__page__catalog__slider__slide__block__description {
		width: 350px;
		max-width: 100%;
	}
	@media screen and (min-width: 768px) {
		.main__page__catalog__slider__slide__block__right__mob {
			display: none;
		}
	}
	@media screen and (max-width: 767px) {
		.main__page__catalog__slider__slide__block__right__mob .main__page__catalog__slider__slide__block__big_img {
			display: block;
		}
		.main__page__catalog__slider__slide__block__right__mob .main__page__catalog__slider__slide__block__big_img img {
			 -webkit-transform: scale(1); 
			 transform: scale(1); 
			 -webkit-transform-origin: 50% 50%; 
			 transform-origin: 50% 50%; 
		}
	}
</style>
<main class="main__page">
	<section class="main__page__title">
		<div class="container">
			<div class="row">
				<div class="col main__page__title__wrap">
					<h1>
						Винтовые компрессоры и генераторы европейского качества
					</h1>
					<h3>
						Прямые поставки от завода изготовителя
					</h3>
				</div>
			</div>
		</div>
	</section>
	<section class="main__page__catalog__slider">
		<div id="main__page__slider" class="main__page__catalog__slider__wrap">
		</div>
		<div id="main__page__catalog__slider__description" class="main__page__catalog__slider__description">
		</div>
	</section>
	<section class="main__page__news">
		<div class="container relative">
			<div id="main__page__news" class="row">
				<div class="col-12">
					<h3 class="main__page__news__title section_title">Новости</h3>
				</div>
				<?php echo trim($siteData->globalDatas['view::View_Shop_News\-novosti']); ?>
			</div>
			<a class="btn btn--alt-p main__page__news__more_news invert" href="<?php echo $siteData->urlBasic;?>/news">
				Все новости
				<img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/page/more_info.png" alt="Все новости">
			</a>
		</div>
	</section>
	<section class="main__page__contacts">
        <?php echo trim($siteData->globalDatas['view::View_Shop_Address\-adres']); ?>
	</section>
</main>
<style>
	<?php echo file_get_contents('https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');  ?>
</style>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/main.js" defer></script>
<script>
    var appStart = function () {
        if (typeof window.App === 'undefined') {
            setTimeout(appStart, 100)
        } else {
            var app = new App.Main('<?php echo $siteData->globalDatas['view::View_Shop_Goods\-produktciya']; ?>');
        }
    }
    appStart();
</script>
