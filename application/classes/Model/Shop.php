<?php defined('SYSPATH') or die('No direct script access.');

class Model_Shop extends Model_Basic_Collations{
    const SHOP_SOUTH = 9999; // Участок Южный
    const SHOP_NORTH = 406514; // Участок Северный

	const PARAM_NAME_SEND_EMAIL_INFO = 'send_email_info'; // массив куда слать сообщения

	const TABLE_NAME='ct_shops';
	const TABLE_ID = 49;

	public function __construct(){
		parent::__construct(
			array(
				'main_shop_id',
				'shop_root_id',
				'is_block',
				'is_active',
				'domain',
				'sub_domain',
				'currency_ids',
				'default_currency_id',
				'language_ids',
				'default_language_id',
				'city_id',
                'city_ids',
                'land_ids',
				'requisites',
				'work_time',
				'delivery_work_time',
				'site_shablon_id',
				'site_shablon_path',
				'shop_menu',
				'params',
                'balance',
                'shop_operation_id',
                'validity_at',
                'referral_shop_id',
			),

			self::TABLE_NAME,
			self::TABLE_ID
		);
	}

    /**
     * Проверяем поля на ошибки
     * @param array $errorFields - массив ошибок
     * @param null $validation
     * @return bool
     */
	public function validationFields(array &$errorFields, $validation = NULL)
	{
	    if($validation === NULL) {
            $validation = new Validation($this->getValues());
        }

		$validation->rule('currency_ids', 'max_length', array(':value', 500))
			->rule('language_ids', 'max_length', array(':value', 500))
			->rule('city_id', 'max_length', array(':value', 11))
			->rule('city_ids', 'max_length', array(':value', 1000))
			->rule('default_language_id', 'max_length', array(':value', 11))
			->rule('default_currency_id', 'max_length', array(':value', 11))
			->rule('site_shablon_id', 'max_length', array(':value', 11))
			->rule('shop_root_id', 'max_length', array(':value', 11))
			->rule('site_shablon_path', 'max_length', array(':value', 100))
			->rule('official_name', 'max_length', array(':value', 250))
			->rule('domain', 'max_length', array(':value', 250))
			->rule('sub_domain', 'max_length', array(':value', 250))
			->rule('work_time', 'max_length', array(':value', 650000))
			->rule('params', 'max_length', array(':value', 650000))
			->rule('shop_menu', 'max_length', array(':value', 650000))
			->rule('requisites', 'max_length', array(':value', 650000))
			->rule('is_block', 'max_length', array(':value', 1))
			->rule('is_active', 'max_length', array(':value', 1))
            ->rule('main_shop_id', 'max_length', array(':value', 11))
            ->rule('referral_shop_id', 'max_length', array(':value', 11))
            ->rule('shop_operation_id', 'max_length', array(':value', 11))
            ->rule('balance', 'max_length', array(':value', 13))
			->rule('delivery_work_time', 'max_length', array(':value', 650000));

        if ($this->isFindFieldAndIsEdit('shop_operation_id')) {
            $validation->rule('shop_operation_id', 'digit');
        }
		if ($this->isFindFieldAndIsEdit('main_shop_id')) {
			$validation->rule('main_shop_id', 'digit');
		}
		if ($this->isFindFieldAndIsEdit('city_id')) {
			$validation->rule('city_id', 'digit');
		}
		if ($this->isFindFieldAndIsEdit('is_active')) {
			$validation->rule('is_active', 'digit');
		}
		if ($this->isFindFieldAndIsEdit('is_block')) {
			$validation->rule('is_block', 'digit');
		}
		if ($this->isFindFieldAndIsEdit('default_language_id')) {
			$validation->rule('default_language_id', 'digit');
		}
		if ($this->isFindFieldAndIsEdit('default_currency_id')) {
			$validation->rule('default_currency_id', 'digit');
		}
		if ($this->isFindFieldAndIsEdit('site_shablon_id')) {
			$validation->rule('site_shablon_id', 'digit');
		}
		if ($this->isFindFieldAndIsEdit('shop_root_id')) {
			$validation->rule('shop_root_id', 'digit');
		}

		return $this->_validationFields($validation, $errorFields);
	}

