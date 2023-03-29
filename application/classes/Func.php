<?php defined('SYSPATH') or die('No direct script access.');

class Func{
    public static function getLimit(array $params) {
        $result = Arr::path($params, 'limit.value', Arr::path($params, 'limit', 0));
        $result = intval($result);
        if($result === FALSE){
            return 0;
        }

        return intval($result);
    }

    /**
     * Проверяем список параметров в массиве, чтобы ни одного не было
     * @param array $keys
     * @param array $search
     * @return bool
     */
    public static function not_key_exists(array $keys, array $search) {

        foreach ($keys as $key){
            if(key_exists($key, $search)){
                return FALSE;
            }
        }

        return TRUE;
    }

    /**
     * Генерируем уникальный пароль
     * @param int $countSymbol
     * @return string
     */
    public static function generatePassword($countSymbol = 8){
        // Символы, которые будут использоваться в пароле.
        $chars = 'qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP';
        $size = StrLen($chars)-1;
        $password = '';
        while($countSymbol--) {
            $password .= $chars[rand(0, $size)];
        }
        return $password;

    }

	public static function _empty($data)
	{
		return empty($data);
	}

	public static function mb_strtoupper($str)
	{
		if (function_exists('mb_strtoupper'))
			$str = mb_strtoupper($str, 'UTF-8');
		else
			$str = strtoupper($str);

		return $str;
	}

    /**
     * Получаем номер месяца с нулем впереди, если меньше 2 символов
     * @param $index - порядковый месяц от начала полугодия
     * @param $halfYear - первое или второе полугодие
     * @return string
     */
    public static function getMonthHalf($index, $halfYear)
    {
        $result = $index;
        if ($halfYear > 1){
            $result = $result + 6;
        }
        if($result < 10) {
            $result = '0' . $result;
        }

        return $result;
    }

	/**
	 * Преобразуем в строку true / false
	 * @param $value
	 * @return string
	 */
	public static function boolToStr($value){
		if(is_string($value)) {
			$value = strtolower($value);
		}
		if ((!is_array($value)) &&
			((intval($value) === 1) || (is_bool($value) && $value)
				|| ($value === 'true') || ($value === 'on'))){
			return 'true';
		}else{
			return 'false';
		}
	}

    /**
     * Преобразуем boolean в цисло
     * @param bool $value
     * @param $isNull
     * @return int|null
     */
    public static function boolToInt($value, $isNull = false){
       if($value){
           return 1;
       }else{
           if($isNull && $value === null){
               return null;
           }
           return 0;
       }
    }

	public static function isCurrentMenu(SitePageData $siteData, $url, $isIndex = TRUE, $isEdit = TRUE, $isNew = TRUE)
	{
        $url = '/'.$siteData->actionURLName.'/'.$url.'/';

		if(($isIndex) && ($url.'index' == $siteData->url)){
			return TRUE;
		}
		if(($isEdit) && ($url.'edit' == $siteData->url)){
			return TRUE;
		}
		if(($isNew) && ($url.'new' == $siteData->url)){
			return TRUE;
		}
		return FALSE;
	}

    public static function xmlrpc_encode($string)
    {
        return str_replace('<', '&lt;',
            str_replace('>', '&gt;',
                str_replace('&', '&amp;',
                    str_replace('\'', '&apos;',
                        str_replace('"', '&amp;', $string)))));
    }

    /**
     * Перевод русских букв в английские
     * @param $string
     * @param bool $isOnlySymbols
     * @return mixed|string
     */
	public static function get_in_translate_to_en($string, $isOnlySymbols = FALSE)
	{
		$replace = array("А"=>"A","а"=>"a","Б"=>"B","б"=>"b","В"=>"V","в"=>"v","Г"=>"G","г"=>"g","Д"=>"D","д"=>"d",
				"Е"=>"E","е"=>"e","Ё"=>"E","ё"=>"e","Ж"=>"Zh","ж"=>"zh","З"=>"Z","з"=>"z","И"=>"I","и"=>"i",
				"Й"=>"I","й"=>"i","К"=>"K","к"=>"k","Л"=>"L","л"=>"l","М"=>"M","м"=>"m","Н"=>"N","н"=>"n","О"=>"O","о"=>"o",
				"П"=>"P","п"=>"p","Р"=>"R","р"=>"r","С"=>"S","с"=>"s","Т"=>"T","т"=>"t","У"=>"U","у"=>"u","Ф"=>"F","ф"=>"f",
				"Х"=>"Kh","х"=>"kh","Ц"=>"Tc","ц"=>"tc","Ч"=>"Ch","ч"=>"ch","Ш"=>"Sh","ш"=>"sh","Щ"=>"Shch","щ"=>"shch",
				"Ы"=>"Y","ы"=>"y","Э"=>"E","э"=>"e","Ю"=>"Yu","ю"=>"yu","Я"=>"Ya","я"=>"ya","ъ"=>"","ь"=>"",
                "Ә" =>"A","ә" =>"a","Ғ"=>'G',"ғ"=>"g","Қ"=>"Q","қ"=>"q","Ң"=>"N","ң"=>"n","Ө"=>"O","ө"=>"o",
                "Ұ"=>"U","ұ"=>"u","Ү"=>"U","ү"=>"u");

		$string = trim(
		    mb_strtolower(
		        str_replace('/', '-',
                    str_replace('\\', '-',
                        str_replace('/', '-',
                            str_replace('\\', '-',
                                str_replace('%20', ' ', $string)
                            )
                        )
                    )
                )
            )
        );
		$tmp = iconv("UTF-8","UTF-8//IGNORE",strtr($string,$replace));

		$arr = array('q'=>'','w'=>'','e'=>'','r'=>'','t'=>'','y'=>'','u'=>'','i'=>'','o'=>'','p'=>'','a'=>'','s'=>'','d'=>'',
				'f'=>'','g'=>'','h'=>'','j'=>'','k'=>'','l'=>'','z'=>'','x'=>'','c'=>'','v'=>'','b'=>'','n'=>'','m'=>'',
				'1'=>'','2'=>'','3'=>'','4'=>'','5'=>'','6'=>'','7'=>'','8'=>'','9'=>'','0'=>'','-'=>'',' '=>'','_'=>'','.'=>'');

		$s = '';
		for ($i = 0; $i < mb_strlen($tmp); $i++) {
			$c = mb_substr($tmp, $i, 1);
			if(key_exists($c, $arr)){
				$s = $s.$c;
			}
		}

		$tmp = str_replace(' ', '-', $s);
		$tmp = str_replace('_', '-', $tmp);
        if($isOnlySymbols){
            $tmp = str_replace('.', '-', $tmp);
        }
        $tmp = str_replace('--', '-', $tmp);
        $tmp = str_replace('--', '-', $tmp);
		return $tmp;
	}

