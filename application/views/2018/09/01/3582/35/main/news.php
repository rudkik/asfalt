<link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/base/news.css">
<main class="news">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-auto">
                <div class="news__title__wrap">
                    <h3 class="news__title section_title">Новости компании</h3>
                    <h4 class="news__subtitle">В индустрии</h4>
                </div>
            </div>
            <div class="col no-gutters">
                <div class="news__years">
                    <?php echo trim($siteData->globalDatas['view::View_Shop_News\news-goda-novostei']); ?>
                </div>
                <div class="row no-gutters gutters-lg" id="news_container">
                    <?php echo trim($siteData->globalDatas['view::View_Shop_News\news-novosti']); ?>
                </div>
            </div>
        </div>
    </div>
</main>