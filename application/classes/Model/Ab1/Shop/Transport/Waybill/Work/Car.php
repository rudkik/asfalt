<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Transport_Waybill_Work_Car extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ab_shop_transport_waybill_work_cars';
    const TABLE_ID = 366;

    public function __construct(){
        parent::__construct(
            array(
                'shop_transport_id',
                'shop_transport_work_id',
                'date',
                'quantity',
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
                    case 'shop_transport_work_id':
                        $this->_dbGetElement($this->getShopTransportWorkID(), 'shop_transport_work_id', new Model_Ab1_Shop_Transport_Work(), 0);
                        break;
                    case 'shop_transport_id':
                        $this->_dbGetElement($this->getShopTransportID(), 'shop_transport_id', new Model_Ab1_Shop_Transport(), 0);
                        break;
                    case 'shop_transport_waybill_id':
                        $this->_dbGetElement($this->getShopTransportWaybillID(), 'shop_transport_waybill_id', new Model_Ab1_Shop_Transport_Waybill(), $shopID);
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
        $this->isValidationFieldInt('shop_transport_work_id', $validation);
        $this->isValidationFieldInt('shop_transport_id', $validation);
        $this->isValidationFieldInt('shop_transport_waybill_id', $validation);
        $this->isValidationFieldFloat('quantity', $validation);
        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopTransportWorkID($value){
        $this->setValueInt('shop_transport_work_id', $value);
    }
    public function getShopTransportWorkID(){
        return $this->getValueInt('shop_transport_work_id');
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
    public function setQuantity($value){
        $this->setValueFloat('quantity', $value);
    }
    public function getQuantity(){
        return $this->getValueFloat('quantity');
    }
    public function setDate($value){
        $this->setValueDate('date', $value);
    }
    public function getDate(){
        return $this->getValueDate('date');
    }
}