	/**
	 * Преобразуем данне в зависимости от типа
	 * @param MyArray $data
	 * @return string
	 */
	public static function getContactTypeView(MyArray $data){
		$result = $data->values['name'];
		switch ($data->values['contact_type_id']) {
			case Model_ContactType::CONTACT_TYPE_EMAIL:
				$result = '<a href="mailto:'.$result.'">'.$result.'</a>'; break;
		}

		return $result;
	}

	/**
	 * Добавляем к списку параметров
	 * @param array $urlParams
	 * @param array $addParams
	 * @return string
	 */
	public static function getAddURLParams(array $urlParams, array $addParams = array()){
		foreach ($addParams as $key => $value) {
			$urlParams[$key] = $value;
		}

		return URL::query($urlParams, FALSE);
	}

    /**
     * Добавляем к списку параметров
     * @param array $urlParams
     * @param $name
     * @param bool $isDeletePage
     * @return string
     */
	public static function getAddURLSortBy(array $urlParams, $name, $isDeletePage = TRUE){
		$urlParams = array_merge($_GET, $urlParams);

        $sortBy = Arr::path($urlParams, 'sort_by', null);
		if (is_array($sortBy) && ((key_exists($name, $sortBy) && $sortBy[$name]== 'asc') || Arr::path($sortBy, $name, '') == 'asc')){
			$urlParams['sort_by'] = array($name => 'desc');
		}else{
			$urlParams['sort_by'] = array($name => 'asc');
		}

		if($isDeletePage === TRUE){
			unset($urlParams['page']);
		}

		return URL::query($urlParams, FALSE);
	}

    /**
     * Получаем время работы в данный момент
     * @param string (JSON) $data json_encode(array('kitchen' => 'европейская', 'time' => '60 мин.', 'serving_count' => '4', 'info' => 'Предлагаю рецепт плотного, сытного ужина. Основа взята из журнала, но картошку я заменила гречкой.'));
     * @param $name
     * @param string $default
     * @return mixed|string
     */
	public static function getJSONValue($data, $name, $default = ''){
		if(empty($data)){
			return '';
		}

		$arr = json_decode($data, TRUE);
		if ((is_array($arr)) && (key_exists($name, $arr))){
			return $arr[$name];
		}else{
			return $default;
		}
	}

    /**
     * Получаем контакты в виде строки с HTML тегами
     * @param array $values
     * @param bool $isPrefix
     * @param bool $isURLALL
     * @return mixed|string
     */
	public static function getContactHTMLRus(array $values, $isPrefix = TRUE, $isURLALL = FALSE)
	{
		if($isPrefix === TRUE) {
			$result = Arr::path($values, '$elements$.contact_type_id.name', '');
			if(!empty($result)){
				$result = $result.': ';
			}
		}else{
			$result = '';
		}

		switch ($values['contact_type_id'])
		{
			case (Model_ContactType::CONTACT_TYPE_EMAIL):
			case (Model_ContactType::CONTACT_TYPE_ICQ):
				$result = $result.'<a itemprop="email" href="mailto:'.$values['name'].'?subject='.$values['text'].'">'.$values['name'].'</a>';
				break;
			case (Model_ContactType::CONTACT_TYPE_SKYPE):
				$result = $result.'<a href="skype:'.$values['name'].'">'.$values['name'].'</a>';
				break;
			case (Model_ContactType::CONTACT_TYPE_MOBILE):
			case (Model_ContactType::CONTACT_TYPE_PHONE):
				if($isURLALL){
					$result = $result.'<a itemprop="telephone" href="tel:'.$values['name'].'">'.$values['name'].'</a>'; break;
				}else{
					$result  = $result.$values['name'];
				}
				break;
			default:
				$result = $result.$values['name'];
		}

		return $result;
	}

    /**
     * Рабочее ли время в данный момент
     * @param $data
     * @return bool|string
     */
	public static function getisWorkTimeToday($data){
		if(empty($data)){
			return TRUE;
		}

		$week = json_decode($data, TRUE);
		$time = strtotime(date('H:i', time()));
		$tmp = date('N');
		if(key_exists($tmp, $week)){
			return (strtotime($week[$tmp]['from']) <= $time) && (strtotime($week[$tmp]['to']) >= $time);
		}else{
			return FALSE;
		}
	}

