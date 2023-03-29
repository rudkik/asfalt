<div class="container-fluid width_u">
    <div class="center_block">
        <div class="text_block">
            <h1 itemprop="headline" class="objectTitle2">Карта сайта</h1>
            <div class="sitemap">
                <ul>
                    <li class="first">
                        <a href="<?php echo $siteData->urlBasicLanguage; ?>/main" title="Поставка и обслуживание мясоперерабатывающего оборудования в странах Центральной Азии и Ближнего Востока">Поставка и обслуживание мясоперерабатывающего оборудования в странах Центральной Азии и Ближнего Востока</a>
                    </li>
                    <li>
                        <a href="<?php echo $siteData->urlBasicLanguage; ?>/about-us" title="О компании">О компании</a>
                        <ul>
                            <li class="first">
                                <a href="<?php echo $siteData->urlBasicLanguage; ?>/about-us/history" title="История компании">История компании</a>
                            </li>
                            <li>
                                <a href="<?php echo $siteData->urlBasicLanguage; ?>/about-us/news/" title="Новости">Новости</a>
                            </li>
                            <li>
                                <a href="<?php echo $siteData->urlBasicLanguage; ?>/about-us/partners/" title="ПАРТНЕРЫ">ПАРТНЕРЫ</a>
                                <ul>
                                    <?php echo trim($siteData->globalDatas['view::View_Shop_News\-sitemapforsite-partnery']); ?>
                                </ul>
                            </li>
                            <li class="last">
                                <a href="<?php echo $siteData->urlBasicLanguage; ?>/about-us/career" title="Вакансии">Вакансии</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?php echo $siteData->urlBasicLanguage; ?>/events/events-and-exhibitions" title="Выставки">Выставки</a>
                        <ul>
                            <?php echo trim($siteData->globalDatas['view::View_Shop_News\-sitemapforsite-vystavki']); ?>
                        </ul>
                    </li>
                    <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\-sitemapforsite-rubriki']); ?>
                    <li class="last">
                        <a href="<?php echo $siteData->urlBasicLanguage; ?>/contact-us" title="Контакты" >Контакты</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>