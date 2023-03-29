<div class="container">
    <div class="row justify-content-center no-gutters">
        <div class="col-sm-10">
            <nav class="breadcrumbs">
                <span class="breadcrumbs__link">Мой аккаунт</span>
            </nav>
        </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center no-gutters">
        <div class="col-md-10">
            <div class="alert">
                <button class="alert__close"></button>
                <span class="text--title">
                    Приветствуем вас на сайте ADS!
                </span>
                <span class="text--medium">
                    Мы предлагаем вам самые быстрые, продуманные и удобные решения для получения посылок из интернет-магазинов США и отправки их по всему миру.
                    <span class="color--warning">
                        После покупки в интернет магазине обязательно зарегистрируйте посылку в разделе “Ожидаемые”.
                    </span>
              </span>
            </div>
        </div>
    </div>
</div>
<main>
    <div class="container">
        <div class="row justify-content-center justify-content-md-start no-gutters">
            <?php echo trim($siteData->globalDatas['view::View_Ads_Shop_Client\account-klient']); ?>
        </div>
        <div class="row justify-content-center justify-content-md-start no-gutters">
            <div class="offset-md-1 col-sm-auto offset-lg-6 col-lg-5 col-sm-auto">
                <div class="link__block">
                    <a href="#" class="link" data-popup="popup" data-popupfor="address">Как указать адрес для доставки?</a>
                    <a href="#" class="link" data-popup="popup" data-popupfor="restrictions" style="display: none">Ограничения и запреты</a>
                </div>
            </div>
        </div>
    </div>
    <div data-popupid="address" class="popup">
        <div class="title--block">
            Как указать адрес для доставки?
        </div>
        <div class="text--bold text--title">
            Как правильно указать мой американский адрес на сайте магазина?
        </div>
        <div class="text--medium">
            Адрес находится в вашем профиле на сайте ADS<br>
            На сайтах магазинов он заполняется следующим образом:
        </div>
        <table class="table--dubble table--first-main">
            <tr class="table--dubble__row">
                <td class="table--dubble__col">Первая строка</td>
                <td class="table--dubble__col">Ваши имя и фамилия (латиницей)</td>
            </tr>
            <tr class="table--dubble__row">
                <td class="table--dubble__col">Адрес (первая строка)</td>
                <td class="table--dubble__col">1263 Old Coochs Bridge Rd</td>
            </tr>
            <tr class="table--dubble__row">
                <td class="table--dubble__col">Адрес (вторая строка)</td>
                <td class="table--dubble__col">Ste.IPL-### ( ### – это уникальный номер, который вы видите в своем аккаунте. По нему мы узнаем, что это ваша посылка).</td>
            </tr>
            <tr class="table--dubble__row">
                <td class="table--dubble__col">Город</td>
                <td class="table--dubble__col">Newark</td>
            </tr>
            <tr class="table--dubble__row">
                <td class="table--dubble__col">Область</td>
                <td class="table--dubble__col">DE (Delaware)</td>
            </tr>
            <tr class="table--dubble__row">
                <td class="table--dubble__col">Индекс (Zip Code)</td>
                <td class="table--dubble__col">19713</td>
            </tr>
            <tr class="table--dubble__row">
                <td class="table--dubble__col">Телефон</td>
                <td class="table--dubble__col">+1 (302) 273-2981</td>
            </tr>
        </table>
    </div>
</main>
<script>
    function initChangeMailAddresses() {
        var links = document.getElementsByClassName('mail__address');
        var blocks = document.getElementsByClassName('mail__block');
        changeMail(false, blocks, links, links[0]);
        for (var i = 0; i < links.length; i++) {
            links[i].addEventListener('click', function(e) {
                changeMail(e, blocks, links);
            });
        }
    }
    function changeMail(e, blocks, links, init) {
        var currentLink;
        var currentMailId;
        if (e) {
            e.preventDefault();
            currentLink = e.target;
        } else { currentLink = init; }
        currentMailId = currentLink.href.split('#')[1];
        if (blocks.length === links.length) {
            for (var i = 0; i < blocks.length; i++) {
                blocks[i].classList.remove('current');
                links[i].classList.remove('current');
            }
        } else {
            for (var j = 0; j < blocks.length; j++) { blocks[j].classList.remove('current'); }
            for (var k = 0; k < links.length; k++) { links[k].classList.remove('current'); }
        }
        currentLink.classList.add('current');
        document.getElementById(currentMailId).classList.add('current');
    }
    initChangeMailAddresses();
</script>