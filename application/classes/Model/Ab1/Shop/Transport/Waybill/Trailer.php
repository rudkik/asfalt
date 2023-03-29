<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Transport_Waybill_Trailer extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ab_shop_transport_waybill_trailers';
    const TABLE_ID = 417;

    public function __construct(){
        parent::__construct(
            array(
                'shop_transport_driver_id',
                'shop_transport_id',
                'date',
                'from_at',
                'to_at',
                'milage',
                'shop_transport_waybill_id',
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
                        $this->_dbGetElement($this->getShopTransportDriverID(), 'shop_transport_driver_id', new Model_Ab1_Shop_Transport_Driver(), $shopID);
                        break;
                    case 'shop_transport_waybill_id':
                        $this->_dbGetElement($this->getShopTransportWaybillID(), 'shop_transport_waybill_id', new Model_Ab1_Shop_Transport_Waybill(), $shopID);
                        break;
                    case 'shop_transport_id':
                        $this->_dbGetElement($this->getShopTransportID(), 'shop_transport_id', new Model_Ab1_Shop_Transport(), $shopID);
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
        $this->isValidationFieldInt('shop_transport_waybill_id', $validation);
        $this->isValidationFieldInt('shop_transport_id', $validation);
        $this->isValidationFieldFloat('milage', $validation);
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
    public function setShopTransportWaybillID($value){
        $this->setValueInt('shop_transport_waybill_id', $value);
    }
    public function getShopTransportWaybillID(){
        return $this->getValueInt('shop_transport_waybill_id');
    }

    public function setMilage($value){
        $this->setValueFloat('milage', $value);
    }
    public function getMilage(){
        return $this->getValueFloat('milage');
    }
    public function setDate($value){
        $this->setValueDateTime('date', $value);
    }
    public function getDate(){
        return $this->getValueDateTime('date');
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

}
