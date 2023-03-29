<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Transport_Repair extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ab_shop_transport_repairs';
    const TABLE_ID = 397;

    public function __construct(){
        parent::__construct(
            array(
                'shop_transport_driver_id',
                'shop_transport_id',
                'date',
                'from_at',
                'to_at',
                'number',
                'hours',
            ),
            self::TABLE_NAME,
            self::TABLE_ID
        );

        $this->isAddCreated = TRUE;
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
                    case 'shop_transport_driver_id':
                        $this->_dbGetElement($this->getShopTransportDriverID(), 'shop_transport_driver_id', new Model_Ab1_Shop_Transport_Driver(), 0);
                        break;
                    case 'shop_transport_id':
                        $this->_dbGetElement($this->getShopTransportID(), 'shop_transport_id', new Model_Ab1_Shop_Transport(), 0);
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
        $this->isValidationFieldInt('shop_transport_driver_id', $validation);
        $this->isValidationFieldInt('shop_transport_id', $validation);
        $this->isValidationFieldStr('number', $validation);
        $this->isValidationFieldStr('hours', $validation);
        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopTransportDriverID($value){
        $this->setValueInt('shop_transport_driver_id', $value);
    }
    public function getShopTransportDriverID(){
        return $this->getValueInt('shop_transport_driver_id');
    }
    public function setShopTransportID($value){
        $this->setValueInt('shop_transport_id', $value);
    }
    public function getShopTransportID(){
        return $this->getValueInt('shop_transport_id');
    }
    public function setDate($value){
        $this->setValueDate('date', $value);
    }
    public function getDate(){
        return $this->getValueDate('date');
    }

    public function setFromAt($value){
        $this->setValueDateTime('from_at', $value);
    }
    public function getFromAt(){
        return $this->getValueDateTime('from_at');
    }

    public function setToAt($value){
        $this->setValueDateTime('to_at', $value);
    }
    public function getToAt(){
        return $this->getValueDateTime('to_at');
    }
    public function setNumber($value){
        $this->setValue('number', $value);
    }
    public function getNumber(){
        return $this->getValue('number');
    }
    public function setHours($value){
        $this->setValue('hours', $value);
    }
    public function getHours(){
        return $this->getValue('hours');
    }

    public function setShopSubdivisionID($value){
        $this->setValueInt('shop_subdivision_id', $value);
    }
    public function getShopSubdivisionID(){
        return $this->getValueInt('shop_subdivision_id');
    }
}
