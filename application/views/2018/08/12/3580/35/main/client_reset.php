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
                                    <h1>Восстановление пароля</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </figcaption>
            </figure>
        </div>
    </div>
</main>
<div id="listar-wrapper" class="listar-wrapper listar-haslayout">
    <main id="listar-main" class="listar-main listar-haslayout">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-push-1 col-md-10 col-lg-push-2 col-lg-8">
                    <div id="listar-content" class="listar-content box_register">
                        <div class="listar-comingsooncontent">
                            <form class="listar-formtheme listar-formlogin" action="<?php echo $siteData->urlBasic;?>/client-tax/forgot" method="post">
                                <fieldset>
                                    <h2>Восстановление пароля</h2>
                                    <div class="form-group listar-inputwithicon">
                                        <i class="icon-icons208"></i>
                                        <input class="form-control" name="email" placeholder="E-mail" type="email" required>
                                    </div>
                                    <input name="error_url" value="<?php echo $siteData->urlBasic;?>/client/reset" style="display: none">
                                    <input name="url" value="<?php echo $siteData->urlBasic;?>/client/reset/finish" style="display: none">
                                    <button id="button-registration-referral" class="listar-btn listar-btngreen" type="submit">Сброс пароля</button>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
