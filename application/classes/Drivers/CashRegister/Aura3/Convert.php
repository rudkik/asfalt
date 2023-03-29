<?php defined('SYSPATH') or die('No direct script access.');

class Drivers_CashRegister_Aura3_Convert{
    const EAN13 = 2;

    /**
     * Переводим тип оплаты в XML
     * @param int $paymentType
     * @param float $amount
     * @return string
     */
    public static function paymentTypeToXML(int $paymentType, float $amount){
        $result = '<Payment>'
            . '<Paymenttype>'.$paymentType.'</Paymenttype>'
            . '<Sum>'. self::moneyToXML($amount). '</Sum>'
            . '</Payment>';
        return $result;
    }

    /**
     * Переводим из массива в XML
     * @param array $array
     * @return string
     */
    public static function arrayToXML(array $array){
        $result = '';
        foreach ($array as $value){
            $result .= '<String>'.$value.'</String>';
        }
        return $result;
    }

    /**
     * Получаем штрихкод ввиде XML
     * @return string
     */
    public static function barcodeToXML($value){
        return '<TypeBarcode>'.self::EAN13.'</TypeBarcode>'
            . '<ValueBarcode>'.$value.'</ValueBarcode>';
    }

    /**
     * Переводим вещественное значение в целое
     * В тысячных долях процента, например, 12000 == 12,0%.
     * @param $value
     * @return float
     */
    public static function floatToInt($value){
        return explode('.', $value * 1000)[0];
    }

    /**
     * Получаем сумму ввиде XML
     * @return string
     */
    public static function moneyToXML($value){
        $coins = $value - explode('.', $value)[0];
        if($coins > 0){
            $coins = explode('.', $coins * 100)[0];
        }else{
            $coins = 0;
        }

        return '<Bills>'.explode('.', $value)[0].'</Bills>'
            . '<Coins>'.$coins.'</Coins>';
    }
}