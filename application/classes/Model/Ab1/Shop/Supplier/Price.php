<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Supplier_Price extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_supplier_prices';
	const TABLE_ID = 114;

	public function __construct(){
		parent::__construct(
			array(
                'shop_supplier_id',
                'shop_product_id',
                'price',
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
	 */
	public function dbGetElements($shopID = 0, $elements = NULL){
		if(($elements === NULL) || (! is_array($elements))){
		}else{
			foreach($elements as $element){
				switch($element){
                    case 'shop_supplier_id':
                        $this->_dbGetElement($this->getShopSupplierID(), 'shop_supplier_id', new Model_Ab1_Shop_Supplier(), $shopID);
                        break;
					case 'shop_product_id':
						$this->_dbGetElement($this->getShopProductID(), 'shop_product_id', new Model_Ab1_Shop_Product());
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
        $validation->rule('shop_supplier_id', 'max_length', array(':value', 11))
			->rule('shop_product_id', 'max_length', array(':value', 11))
			->rule('price', 'max_length', array(':value', 12));

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopSupplierID($value){
        $this->setValueInt('shop_supplier_id', $value);
    }
    public function getShopSupplierID(){
        return $this->getValueInt('shop_supplier_id');
    }

    public function setShopProductID($value){
        $this->setValueInt('shop_product_id', $value);
    }
    public function getShopProductID(){
        return $this->getValueInt('shop_product_id');
    }

    public function setPrice($value){
        $this->setValueFloat('price', $value);
    }
    public function getPrice(){
        return $this->getValueFloat('price');
    }

    public function setDate($value){
        $this->setValueDate('date', $value);
    }
    public function getDate(){
        return $this->getValue('date');
    }

}
