<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Bid extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_bids';
	const TABLE_ID = 108;

	public function __construct(){
		parent::__construct(
			array(
                'shop_client_id',
                'quantity',
                'rejection_reason_id',
                'date',
                'month',
                'year',
            ),
			self::TABLE_NAME,
			self::TABLE_ID
		);

		$this->isAddCreated = TRUE;
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
                    case 'rejection_reason_id':
                        $this->_dbGetElement($this->getRejectionReasonID(), 'rejection_reason_id', new Model_Ab1_Rejection_Reason());
                        break;
                    case 'shop_client_id':
                        $this->_dbGetElement($this->getShopClientID(), 'shop_client_id', new Model_Ab1_Shop_Client(), $shopID);
                        break;
				}
			}
		}

		parent::dbGetElements($shopID, $elements);
	}

    /**
     * Проверяем поля на ошибки
     * @param array $errorFields - массив ошибок
     * @return boolean
     */
    public function validationFields(array &$errorFields)
    {
        $validation = new Validation($this->getValues());
        $validation->rule('shop_client_id', 'max_length', array(':value', 11))
			->rule('rejection_reason_id', 'max_length', array(':value', 11))
			->rule('quantity', 'max_length', array(':value', 12))
			->rule('month', 'max_length', array(':value', 2))
            ->rule('year', 'max_length', array(':value', 4));

        return $this->_validationFields($validation, $errorFields);
    }

    public function setDate($value){
        $this->setValueDate('date', $value);
    }
    public function getDate(){
        return $this->getValue('date');
    }

    public function setMonth($value){
        $this->setValueInt('month', $value);
    }
    public function getMonth(){
        return $this->getValueInt('month');
    }

    public function setYear($value){
        $this->setValueInt('year', $value);
    }
    public function getYear(){
        return $this->getValueInt('year');
    }

    public function setShopClientID($value){
        $this->setValueInt('shop_client_id', $value);
    }
    public function getShopClientID(){
        return $this->getValueInt('shop_client_id');
    }

    public function setRejectionReasonID($value){
        $this->setValueInt('rejection_reason_id', $value);
    }
    public function getRejectionReasonID(){
        return $this->getValueInt('rejection_reason_id');
    }

    public function setQuantity($value){
        $this->setValueFloat('quantity', $value);
    }
    public function getQuantity(){
        return $this->getValueFloat('quantity');
    }
}
