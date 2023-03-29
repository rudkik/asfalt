<?php defined('SYSPATH') or die('No direct script access.');

class Model_Magazine_Shop_Realization_Item extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'sp_shop_realization_items';
	const TABLE_ID = 252;

	public function __construct(){
		parent::__construct(
			array(
			    'shop_card_id',
                'shop_realization_id',
                'amount',
                'price',
                'quantity',
                'shop_worker_id',
                'is_esf',
                'is_special',
                'shop_write_off_type_id',
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
                    case 'shop_worker_id':
                        $this->_dbGetElement($this->getShopWorkerID(), 'shop_worker_id', new Model_Ab1_Shop_Worker(), $shopID);
                        break;
                    case 'shop_card_id':
                        $this->_dbGetElement($this->getShopCardID(), 'shop_card_id', new Model_Magazine_Shop_Card(), $shopID);
                        break;
                    case 'shop_realization_id':
                        $this->_dbGetElement($this->getShopRealizationID(), 'shop_realization_id', new Model_Magazine_Shop_Realization());
                        break;
                    case 'shop_realization_return_id':
                        $this->_dbGetElement($this->getShopRealizationReturnID(), 'shop_realization_return_id', new Model_Magazine_Shop_Realization_Return());
                        break;
                    case 'shop_production_id':
                        $this->_dbGetElement($this->getShopProductionID(), 'shop_production_id', new Model_Magazine_Shop_Production(), $shopID);
                        break;
                    case 'shop_write_off_type_id':
                        $this->_dbGetElement($this->getShopWriteOffTypeID(), 'shop_write_off_type_id', new Model_Magazine_Shop_WriteOff_Type());
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
        $this->isValidationFieldInt('shop_realization_id', $validation);
        $this->isValidationFieldInt('shop_worker_id', $validation);
        $this->isValidationFieldInt('shop_card_id', $validation);
        $this->isValidationFieldFloat('amount', $validation);
        $this->isValidationFieldFloat('price', $validation);
        $this->isValidationFieldFloat('quantity', $validation);
        $this->isValidationFieldFloat('esf_receive_quantity', $validation);
        $this->isValidationFieldBool('is_esf', $validation);
        $this->isValidationFieldInt('is_special', $validation);
        $this->isValidationFieldInt('shop_write_off_type_id', $validation);

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

    public function setShopRealizationID($value){
        $this->setValueInt('shop_realization_id', $value);
    }
    public function getShopRealizationID(){
        return $this->getValueInt('shop_realization_id');
    }

    public function setShopCardID($value){
        $this->setValueInt('shop_card_id', $value);
    }
    public function getShopCardID(){
        return $this->getValueInt('shop_card_id');
    }

    public function setShopWorkerID($value){
        $this->setValueInt('shop_worker_id', $value);
    }
    public function getShopWorkerID(){
        return $this->getValueInt('shop_worker_id');
    }

    public function setIsESF($value){
        $this->setValueBool('is_esf', $value);
    }
    public function getIsESF(){
        return $this->getValueBool('is_esf');
    }

    public function setESFReceiveQuantity($value){
        $this->setValueFloat('esf_receive_quantity', round($value, 3));
    }
    public function getESFReceiveQuantity(){
        return $this->getValueFloat('esf_receive_quantity');
    }

    public function setIsSpecial($value){
        $this->setValueInt('is_special', $value);
    }
    public function getIsSpecial(){
        return $this->getValueInt('is_special');
    }

    public function setShopWriteOffTypeID($value){
        $this->setValueInt('shop_write_off_type_id', $value);
    }
    public function getShopWriteOffTypeID(){
        return $this->getValueInt('shop_write_off_type_id');
    }
}
