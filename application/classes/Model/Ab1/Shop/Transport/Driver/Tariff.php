<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Transport_Driver_Tariff extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_transport_driver_tariffs';
	const TABLE_ID = 388;

	public function __construct(){
		parent::__construct(
			array(
                'shop_worker_id',
                'shop_transport_driver_id',
                'date_from',
                'date_to',
                'shop_transport_id',
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
                    case 'shop_transport_driver_id':
                        $this->_dbGetElement($this->getShopTransportDriverID(), 'shop_transport_driver_id', new Model_Ab1_Shop_Transport_Driver(), 0);
                        break;
                    case 'shop_transport_id':
                        $this->_dbGetElement($this->getShopTransportID(), 'shop_transport_id', new Model_Ab1_Shop_Transport(), 0);
                        break;
                    case 'shop_worker_id':
                        $this->_dbGetElement($this->getShopWorkerID(), 'shop_worker_id', new Model_Ab1_Shop_Worker(), $shopID);
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
        $this->isValidationFieldInt('shop_transport_driver_id', $validation);
        $this->isValidationFieldInt('shop_worker_id', $validation);
        $this->isValidationFieldStr('quantity', $validation);
        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopTransportID($value){
        $this->setValueInt('shop_transport_id', $value);
    }
    public function getShopTransportID(){
        return $this->getValueInt('shop_transport_id');
    }
    public function setShopTransportDriverID($value){
        $this->setValueInt('shop_transport_driver_id', $value);
    }
    public function getShopTransportDriverID(){
        return $this->getValueInt('shop_transport_driver_id');
    }
    public function setShopWorkerID($value){
        $this->setValueInt('shop_worker_id', $value);
    }
    public function getShopWorkerID(){
        return $this->getValueInt('shop_worker_id');
    }
    public function setQuantity($value){
        $this->setValue('quantity', $value);
    }
    public function getQuantity(){
        return $this->getValue('quantity');
    }
    public function setDateFrom($value){
        $this->setValueDate('date_from', $value);
    }
    public function getDateFrom(){
        return $this->getValueDateTime('date_from');
    }
    public function setDateTo($value){
        $this->setValueDate('date_to', $value);
    }
    public function getDateTo(){
        return $this->getValueDateTime('date_to');
    }
}