	/**
	 * Получение данных для вспомогательных элементов из базы данных
	 * и добавление его в массив
	 */
    public function dbGetElements($shopID = 0, $elements = NULL)
    {
		if(($elements === NULL) || (! is_array($elements))){
		}else{
            foreach($elements as $element){
                switch($element){
					case 'site_shablon_id':
						$this->_dbGetElement($this->getSiteShablonID(), 'site_shablon_id', new Model_SiteShablon());
						break;
                    case 'shop_root_id':
                        $this->_dbGetElement($this->getShopRootID(), 'shop_root_id', new Model_Shop());
                        break;
                    case 'main_shop_id':
                        $this->_dbGetElement($this->getMainShopID(), 'main_shop_id', new Model_Shop());
                        break;
                    case 'city_id':
                        $this->_dbGetElement($this->getCityID(), 'city_id', new Model_City());
                        break;
                    case 'land_id':
                        $this->_dbGetElement($this->getLandID(), 'land_id', new Model_Land());
                        break;
                    case 'default_language_id':
                        $this->_dbGetElement($this->getDefaultLanguageID(), 'default_language_id', new Model_Language());
                        break;
                    case 'default_currency_id':
                        $this->_dbGetElement($this->getDefaultCurrencyID(), 'default_currency_id', new Model_Currency());
                        break;
                    case 'shop_operation_id':
                        $this->_dbGetElement($this->getShopOperationID(), 'shop_operation_id', new Model_Shop_Operation(), $shopID);
                        break;
					case 'shop_address_id':
						$sitePageData = new SitePageData();
						$sitePageData->dataLanguageID = $this->languageID;
						$this->_dbGetElement(Request_Shop_Address::getMainAddressID($this->id, $sitePageData, $this->getDBDriver()), 'shop_address_id', new Model_Shop_Address(), $shopID);
						break;
                    case 'requisites_bank_id':
                        $this->_dbGetElement(Arr::path($this->getRequisitesArray(), 'bank_id', 0), 'requisites_bank_id', new Model_Bank());
                        break;
                    case 'requisites_organization_type_id':
                        $this->_dbGetElement(Arr::path($this->getRequisitesArray(), 'organization_type_id', 0), 'requisites_organization_type_id', new Model_OrganizationType());
                        break;
                    case 'requisites_organization_tax_type_id':
                        $this->_dbGetElement(Arr::path($this->getRequisitesArray(), 'organization_tax_type_id', 0), 'requisites_organization_tax_type_id', new Model_Tax_OrganizationTaxType());
                        break;
                    case 'requisites_authority_id':
                        $this->_dbGetElement(Arr::path($this->getRequisitesArray(), 'authority_id', 0), 'requisites_authority_id', new Model_Tax_Authority());
                        break;
                    case 'requisites_akimat_id':
                        $this->_dbGetElement(Arr::path($this->getRequisitesArray(), 'akimat_id', 0), 'requisites_akimat_id', new Model_Tax_Akimat());
                        break;
                    case 'requisites_shop_bank_account_id':
                        $this->_dbGetElement(Arr::path($this->getRequisitesArray(), 'shop_bank_account_id', 0), 'requisites_shop_bank_account_id', new Model_Tax_Shop_Bank_Account());
                        break;
                }
            }
        }

        parent::dbGetElements($shopID, $elements);
    }

	/**
	 * Возвращаем cписок всех переменных
	 */
	public function getValues($isGetElement = FALSE, $isParseArray = FALSE, $shopID = NULL)
	{
		$arr = parent::getValues($isGetElement, $isParseArray, $shopID);

		if($isParseArray === TRUE) {
			$arr['shop_menu'] = $this->getShopMenuArray();
            $arr['currency_ids'] = $this->getCurrencyIDsArray();
            $arr['params'] = $this->getParamsArray();
            $arr['requisites'] = $this->getRequisitesArray();
			$arr['language_ids'] = $this->getLanguageIDsArray();
			$arr['city_ids'] = $this->getCityIDsArray();
            $arr['delivery_work_time'] = $this->getDeliveryWorkTimeArray();
            $arr['work_time'] = $this->getWorkTimeArray();
		}

		return $arr;
	}