    /**
     * Получаем время работы в данный момент
     * @param $data
     * @return string
     */
	public static function getWorkTimeToday($data){
		if(empty($data)){
			return '';
		}

		if (is_array($data)){
			$week = $data;
		}else{
			$week = json_decode($data, TRUE);
		}
		
		if(! is_array($week)){
			return '';
		}
		
		$tmp = date('N');
		if(key_exists($tmp, $week)){
			return $week[$tmp]['from'].'-'.$week[$tmp]['to'];
		}else{
			return '';
		}
	}

    /**
     * Получаем минимальную стоимости доставки
     * @param string (JSON) $data
     * @return int
     */
	public static function getMinPriceDelivery($data){
		if(empty($data)){
			return 0;
		}

		$options = json_decode($data, TRUE);
		if (key_exists('min_price_delivery', $options)){
			return $options['min_price_delivery'];
		}else{
			return 0;
		}
	}

	public static function setMinPriceDelivery($data, $value){
		if(is_array($data)){
			$result = $data;
		}elseif(empty($data)){
			$result = array();
		}elseif(is_string($data)){
			$result = json_decode($data, TRUE);
		}else{
			$result = array();
		}

		$result['min_price_delivery'] = $value;
		return $result;
	}

    /**
     * Получаем среднее время доставки
     * @param $time
     * @param string $default
     * @return string
     */
	public static function getMeanTimeDelivery($time, $default = 'не задано'){
		$result = '';
		if ($time > 24 * 60 - 1){
			$tmp = floor($time/(24 * 60));
			$result = self::getCountElementStrRus($tmp, 'дней', 'день', 'дня').' ';
			$time = $time - $tmp * 24 * 60 ;
		}

		if ($time > 59){
			$tmp = floor($time/60);
			$result = $result.self::getCountElementStrRus($tmp, 'часов', 'час', 'часа').' ';
			$time = $time - $tmp * 60;
		}

		if ($time > 0){
			$result = $result.self::getCountElementStrRus($time, 'минут', 'минуту', 'минуты').' ';
		}

		if(empty($result)){
			$result = $default;
		}

		return $result;
	}

    /**
     * Получаем название валюты
     * @param Model_Currency $currency
     * @return string
     */
	public static function getCurrency(Model_Currency $currency){
		return trim(str_replace('{amount}', '', $currency->getSymbol()));
	}

    /**
     * @param $price
     * @param bool $isBreakDigit
     * @param int $decimals
     * @param bool $isDeleteZero
     * @return float|int|mixed|string
     */
	public static function getNumberStr($price, $isBreakDigit = TRUE, $decimals = 2, $isDeleteZero = TRUE){
	    if(!is_numeric($price)){
	        return '';
        }
        $price = (float)$price;
		if($isBreakDigit === TRUE) {
            $price = number_format($price, $decimals, '.', ' ');
		    if($isDeleteZero && ($decimals == 2)) {
                $price = str_replace('.00', '', $price);
            }
		}else{
            $price = number_format($price, $decimals, '.', '');
        }
		if($isDeleteZero) {
            if (strpos($price, '.') !== FALSE) {
                $price = rtrim(rtrim($price, '0'), '.');
            }
        }

		return $price;
	}

	public static function getPrice(Model_Currency $currency,  $price, $isRound = NULL){
		$price = intval($price);
		$price = round($price * $currency->getCurrencyRate(), 2);
		if ($isRound && $currency->getIsRound()){
			$price = round($price);
		}

		return $price;
	}

    /**
     * Добавляем курс валюты, курс валюты задан массивом значений
     * @param array $currency
     * @param $price
     * @param bool $isCalcCurrency
     * @param null $isRound
     * @return mixed
     */
    public static function getPriceStrCurrencyArray(array $currency, $price, $isCalcCurrency = TRUE, $isRound = NULL){
        $price = intval($price);

        $symbol = Arr::path($currency, 'symbol', '');
        if ($symbol == ''){
            $symbol = '{amount}';
        }

        if ($isCalcCurrency) {
            $currencyRate = Arr::path($currency, 'currency_rate', 0);
            if ($currencyRate > 0) {
                $price = round($price * $currencyRate, 2);
            }
        }
        if ($isRound && Arr::path($currency, 'is_round', FALSE)){
            $price = round($price);
        }
        return str_replace('{amount}', str_replace('.00', '', self::getNumberStr($price)), $symbol);
    }

	public static function getPriceStr(Model_Currency $currency, $price, $isCalcCurrency = TRUE, $isRound = NULL,
                                       $isDeleteZero = TRUE){
        $price = intval($price);
        $symbol = $currency->getSymbol();
        if ($symbol == ''){
            $symbol = '{amount}';
        }

        if(($isCalcCurrency === TRUE) && ($currency->getCurrencyRate() > 0)) {
            $price = round($price * $currency->getCurrencyRate(), 2);
        }
        if ($isRound && $currency->getIsRound()){
            $price = round($price);
        }

        return str_replace('{amount}', self::getNumberStr($price, TRUE, 2, $isDeleteZero), $symbol);
	}

	/**
	 * Переводим часы в дни
	 * @param $hour
	 * @return float|String
	 */
	public static function hourToDayStrRus($hour){
		$hour = intval($hour);
		if($hour < 24){
			$result = self::getCountElementStrRus($hour, 'часов', 'час', 'часа');
		}else{
			$result = floor($hour / 24);
			$result = self::getCountElementStrRus($result, 'дней', 'день', 'дня');

			$hour = $hour - $result * 24;
			if($hour != 0){
				$result = $result.' '.self::getCountElementStrRus($hour, 'часов', 'час', 'часа');
			}
		}

		return $result;
	}

