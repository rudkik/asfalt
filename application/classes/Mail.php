<?php defined('SYSPATH') or die('No direct script access.');

class Mail  {

    /**
     * Функция отправки сообщения на email
     * @param SitePageData $sitePageData
     * @param $email
     * @param $title
     * @param $message
     * @param array $files
     * @return bool
     * @throws HTTP_Exception_500
     */
    public static function sendEMailHTML(SitePageData $sitePageData, $email, $title, $message, array $files = array())
    {
        $file = APPPATH . 'views' . DIRECTORY_SEPARATOR . $sitePageData->shopShablonPath . DIRECTORY_SEPARATOR . 'email.php';
        if (!file_exists($file)){
            return FALSE;
        }

        $emailOptions = include $file;

        $site = $sitePageData->getSiteName();
        if(key_exists($site, $emailOptions)){
            $emailOptions = $emailOptions[$site];
        }

        require_once MODPATH.'mailer/PHPMailerAutoload.php';

        if (empty($title)){
            $title = 'Сообщение';
        }

        $mail = new PHPMailer(TRUE);
        $mail->Host = Arr::path($emailOptions, 'host', '');

        switch ($mail->Host){
            case 'smtp.gmail.com':
                $mail->SMTPDebug = 1;
                $mail->isSMTP();
            default:
                $mail->isMail();
        }

        $mail->SMTPAuth = true;
        $mail->SMTPKeepAlive = true;
        $mail->Username = Arr::path($emailOptions, 'user_name', '');
        $mail->Password = Arr::path($emailOptions, 'password', '');
        $mail->SMTPSecure = Arr::path($emailOptions, 'SMTPSecure', 'SSL');
        $mail->Port = intval(Arr::path($emailOptions, 'port', 465));
        $mail->CharSet = Arr::path($emailOptions, 'charset', 'UTF-8');
        $mail->WordWrap = 500;
        $mail->isHTML(TRUE);


        $tmp = Arr::path($emailOptions, 'email', '');
        if(is_array($tmp)){
            $mail->SetFrom(Arr::path($tmp, 'email', ''), Arr::path($tmp, 'title', ''));
        }else{
            $mail->SetFrom($tmp);
        }

        if(is_array($email)){
            foreach($email as $value){
                if (!Helpers_EMail::isStrEMail($value)){
                    throw new HTTP_Exception_500('E-mail "'.$value.'" not found. Code: 3127');
                }
                $mail->addAddress($value);
            }
        }else {
            if(!empty($email)){
                if (!Helpers_EMail::isStrEMail($email)){
                    throw new HTTP_Exception_500('E-mail "'.$email.'" not found. Code: 3128');
                }

                $mail->addAddress($email);
            }
        }

        // дополнительные емаилы для отправки
        $arr = Arr::path($emailOptions, 'addition_emails', '');
        if(is_array($arr)) {
            foreach ($arr as $value) {
                if(is_array($value)){
                    $emailValue = Arr::path($value, 'email', '');
                    if (!Helpers_EMail::isStrEMail($emailValue)){
                        throw new HTTP_Exception_500('E-mail "'.$emailValue.'" not found. Code: 3129');
                    }
                    $mail->addAddress($emailValue, Arr::path($value, 'title', ''));
                }else{
                    if (!Helpers_EMail::isStrEMail($value)){
                        throw new HTTP_Exception_500('E-mail "'.$value.'" not found. Code: 3130');
                    }
                    $mail->addAddress($value);
                }
            }
        }

        // загружаем файлы
        foreach($files as  $file) {
            $mail->addAttachment($file);
        }

        $mail->Subject = $title;
        $mail->Body = $message;
        $mail->AltBody = '';


        try{
            if($mail->send()) {
                return TRUE;
            } else {
                return FALSE;
            }
        }catch (Exception $exception){
            return FALSE;
        }
    }

}