    // срок действия подписки
    public function setReferralShopID($value){
        $this->setValueInt('referral_shop_id', $value);
    }
    public function getReferralShopID(){
        return $this->getValueInt('referral_shop_id');
    }

	// срок действия подписки
    public function setValidityAt($value){
        $this->setValueDateTime('validity_at', $value);
    }
    public function getValidityAt(){
        return $this->getValueDateTime('validity_at');
    }

	// JSON настройки списка полей
	public function setShopMenu($value){
		$this->setValue('shop_menu', $value);
	}
	public function getShopMenu(){
		return $this->getValue('shop_menu');
	}
	public function setShopMenuArray(array $value){
		$this->setValueArray('shop_menu', $value);
	}
	public function getShopMenuArray()
	{
		return $this->getValueArray('shop_menu');
	}

    // JSON параметры магазина
    public function setParams($value){
        $this->setValue('params', $value);
    }
    public function getParams(){
        return $this->getValue('params');
    }
    public function setParamsArray(array $value){
        $this->setValueArray('params', $value);
    }
    public function getParamsArray($key = NULL, $default = array())
	{
		return $this->getValueArray('params', $key, $default);
	}
	public function addParamsArray(array $value){
		$tmp = $this->getParamsArray();

		foreach($value as $k => $v){
			// список e-mail для отправки системных сообщений
			if($k == self::PARAM_NAME_SEND_EMAIL_INFO){
				if((!is_array($v)) && (!empty($v))){
					$tmp = explode(',', str_replace(',,', ',', str_replace(' ', ',', str_replace("\r\n", ',', $v))));

					$v = array();
					foreach($tmp as $value){
						if(!empty($value)){
							$v[] = $value;
						}
					}
				}
			}

			$tmp[$k] = $v;
		}

		$this->setParamsArray($tmp);
	}

	// JSON реквизитов
	public function setRequisites($value){
		$this->setValue('requisites', $value);
	}
	public function getRequisites(){
		return $this->getValue('requisites');
	}
	public function setRequisitesArray(array $value){
		$this->setValueArray('requisites', $value);
	}
	public function getRequisitesArray()
	{
		return $this->getValueArray('requisites');
	}

    /**
     * @param array $value
     * @param bool $isAddAll - добавлять все записи или только новые
     */
    public function addRequisitesArray(array $value, $isAddAll = TRUE){
        $tmp = $this->getRequisitesArray();

        foreach($value as $k => $v){
            if($isAddAll || (! key_exists($k, $tmp) || empty($tmp[$k]))) {
                $tmp[$k] = $v;
            }
        }

        $this->setRequisitesArray($tmp);
    }

    // Список ID городов
    public function setCityIDs($value){
        $this->setValue('city_ids', $value);
    }
    public function getCityIDs(){
        return $this->getValue('city_ids');
    }
    public function setCityIDsArray(array $value){
        $this->setValueArrayIDs('city_ids', $value);
    }
    public function getCityIDsArray(){
        return $this->getValueArrayIDs('city_ids');
    }

    // Список ID стран
    public function setLandIDs($value){
        $this->setValue('land_ids', $value);
    }
    public function getLandIDs(){
        return $this->getValue('land_ids');
    }
    public function setLandIDsArray(array $value){
        $this->setValueArrayIDs('land_ids', $value);
    }
    public function getLandIDsArray(){
        return $this->getValueArrayIDs('land_ids');
    }

	// Список ID курсов оплаты магазина
	public function setCurrencyIDs($value){
		$this->setValue('currency_ids', $value);
	}
	public function getCurrencyIDs(){
		return $this->getValue('currency_ids');
	}
	public function setCurrencyIDsArray(array $value){
		$this->setValueArrayIDs('currency_ids', $value);
	}

	/**
	 * @return array
	 */
	public function getCurrencyIDsArray(){
		return $this->getValueArrayIDs('currency_ids');
	}