    /**
     * Переводим секунды во время
     * @param $seconds
     * @return String
     */
    public static function secondToTimeStrRus($seconds){
        $result = '';

        $isFirst = false;

        $days = floor($seconds / 86400);
        $seconds = $seconds % 86400;
        if($days > 0) {
            $result .= $days . ' д ';
            $isFirst = true;
        }

        $hours = floor($seconds / 3600);
        $seconds = $seconds % 3600;
        if($isFirst || $hours > 0) {
            $result .= $hours . ' ч ';
            $isFirst = true;
        }

        $minutes = floor($seconds / 60);
        $seconds = $seconds % 60;
        if($isFirst || $minutes > 0) {
            $result .= $minutes . ' м ';
        }

        $result .= $seconds . ' с';

        return trim($result);
    }

	public static function getGoodDiscountStr(MyArray $data){
		if($data->values['system_is_discount'] == 1) {
            return self::getNumberStr(floatval($data->values['system_discount']));
		}else{
			$discount = floatval($data->values['discount']);
            if($discount > 0){
                return self::getNumberStr($discount);
            }
		}

        return '';
	}

    /**
     * Получаем старую и новую цену
     * @param Model_Currency $currency
     * @param MyArray $data
     * @param $price
     * @param $priceOld
     * @param bool $isAddCurrency
     * @return float|int|mixed
     */
	public static function getGoodPriceStr(Model_Currency $currency, MyArray $data, &$price, &$priceOld, $isAddCurrency = TRUE){
		$discount = floatval(Arr::path($data->values, 'system_discount', 0));
		if ($discount <= 0){
			$discount = floatval(Arr::path($data->values, 'discount', 0));
		}

		if ($discount > 0){
			$price = $data->values['price'];

			$priceOld = $price;

			$price = $price/100*(100-$discount);
			if ($currency->getIsRound()){
				$price = round($price);
			}
		}else{
			$priceOld = $data->values['price_old'];

			if ($priceOld < 0.01){
				$priceOld = '';
            }

            $price = $data->values['price'];

		}

        if($isAddCurrency === TRUE) {
		    if (Arr::path($data->values, 'currency_id', 0) > 0){
                $price = Func::getPriceStrCurrencyArray(
                    $data->getElementValue('currency_id', '', array()),
                    $price
                );

                if (!empty($priceOld)) {
                    $priceOld = Func::getPriceStrCurrencyArray(
                        $data->getElementValue('currency_id', '', array()),
                        $priceOld
                    );
                }
            }else {
                $price = Func::getPriceStr($currency, $price);
                if (!empty($priceOld)) {
                    $priceOld = Func::getPriceStr($currency, $priceOld);
                }
            }
        }

		return $price;
	}

    /**
     * Получаем старую и новую цену
     * @param Model_Currency $currency
     * @param MyArray $data
     * @param $price
     * @param $priceOld
     * @param bool $isAddCurrency
     * @return float|int|mixed
     */
    public static function getCarPriceStr(Model_Currency $currency, MyArray $data, &$price, &$priceOld,
                                          $isAddCurrency = TRUE){
        $priceOld = $data->values['price_old'];

        if ($priceOld < 0.01){
            $priceOld = '';
        }

        $price = $data->values['price'];

        if($isAddCurrency === TRUE) {
            if (Arr::path($data->values, 'currency_id', 0) > 0){
                $price = Func::getPriceStrCurrencyArray(
                    $data->getElementValue('currency_id', '', array()),
                    $price
                );

                if (!empty($priceOld)) {
                    $priceOld = Func::getPriceStrCurrencyArray(
                        $data->getElementValue('currency_id', '', array()),
                        $priceOld
                    );
                }
            }else {
                $price = Func::getPriceStr($currency, $price);
                if (!empty($priceOld)) {
                    $priceOld = Func::getPriceStr($currency, $priceOld);
                }
            }
        }

        return $price;
    }


    public static function getGoodAmount(MyArray $data, $count, $isRound){
		if($data->isFindDB !== TRUE){
			return 0;
		}

		$discount = floatval($data->values['system_discount']);
		if ($discount <= 0){
			$discount = floatval($data->values['discount']);
		}

		$price = $data->values['price'];
		if ($discount > 0){
			$price = $price/100*(100-$discount);
			if ($isRound){
				$price = round($price);
			}
		}

		return $price * $count;
	}

    public static function getGoodBonus(MyArray $data){
        return floatval(Arr::path($data->values, 'bonus', 0)) * intval(Arr::path($data->additionDatas, 'count', 0));
    }

	public static function getGoodAmountStr(Model_Currency $currency, MyArray $data, $count){

		return Func::getPriceStr($currency, self::getGoodAmount($data, $count, $currency->getIsRound()));
	}

	public static function getGoodsAmount(MyArray $data, $isRound){
		$amount = 0;
		foreach ($data->childs as $value) {
			$amount = $amount + self::getGoodAmount($value, Arr::path($value->additionDatas, 'count', 0), $isRound);
		}

		return $amount;
	}

	public static function getGoodsCount(MyArray $data){
		$result = 0;
		foreach ($data->childs as $value) {
			$result = $result + intval(Arr::path($value->additionDatas, 'count', 0));
		}

		return $result;
	}

