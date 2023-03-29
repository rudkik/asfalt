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
                                    <h1>Регистрация по партнерской ссылки</h1>
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
                            <form class="listar-formtheme listar-formlogin" action="<?php echo $siteData->urlBasic;?>/command/shopcreate" method="post">
                                <fieldset>
                                    <h2>Данные для регистрации</h2>
                                    <div class="form-group listar-inputwithicon">
                                        <i class="icon-profile-male"></i>
                                        <input class="form-control" name="shop[name]" placeholder="Юридическое название компании" type="text" required>
                                    </div>
                                    <div class="form-group listar-inputwithicon">
                                        <i class="icon-phone"></i>
                                        <input class="form-control" name="shop[options][phone]" placeholder="Телефон" type="phone" required>
                                    </div>
                                    <div class="form-group listar-inputwithicon">
                                        <i class="icon-icons208"></i>
                                        <input class="form-control" name="user[email]" placeholder="E-mail" type="email" required>
                                    </div>
                                    <div class="form-group listar-inputwithicon">
                                        <i class="icon-lock-stripes"></i>
                                        <input class="form-control" name="user[password]" placeholder="Пароль" type="password" required>
                                    </div>
                                    <div class="form-group listar-inputwithicon box_referral">
                                        <label>Номер реферала</label>
                                    </div>
                                    <div class="form-group listar-inputwithicon">
                                        <i class="icon-layers"></i>
                                        <input class="form-control" name="shop[referral]" placeholder="Номер реферала" type="text" value="<?php echo Request_RequestParams::getParamInt('referral'); ?>">
                                    </div>
                                    <div class="form-group">
                                        <div class="listar-checkbox">
                                            <input class="form-control offers" checked name="is_agreement" type="checkbox" value="1">
                                            <label for="rememberpass">Принимаю <a target="_blank" href="<?php echo $siteData->urlBasic;?>/offers">договор оферты</a></label>

                                            <script>
                                                $('[name="is_agreement"]').change(function () {
                                                    if($(this).prop('checked')){
                                                        $('#button-registration-referral').removeAttr('disabled');
                                                    }else{
                                                        $('#button-registration-referral').attr('disabled', '');
                                                    }
                                                });
                                            </script>
                                        </div>
                                    </div>
                                    <input name="shop[shop_branch_type_id]" value="3827" hidden="">
                                    <input name="url" value="<?php echo $siteData->urlBasic;?>/client/register" hidden="">
                                    <input name="redirect_url" value="<?php echo $siteData->urlBasic;?>/tax" hidden="">
                                    <button id="button-registration-referral" class="listar-btn listar-btngreen" type="submit">Зарегистрироваться</button>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
