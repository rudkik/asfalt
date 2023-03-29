<?php defined('SYSPATH') or die('No direct script access.');

class Model_Tax_Shop_Bill extends Model_Shop_Basic_Bill{

	const TABLE_NAME = 'tax_shop_bills';
	const TABLE_ID = 171;

	public function __construct(){
		parent::__construct(
			array(
				'shop_good_id',
				'paid_type_id',
                'month',
                'access_type_id',
			),
			self::TABLE_NAME,
			self::TABLE_ID,
			FALSE
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
                    case 'shop_good_id':
                        $this->_dbGetElement($this->getShopGoodID(), 'shop_good_id', new Model_Shop_Good(), $shopID);
                        break;
					case 'paid_type_id':
						$this->_dbGetElement($this->getPaidTypeID(), 'paid_type_id', new Model_PaidType(), $shopID);
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

        $validation->rule('shop_good_id', 'max_length', array(':value', 11))
            ->rule('paid_type_id', 'max_length', array(':value', 11))
            ->rule('access_type_id', 'max_length', array(':value', 11))
            ->rule('options', 'max_length', array(':value', 650000))
            ->rule('month', 'max_length', array(':value', 3));

        if ($this->isFindFieldAndIsEdit('shop_good_id')) {
            $validation->rule('shop_good_id', 'digit');
        }
        if ($this->isFindFieldAndIsEdit('paid_type_id')) {
            $validation->rule('paid_type_id', 'digit');
        }

        return $this->_validationFields($validation, $errorFields);
    }

    /**
     * сохранение записи в базу данных
     * @param int $languageID
     * @param int $userID
     * @param int $shopID
     * @return mixed
     * @throws Kohana_Kohana_Exception
     */
    public function dbSave($languageID = 0, $userID = 0, $shopID = 0)
    {
        $this->_preDBSave(0, $userID, $shopID);

        if ($this->isEdit()) {
            $this->_isDBDriver();
            $this->id = $this->getDBDriver()->saveObject($this, 0, $this->shopID);
        }

        return $this->id;
    }

    public function setShopGoodID($value){
        $this->setValueInt('shop_good_id', $value);
    }
    public function getShopGoodID(){
        return $this->getValueInt('shop_good_id');
    }

    // Тип оплаты заказа
    public function setPaidTypeID($value){
        $this->setValueInt('paid_type_id', $value);
    }
    public function getPaidTypeID(){
        return $this->getValueInt('paid_type_id');
    }

    // Кол-во месяцев
    public function setMonth($value){
        $this->setValueFloat('month', $value);
    }
    public function getMonth(){
        return $this->getValueFloat('month');
    }

    // Тип доступа
    public function setAccessTypeID($value){
        $this->setValueInt('access_type_id', $value);
    }
    public function getAccessTypeID(){
        return $this->getValueInt('access_type_id');
    }
}
