<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Transport_Sample_Fuel extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_transport_sample_fuels';
    const TABLE_ID = 392;

    public function __construct(){
        parent::__construct(
            array(
                'shop_transport_mark_id',
                'quantity',
                'shop_transport_driver_id',
                'shop_worker_responsible_id',
                'number',
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
                    case 'shop_transport_mark_id':
                        $this->_dbGetElement($this->getShopTransportDriverID(), 'shop_transport_mark_id', new Model_Ab1_Shop_Transport_Mark(), $shopID);
                        break;
                    case 'shop_worker_responsible_id':
                        $this->_dbGetElement($this->getShopWorkerResponsibleID(), 'shop_worker_responsible_id', new Model_Ab1_Shop_Worker_Responsible(), $shopID);
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
        $this->isValidationFieldInt('shop_transport_mark_id', $validation);
        $this->isValidationFieldInt('shop_worker_responsible_id', $validation);
        $this->isValidationFieldFloat('quantity', $validation);
        $this->isValidationFieldStr('number', $validation);
        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopTransportDriverID($value){
        $this->setValueInt('shop_transport_driver_id', $value);
    }
    public function getShopTransportDriverID(){
        return $this->getValueInt('shop_transport_driver_id');
    }
    public function setShopTransportMarkID($value){
        $this->setValueInt('shop_transport_mark_id', $value);
    }
    public function getShopTransportMarkID(){
        return $this->getValueInt('shop_transport_mark_id');
    }
    public function setShopWorkerResponsibleID($value){
        $this->setValueInt('shop_worker_responsible_id', $value);
    }
    public function getShopWorkerResponsibleID(){
        return $this->getValueInt('shop_worker_responsible_id');
    }
    public function setQuantity($value){
        $this->setValueFloat('quantity', $value);
    }
    public function getQuantity(){
        return $this->getValueFloat('quantity');
    }
    public function setUnit($value){
        $this->setValue('number', $value);
    }
    public function getUnit(){
        return $this->getValue('number');
    }

    public function setMilage($value){
        $this->setValue('milage', $value);
    }
    public function getMilage(){
        return $this->getValue('milage');
    }

}
