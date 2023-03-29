<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Product_Balance extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_product_balances';
	const TABLE_ID = 342;

	public function __construct(){
		parent::__construct(
			array(
                'quantity',
                'shop_storage_id',
                'shop_product_id',
            ),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}

    /**
     * Получение данных для вспомогательных элементов из базы данных
     * и добавление его в массив
     * @param int $shopID
     * @param null | array $elements
     * @return bool
     */
	public function dbGetElements($shopID = 0, $elements = NULL){
		if(($elements !== NULL) && (! is_array($elements))){
            foreach($elements as $element){
                switch($element){
                    case 'shop_product_id':
                        $this->_dbGetElement($this->getShopFormulaProductID(), 'shop_product_id', new Model_Ab1_Shop_Product(), $shopID);
                        break;
                    case 'shop_storage_id':
                        $this->_dbGetElement($this->getShopStorageID(), 'shop_storage_id', new Model_Ab1_Shop_Storage());
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
        $validation->rule('quantity', 'max_length', array(':value', 12));

        $this->isValidationFieldInt('shop_storage_id', $validation);
        $this->isValidationFieldInt('shop_product_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setQuantity($value){
        $this->setValueFloat('quantity', $value);
    }
    public function getQuantity(){
        return $this->getValueFloat('quantity');
    }

    public function setShopStorageID($value){
        $this->setValueInt('shop_storage_id', $value);
    }
    public function getShopStorageID(){
        return $this->getValueInt('shop_storage_id');
    }

    public function setShopProductID($value){
        $this->setValueInt('shop_product_id', $value);
    }
    public function getShopProductID(){
        return $this->getValueInt('shop_product_id');
    }
}
