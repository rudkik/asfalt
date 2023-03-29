<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Consumable extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_consumables';
	const TABLE_ID = 85;

	public function __construct(){
		parent::__construct(
			array(
                'from_at',
                'to_at',
                'number',
                'amount',
                'shop_cashbox_id',
            ),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}

    /**
     * Проверяем поля на ошибки
     * @param array $errorFields - массив ошибок
     * @return boolean
     */
    public function validationFields(array &$errorFields)
    {
        $validation = new Validation($this->getValues());
        $validation->rule('number', 'max_length', array(':value', 250))
			->rule('amount', 'max_length', array(':value', 14));

        return $this->_validationFields($validation, $errorFields);
    }

    public function setBase($value){
        $this->setValue('base', $value);
    }
    public function getBase(){
        return $this->getValue('base');
    }

    public function setExtradite($value){
        $this->setValue('extradite', $value);
    }
    public function getExtradite(){
        return $this->getValue('extradite');
    }

    public function setShopCashboxID($value){
        $this->setValueInt('shop_cashbox_id', $value);
    }
    public function getShopCashboxID(){
        return $this->getValueInt('shop_cashbox_id');
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

	public function setNumber($value){
		$this->setValue('number', $value);
	}
	public function getNumber(){
		return $this->getValue('number');
	}

	public function setAmount($value){
		$this->setValueFloat('amount', $value);
	}
	public function getAmount(){
		return $this->getValueFloat('amount');
	}

    public function setGUID1C($value){
        $this->setValue('guid_1c', $value);
    }
    public function getGUID1C(){
        return $this->getValue('guid_1c');
    }
}
