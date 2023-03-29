<?php defined('SYSPATH') or die('No direct script access.');


class Model_Magazine_Shop_Production_Item extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'sp_shop_production_items';
	const TABLE_ID = 275;

	public function __construct(){
		parent::__construct(
			array(
			    'root_id',
                'shop_production_id',
                'shop_product_id',
                'coefficient',
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
                    case 'root_id':
                        $this->_dbGetElement($this->getRootID(), 'root_id', new Model_Magazine_Shop_Production(), $shopID);
                        break;
                    case 'shop_production_id':
                        $this->_dbGetElement($this->getShopProductionID(), 'shop_production_id', new Model_Magazine_Shop_Production(), $shopID);
                        break;
                    case 'shop_product_id':
                        $this->_dbGetElement($this->getShopProductID(), 'shop_product_id', new Model_Magazine_Shop_Product(), $shopID);
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
        $this->isValidationFieldInt('shop_production_id', $validation);
        $this->isValidationFieldInt('shop_product_id', $validation);
        $this->isValidationFieldInt('root_id', $validation);
        $this->isValidationFieldFloat('coefficient', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopProductionID($value){
        $this->setValueInt('shop_production_id', $value);
    }
    public function getShopProductionID(){
        return $this->getValueInt('shop_production_id');
    }

    public function setShopProductID($value){
        $this->setValueInt('shop_product_id', $value);
    }
    public function getShopProductID(){
        return $this->getValueInt('shop_product_id');
    }

    public function setRootID($value){
        $this->setValueInt('root_id', $value);
    }
    public function getRootID(){
        return $this->getValueInt('root_id');
    }

    public function setCoefficient($value){
        $this->setValueFloat('coefficient', $value);
    }
    public function getCoefficient(){
        return $this->getValueFloat('coefficient');
    }
}
