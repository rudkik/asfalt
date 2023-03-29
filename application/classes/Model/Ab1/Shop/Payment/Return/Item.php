<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Payment_Return_Item extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_payment_return_items';
	const TABLE_ID = 305;

	public function __construct(){
		parent::__construct(
			array(
                'shop_client_id',
                'shop_payment_return_id',
            ),
			self::TABLE_NAME,
			self::TABLE_ID
		);
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
					case 'shop_product_id':
						$this->_dbGetElement($this->getShopProductID(), 'shop_product_id', new Model_Ab1_Shop_Product());
						break;
                    case 'shop_payment_return_id':
                        $this->_dbGetElement($this->getShopPaymentReturnID(), 'shop_payment_return_id', new Model_Ab1_Shop_Payment_Return());
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
        $validation->rule('shop_product_id', 'max_length', array(':value', 11))
			->rule('quantity', 'max_length', array(':value', 12))
			->rule('price', 'max_length', array(':value', 12))
			->rule('amount', 'max_length', array(':value', 12))
            ->rule('shop_payment_return_id', 'max_length', array(':value', 11));

        $this->isValidationFieldInt('shop_client_id', $validation);

        if ($this->isFindFieldAndIsEdit('shop_product_id')) {
            $validation->rule('shop_product_id', 'digit');
        }
        if ($this->isFindFieldAndIsEdit('shop_payment_return_id')) {
            $validation->rule('shop_payment_return_id', 'digit');
        }

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopProductID($value){
        $this->setValueInt('shop_product_id', $value);
    }
    public function getShopProductID(){
        return $this->getValueInt('shop_product_id');
    }

    public function setShopClientID($value){
        $this->setValueInt('shop_client_id', $value);
    }
    public function getShopClientID(){
        return $this->getValueInt('shop_client_id');
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
        $this->setValueFloat('amount', round($value, 0));
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

    public function setShopPaymentReturnID($value){
        $this->setValueInt('shop_payment_return_id', $value);
    }
    public function getShopPaymentReturnID(){
        return $this->getValueInt('shop_payment_return_id');
    }
}
