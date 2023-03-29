<?php defined('SYSPATH') or die('No direct script access.');


class Model_Magazine_Shop_Talon extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'sp_shop_talons';
	const TABLE_ID = 271;

	public function __construct(){
		parent::__construct(
			array(
                'shop_worker_id',
                'talon_type_id',
                'quantity',
                'quantity_spent',
                'date',
                'validity_from',
                'validity_to',
                'quantity_balance',
            ),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}

    /**
     * Получение данных для вспомогательных элементов из базы данных
     * и добавление его в массив
     * @param int $shopID
     * @param null $elements
     * @return bool
     */
    public function dbGetElements($shopID = 0, $elements = NULL){
        if(is_array($elements)){
            foreach($elements as $element){
                switch($element){
                    case 'shop_worker_id':
                        $this->_dbGetElement($this->getShopWorkerID(), 'shop_worker_id', new Model_Ab1_Shop_Worker(), $shopID);
                        break;
                    case 'talon_type_id':
                        $this->_dbGetElement($this->getTalonTypeID(), 'talon_type_id', new Model_Magazine_TalonType(), $shopID);
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
        $this->isValidationFieldInt('shop_worker_id', $validation);
        $this->isValidationFieldInt('talon_type_id', $validation);
        $this->isValidationFieldInt('quantity', $validation);
        $this->isValidationFieldInt('quantity_spent', $validation);
        $this->isValidationFieldInt('quantity_balance', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopWorkerID($value){
        $this->setValueInt('shop_worker_id', $value);
    }
    public function getShopWorkerID(){
        return $this->getValueInt('shop_worker_id');
    }

    public function setTalonTypeID($value){
        $this->setValueInt('talon_type_id', $value);
    }
    public function getTalonTypeID(){
        return $this->getValueInt('talon_type_id');
    }

    public function setQuantity($value){
        $this->setValueInt('quantity', $value);

        $this->setQuantityBalance($this->getQuantity() - $this->getQuantitySpent());
    }
    public function getQuantity(){
        return $this->getValueInt('quantity');
    }

    public function setQuantitySpent($value){
        $this->setValueInt('quantity_spent', $value);
        $this->setQuantityBalance($this->getQuantity() - $this->getQuantitySpent());
    }
    public function getQuantitySpent(){
        return $this->getValueInt('quantity_spent');
    }

    public function setQuantityBalance($value){
        $this->setValueInt('quantity_balance', $value);
    }
    public function getQuantityBalance(){
        return $this->getValueInt('quantity_balance');
    }

    public function setDate($value){
        $this->setValueDate('date', $value);
    }
    public function getDate(){
        return $this->getValueDate('date');
    }

    public function setValidityTo($value){
        $this->setValueDate('validity_to', $value);
    }
    public function getValidityTo(){
        return $this->getValueDate('validity_to');
    }

    public function setValidityFrom($value){
        $this->setValueDate('validity_from', $value);
    }
    public function getValidityFrom(){
        return $this->getValueDate('validity_from');
    }

    public function setYear($value){
        if (empty($this->getDate())){
            $this->setDate($value.'-01-01');
        }else{
            $tmp = $this->getMonth();
            if(strlen($tmp) < 2){
                $tmp = '0'.$tmp;
            }
            $this->setDate($value.'-'.$tmp.'-01');
        }
    }
    public function getYear(){
        return Helpers_DateTime::getYear($this->getDate());
    }

    public function setMonth($value){
        $date = $this->getDate();
        if (empty($date)){
            $this->setDate(date('Y').'-'.$value.'-01');
        }else{
            if(strlen($value) < 2){
                $value = '0'.$value;
            }
            $this->setDate($this->getYear().'-'.$value.'-01');
        }
    }
    public function getMonth(){
        return Helpers_DateTime::getMonth($this->getDate());
    }
}
