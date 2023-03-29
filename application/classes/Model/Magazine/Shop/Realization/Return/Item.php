<?php defined('SYSPATH') or die('No direct script access.');

class Model_Magazine_Shop_Realization_Return_Item extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'sp_shop_realization_return_items';
	const TABLE_ID = 308;

	public function __construct(){
		parent::__construct(
			array(
                'shop_realization_return_id',
                'amount',
                'price',
                'quantity',
                'is_esf',
                'esf_receive_quantity',
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
                    case 'shop_realization_return_id':
                        $this->_dbGetElement($this->getShopRealizationReturnID(), 'shop_realization_return_id', new Model_Magazine_Shop_Realization_Return());
                        break;
                    case 'shop_production_id':
                        $this->_dbGetElement($this->getShopProductionID(), 'shop_production_id', new Model_Magazine_Shop_Production(), $shopID);
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
        $this->isValidationFieldFloat('amount', $validation);
        $this->isValidationFieldFloat('price', $validation);
        $this->isValidationFieldFloat('quantity', $validation);
        $this->isValidationFieldFloat('esf_receive_quantity', $validation);
        $this->isValidationFieldBool('is_esf', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopProductionID($value){
        $this->setValueInt('shop_production_id', $value);
    }
    public function getShopProductionID(){
        return $this->getValueInt('shop_production_id');
    }

    public function setQuantity($value){
        $this->setValueFloat('quantity', $value);
        $this->setAmount($this->getQuantity() * $this->getPrice());
    }
    public function getQuantity(){
        return $this->getValueFloat('quantity');
    }

    public function setPrice($value){
        $this->setValueFloat('price', $value);
        $this->setAmount($this->getQuantity() * $this->getPrice());
    }
    public function getPrice(){
        return $this->getValueFloat('price');
    }

    public function setAmount($value){
        $value = round($value, 0);
        $this->setValueFloat('amount', $value);
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

    public function setShopRealizationReturnID($value){
        $this->setValueInt('shop_realization_return_id', $value);
    }
    public function getShopRealizationReturnID(){
        return $this->getValueInt('shop_realization_return_id');
    }

    public function setIsESF($value){
        $this->setValueBool('is_esf', $value);
    }
    public function getIsESF(){
        return $this->getValueBool('is_esf');
    }

    public function setESFReceiveQuantity($value){
        $this->setValueFloat('esf_receive_quantity', $value);
    }
    public function getESFReceiveQuantity(){
        return $this->getValueFloat('esf_receive_quantity');
    }
}
