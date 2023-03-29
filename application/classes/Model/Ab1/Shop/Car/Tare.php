<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Car_Tare extends Model_Shop_Basic_Object{

	const TABLE_NAME = 'ab_shop_car_tares';
	const TABLE_ID = 82;

	public function __construct(){
		parent::__construct(
			array(
                'weight',
                'shop_transport_company_id',
                'tare_type_id',
                'shop_client_id',
                'is_test',
            ),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}

    /**
     * Получение данных для вспомогательных элементов из базы данных
     * и добавление его в массив
     * @param int $shopID
     * @param null | array $elements
     * @return bool
     */
    public function dbGetElements($shopID = 0, $elements = NULL){
        if(($elements !== NULL) && (is_array($elements))){
            foreach($elements as $element){
                switch($element){
                    case 'shop_transport_company_id':
                        $this->_dbGetElement($this->getShopTransportCompanyID(), 'shop_transport_company_id', new Model_Ab1_Shop_Transport_Company(), $shopID);
                        break;
                    case 'shop_client_id':
                        $this->_dbGetElement($this->getShopTransportCompanyID(), 'shop_client_id', new Model_Ab1_Shop_Client(), $shopID);
                        break;
                    case 'tare_type_id':
                        $this->_dbGetElement($this->getTareTypeID(), 'tare_type_id', new Model_Ab1_TareType(), 0);
                        break;
                }
            }
        }

        return parent::dbGetElements($shopID, $elements);
    }

    /**
     * Проверяем поля на ошибки
     * @param array $errorFields - массив ошибок
     * @return boolean
     */
    public function validationFields(array &$errorFields)
    {
        $validation = new Validation($this->getValues());
        $validation->rule('weight', 'max_length', array(':value', 13));
        $this->isValidationFieldInt('shop_transport_company_id', $validation);
        $this->isValidationFieldInt('shop_client_id', $validation);
        $this->isValidationFieldInt('tare_type_id', $validation);
        $this->isValidationFieldBool('is_test', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setTareTypeID($value){
        $this->setValueInt('tare_type_id', $value);
    }
    public function getTareTypeID(){
        return $this->getValueInt('tare_type_id');
    }

    public function setWeight($value){
        $this->setValueFloat('weight', $value);
    }
    public function getWeight(){
        return $this->getValueFloat('weight');
    }

    public function setShopTransportCompanyID($value){
        $this->setValueInt('shop_transport_company_id', $value);
    }
    public function getShopTransportCompanyID(){
        return $this->getValueInt('shop_transport_company_id');
    }

    public function setShopClientID($value){
        $this->setValueInt('shop_client_id', $value);

        if($this->getShopClientID() > 0){
            $this->setTareTypeID(Model_Ab1_TareType::TARE_TYPE_CLIENT);
        }
    }
    public function getShopClientID(){
        return $this->getValueInt('shop_client_id');
    }

    public function setIsTest($value){
        $this->setValueBool('is_test', $value);
    }
    public function getIsTest(){
        return $this->getValueBool('is_test');
    }

    public function setDriver($value){
        $this->setValue('driver', $value);
    }
    public function getDriver(){
        return $this->getValue('driver');
    }

    public function setShopTransportID($value){
        $this->setValueInt('shop_transport_id', $value);
    }
    public function getShopTransportID(){
        return $this->getValueInt('shop_transport_id');
    }
}
