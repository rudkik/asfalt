<?php if($data->id != 999999999){ ?>
    <section class="tz-banner tz-banner-style2">
        <div class="tz-banner-style2">
            <div class="tz-slider-banner">
                <?php echo trim($siteData->globalDatas['view::View_ShopGallerys\event_slaider']); ?>
            </div>
        </div>
    </section>
    
    <?php if (Arr::path($data->values['options'], 'is_menu_webinar', '0') == 1){ ?>
        <section class="tz-portfolio-wrapper">
            <div class="row">
                <?php echo trim($siteData->globalDatas['view::View_ShopGallerys\event_logo']); ?>
                <div class="col-md-12">
                    <span class="bigheader-top">Вебинар</span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <span class="webinar-name"><?php echo $data->values['name']; ?></span>
                </div>
            </div>
        </section>
    <?php } ?>
    <section class="tz-introduce-univesity">
        <?php if (Arr::path($data->values['options'], 'is_menu', '0') == 1){ ?>
            <div class="tz-cource-services tz-cource-services-style-2">
                <ul>
                    <li>
                        <div class="tz-background-color-1">
                            <a href="<?php echo $siteData->urlBasic;?>/event/info?id=<?php echo Request_RequestParams::getParamInt('id'); ?>" target="_blank"><i class="tz-color-1 fa fa-info"></i></a>
                            <span><a href="<?php echo $siteData->urlBasic;?>/event/info?id=<?php echo Request_RequestParams::getParamInt('id'); ?>" target="_blank">Основная информация</a></span>
                        </div>
                    </li>
                    <li>
                        <div class="tz-background-color-2">
                            <a href="<?php echo $siteData->urlBasic;?>/event/registration?id=<?php echo Request_RequestParams::getParamInt('id'); ?>" target="_blank"><i class="tz-color-2 fa fa-file-text-o"></i></a>
                            <span><a href="<?php echo $siteData->urlBasic;?>/event/registration?id=<?php echo Request_RequestParams::getParamInt('id'); ?>" target="_blank">Онлайн регистрация</a></span>
                        </div>
                    </li>
                    <li>
                        <div class="tz-background-color-3">
                            <a href="<?php echo $siteData->urlBasic;?>/event/address?id=<?php echo Request_RequestParams::getParamInt('id'); ?>" target="_blank"><i class="tz-color-3 fa fa-map-marker"></i></a>
                            <span><a href="<?php echo $siteData->urlBasic;?>/event/address?id=<?php echo Request_RequestParams::getParamInt('id'); ?>" target="_blank">Место проведения</a></span>
                        </div>
                    </li>
                    <li>
                        <div class="tz-background-color-4">
                            <a href="<?php echo $siteData->urlBasic;?>/event/hotels?id=<?php echo Request_RequestParams::getParamInt('id'); ?>" target="_blank"><i class="tz-color-4 fa fa-bed"></i></a>
                            <span><a href="<?php echo $siteData->urlBasic;?>/event/hotels?id=<?php echo Request_RequestParams::getParamInt('id'); ?>" target="_blank">Проживание</a></span>
                        </div>
                    </li>
                    <li>
                        <div class="tz-background-color-4">
                            <a href="<?php echo $siteData->urlBasic;?>/event/programs?id=<?php echo Request_RequestParams::getParamInt('id'); ?>" target="_blank"><i class="tz-color-4 fa fa-clock-o"></i></a>
                            <span><a href="<?php echo $siteData->urlBasic;?>/event/programs?id=<?php echo Request_RequestParams::getParamInt('id'); ?>" target="_blank">Программа</a></span>
                        </div>
                    </li>
                    <li>
                        <div class="tz-background-color-3">
                            <a href="<?php echo $siteData->urlBasic;?>/event/contacts" target="_blank"><i class="tz-color-4 fa fa-phone"></i></a>
                            <span><a href="<?php echo $siteData->urlBasic;?>/event/contacts" target="_blank">Контакты организаторов</a></span>
                        </div>
                    </li>
                    <li>
                        <div class="tz-background-color-2">
                            <a href="<?php echo $siteData->urlBasic;?>/event/add-article?id=<?php echo Request_RequestParams::getParamInt('id'); ?>" target="_blank"><i class="tz-color-4 fa fa-cloud-upload"></i></a>
                            <span><a href="<?php echo $siteData->urlBasic;?>/event/add-article?id=<?php echo Request_RequestParams::getParamInt('id'); ?>" target="_blank">Разместить статью / доклад</a></span>
                        </div>
                    </li>
                    <li>
                        <div class="tz-background-color-1">
                            <a href="<?php echo $siteData->urlBasic;?>/event/documents?id=<?php echo Request_RequestParams::getParamInt('id'); ?>" target="_blank"><i class="tz-color-4 fa fa-file-powerpoint-o"></i></a>
                            <span><a href="<?php echo $siteData->urlBasic;?>/event/documents?id=<?php echo Request_RequestParams::getParamInt('id'); ?>" target="_blank">Презентации</a></span>
                        </div>
                    </li>
                </ul>
            </div>
        <?php } ?>
        <?php if (Arr::path($data->values['options'], 'is_info', '0') == 1 && Arr::path($data->values['options'], 'is_menu_webinar', '0') != 1){ ?>
            <div class="tz-introduce-content">
                <div class="row">
                    <?php echo trim($siteData->globalDatas['view::View_Shop\event_opisanie-meropriyatiya']); ?>
                </div>
            </div>
        <?php } ?>
    </section>
    <?php if (Arr::path($data->values['options'], 'is_info', '0') == 1 && Arr::path($data->values['options'], 'is_menu_webinar', '0') == 1){ ?>
    <section class="tz-introduce-univesity">
        <div class="tz-introduce-content">
	        <div class="row">
	            <div class="col-lg-7 col-md-7 col-xs-12 col-sm-7">
				        <?php echo $data->values['info']; ?>
	            </div>
	            <div class="col-lg-5 col-md-5 col-xs-12 col-sm-5">
			            <img src="<?php echo $data->values['file_logotype'];?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>" class="webinar-poster">
				</div>
	        </div>
        </div>
    </section>
    <?php } ?>

    <?php if (Arr::path($data->values['options'], 'is_program', '0') == 1){ ?>
        <section class="tz-cources">
            <span class="tz-images-check">
            <h3 class="tz-title-find">Программа мероприятия:</h3>
            <?php echo trim($siteData->globalDatas['view::View_ShopFiles\event_faily-programmy']); ?>
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <ul id="tz-sidemenu" class="tz-cources-content-left">
                            <?php echo trim($siteData->globalDatas['view::View_ShopFileRubrics\event_programma-dni']); ?>
                        </ul>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                        <?php echo trim($siteData->globalDatas['view::View_ShopFileRubrics\event_programma']); ?>
                    </div>
                </div>
            </div>
        </section>
    <?php } ?>

    <?php if (Arr::path($data->values['options'], 'is_video', '0') == 1){ ?>
        <section class="tz-portfolio-wrapper">
	        <div class="row">
	            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
	                <div class="tz-gallary">
	                    <h3>
	                        <a>Видео</a>
	                    </h3>
	                    <div class="tz-gallery-images videoWrapper">
	                        <?php echo Arr::path($data->values['options'], 'youtube', ''); ?>
	                    </div>
	                </div>
	            </div>
	        </div>
        </section>
    <?php } ?>
    <?php echo trim($siteData->globalDatas['view::View_ShopGallerys\event_uchastnik']); ?>

    <?php if (Arr::path($data->values['options'], 'is_spam', '0') == 1){ ?>
    <div class="tz-contact-us">
        <div class="container">
            <form action="<?php echo $siteData->urlBasic;?>/command/subscribeadd" method="post" class="tz-contact-form" name="frm_contact">
                <ul class="tz-contact-wapper tz-contact-wapper-style-6" style="padding-bottom: 20px;">
                    <li>
                        <span>Хотите знать больше? <br> Подпишитесь на рассылку!</span>
                    </li>
                    <li>
                        <input class="tz-contact-input-name" type="text" name="name" placeholder="Ваше имя" required>
                    </li>
                    <li>
                        <input class="tz-contact-input-email" type="text" name="email" placeholder="email" required>
                    </li>
                    <li>
                        <textarea class="tz-contact-message" name="text" placeholder="Сообщение"></textarea>
                    </li>
                </ul>
                <ul class="tz-contact-wapper tz-contact-wapper-style-6" style="padding-top: 0px; float:right;">
                    <li>
                        <div class="g-recaptcha" data-sitekey="<?php
                        $path = APPPATH . 'views' . DIRECTORY_SEPARATOR . $siteData->shopShablonPath . DIRECTORY_SEPARATOR . 'google-recaptcha.php';
                        $key = include_once $path;
                        echo $key['public'];
                        ?>"></div>
                        <script src='https://www.google.com/recaptcha/api.js'></script>
                    </li>
                    <li>
                        <input name="shop_subscribe_catalog_id" value="15814" hidden>
                        <input name="url" value="<?php echo $siteData->urlBasic;?>/send-message" hidden>
                        <button type="submit"style="margin-top: 13px;"><i class="fa fa-arrows-alt"></i>Отправить</button>
                    </li>
                </ul>
            </form>
        </div>
    </div>
    <?php } ?>


    <?php if (Arr::path($data->values['options'], 'is_sponsor', '0') == 1){ ?>
        <?php echo trim($siteData->globalDatas['view::View_ShopFileRubrics\event_sponsor']); ?>
    <?php } ?>
    <?php if (Arr::path($data->values['options'], 'is_place', '0') == 1){ ?>
        <?php echo trim($siteData->globalDatas['view::View_ShopNewRubrics\event_oteli']); ?>
    <?php } ?>
    <?php if (Arr::path($data->values['options'], 'is_gallery', '0') == 1){ ?>
        <?php echo trim($siteData->globalDatas['view::View_ShopGallerys\event_fotogalereya']); ?>
    <?php } ?>
    <?php echo trim($siteData->globalDatas['view::View_ShopNews\event_kontakty']); ?>
<?php } ?>