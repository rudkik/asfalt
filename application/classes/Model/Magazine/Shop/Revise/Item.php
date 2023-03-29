<?php defined('SYSPATH') or die('No direct script access.');


class Model_Magazine_Shop_Revise_Item extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'sp_shop_revise_items';
	const TABLE_ID = 254;

	public function __construct(){
		parent::__construct(
			array(
                'shop_revise_id',
                'quantity_actual',
                'quantity',
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
                    case 'shop_revise_id':
                        $this->_dbGetElement($this->getShopReviseID(), 'shop_revise_id', new Model_Magazine_Shop_Revise());
                        break;
                    case 'shop_product_id':
                        $this->_dbGetElement($this->getShopClientID(), 'shop_product_id', new Model_Magazine_Shop_Product(), $shopID);
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
        $this->isValidationFieldInt('shop_product_id', $validation);
        $this->isValidationFieldInt('shop_revise_id', $validation);
        $this->isValidationFieldFloat('quantity_actual', $validation);
        $this->isValidationFieldFloat('quantity', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopProductID($value){
        $this->setValueInt('shop_product_id', $value);
    }
    public function getShopProductID(){
        return $this->getValueInt('shop_product_id');
    }

    public function setQuantity($value){
        $this->setValueFloat('quantity', $value);
    }
    public function getQuantity(){
        return $this->getValueFloat('quantity');
    }

    public function setQuantityActual($value){
        $this->setValueFloat('quantity_actual', $value);
    }
    public function getQuantityActual(){
        return $this->getValueFloat('quantity_actual');
    }

    public function setShopReviseID($value){
        $this->setValueInt('shop_revise_id', $value);
    }
    public function getShopReviseID(){
        return $this->getValueInt('shop_revise_id');
    }
}
