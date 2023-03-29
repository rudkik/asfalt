<?php defined('SYSPATH') or die('No direct script access.');

class Helpers_EMail {
    // настройки mail.ru
    const MAIL_RU = array(
        'Host' => 'smtp.mail.ru',
        'SMTPAuth' => true,
        'SMTPSecure' => 'tls',
        'Port' => 2525
    );

    // настройки gmail.com
    const GMAIL_COM = array(
        'Host' => 'smtp.gmail.com',
        'SMTPAuth' => true,
        'SMTPSecure' => 'tls',
        'Port' => 587,
        'SMTPOptions' => array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        )
    );

    /**
     * Явлеяется ли строка e-mail адресом?
     * @param $email
     * @return bool
     */
    public static function isStrEMail($email)
    {
        if (preg_match("/^(?:[a-zA-Z0-9]+([-_.]+[a-zA-Z0-9]+)*@[a-zA-Z0-9_.-]+(?:\.?[a-zA-Z0-9_.-]+)?\.[a-zA-Z]{2,5})$/i", $email)) {
            return TRUE;
        }else{
            return FALSE;
        }
    }

}