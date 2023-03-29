<header class="header-direction-info">
    <div class="container">
        <h2>У нас выгодные цены на грузоперевозки <br><span>по Казахстану</span></h2>
        <p class="box-info">от <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/money.png"> 15 тенге за 1 кг</p>
        <div class="text-center">
            <img class="line" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line-two.png">
        </div>
        <div class="box-text text-center">
            <p>Все потому, что у нашей транспортной компании есть собственный автопарк – машины грузоподъемностью 20 т с объемом кузова 86 м³,</p>
            <p>и железнодорожные тупики в Алматы, Атырау, Актау, Актобе и Уральске. Заключен договор с крупным авиаперевозчиком EurAsianTransit.</p>
        </div>
        <p class="box-title">Почему стоит выбрать именно нас?</p>
        <div class="row box-why">
            <div class="col-md-3">
                <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/why/w-1.png">
                <p class="name">Страхование CMR</p>
                <p class="info">Предполагающее страхование ответственности перевозчика. Благодаря этому вы можете не волноваться о вашем имуществе</p>
            </div>
            <div class="col-md-3">
                <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/why/w-2.png">
                <p class="name">
                <p class="name">Весь спектр услуг</p>
                <p class="info">Перевозки внутри страны и внутри Европы, таможенно-брокерские и транспортно-экспедиционные услуги, консолидация</p>
            </div>
            <div class="col-md-3">
                <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/why/w-3.png">
                <p class="name">ADR комплекты</p>
                <p class="info">Они позволяют нам перевозить опасные грузы всех без исключения классов. За годы деятельности данная разновидность перевозок стала фирменной специализацией</p>
            </div>
            <div class="col-md-3">
                <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/why/w-4.png">
                <p class="name">Собственный автопарк</p>
                <p class="info">Мы осуществляем доставку по доступным ценам, в самые короткие сроки, контролируем перемещение груза на всех без исключения этапах</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <a href="<?php echo Arr::path($data->values['options'], 'contract.file', ''); ?>" title="Договор на перевозку грузов" class="margin-b-30 btn btn-flat btn-orange btn-big pull-right"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/contract.png"> Договор на перевозку груза</a>
            </div>
            <div class="col-md-6">
                <a href="<?php echo Arr::path($data->values['options'], 'bill.file', ''); ?>" title="Транспортная заявка" class="btn btn-flat btn-white btn-big pull-left"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/bill.png"> Транспортная заявка</a>
            </div>
        </div>
    </div>
</header>