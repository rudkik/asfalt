<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Transport_Waybill_Fuel_Issue extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ab_shop_transport_waybill_fuel_issues';
    const TABLE_ID = 414;

    public function __construct(){
        parent::__construct(
            array(
                'shop_transport_id',
                'fuel_type_id',
                'date',
                'shop_transport_waybill_id',
                'fuel_issue_id',
                'quantity',
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
                    case 'shop_transport_id':
                        $this->_dbGetElement($this->getShopTransportID(), 'shop_transport_id', new Model_Ab1_Shop_Transport(), $shopID);
                        break;
                    case 'shop_transport_waybill_id':
                        $this->_dbGetElement($this->getShopTransportWaybillID(), 'shop_transport_waybill_id', new Model_Ab1_Shop_Transport_Waybill(), $shopID);
                        break;
                    case 'fuel_type_id':
                        $this->_dbGetElement($this->getFuelTypeID(), 'fuel_type_id', new Model_Ab1_Fuel_Type(), 0);
                        break;
                    case 'fuel_issue_id':
                        $this->_dbGetElement($this->getFuelIssueID(), 'fuel_issue_id', new Model_Ab1_Fuel_Issue(), 0);
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
        $this->isValidationFieldInt('shop_transport_id', $validation);
        $this->isValidationFieldInt('shop_transport_waybill_id', $validation);
        $this->isValidationFieldInt('fuel_type_id', $validation);
        $this->isValidationFieldInt('fuel_issue_id', $validation);
        $this->isValidationFieldFloat('quantity', $validation);
        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopTransportID($value){
        $this->setValueInt('shop_transport_id', $value);
    }
    public function getShopTransportID(){
        return $this->getValueInt('shop_transport_id');
    }
    public function setFuelTypeID($value){
        $this->setValueInt('fuel_type_id', $value);
    }
    public function getFuelTypeID(){
        return $this->getValueInt('fuel_type_id');
    }
    public function setFuelIssueID($value){
        $this->setValueInt('fuel_issue_id', $value);
    }
    public function getFuelIssueID(){
        return $this->getValueInt('fuel_issue_id');
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
        $this->setValueDateTime('date', $value);
    }
    public function getDate(){
        return $this->getValueDateTime('date');
    }
}
