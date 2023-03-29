<?php defined('SYSPATH') or die('No direct script access.');

class Api_Tax_NDS  {

    /**
     * Сумма НДС
     * @return float
     */
    public static function getNDS()
    {
        return 12;
    }

    /**
     * Возвращаем сумму без НДС
     * @param $amount
     * @param bool $isNDS
     * @param null $ndsPercent
     * @return float
     */
    public static function getAmountWithoutNDS($amount, $isNDS = TRUE, $ndsPercent = null){
        if($isNDS){
            if($ndsPercent == 0 || $ndsPercent === null){
                $ndsPercent = Api_Tax_NDS::getNDS();
            }

            $amount = round($amount / (100 + $ndsPercent) * 100, 2);
        }
        return $amount;
    }

    /**
     * Возвращем сумму НДС
     * @param $amount
     * @param bool $isNDS
     * @param null $ndsPercent
     * @return float|int
     */
    public static function getAmountNDS($amount, $isNDS = TRUE, $ndsPercent = null){
        if($isNDS){
            if($ndsPercent == 0 || $ndsPercent === null){
                $ndsPercent = Api_Tax_NDS::getNDS();
            }

            $result = round($amount / (100 + $ndsPercent) * $ndsPercent, 2);
        }else{
            $result = 0;
        }
        return $result;
    }
}
