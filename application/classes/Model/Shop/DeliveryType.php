<?php defined('SYSPATH') or die('No direct script access.');


class Model_Shop_DeliveryType extends Model_Shop_Basic_Remarketing{

	const TABLE_NAME = 'ct_shop_delivery_types';
	const TABLE_ID = 23;

	public function __construct(){
		parent::__construct(
			array(
                'delivery_type_id',
				'price'
			),
			self::TABLE_NAME,
			self::TABLE_ID
		);

		$this->isAddCreated = TRUE;
        $this->isCreateUser = TRUE;
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
                    case 'delivery_type_id':
                        $this->_dbGetElement($this->getDeliveryTypeID(), 'delivery_type_id', new Model_DeliveryType());
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
	public function validationFields(array &$errorFields){
		$validation = new Validation($this->getValues());

		$validation->rule('price', 'max_length', array(':value', 13))
            ->rule('delivery_type_id', 'max_length', array(':value', 11));

        if ($this->isFindFieldAndIsEdit('delivery_type_id')){
            $validation->rule('delivery_type_id', 'digit');
        }

		return $this->_validationFields($validation, $errorFields);
	}

    public function setPrice($value){
        $this->setValueFloat('price', $value);
    }

    public function getPrice(){
        return $this->getValueFloat('price');
    }

    public function setDeliveryType($value){
        $this->setValueInt('delivery_type_id', $value);
    }

    public function getDeliveryType(){
        return $this->getValueInt('delivery_type_id');
    }
}