	public static function getGoodsBonus(MyArray $data){
		$result = 0;
		foreach ($data->childs as $value) {
			$result = $result + floatval(Arr::path($value->values, 'bonus', 0)) * intval(Arr::path($value->additionDatas, 'count', 0));
		}

		return $result;
	}

	public static function getGoodsAmountStr(Model_Currency $currency, MyArray $data){
		return Func::getPriceStr($currency, self::getGoodsAmount($data, $currency->getIsRound()));
	}

	public static function getBillAmountStr(Model_Currency $currency, MyArray $data){
		return Func::getPriceStr($currency, $data->values['amount']);
	}

	public static function getBillDiscountStr(MyArray $data){
		$discount = floatval($data->values['discount']);

		if ($discount > 0){
			return self::getNumberStr($discount);
		}

		return '';
	}

	public static function getDeliveryTypeAmountStr(Model_Currency $currency, MyArray $data, $default = ''){
		$price = $data->values['price'];
		if ($price <= 0){
			return $default;
		}

		return Func::getPriceStr($currency, $price);
	}

	public static function getBillItemsAmountStr(Model_Currency $currency, MyArray $data){

		$amount = 0;
		foreach ($data->childs as $value) {
			$amount = $amount + $value->values['amount'];
		}

		return Func::getPriceStr($currency, $amount);
	}

	public static function getBillItemAmountStr(Model_Currency $currency, MyArray $data){
		$price = $data->values['amount'];
		if ($price <= 0){
			return '';
		}

		return Func::getPriceStr($currency, $price);
	}

    /**
     * @param Model_Currency $currency
     * @param MyArray $data
     * @return mixed|string
     */
	public static function getBillItemPriceStr(Model_Currency $currency, MyArray $data){
		$price = $data->values['price'];
		if ($price <= 0){
			return '';
		}

		return Func::getPriceStr($currency, $price);
	}

    /**
     * Функция возвращает окончание для множественного числа слова на основании числа и массива окончаний
     * @param Integer $number  Число на основе которого нужно сформировать окончание
     * @param String $zero 'яблок'
     * @param String $one 'яблоко'
     * @param String $two 'яблока'
     * @param bool $isAddCount
     * @return string
     */
	public static function getCountElementStrRus($number, $zero, $one, $two, $isAddCount = TRUE){
		$count = $number;
		$number = $number % 100;
		if ($number >= 11 && $number <= 19) {
			$ending = $zero;
		}
		else {
			$i = $number % 10;
			switch ($i)
			{
				case (1): $ending = $one; break;
				case (2):
				case (3):
				case (4): $ending = $two; break;
				default: $ending = $zero;
			}
		}
		if ($isAddCount) {
            return $count . ' ' . $ending;
        }else{
            return $ending;
        }
	}


