<?php defined('SYSPATH') or die('No direct script access.');


class Model_Shop_Paid extends Model_Shop_Table_Basic_Rubric{

	const TABLE_NAME="ct_shop_paids";
	const TABLE_ID = 69;

    public function __construct(){
        parent::__construct(
            array(
                'shop_bill_id',
                'shop_paid_type_id',
                'paid_shop_id',
                'paid_type_id',
                'shop_operation_id',
                'amount',
            ),
            self::TABLE_NAME,
            self::TABLE_ID,
            TRUE
        );

        $this->isAddCreated = TRUE;
    }

    /**
	 * Проверяем поля на ошибки
	 * @param array $errorFields - массив ошибок
	 * @return boolean
	 */
	public function validationFields(array &$errorFields){
		$validation = new Validation($this->getValues());

		$validation->rule('shop_bill_id', 'max_length', array(':value', 11))
			->rule('shop_paid_type_id', 'max_length', array(':value', 11))
            ->rule('paid_shop_id', 'max_length', array(':value', 11))
            ->rule('shop_operation_id', 'max_length', array(':value', 11))
            ->rule('paid_type_id', 'max_length', array(':value', 11))
            ->rule('amount', 'max_length', array(':value', 13));

		if ($this->isFindFieldAndIsEdit('shop_bill_id')){
			$validation->rule('shop_bill_id', 'digit');
		}
		if ($this->isFindFieldAndIsEdit('shop_paid_type_id')){
			$validation->rule('shop_paid_type_id', 'digit');
		}
		if ($this->isFindFieldAndIsEdit('paid_shop_id')){
			$validation->rule('paid_shop_id', 'digit');
		}
        if ($this->isFindFieldAndIsEdit('paid_type_id')){
            $validation->rule('paid_type_id', 'digit');
        }
        if ($this->isFindFieldAndIsEdit('shop_operation_id')){
            $validation->rule('shop_operation_id', 'digit');
        }

        return $this->_validationFields($validation, $errorFields);
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
                    case 'shop_bill_id':
                        $this->_dbGetElement($this->getShopBillID(), 'shop_bill_id', new Model_Shop_Bill());
                        break;
                    case 'paid_shop_id':
                        $this->_dbGetElement($this->getPaidShopID(), 'paid_shop_id', new Model_Shop());
                        break;
                    case 'shop_paid_type_id':
                        $this->_dbGetElement($this->getShopPaidTypeID(), 'shop_paid_type_id', new Model_Shop_PaidType(), $shopID);
                        break;
                    case 'paid_type_id':
                        $this->_dbGetElement($this->getPaidTypeID(), 'paid_type_id', new Model_PaidType());
                        break;
                    case 'shop_operation_id':
                        $this->_dbGetElement($this->getShopOperationID(), 'shop_operation_id', new Model_Shop_Operation(), $shopID);
                        break;
				}
			}
		}

		parent::dbGetElements($shopID, $elements);
	}

    public function setAmount($value){
        $this->setValueInt('amount', $value);
    }
    public function getAmount(){
        return $this->getValueInt('amount');
    }

    public function setShopBillID($value){
        $this->setValueInt('shop_bill_id', $value);
    }
    public function getShopBillID(){
        return $this->getValueInt('shop_bill_id');
    }

    public function setShopPaidTypeID($value){
        $this->setValueInt('shop_paid_type_id', $value);
    }
    public function getShopPaidTypeID(){
        return $this->getValueInt('shop_paid_type_id');
    }

    public function setPaidShopID($value){
        $this->setValueInt('paid_shop_id', $value);
    }
    public function getPaidShopID(){
        return $this->getValueInt('paid_shop_id');
    }

    public function setPaidTypeID($value){
        $this->setValueInt('paid_type_id', $value);
    }
    public function getPaidTypeID(){
        return $this->getValueInt('paid_type_id');
    }

    public function setShopOperationID($value){
        $this->setValueInt('shop_operation_id', $value);
    }
    public function getShopOperationID(){
        return $this->getValueInt('shop_operation_id');
    }
}



