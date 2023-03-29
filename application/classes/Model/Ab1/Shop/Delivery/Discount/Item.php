<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_Shop_Delivery_Discount_Item extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ab_shop_delivery_discount_items';
    const TABLE_ID = '';

    public function __construct(){
        parent::__construct(
            array(
			'shop_product_id',
			'price',
			'shop_delivery_discount_id',
			'is_public',
			'shop_product_rubric_id',
			'shop_client_id',
			'from_at',
			'to_at',
			'discount',
			'is_discount_amount',
			'block_amount',
			'balance_amount',
			'amount',
			'product_shop_branch_id',
            ),
            self::TABLE_NAME,
            self::TABLE_ID
        );

        $this->isAddCreated = TRUE;
    }

    /**
     * Получение данных для вспомогательных элементов из базы данных
     * и добавление его в массив
     * @param int $shopID
     * @param null | array $elements
     * @return bool
     */


    /**
     * Проверяем поля на ошибки
     * @param array $errorFields - массив ошибок
     * @return boolean
     */
    public function validationFields(array &$errorFields)
    {
        $validation = new Validation($this->getValues());

        $this->isValidationFieldInt('shop_product_id', $validation);
        $validation->rule('price', 'max_length', array(':value',13));

        $this->isValidationFieldInt('shop_delivery_discount_id', $validation);
        $this->isValidationFieldBool('is_public', $validation);
        $this->isValidationFieldInt('shop_product_rubric_id', $validation);
        $this->isValidationFieldInt('shop_client_id', $validation);

        $validation->rule('discount', 'max_length', array(':value',13));

        $this->isValidationFieldBool('is_discount_amount', $validation);
        $validation->rule('block_amount', 'max_length', array(':value',13));

        $validation->rule('balance_amount', 'max_length', array(':value',13));

        $validation->rule('amount', 'max_length', array(':value',13));

        $this->isValidationFieldInt('product_shop_branch_id', $validation);

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

    public function setShopDeliveryDiscountID($value){
        $this->setValueInt('shop_delivery_discount_id', $value);
    }
    public function getShopDeliveryDiscountID(){
        return $this->getValueInt('shop_delivery_discount_id');
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
