<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Client_Guarantee_Item extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_client_guarantee_items';
	const TABLE_ID = 256;

	public function __construct(){
		parent::__construct(
			array(
                'amount',
                'price',
                'quantity',
                'shop_client_guarantee_id',
                'shop_product_id',
                'shop_product_rubric_id',
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
        if(($elements === NULL) || (! is_array($elements))){
            return FALSE;
        }

        foreach($elements as $key => $element){
            if (is_array($element)){
                $element = $key;
            }

            switch ($element) {
                case 'shop_client_guarantee_id':
                    $this->_dbGetElement($this->getShopClientGuaranteeID(), 'shop_client_guarantee_id', new Model_Ab1_Shop_Client_Guarantee(), $shopID);
                    break;
                case 'shop_product_id':
                    $this->_dbGetElement($this->getShopProductID(), 'shop_product_id', new Model_Ab1_Shop_Product());
                    break;
                case 'shop_product_rubric_id':
                    $this->_dbGetElement($this->getShopProductRubricID(), 'shop_product_rubric_id', new Model_Ab1_Shop_Product_Rubric());
                    break;
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
        $this->isValidationFieldInt('shop_client_guarantee_id', $validation);
        $this->isValidationFieldInt('shop_product_id', $validation);
        $this->isValidationFieldInt('shop_product_rubric_id', $validation);
        $this->isValidationFieldFloat('amount', $validation);
        $this->isValidationFieldFloat('price', $validation);
        $this->isValidationFieldFloat('quantity', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopClientGuaranteeID($value){
        $this->setValueInt('shop_client_guarantee_id', $value);
    }
    public function getShopClientGuaranteeID(){
        return $this->getValueInt('shop_client_guarantee_id');
    }

    public function setShopProductID($value){
        $this->setValueInt('shop_product_id', $value);
    }
    public function getShopProductID(){
        return $this->getValueInt('shop_product_id');
    }

    public function setShopProductRubricID($value){
        $this->setValueInt('shop_product_rubric_id', $value);
    }
    public function getShopProductRubricID(){
        return $this->getValueInt('shop_product_rubric_id');
    }

	public function setAmount($value){
		$this->setValueFloat('amount', $value);
	}
	public function getAmount(){
		return $this->getValueFloat('amount');
	}

    public function setPrice($value){
        $this->setValueFloat('price', $value);

        $this->setAmount($this->getPrice() * $this->getQuantity());
    }
    public function getPrice(){
        return $this->getValueFloat('price');
    }

    public function setQuantity($value){
        $this->setValueFloat('quantity', $value);

        $this->setAmount($this->getPrice() * $this->getQuantity());
    }
    public function getQuantity(){
        return $this->getValueFloat('quantity');
    }
}