    /**
     * @param $filePath
     * @param SitePageData $sitePageData
     * @return mixed|string
     */
	public static function addSiteNameInFilePath($filePath, $sitePageData = NULL){
	    if (empty($filePath)){
	        return $filePath;
        }

	    if ($sitePageData !== NULL) {
            $scheme = $sitePageData->scheme;
        }else{
            if (key_exists('REQUEST_SCHEME', $_SERVER)){
                $scheme = $_SERVER['REQUEST_SCHEME'].'://';
            }elseif ((key_exists('HTTPS', $_SERVER)) && ($_SERVER['HTTPS'] == 'on')){
                $scheme = 'https://';
            }else{
                $scheme = 'http://';
            }
        }

		if((strpos($filePath, 'http://') === FALSE) && (strpos($filePath, 'https://') === FALSE)){
			$filePath = $scheme. (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'])) . $filePath;
		}
		$filePath = str_replace('http://', $scheme, str_replace('https://', $scheme, $filePath));

		return $filePath;
	}

    public static function getWeekDay($date){
        $tmp = strtotime($date);
        if ($tmp > 0){
            return strftime('%u', $tmp);
        }
        return '';
    }

    /**
     * Обрезать текст по заданному количеству символов
     * @param $text
     * @param $length
     * @param bool $trimWord
     * @return mixed|string
     */
	public static function trimTextNew($text, $length = NULL, $trimWord = TRUE)
    {
        if ($length === NULL){
            $length = mb_strlen($text);
        }

        $text = str_replace('  ', ' ',
            str_replace("\t", ' ',
                str_replace("\n", ' ',
                    str_replace("\r", ' ',
                        str_replace('&nbsp;', ' ',
                            strip_tags($text))))));
        if (mb_strlen($text) <= $length) {
            return $text;
        }
        $text = ' ' . mb_substr($text, 0, $length);

        if($trimWord == TRUE) {
            for ($i = mb_strlen($text); $i > -1; $i--) {
                $s = mb_substr($text, $i, 1);
                if (($s == ' ') || ($s == '.') || ($s == ',') || ($s == '!') || ($s == '?')) {
                    return trim(mb_substr($text, 0, $i)) . '...';
                }
            }
        }

        return $text;
    }

    /**
     * Обрезать текст по первому предложению
     * @param $text
     * @param int $maxLength
     * @return string
     */
    public static function trimTextFirstSentence($text, $maxLength = 0){
        $text = strip_tags($text);

        $length = strlen($text);
        if(($maxLength > 0)&&($length > $maxLength)){
            $length = $maxLength;
        }

        $result = '';
        for($i = 0; $i < $length; $i++){
            switch ($text[$i]) {
                case '.':
                case '!':
                case '?':
                    return $result = $result . $text[$i];
                    break;
            }
            $result = $result . $text[$i];
        }
        return $result;
    }

    /**
     * Есть ли пункт меню в настройках магазина
     * @param $name
     * @param SitePageData $sitePageData
     * @return bool
     */
	public static function isShopMenu($name, SitePageData $sitePageData, $isBranch = FALSE){
        $result = FALSE;

		$shopMenu = $sitePageData->shopMain->getShopMenuArray();
		if (($sitePageData->branchID > 0)){
            $shopMenu = Arr::path($shopMenu, 'shop_branch_'.$sitePageData->branch->getShopTableCatalogID(), array());
        }
       // echo print_r($sitePageData->shopMain); die;
		if (key_exists($name, $shopMenu)) {
			$result = ((Request_RequestParams::isBoolean($shopMenu[$name])));
		}

        if ($result) {
            if ($sitePageData->operation !== NULL) {
                $shopMenu = $sitePageData->operation->getAccessArray();

                if (key_exists($name, $shopMenu)) {
                    $result = (Request_RequestParams::isBoolean($shopMenu[$name]));
                }
            }
        }

        return $result;
	}

    /**
     * Ссылка на сайт магазина
     * @param SitePageData $sitePageData
     * @return string
     */
    public static function getBasicURLShop(SitePageData $sitePageData)
    {
        $result = $sitePageData->shop->getDomain();
        if(empty($result)){
            $result = $sitePageData->shop->getSubDomain().'.oto.kz';
        }

        return $sitePageData->scheme.$result.'/';
    }

    /**
     * Переводим параметы URL в input
     * @param $paramName
     * @param $paramValue
     * @return string
     */
	private static function _getURLParamToInput($paramName, &$paramValue){
		$result = '';
		if(is_array($paramValue)){
			foreach($paramValue as $key => $value) {
				$result = $result .self::_getURLParamToInput($paramName.'['.$key.']', $value);
			}
		}else{
			$result = $result . '<input name="' . $paramName . '" value="' . htmlspecialchars($paramValue) . '">';
		}

		return $result;
	}

    /**
     * Переводим параметы URL в input
     * @param array $params
     * @param null $prefix
     * @return string
     */
	public static function getURLParamsToInput($params, $prefix = NULL){
		$result = '';
		if(!is_array($params)){
		    return $result;
        }

		if(empty($prefix)) {
			foreach ($params as $paramName => $paramValue) {
				$result = $result . self::_getURLParamToInput($paramName, $paramValue);
			}
		}else{
			foreach ($params as $paramName => $paramValue) {
				$result = $result . self::_getURLParamToInput($prefix.'['.$paramName.']', $paramValue);
			}
		}

		return $result;
	}

    /**
     * Формирование полностью URL
     * @param SitePageData $sitePageData
     * @param $url
     * @param array $keyRead
     * @param array $keyFixed
     * @param array $values
     * @param bool $isGET
     * @param bool $isBranch
     * @param bool $isShop
     * @return string
     */
    public static function getFullURL(SitePageData $sitePageData, $url, array $keyRead = array(),
                                      array $keyFixed = array(), array $values = array(), $isGET = FALSE,
                                      $isBranch = FALSE, $isShop = FALSE)
    {
        $arr = array();
        foreach ($keyRead as $k => $v) {
            if(is_numeric($k)){
                $k = $v;
            }
            if (key_exists($v, $values)) {
                $tmp = $values[$v];
            }else {
                $tmp = Request_RequestParams::getParam($v);
            }

            $arr[$k] = $tmp;
        }

        if($isBranch && ($sitePageData->branchID > 0)){
            $arr['shop_branch_id']  = $sitePageData->branchID;
        }
        if($isShop && key_exists('shop_id', $values)){
            $arr['shop_branch_id']  = $values['shop_id'];
        }
        if($sitePageData->superUserID > 0){
            $arr['shop_id'] = $sitePageData->shopID;
        }

        if($isGET){
            $arr = array_merge($_GET, $arr);
        }

        $arr = array_merge($arr, $keyFixed);

        foreach ($arr as $k => $v) {
            if($v === null){
                unset($arr[$k]);
            }
        }
        ksort($arr);

        return $sitePageData->urlBasic . '/' . $sitePageData->actionURLName . $url . URL::query($arr, FALSE);
    }

    /**
     * Ссылка с добавлением параметров
     * @param SitePageData $sitePageData
     * @param $url
     * @param array $params
     * @param bool $isURLParams
     * @param bool $isGET
     * @return string
     */
    public static function getURL(SitePageData $sitePageData, $url, array $params = array(), $isURLParams = FALSE, $isGET = FALSE)
    {
		$arr = array();
        $tmp = Request_RequestParams::getParamBoolean('is_ignore_block');
        if($tmp !== NULL){
            if($tmp){
				$arr['is_ignore_block'] = 1;
            }else{
				$arr['is_ignore_block'] = 0;
            }
        }

		$arr['city_id'] = $sitePageData->cityID;

		$params = array_merge($arr, $params);

        if($isURLParams === TRUE){
            $params = array_merge($sitePageData->urlParams, $params);
        }

		if($isGET === TRUE){
			$params = array_merge($_GET, $params);
		}

        $s = URL::query($params, FALSE);

        if(strpos($url, '?') !== FALSE) {
            $s = '&'.substr($s, 1);
        }

        return $sitePageData->urlBasic . $url . $s;
    }

    public static function echoArrayInXML($key, $value){
        echo '<' . $key . '>';
        foreach($value as $key1 => $value1) {
            if (is_array($value1)) {
                self::echoArrayInXML($key1, $value1);
            }else{
                echo '<' . $key1 . '>' . htmlspecialchars($value1) . '</' . $key1 . '>';
            }
        }
        echo '</' . $key . '>';
    }

    /**
     * Вычисляется размер бонуса взависимости от случайного числа и даты создания товара
     * @param $maxPercentBonus
     * @param $number
     * @param $createdAt
     * @return float
     */
    public static function getPercentBonus($maxPercentBonus, $number, $createdAt){
        $number = abs($number) % 10;
        $day = date('j', strtotime($createdAt)) % 10;

        $shift = ($number + $day) % 10;
        if($shift == 0){
            $shift = 10;
        }

        $result = ($maxPercentBonus / 2);

        $result = (($result) / 10) * $shift;
        return ($maxPercentBonus / 2) + $result;
    }

    /**
     * Проверяем данные не пустые ли
     * если массив, то должен быть заполнен хотя бы один элемент
     * @param $value
     * @return bool
     */
    public static function emptyValue(&$value){
        if(is_array($value)){
            foreach($value as $value1){
                if(!self::emptyValue($value1)){
                    return FALSE;
                }
            }

            return TRUE;
        }else{
            return empty($value) || $value == '0.00';
        }
    }

    /**
     * Преобразует число в строку
     * @param float $number
     * @param bool $isAddCurrency
     * @param null|Model_Currency $currency
     * @param bool $isAddFloat
     * @param bool $iskop
     * @return string
     */
    public static function numberToStr($number, $isAddCurrency = FALSE, $currency = NULL, $isAddFloat = FALSE, $iskop = FALSE) {
        //$f = new NumberFormatter("ru", NumberFormatter::SPELLOUT);
        //echo $f->format(123456);// сто двадцать три тысяч четыреста пятьдесят шесть

        $nul='ноль';
        $ten=array(
            array('','один','два','три','четыре','пять','шесть','семь', 'восемь','девять'),
            array('','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять'),
        );
        $a20=array('десять','одиннадцать','двенадцать','тринадцать','четырнадцать' ,'пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать');
        $tens=array(2=>'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят' ,'восемьдесят','девяносто');
        $hundred=array('','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот','восемьсот','девятьсот');

        $unit = array();
        if ($isAddCurrency){
             switch($currency->id){
                 case Model_Currency::KZT:
                     $unit=array( // Units
                         array('тиын' ,'тиын' ,'тиын',	 1),
                         array('тенге'   ,'тенге'   ,'тенге'    ,0),
                         array('тысяча'  ,'тысячи'  ,'тысяч'     ,1),
                         array('миллион' ,'миллиона','миллионов' ,0),
                         array('миллиард','милиарда','миллиардов',0),
                     );
                     break;
                 case Model_Currency::RUB:
                     $unit=array( // Units
                         array('копейка' ,'копейки' ,'копеек',	 1),
                         array('рубль'   ,'рубля'   ,'рублей'    ,0),
                         array('тысяча'  ,'тысячи'  ,'тысяч'     ,1),
                         array('миллион' ,'миллиона','миллионов' ,0),
                         array('миллиард','милиарда','миллиардов',0),
                     );
                     break;
                 case Model_Currency::USD:
                     $unit=array( // Units
                         array('' ,'' ,'',	 1),
                         array(''   ,''   ,''    ,0),
                         array('тысяча'  ,'тысячи'  ,'тысяч'     ,1),
                         array('миллион' ,'миллиона','миллионов' ,0),
                         array('миллиард','милиарда','миллиардов',0),
                     );
                     break;
             }
        }else{
            $unit=array( // Units
                array(''   ,''   ,''    ,1),
                array('' ,'' ,'',	 0),
                array('тысяча'  ,'тысячи'  ,'тысяч'     ,1),
                array('миллион' ,'миллиона','миллионов' ,0),
                array('миллиард','милиарда','миллиардов',0),
            );
        }
        //
        list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($number)));
        $out = array();
        if (intval($rub)>0) {
            foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
                if (!intval($v)) continue;
                $uk = sizeof($unit)-$uk-1; // unit key
                $gender = $unit[$uk][3];
                if($isAddFloat){
                    $gender = 1;
                }
                list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
                // mega-logic
                $out[] = $hundred[$i1]; # 1xx-9xx
                if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
                else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
                // units without rub & kop
                if ($uk>1) $out[]= self::morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
            } //foreach
        }
        else $out[] = $nul;
        $out[] = self::morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); // rub
        if ($isAddCurrency) {
            $out[] = $kop . ' ' . self::morph($kop, $unit[0][0], $unit[0][1], $unit[0][2]); // kop
        }elseif ($isAddFloat && !$iskop && $kop != 0){
            $data = self::morph(intval($rub), 'целая', 'целых', 'целых') . ' ';
            $data .= self::numberToStr($kop, $isAddCurrency, $currency, $isAddFloat, TRUE) . ' ';
            switch (strlen($kop)) {
                case 1:
                    $data .= self::morph($kop, 'десятая', 'десятых', 'десятых');
                    break;
                case 2:
                    $data .= self::morph($kop, 'сотая', 'сотых', 'сотых');
                    break;
                case 3:
                    $data .= self::morph($kop, 'тысячная', 'тысячных', 'тысячных');
                    break;
                default:
                    $data = '';
            }

            $out[] = $data;

        }
        return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
    }

    /**
     * Склоняем словоформу
     * @param $n
     * @param $f1
     * @param $f2
     * @param $f5
     * @return mixed
     */
    private static function morph($n, $f1, $f2, $f5) {
        $n = abs(intval($n)) % 100;
        if ($n>10 && $n<20) return $f5;
        $n = $n % 10;
        if ($n>1 && $n<5) return $f2;
        if ($n==1) return $f1;
        return $f5;
    }

    /**
     * Склонение слов русского языка
     * Именнительный
     * NCL::$IMENITLN = 0;
     * Родительный падеж
     * NCL::$RODITLN = 1;
     * Дательный падеж
     * NCL::$DATELN = 2;
     * Винительный падеж
     * NCL::$VINITELN = 3;
     * Творительный падеж
     * NCL::$TVORITELN = 4;
     * Предложный падеж
     * NCL::$PREDLOGN = 5;
     *
     * $gender - род
     * - 0 - не определено
     * - 1 - мужчина
     * - 2 - женщина
     * @param $value
     * @param int|null $caseNum
     * @param int $gender
     * @return mixed
     */
	public static function getStringCaseRus($value, $caseNum = NULL, $gender = 1){
		require_once APPPATH.'vendor'.DIRECTORY_SEPARATOR.'NameCaseLib'.DIRECTORY_SEPARATOR.'NCLNameCaseRu.php';

		$nc = new NCLNameCaseRu();
		return $nc->q($value, $caseNum, $gender);
	}

    /**
     * Первая буква верхнего регистра
     * @param $str
     * @param string $encoding
     * @return false|string
     */
    public static function mb_ucfirst($str, $encoding='UTF-8')
    {
        $str = mb_ereg_replace('^[\ ]+', '', $str);
        $str = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding).
            mb_substr($str, 1, mb_strlen($str), $encoding);
        return $str;
    }

    /**
     * Первая буква нижнего регистра
     * @param $str
     * @param string $encoding
     * @return false|string
     */
    public static function mb_lcfirst($str, $encoding='UTF-8')
    {
        $str = mb_ereg_replace('^[\ ]+', '', $str);
        $str = mb_strtolower(mb_substr($str, 0, 1, $encoding), $encoding).
            mb_substr($str, 1, mb_strlen($str), $encoding);
        return $str;
    }

    /**
     * @param $search
     * @param $replace
     * @param $subject
     * @return array|string
     */
    public static function mb_str_replace($search, $replace, $subject)
    {
        if (is_array($subject)) {
            $ret = array();
            foreach ($subject as $key => $val) {
                $ret[$key] = mb_str_replace($search, $replace, $val);
            }
            return $ret;
        }

        foreach ((array) $search as $key => $s) {
            if ($s == '' && $s !== 0) {
                continue;
            }
            $r = !is_array($replace) ? $replace : (array_key_exists($key, $replace) ? $replace[$key] : '');
            $pos = mb_strpos($subject, $s, 0, 'UTF-8');
            while ($pos !== false) {
                $subject = mb_substr($subject, 0, $pos, 'UTF-8') . $r . mb_substr($subject, $pos + mb_strlen($s, 'UTF-8'), 65535, 'UTF-8');
                $pos = mb_strpos($subject, $s, $pos + mb_strlen($r, 'UTF-8'), 'UTF-8');
            }
        }
        return $subject;
    }

    public static function str_replace_once($search, $replace, $text)
    {
        $pos = strpos($text, $search);
        return $pos!==false ? substr_replace($text, $replace, $pos, strlen($search)) : $text;
    }

    /**
     * Добавляем вначало указанный символ, чтобы был определенный размер строки
     * @param string $value
     * @param string $addSymbol
     * @param int length
     * @return string
     */
    public static function addBeginSymbol($value, $addSymbol, $length)
    {
        $length = $length - mb_strlen($value);
        for ($i = 1; $i <= $length; $i++){
            $value = $addSymbol.$value;
        }
        return $value;
    }

    /**
     * Содиняем строку со страками
     * @param $string1
     * @param $string2
     * @param string $prefix
     * @param string $postfix
     */
    public static function str_concat($string1, $string2, $prefix = '', $postfix = ''){
        if(!is_array($string2)){
            $string2 = [$string];
        }

        foreach ($string2 as $child){
            if(!empty($child)){
                $string1 .= $prefix . $child . $postfix;
            }
        }

        if(!empty($postfix)) {
            $string1 = mb_substr($string1, 0, mb_strlen($postfix) * -1);
        }

        return $string1;
    }
}

if ((!function_exists('mb_str_replace')) &&
    (function_exists('mb_substr')) && (function_exists('mb_strlen')) && (function_exists('mb_strpos'))) {
    function mb_str_replace($search, $replace, $subject)
    {
        if (is_array($subject)) {
            $ret = array();
            foreach ($subject as $key => $val) {
                $ret[$key] = mb_str_replace($search, $replace, $val);
            }
            return $ret;
        }

        foreach ((array) $search as $key => $s) {
            if ($s == '' && $s !== 0) {
                continue;
            }
            $r = !is_array($replace) ? $replace : (array_key_exists($key, $replace) ? $replace[$key] : '');
            $pos = mb_strpos($subject, $s, 0, 'UTF-8');
            while ($pos !== false) {
                $subject = mb_substr($subject, 0, $pos, 'UTF-8') . $r . mb_substr($subject, $pos + mb_strlen($s, 'UTF-8'), 65535, 'UTF-8');
                $pos = mb_strpos($subject, $s, $pos + mb_strlen($r, 'UTF-8'), 'UTF-8');
            }
        }
        return $subject;
    }
}
