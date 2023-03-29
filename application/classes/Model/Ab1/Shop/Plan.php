<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_Shop_Plan extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_plans';
	const TABLE_ID = 206;

	public function __construct(){
		parent::__construct(
			array(
                'shop_client_id',
                'date_from',
                'date_to',
                'cars',
            ),
			self::TABLE_NAME,
			self::TABLE_ID
		);

		$this->isAddCreated = TRUE;
	}

	/**
	 * Получение данных для вспомогательных элементов из базы данных
	 * и добавление его в массив
	 */
	public function dbGetElements($shopID = 0, $elements = NULL){
		if(($elements === NULL) || (! is_array($elements))){
		}else{
			foreach($elements as $element){
				switch($element){
                    case 'shop_client_foreman_id':
                        $this->_dbGetElement($this->getShopClientForemanID(), 'shop_client_foreman_id', new Model_Ab1_Shop_Client());
                        break;
                    case 'shop_client_id':
                        $this->_dbGetElement($this->getShopClientID(), 'shop_client_id', new Model_Ab1_Shop_Client(), $shopID);
                        break;
				}
			}
		}

		parent::dbGetElements($shopID, $elements);
	}

    /**
     * Проверяем поля на ошибки
     * @param array $errorFields - массив ошибок
     * @return boolean
     */
    public function validationFields(array &$errorFields)
    {
        $validation = new Validation($this->getValues());
        $this->isValidationFieldInt('shop_client_id', $validation);
        $this->isValidationFieldInt('shop_client_foreman_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    /**
     * Возвращаем cписок всех переменных
     */
    public function getValues($isGetElement = FALSE, $isParseArray = FALSE, $shopID = NULL)
    {
        $arr = parent::getValues($isGetElement, $isParseArray, $shopID);

        if($isParseArray === TRUE) {
            $arr['cars'] = $this->getCarsArray();
            $arr['deliveries'] = $this->getDeliveriesArray();
        }

        return $arr;
    }

    // Список номеров через запятую
    public function setCars($value){
        $this->setValue('cars', $value);
    }
    public function getCars(){
        return $this->getValue('cars');
    }
    public function setCarsArray(array $value){
        $this->setValueArray('cars', $value, FALSE);
    }
    public function getCarsArray(){
        return $this->getValueArray('cars', NULL, array(), FALSE);
    }

    // Список доставок
    public function setDeliveries($value){
        $this->setValue('deliveries', $value);
    }
    public function getDeliveries(){
        return $this->getValue('deliveries');
    }
    public function setDeliveriesArray(array $value){
        $this->setValueArray('deliveries', $value);
    }
    public function getDeliveriesArray(){
        return $this->getValueArray('deliveries', NULL, array());
    }

    public function setDate($value){
        $this->setValueDate('date', $value);
    }
    public function getDate(){
        return $this->getValueDate('date');
    }

    public function setDateFrom($value){
        $this->setValueDateTime('date_from', $value);
    }
    public function getDateFrom(){
        return $this->getValueDateTime('date_from');
    }
    public function setTimeFrom($value){
        $value1 = strtotime($value, FALSE);
        if($value1 === FALSE){
            $this->setDateFrom(NULL);
        }else {
            $this->setDateFrom($this->getDate().' '.date('H:i:s', $value1));
        }
    }
    public function getTimeFrom(){
        $result = strtotime($this->getDateFrom(), FALSE);
        if ($result !== FALSE){
            return date('H:i:s', $result);
        }
        return NULL;
    }

    public function setDateTo($value){
        $this->setValueDateTime('date_to', $value);
    }
    public function getDateTo(){
        return $this->getValueDateTime('date_to');
    }
    public function setTimeTo($value){
        $value2 = strtotime($value);
        if($value2 === FALSE){
            $this->setDateTo(NULL);
        }else {
            $value1 = strtotime($this->getTimeFrom());
            if (($value2 === NULL) || ($value1 < $value2)) {
                $this->setDateTo($this->getDate().' '.date('H:i:s', $value2));
            }else{
                $this->setDateTo(date('Y-m-d', strtotime($this->getDate().' +1 day')).' '.date('H:i:s', $value2));
            }
        }
    }
    public function getTimeTo(){
        $result = strtotime($this->getDateTo());
        if ($result !== FALSE){
            return date('H:i:s', $result);
        }
        return NULL;
    }

    public function setShopClientID($value){
        $this->setValueInt('shop_client_id', $value);
    }
    public function getShopClientID(){
        return $this->getValueInt('shop_client_id');
    }

    public function setShopClientForemanID($value){
        $this->setValueInt('shop_client_foreman_id', $value);
    }
    public function getShopClientForemanID(){
        return $this->getValueInt('shop_client_foreman_id');
    }
}
