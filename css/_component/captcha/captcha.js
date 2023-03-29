$(function() {
    /**
     * Выводит новый код CAPTCHA при нажатии на кнопку Обновить
     * Параметры:
     * id="reload-captcha" - кнопка обновления капчи
     * id="img-captcha" - картинка капчи
     * Подключение:
     <script src="<?php echo $siteData->urlBasic; ?>/css/_component/captcha/captcha.js"></script>
     */
    $("#reload-captcha").click(function() {
        $('#img-captcha').attr('src', '/command/get_image_captcha?id='+Math.random()+'');
    });
});