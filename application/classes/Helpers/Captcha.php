<?php defined('SYSPATH') or die('No direct script access.');

class Helpers_Captcha {

    const WRITE_LOGS = TRUE;
    private static function _writeLogs($data){
        if (!self::WRITE_LOGS){
            return FALSE;
        }

        try {
            $path = APPPATH . 'logs' . DIRECTORY_SEPARATOR . 'captcha'. DIRECTORY_SEPARATOR;
            Helpers_Path::createPath($path);
            file_put_contents($path . date('Y-m-d H-i-s').'.txt', $data."\r\n" , FILE_APPEND);
        } catch (Exception $e) {
        }

        return TRUE;
    }

    /**
     * Капча из математической формулы
     * @param int $max
     * @param string $salt
     * @return string
     */
    public static function getCaptchaMathematical($max = 30, $salt = 'Captcha')
    {
        $i1 = rand(1, $max);
        $i2 = rand(1, $max);
        $result = $i1 + $i2;

        $h = date('G');
        $hash = md5($h. $result . $salt . $result. $h);

        $_SESSION["code_captcha_mathematical"] = $hash;
        return $i1 + $i2;
    }

    /**
     * Капча из математической формулы
     * @param int $max
     * @param string $salt
     * @return string
     */
    public static function getCaptchaMathematicalExample($max = 30, $salt = 'Captcha')
    {
        $i1 = rand(1, $max);
        $i2 = rand(1, $max);
        $result = $i1 + $i2;

        $h = date('G');
        $hash = md5($h. $result . $salt . $result. $h);

        $_SESSION["code_captcha_mathematical"] = $hash;
        return $i1 . ' + ' . $i2 . ' = ';
    }

    /**
     * Проверка капчи из математической формулы
     * @param $result
     * @param string $salt
     * @return bool
     */
    public static function checkCaptchaMathematicalExample($result, $salt = 'Captcha')
    {
        $h = date('G');
        $hash = md5($h. $result . $salt . $result. $h);

        return key_exists('code_captcha_mathematical', $_SESSION) && $hash == $_SESSION["code_captcha_mathematical"];
    }

    /**
     * Проверка капчи
     * Адрес google 'views' . DIRECTORY_SEPARATOR . $sitePageData->shopShablonPath . DIRECTORY_SEPARATOR . 'google-recaptcha.php';
     * @param SitePageData $sitePageData
     * @param bool $isNotCaptcha
     * @return bool
     */
    public static function checkCaptcha(SitePageData $sitePageData, $isNotCaptcha = FALSE){
        if($isNotCaptcha && (Request_RequestParams::getParamBoolean('is_not_captcha_hash'))){
            return TRUE;
        }

        $isSuccess = FALSE;
        $captcha = Request_RequestParams::getParamStr('image_captcha');
        if (!empty($captcha)) {
            $isSuccess = key_exists('code_captcha_image', $_SESSION) && strtolower($_SESSION["code_captcha_image"]) == strtolower($captcha);
        }else{
            $recaptcha = Request_RequestParams::getParamStr('g-recaptcha-response');
            if (!empty($recaptcha)) {
                $url_to_google_api = "https://www.google.com/recaptcha/api/siteverify";

                $path = APPPATH . 'views' . DIRECTORY_SEPARATOR . $sitePageData->shopShablonPath . DIRECTORY_SEPARATOR . 'google-recaptcha.php';
                if (file_exists($path)) {
                    $key = include $path;

                    // если капча для другого сайта
                    $site = $sitePageData->getSiteName();
                    if(key_exists($site, $key)){
                        $key = $key[$site];
                    }

                    $secret_key = $key['secret'];
                    $query = $url_to_google_api . '?secret=' . $secret_key . '&response=' . $recaptcha . '&remoteip=' . $_SERVER['REMOTE_ADDR'];

                    try {
                        $data = file_get_contents($query);

                        self::_writeLogs($data);

                        $data = json_decode($data);
                        $isSuccess = $data->success;
                    }catch(Exception $e){
                        $isSuccess = FALSE;
                    }
                }
            } else {
                $captchaHash = Request_RequestParams::getParamStr('captcha_hash');
                if (self::checkCaptchaMathematicalExample($captchaHash)) {
                    $isSuccess = TRUE;
                }
            }
        }

        return $isSuccess;
    }

    /**
     * Получение публичного ключа ReCaptcha
     * Адрес google 'views' . DIRECTORY_SEPARATOR . $sitePageData->shopShablonPath . DIRECTORY_SEPARATOR . 'google-recaptcha.php';
     * @param SitePageData $sitePageData
     * @return string
     */
    public static function getPublicReCaptchaGoogle(SitePageData $sitePageData){
        $path = APPPATH . 'views' . DIRECTORY_SEPARATOR . $sitePageData->shopShablonPath . DIRECTORY_SEPARATOR . 'google-recaptcha.php';
        if (file_exists($path)) {
            $key = include $path;

            // если капча для другого сайта
            $site = $sitePageData->getSiteName();
            if(key_exists($site, $key)){
                $key = $key[$site];
            }

            return Arr::path($key, 'public', '');

        }else{
            return '';
        }
    }

    /**
     * Генерирует картинку CAPTCHA и передаем ее в Content-type
     */
    public static function getCaptchaImage(){
        //присваивает PHP переменной captchastring строку символов
        $captchaString = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz';
        //получает первые 6 символов после их перемешивания с помощью функции str_shuffle
        $captchaString = substr(str_shuffle($captchaString), 0, 6);
        //инициализация переменной сессии с помощью сгенерированной подстроки captchastring,
        //содержащей 6 символов
        $_SESSION["code_captcha_image"] = $captchaString;

        //Генерирует CAPTCHA

        $path = Helpers_Path::getPathFile(DOCROOT, array('css', '_component', 'captcha'));

        //создает новое изображение из файла background.png
        $image = imagecreatefrompng($path .'background.png');
        //устанавливает цвет (R-200, G-240, B-240) изображению, хранящемуся в $image
        $colour = imagecolorallocate($image, 200, 240, 240);
        //присваивает переменной font название шрифта
        $font = $path . 'oswald.ttf';
        //устанавливает случайное число между -10 и 10 градусов для поворота текста
        $rotate = rand(-10, 10);
        //рисует текст на изображении шрифтом TrueType (1 параметр - изображение ($image),
        //2 - размер шрифта (18), 3 - угол поворота текста ($rotate),
        //4, 5 - начальные координаты x и y для текста (18,30), 6 - индекс цвета ($colour),
        //7 - путь к файлу шрифта ($font), 8 - текст ($captchastring)
        imagettftext($image, 18, $rotate, 28, 32, $colour, $font, $captchaString);
        //будет передавать изображение в формате png
        header('Content-type: image/png');
        //выводит изображение
        imagepng($image);
    }
}
