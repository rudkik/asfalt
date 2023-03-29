<main>
    <?php echo trim($siteData->globalDatas['view::View_Shop_News\-pervaya-kartinka-na-glavnoi']); ?>
    <section class="section--2">
        <div class="container relative">
            <div class="scrollme scrollme--abs-center">
                <div class="scrollme__inner">
                    <span>Крути вниз</span>
                    <span class="scrollme__line"></span>
                </div>
            </div>
            <div class="section--2__title">
                <div class="row no-gutters align-items-center">
                    <div class="col-md-1 offset-md-1">
                        <div class="section-number">
                            02
                        </div>
                    </div>
                    <div class="col-12 col-md-8 d-flex justify-content-center">
                        <h2 id="how-it-works" class="title">
                            <span class="title__row">
                              Как работает ADS?
                            </span>
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-xl-10">
                    <div class="row justify-content-center">
						<?php echo trim($siteData->globalDatas['view::View_Shop_News\-kak-eto-rabotaet']); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section--3" id="form_new_address">
        <div class="container relative">
            <div class="row justify-content-end">
                <div class="col-12 col-lg-6">
                    <div class="section--3__block">
                        <h2 class="title title--mob-center d-none d-lg-block">
                            <span class="title__row">
                              Получите свой личный 
                              <span class="section--3__num">
                                <div class="section-number">
                                  03
                                </div>
                              </span>
                            </span>
                            <span class="title__row">
                              адрес в США прямо сейчас
                            </span>
                        </h2>
                        <h2 class="title d-lg-none">
                            <span class="title__row">
                              Получите свой
                            </span>
                            <span class="title__row">
                              личный адрес в США
                            </span>
                            <span class="title__row">
                              прямо сейчас
                            </span>
                        </h2>
                        <form id="form-save" action="<?php echo $siteData->urlBasic;?>/adsgs/user_registration" class="form" method="post">
                            <span class="form__title text--title--big">
                              Зарегистрируйтесь для получения адреса
                            </span>
                            <input id="first_name" data-action="english" type="text" class="field" name="user[first_name]" placeholder="Ваше имя*">
                            <input id="last_name" data-action="english" type="text" class="field" name="user[last_name]" placeholder="Ваша фалимия*">
                            <input id="email" type="text" class="field" name="user[email]" placeholder="Ваш e-mail*">
                            <input class="field" type="text" name="captcha" placeholder="Решите пример <?php echo Helpers_Captcha::getCaptchaMathematicalExample(); ?>">
                            <input id="form-save-button" type="button" class="btn" value="Регистрация">
                        </form>
                        <script>
                            $('#form-save-button').on('click', function(e){
                                e.preventDefault();
                                var $that = $('#form-save'),
                                    formData = new FormData($that.get(0)); // создаем новый экземпляр объекта и передаем ему нашу форму (*)

                                var messagePanel = $('#message-error');

                                var isOK = true;

                                el = $that.find('[id="first_name"]');
                                var s = el.val();
                                $that.find('[data="'+el.attr('id')+'"]').remove();
                                if ((s == '') || (!(/^[a-zA-Z]+$/.test(s)))){
                                    el.after('<span data="'+el.attr('id')+'" class="text--title alert--error">Заполните "Ваше имя" латинскими буквами</span>');
                                    isOK = false;
                                }

                                el = $that.find('[id="last_name"]');
                                var s = el.val();
                                $that.find('[data="'+el.attr('id')+'"]').remove();
                                if ((s == '') || (!(/^[a-zA-Z]+$/.test(s)))){
                                    el.after('<span data="'+el.attr('id')+'" class="text--title alert--error">Заполните "Вашa фалимия" латинскими буквами</span>');
                                    isOK = false;
                                }

                                el = $that.find('[id="email"]');
                                var s = el.val();
                                $that.find('[data="'+el.attr('id')+'"]').remove();
                                if ((s == '') || (!(/^[\.a-zA-Z0-9_-]+@[a-zA-Z0-9-]+\.[a-zA-Z]{2,6}$/i.test(s)))){
                                    el.after('<span data="'+el.attr('id')+'" class="text--title alert--error">Введите корректный "E-mail"</span>');
                                    isOK = false;
                                }

                                el = $that.find('[name="captcha"]');
                                var s = el.val();
                                $that.find('[data="'+el.attr('id')+'"]').remove();
                                if (s == ''){
                                    el.after('<span data="'+el.attr('id')+'" class="text--title alert--error">Решите пример</span>');
                                    isOK = false;
                                }

                                /*el = $that.find('[id="g-recaptcha-response"]');
                                var s = el.val();
                                $that.find('[data="'+el.attr('id')+'"]').remove();
                                if (s == ''){
                                    $that.find('div[class="g-recaptcha"]').after('<span data="'+el.attr('id')+'" class="text--title alert--error">Установите галочку "Я не робот"</span>');
                                    isOK = false;
                                }*/
                                if (isOK){
                                    var url = $(this).attr('action');

                                    jQuery.ajax({
                                        url: url,
                                        data: formData,
                                        type: "POST",
                                        contentType: false, // важно - убираем форматирование данных по умолчанию
                                        processData: false, // важно - убираем преобразование строк по умолчанию
                                        success: function (data) {
                                            var obj = jQuery.parseJSON($.trim(data));
                                            if(obj.error == 0){
                                                window.location.href = '/user/login?password='+obj.password+'&email='+obj.email+'&url=/account/profile/edit';
                                            }else{
                                                if (obj.error_type == 'email'){
                                                    var el = $that.find('[id="email"]');
                                                    el.after('<span data="'+el.attr('id')+'" class="text--title alert--error">Такой "E-mail" уже зарегистрирован</span>');
                                                }else{
                                                    if (obj.error_type == 'captcha'){
                                                        var el = $that.find('[name="captcha"]');
                                                        el.after('<span data="'+el.attr('id')+'" class="text--title alert--error">Решите пример правильно</span>');
                                                    }
                                                }
                                            }
                                        },
                                        error: function (data) {
                                            console.log(data.responseText);
                                        }
                                    });
                                }

                                return false;
                            });
                        </script>
                    </div>
                </div>
            </div>
            <div class="scrollme scrollme--abs-center scrollme--right">
                <div class="scrollme__inner">
                    <span>Крути вниз</span>
                    <span class="scrollme__line"></span>
                </div>
            </div>
        </div>
    </section>
    <section class="section--4">
        <div class="container relative">
            <div class="scrollme scrollme--abs-center">
                <div class="scrollme__inner">
                    <span>Крути вниз</span>
                    <span class="scrollme__line"></span>
                </div>
            </div>
            <div class="row relative no-gutters">
                <div class="col-12 col-lg-11 offset-lg-1 section--4__title">
                    <div class="section-number">
                        04
                    </div>
                    <h2 class="title">
                        <span class="title__row">
                          Почему ADS?
                        </span>
                    </h2>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-12 col-lg-6 offset-lg-1">
                    <div class="row advantage__wrap">                        
						<?php echo trim($siteData->globalDatas['view::View_Shop_News\-pochemu-ads']); ?>
                    </div>
                </div>
                <div class="col-12 col-lg-5 d-none d-md-block">
                    <figure class="section--4__img">
                        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/dist/img/main/section-4/woman.jpg" alt="Woman, Advantage">
                    </figure>
                </div>
            </div>
        </div>
    </section>
    <section class="section--5" id="calc">
        <div class="container relative">
            <div>
                <div class="section--5__title row no-gutters align-items-center">
                    <div class="col-md-1 offset-md-1">
                        <div class="section-number section-number--invert">
                            05
                        </div>
                    </div>
                    <div class="col-12 col-md-8 d-flex justify-content-center">
                        <h2 id="price" class="title">
                            <span class="title__row">
                              Сколько это стоит?
                            </span>
                        </h2>
                    </div>
                </div>
            </div>
            <!-- 
            <form action="#calc" class="row align-items-center section--5__form flex-column flex-md-row flex-md-wrap">
                <div class="col-md-6 col-lg-auto">
                    <div class="field__wrap">
                        <input type="text" class="field field--nom field--invert field--little" placeholder="Вес">
                        <label for="" class="field__extra">кг</label>
                    </div>
                </div>
                <div class="col-md-6 col-lg">
                    <div class="dropdown">
                        <select class="dropdown__current__wrap">
                            <option disabled selected>Страна</option>
                            <option value="Lorem ipsum." class="dropdown__item">Lorem ipsum.</option>
                            <option value="Lorem ipsum." class="dropdown__item">Lorem ipsum.</option>
                            <option value="Lorem ipsum." class="dropdown__item">Lorem ipsum.</option>
                            <option value="Lorem ipsum." class="dropdown__item">Lorem ipsum.</option>
                            <option value="Lorem ipsum." class="dropdown__item">Lorem ipsum.</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 col-lg">
                    <div class="dropdown">
                        <select class="dropdown__current__wrap">
                            <option disabled selected>Город</option>
                            <option value="Lorem ipsum." class="dropdown__item">Lorem ipsum.</option>
                            <option value="Lorem ipsum." class="dropdown__item">Lorem ipsum.</option>
                            <option value="Lorem ipsum." class="dropdown__item">Lorem ipsum.</option>
                            <option value="Lorem ipsum." class="dropdown__item">Lorem ipsum.</option>
                            <option value="Lorem ipsum." class="dropdown__item">Lorem ipsum.</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 col-lg-auto">
                    <input type="submit" class="btn btn--field-sz" value="Рассчитать">
                </div>
            </form>
            -->
            <div class="row align-items-center section--5__calc--block">
                <div class="col-12">
                    <div class="row no-gutters align-items-center section--5__calc section--5__comp">
                        <div class="col-sm-10 offset-sm-1 section--5__comp--desc">
                            Сервис ADSGS – наша гордость, нам удалось автоматизировать склад и снизить срок доставки, сохранив доступную цену. Удобный пункт самовывоза в г. Алматы и доставка по городу и по регионам РК.
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row no-gutters section--5__calc" style="padding-bottom: 30px;">
                        <div class="col-12 col-md-4">
                            <div class="text--center section--5__block">
                                <p class="section--5__block--row">
                                    <span>
                                      Примерное время доставки
                                    </span>
                                    <span>
                                      4-10 дней
                                    </span>
                                </p>
                                <p class="section--5__block--row">
                                    <span>
                                      Таможенный лимит
                                    </span>
                                    <span>
                                      1000 евро и 31 кг на одного получателя в календарный месяц.
                                    </span>
                                </p>
                            </div>

                        </div>
                        <div class="col-12 col-md-7">

                            <div class="table__wrap">
                                <table class="table table--invert table--full">
                                    <tbody class="table__body">
                                    <tr class="table__row">
                                        <td class="table__col">Стоимость доставки 1 кг</td>
                                        <td class="table__col">13$</td>
                                    </tr>
                                    <tr class="table__row">
                                        <td class="table__col">Срок доставки</td>
                                        <td class="table__col">от 4 до 10 дней</td>
                                    </tr>
                                    <tr class="table__row">
                                        <td class="table__col">Хранение на складе (7 дней)</td>
                                        <td class="table__col">0 тг</td>
                                    </tr>
                                    <tr class="table__row">
                                        <td class="table__col">Объединение посылок</td>
                                        <td class="table__col">0 тг</td>
                                    </tr>
                                    <tr class="table__row">
                                        <td class="table__col">Упаковка</td>
                                        <td class="table__col">0 тг</td>
                                    </tr>
                                    <tr class="table__row">
                                        <td class="table__col">Доставка курьером по г. Алматы</td>
                                        <td class="table__col">800 тг</td>
                                    </tr>
                                    <tr class="table__row">
                                        <td class="table__col">Доставка по городам РК</td>
                                        <td class="table__col">от 1500 тг</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- 
                            <div class="link__block">
                                <a href="#" class="link link--smb link__main link__little">Ссылка на расчет</a>
                                <a href="#" class="link link--smb link__main link__little">Сколько весят товары?</a>
                            </div>
                             -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php echo trim($siteData->globalDatas['view::View_Shop_News\-nash-logisticheskii-partner']); ?>
</main>