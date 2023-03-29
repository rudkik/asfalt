<?php defined('SYSPATH') or die('No direct script access.');


class Model_Magazine_Shop_Worker_Limit extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'sp_shop_worker_limits';
    const TABLE_ID = 293;

	public function __construct(){
		parent::__construct(
			array(
                'amount',
                'amount_block',
                'amount_balance',
                'shop_worker_id',
                'date',
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

        $this->isValidationFieldFloat('amount', $validation);
        $this->isValidationFieldFloat('amount_block', $validation);
        $this->isValidationFieldFloat('amount_balance', $validation);
        $this->isValidationFieldInt('shop_worker_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setAmount($value){
        $this->setValueFloat('amount', $value);
        $this->setAmountBalance($this->getAmount() - $this->getAmountBlock());
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

    public function setAmountBlock($value){
        $this->setValueFloat('amount_block', $value);
        $this->setAmountBalance($this->getAmount() - $this->getAmountBlock());
    }
    public function getAmountBlock(){
        return $this->getValueFloat('amount_block');
    }

    public function setAmountBalance($value){
        $this->setValueFloat('amount_balance', $value);
    }
    public function getAmountBalance(){
        return $this->getValueFloat('amount_balance');
    }

    public function setShopWorkerID($value){
        $this->setValueInt('shop_worker_id', $value);
    }
    public function getShopWorkerID(){
        return $this->getValueInt('shop_worker_id');
    }

    public function setDate($value){
        $this->setValueDate('date', $value);
        return $this;
    }
    public function getDate(){
        return $this->getValueDate('date');
    }
    public function setYear($value){
        $date = $this->getDate();
        if (empty($date)){
            $this->setDate($value.'-01-01');
        }else{
            $tmp = Helpers_DateTime::getMonth($date);
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
        if(strlen($value) < 2){
            $value = '0'.$value;
        }

        $date = $this->getDate();
        if (empty($date)){
            $this->setDate(date('Y').'-'.$value.'-01');
        }else{
            $this->setDate(Helpers_DateTime::getYear($date).'-'.$value.'-01');
        }
    }
    public function getMonth(){
        return Helpers_DateTime::getMonth($this->getDate());
    }

}