	// Список ID языков магазина
	public function setLanguageIDs($value){
		$this->setValue('language_ids', $value);
	}
	public function getLanguageIDs(){
		return $this->getValue('language_ids');
	}
	public function setLanguageIDsArray(array $value){
		$this->setValueArrayIDs('language_ids', $value);
	}
	public function getLanguageIDsArray(){
		return $this->getValueArrayIDs('language_ids');
	}

	// ID родителя магазина
	public function setShopRootID($value){
		$this->setValueInt('shop_root_id', $value);
	}
	public function getShopRootID(){
		return $this->getValueInt('shop_root_id');
	}

	// ID города, где работает магазин
	public function setCityID($value){
		$this->setValueInt('city_id', $value);
	}
	public function getCityID(){
		return $this->getValueInt('city_id');
	}

	// ID языка используемый магазином по умолчанию
	public function setDefaultLanguageID($value){
		$this->setValueInt('default_language_id', $value);
	}
	public function getDefaultLanguageID(){
		return $this->getValueInt('default_language_id');
	}

	// ID курса валюты используемые магазином по умолчанию
	public function setDefaultCurrencyID($value){
		$this->setValueInt('default_currency_id', $value);
	}
	public function getDefaultCurrencyID(){
		return $this->getValueInt('default_currency_id');
	}

	// Официальное название магазина
	public function setOfficialName($value){
		$this->setValue('official_name', $value);
	}
	public function getOfficialName(){
		return $this->getValue('official_name');
	}

	// Адрес внешнего домена
	public function setDomain($value){
		$this->setValue('domain', $value);
	}
	public function getDomain(){
		return $this->getValue('domain');
	}

	// Адрес поддомена на сайте
	public function setSubDomain($value){
		$this->setValue('sub_domain', $value);
	}
	public function getSubDomain(){
		return $this->getValue('sub_domain');
	}


	// JSON времени работы магазина
	public function setWorkTime($value){
		$this->setValue('work_time', $value);
	}
	public function getWorkTime(){
		return $this->getValue('work_time');
	}
	public function setWorkTimeArray(array $value){
		$this->getValueArray('work_time', $value);
	}
	public function getWorkTimeArray(){
		return $this->getValueArray('work_time');
	}

	// JSON времени работы магазина
	public function setDeliveryWorkTime($value){
		$this->setValue('delivery_work_time', $value);
	}
	public function getDeliveryWorkTime(){
		return $this->getValue('delivery_work_time');
	}
	public function setDeliveryWorkTimeArray(array $value){
		$this->getValueArray('delivery_work_time', $value);
	}
	public function getDeliveryWorkTimeArray(){
		return $this->getValueArray('delivery_work_time');
	}

	// ID шаблона сайта
	public function setSiteShablonID($value){
		$this->setValueInt('site_shablon_id', $value);
	}
	public function getSiteShablonID(){
		return $this->getValueInt('site_shablon_id');
	}

	// ID основного магазина
	public function setMainShopID($value){
		$this->setValueInt('main_shop_id', $value);
	}
	public function getMainShopID(){
		return $this->getValueInt('main_shop_id');
	}

	// Активна ли запись
	public function setIsActive($value)
	{
		$this->setValueBool('is_active', $value);
	}
	public function getIsActive()
	{
		$this->getValueBool('is_active');
	}

	// Активна ли запись
	public function setIsBlock($value)
	{
		$this->setValueBool('is_block', $value);
	}
	public function getIsBlock()
	{
		$this->getValueBool('is_block');
	}

	// Путь до шаблона магазина
	public function setSiteShablonPath($value){
		$this->setValueInt('site_shablon_path', $value);
	}
	public function getSiteShablonPath(){
		return $this->getValueInt('site_shablon_path');
	}

    public function setBalance($value){
        $this->setValueFloat('balance', $value);
    }
    public function getBalance(){
        return $this->getValueFloat('balance');
    }

    public function setShopOperationID($value){
        $this->setValueInt('shop_operation_id', $value);
    }
    public function getShopOperationID(){
        return $this->getValueInt('shop_operation_id');
    }
}
