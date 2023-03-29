<div class="container">
    <div class="row justify-content-center no-gutters">
        <div class="col-sm-10">
            <nav class="breadcrumbs">
                <!-- <span class="breadcrumbs__link">Вход</span> -->
            </nav>
        </div>
    </div>
</div>
<main>
    <div class="container">
        <div class="row justify-content-center no-gutters flex-column align-items-center">
            <?php if (Arr::path(Request_RequestParams::getParamArray('system'), 'error', FALSE)){ ?>
                <h2 class="alert--error">Пароль и логин введен неверно.</h2>
            <?php } ?>
            <form action="<?php echo $siteData->urlBasic;?>/user/login" class="form align-items-center">
			    <span class="form__title form__title--nobottom text--title--big">
			  		Вход
			    </span>
                <input name="email" type="email" class="field" placeholder="Ваш e-mail">
                <input name="password" type="password" class="field" placeholder="Ваш пароль">
                <a href="<?php echo $siteData->urlBasic;?>/account/reset" class="link margin-t-1 margin-b-1-5">
                    Я не помню пароль
                </a>
                <input name="error_url" value="<?php echo $siteData->urlBasic;?>/account/auth" style="display: none">
                <input name="url" value="<?php echo $siteData->urlBasic;?>/account" style="display: none">
                <input type="submit" class="btn margin-b-4" value="Войти">
            </form>
        </div>
    </div>
</main>