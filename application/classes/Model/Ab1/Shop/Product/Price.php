<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Product_Price extends Model_Shop_Basic_Object{

	const TABLE_NAME = 'ab_shop_product_prices';
	const TABLE_ID = 63;

	public function __construct(){
		parent::__construct(
			array(
                'amount',
                'block_amount',
                'balance_amount',
                'shop_product_rubric_id',
                'shop_pricelist_id',
                'shop_product_id',
                'discount',
                'shop_client_id',
                'from_at',
                'to_at',
                'product_shop_branch_id',
            ),
			self::TABLE_NAME,
			self::TABLE_ID
		);
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
			->rule('price', 'max_length', array(':value', 14))
			->rule('shop_pricelist_id', 'max_length', array(':value', 11));
        $this->isValidationFieldInt('product_shop_branch_id', $validation);
        $this->isValidationFieldInt('shop_product_rubric_id', $validation);
        $this->isValidationFieldFloat('discount', $validation);
        $this->isValidationFieldInt('shop_client_id', $validation);

        $this->isValidationFieldFloat('amount', $validation);
        $this->isValidationFieldFloat('block_amount', $validation);
        $this->isValidationFieldFloat('balance_amount', $validation);

        return $this->_validationFields($validation, $errorFields);
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
    public function getShopProducRubricID(){
        return $this->getValueInt('shop_product_rubric_id');
    }

    public function setShopPriceListID($value){
        $this->setValueInt('shop_pricelist_id', $value);
    }
    public function getShopPriceListID(){
        return $this->getValueInt('shop_pricelist_id');
    }

    public function setShopClientID($value){
        $this->setValueInt('shop_client_id', $value);
    }
    public function getShopClientID(){
        return $this->getValueInt('shop_client_id');
    }

    public function setProductShopBranchID($value){
        $this->setValueInt('product_shop_branch_id', $value);
    }
    public function getProductShopBranchID(){
        return $this->getValueInt('product_shop_branch_id');
    }

    public function setPrice($value){
        $this->setValueFloat('price', $value);
    }
    public function getPrice(){
        return $this->getValueFloat('price');
    }

    public function setDiscount($value){
        $this->setValueFloat('discount', $value);
    }
    public function getDiscount(){
        return $this->getValueFloat('discount');
    }

    public function setFromAt($value){
        $this->setValueDateTime('from_at', $value);
    }
    public function getFromAt(){
        return $this->getValue('from_at');
    }

    public function setToAt($value){
        $this->setValueDateTime('to_at', $value);
    }
    public function getToAt(){
        return $this->getValue('to_at');
    }

    public function setAmount($value){
        $this->setValueFloat('amount', $value);
        $this->setBalanceAmount($this->getAmount() - $this->getBlockAmount());
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

    public function setBlockAmount($value){
        $this->setValueFloat('block_amount', $value);
        $this->setBalanceAmount($this->getAmount() - $this->getBlockAmount());
    }
    public function getBlockAmount(){
        return $this->getValueFloat('block_amount');
    }

    public function setBalanceAmount($value){
        $this->setValueFloat('balance_amount', $value);
    }
    public function getBalanceAmount(){
        return $this->getValueFloat('balance_amount');
    }
}
