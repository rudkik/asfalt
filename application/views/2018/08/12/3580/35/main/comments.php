<main id="listar-main" class="listar-main listar-haslayout">
    <div id="listar-twocolumns" class="listar-twocolumns">
        <div class="listar-themepost listar-post listar-detail listar-postdetail">
            <figure class="listar-featuredimg">
                <img src="<?php echo $siteData->urlBasic.'/css/'.$siteData->shopShablonPath.'/images/parallax/bgparallax-110.jpg'; ?>" alt="Отзывы">
                <figcaption>
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="listar-postcontent">
                                    <h1>Отзывы</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </figcaption>
            </figure>
        </div>
    </div>
</main>

<main id="listar-main" class="listar-main listar-haslayout">
    <section class="listar-sectionspace listar-haslayout">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="listar-sectionhead">
                        <div class="listar-sectiontitle">
                            <h2>Отзывы клиентов</h2>
                        </div>
                        <div class="listar-description">
                            <p>Мы ценим мнение каждого нашего клиента</p>
                        </div>
                    </div>
                </div>
                <div id="listar-testimonialslidervthree" class="listar-threecolumnsslider listar-testimonials listar-testimonialsvthree owl-carousel">
                    <?php echo trim($siteData->globalDatas['view::View_Shop_Comments\-otzyvy']); ?>
                </div>
            </div>
        </div>
    </section>
</main>