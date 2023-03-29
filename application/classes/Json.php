<?php defined('SYSPATH') or die('No direct script access.');

class Json{
    static public $_code;

    static public function json_encode($data, $assoc = false){
        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        Json::$_code=0;
        return preg_replace_callback('/\\\\u([0-9a-f]{4})/i',
            function($val){
                $val=hexdec($val[1]);
                if(Json::$_code){
                    $val=((Json::$_code&0x3FF)<<10)+($val&0x3FF)+0x10000;
                    Json::$_code=0;
                }elseif($val>=0xD800&&$val<0xE000){
                    Json::$_code=$val;
                    return '';
                }
                return html_entity_decode(sprintf('&#x%x;', $val), ENT_NOQUOTES, 'utf-8');
            }, json_encode($data, $assoc)
        );
    }
}