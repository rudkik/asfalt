<div class="header header-menu">
    <div class="container">
        <nav class="navbar navbar-default navbar-static" role="navigation" id="menu-top">
            <div class="navbar-header">
                <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#menu-top .bs-example-js-navbar-collapse">
                    <span class="sr-only">Переключить навигацию</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="navbar-collapse bs-example-js-navbar-collapse collapse padding-0px" aria-expanded="false">
                <ul class="nav navbar-nav">
                    <?php echo trim($data['view::_shop/rubric/list/menu']); ?>
                </ul>
            </div>
        </nav>
    </div>
</div>
<div class="header header-slider">
    <div class="container">
        <div class="box-sliders">
            <div id="header-slider-photo" class="carousel slide">
                <ol class="carousel-indicators" hidden="">
                    <li data-target="#header-slider-photo" data-slide-to="0" class="active"></li>                    </ol>
                <div class="carousel-inner">
                    <div class="item active">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box-text">
                                </div>
                                <img src="/img/1/2021/06/07/4049/15768.gif" class="img-responsive width-100" alt="Баннер 1">
                            </div>
                        </div>
                    </div>                    </div>
            </div>
        </div>
    </div>
</div>
<div class="header header-advantages">
    <div class="container">
        <div class="advantages">
            <div class="box-advantages">
                <div class="row">
                    <div class="col-md-4">
                        <img src="/img/1/2021/06/07/4049/15774.png" class="img-responsive icon" alt="Широкий ассортимент">
                        <div class="box-text">
                            <div class="title">Широкий ассортимент</div>
                            <div class="text">Продукты на любой вкус</div>
                        </div>
                        <div class="line"></div>
                    </div><div class="col-md-4">
                        <img src="/img/1/2021/06/07/4049/15772.png" class="img-responsive icon" alt="Лучшие цены">
                        <div class="box-text">
                            <div class="title">Лучшие цены</div>
                            <div class="text">Самые выгодные предложения</div>
                        </div>
                        <div class="line"></div>
                    </div><div class="col-md-4">
                        <img src="/img/1/2021/06/07/4049/15770.png" class="img-responsive icon" alt="Проверенные поставщики">
                        <div class="box-text">
                            <div class="title">Проверенные поставщики</div>
                            <div class="text">Дистрибьютеры проверенные временем</div>
                        </div>
                        <div class="line"></div>
                    </div>                    </div>
            </div>
        </div>
    </div>
</div>
<div class="header header-products padding-top-25" >
    <div class="container">
        <h2>Мы рекомендуем купить в Алматы</h2>
        <div class="row products products-row-two">
            <?php echo trim($data['view::_shop/product/list/recommend']); ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="find-add"><a href="/trade/catalog/index">Посмотреть еще</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="header header-products header-blue padding-top-25" >
    <div class="container">
        <h2>Актуальное сейчас в Алматы</h2>
        <div class="row products products-row-two">
            <?php echo trim($data['view::_shop/product/list/popular']); ?>
        </div>
        <h2>Лучшие цены в Алматы</h2>
        <div class="row products products-row-two">
            <?php echo trim($data['view::_shop/product/list/price']); ?>
        </div>
    </div>
</div>
<div class="header header-advantages-bottom">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <object type="image/svg+xml" data="/files/77/2021/08/03/1458829/15780.svg" class="img-svg"></object>
                <div class="title">Бонусы с каждой покупки</div>
                <div class="text"></div>
            </div><div class="col-md-4">
                <object type="image/svg+xml" data="/files/77/2021/08/03/1458829/15778.svg" class="img-svg"></object>
                <div class="title">Заказ продуктов, не выходя из дома</div>
                <div class="text"></div>
            </div><div class="col-md-4">
                <object type="image/svg+xml" data="/files/77/2021/08/03/1458829/15776.svg" class="img-svg"></object>
                <div class="title">Доставка до двери</div>
                <div class="text"></div>
            </div>        </div>
    </div>
</div>
<div class="header header-find-rubrics">
    <div class="container">
        <h2>Сейчас ищут в Алматы</h2>
        <div class="row rubrics">
            <?php echo trim($data['view::_shop/rubric/list/common']); ?>
        </div>
    </div>
</div>