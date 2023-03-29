<div class="container">
    <div class="row justify-content-center no-gutters">
        <div class="col-sm-10">
            <nav class="breadcrumbs">
                <a href="<?php echo $siteData->urlBasic;?>/account/auth" class="breadcrumbs__link">Вход</a>
                <span class="breadcrumbs__link">Восстановление пароля</span>
            </nav>
        </div>
    </div>
</div>
<main>
    <div class="container">
        <div class="row justify-content-center no-gutters">
            <form action="<?php echo $siteData->urlBasic;?>/user/forgot" class="form align-items-center">
                <span class="form__title form__title--nobottom text--title--big">
                    Восстановление пароля
                </span>
                <input name="email" type="text" class="field" placeholder="Ваша email">
                <input name="error_url" value="<?php echo $siteData->urlBasic;?>/user/forgot" style="display: none">
                <input name="url" value="<?php echo $siteData->urlBasic;?>/account/reset/ok" style="display: none">
                <input type="submit" class="btn margin-b-4" value="Восстановить" style="margin-top: 5px;">
            </form>
        </div>
    </div>
</main>