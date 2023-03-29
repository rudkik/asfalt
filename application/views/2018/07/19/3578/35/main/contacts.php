<header class="header-blog-slider"></header>
<header class="header-blogs">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1>Наши контакты</h1>
                <div style="height: 600px"><?php echo trim($siteData->globalDatas['view::View_Shop_Address\contacts-karta']); ?></div>
            </div>
            <div class="col-md-4">
                <div class="box-catalogs">
                    <div class="name">Телефоны</div>
                    <ul class="catalog">
                        <?php echo trim($siteData->globalDatas['view::View_Shop_AddressContacts\contacts-kontakty']); ?>
                    </ul>
                </div>
                <div class="box-catalogs">
                    <div class="name">Адрес</div>
                    <ul class="catalog">
                        <?php echo trim($siteData->globalDatas['view::View_Shop_Address\contacts-adres']); ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>