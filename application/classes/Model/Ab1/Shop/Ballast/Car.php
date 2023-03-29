<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Ballast_Car extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_ballast_cars';
	const TABLE_ID = 189;

	public function __construct(){
		parent::__construct(
			array(
                'shop_ballast_driver_id',
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
	 */
	public function dbGetElements($shopID = 0, $elements = NULL){
		if(($elements === NULL) || (! is_array($elements))){
		}else{
			foreach($elements as $element){
				switch($element){
                    case 'shop_ballast_driver_id':
                        $this->_dbGetElement($this->getShopBallastDriverID(), 'shop_ballast_driver_id', new Model_Ab1_Shop_Ballast_Driver());
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
        $validation->rule('shop_ballast_driver_id', 'max_length', array(':value', 11));
        $this->isValidationFieldFloat('quantity', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopBallastDriverID($value){
        $this->setValueInt('shop_ballast_driver_id', $value);
    }
    public function getShopBallastDriverID(){
        return $this->getValueInt('shop_ballast_driver_id');
    }

    public function setQuantity($value){
        $this->setValueInt('quantity', $value);
    }
    public function getQuantity(){
        return $this->getValueInt('quantity');
    }

    public function setShopTransportID($value){
        $this->setValueInt('shop_transport_id', $value);
    }
    public function getShopTransportID(){
        return $this->getValueInt('shop_transport_id');
    }
}
