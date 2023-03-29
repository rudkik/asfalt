<link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/base/news.css">
<main class="news">
	<div class="container">
		<div class="row">
			<div class="col-12 col-lg-auto">
				<div class="news__title__wrap">
					<h3 class="news__title section_title">Новости компании</h3>
					<h4 class="news__subtitle">В индустрии</h4>
					<a class="news__back btn left btn--alt-p main__page__news__more_news invert" href="<?php echo $siteData->urlBasic;?>/news">
						<img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/page/more_info.png" alt="Все новости">
						К списку новостей
					</a>
				</div>
			</div>
			<div class="col no-gutters">
				<div class="row no-gutters gutters-lg">
					<div class="col-12">
						<?php echo trim($siteData->globalDatas['view::View_Shop_New\article-statya']); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>