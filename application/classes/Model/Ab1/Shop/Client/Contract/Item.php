<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Client_Contract_Item extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_client_contract_items';
	const TABLE_ID = 225;

	public function __construct(){
		parent::__construct(
			array(
                'amount',
                'block_amount',
                'balance_amount',
                'price',
                'quantity',
                'shop_client_contract_id',
                'shop_product_id',
                'shop_product_rubric_id',
                'discount',
                'is_discount_amount',
                'agreement_number',
                'is_fixed_price',
                'from_at',
                'product_shop_branch_id',
                'shop_material_id',
                'shop_raw_id',
                'shop_client_id',
                'basic_shop_client_contract_id',
                'is_add_basic_contract',
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
                case 'basic_shop_client_contract_id':
                    $this->_dbGetElement($this->getBasicShopClientContractID(), 'basic_shop_client_contract_id', new Model_Ab1_Shop_Client_Contract(), $shopID);
                    break;
                case 'shop_client_contract_id':
                    $this->_dbGetElement($this->getShopClientContractID(), 'shop_client_contract_id', new Model_Ab1_Shop_Client_Contract(), $shopID);
                    break;
                case 'shop_client_id':
                    $this->_dbGetElement($this->getShopClientID(), 'shop_client_id', new Model_Ab1_Shop_Client(), $shopID);
                    break;
                case 'shop_product_id':
                    $this->_dbGetElement($this->getShopProductID(), 'shop_product_id', new Model_Ab1_Shop_Product());
                    break;
                case 'shop_material_id':
                    $this->_dbGetElement($this->getShopMaterialID(), 'shop_material_id', new Model_Ab1_Shop_Product(), $shopID);
                    break;
                case 'shop_raw_id':
                    $this->_dbGetElement($this->getShopRawID(), 'shop_raw_id', new Model_Ab1_Shop_Product(), $shopID);
                    break;
                case 'shop_product_rubric_id':
                    $this->_dbGetElement($this->getShopProductRubricID(), 'shop_product_rubric_id', new Model_Ab1_Shop_Product_Rubric());
                    break;
                case 'product_shop_branch_id':
                    $this->_dbGetElement($this->getProductShopBranchID(), 'product_shop_branch_id', new Model_Shop(), 0);
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
        $this->isValidationFieldInt('product_shop_branch_id', $validation);
        $this->isValidationFieldInt('shop_client_contract_id', $validation);
        $this->isValidationFieldInt('shop_client_id', $validation);
        $this->isValidationFieldInt('shop_product_id', $validation);
        $this->isValidationFieldInt('shop_product_rubric_id', $validation);
        $this->isValidationFieldFloat('amount', $validation);
        $this->isValidationFieldFloat('block_amount', $validation);
        $this->isValidationFieldFloat('balance_amount', $validation);
        $this->isValidationFieldFloat('price', $validation);
        $this->isValidationFieldFloat('quantity', $validation);
        $this->isValidationFieldFloat('discount', $validation);
        $this->isValidationFieldBool('is_discount_amount', $validation);
        $this->isValidationFieldBool('is_fixed_price', $validation);
        $this->isValidationFieldStr('agreement_number', $validation, 20);
        $this->isValidationFieldInt('shop_material_id', $validation);
        $this->isValidationFieldInt('shop_raw_id', $validation);
        $this->isValidationFieldInt('basic_shop_client_contract_id', $validation);
        $this->isValidationFieldBool('is_add_basic_contract', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setAgreementNumber($value){
        $this->setValue('agreement_number', $value);
    }
    public function getAgreementNumber(){
        return $this->getValue('agreement_number');
    }

    public function setFromAt($value){
        $this->setValueDate('from_at', $value);
    }
    public function getFromAt(){
        return $this->getValueDate('from_at');
    }

    public function setIsFixedPrice($value){
        $this->setValueBool('is_fixed_price', $value);
    }
    public function getIsFixedPrice(){
        return $this->getValueBool('is_fixed_price');
    }

    public function setDiscount($value){
        $this->setValueFloat('discount', $value);
    }
    public function getDiscount(){
        return $this->getValueFloat('discount');
    }

    public function setIsDiscountAmount($value){
        $this->setValueBool('is_discount_amount', $value);
    }
    public function getIsDiscountAmount(){
        return $this->getValueBool('is_discount_amount');
    }

    public function setShopClientContractID($value){
        $this->setValueInt('shop_client_contract_id', $value);
    }
    public function getShopClientContractID(){
        return $this->getValueInt('shop_client_contract_id');
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

    public function setShopProductID($value){
        $this->setValueInt('shop_product_id', $value);
    }
    public function getShopProductID(){
        return $this->getValueInt('shop_product_id');
    }

    public function setShopMaterialID($value){
        $this->setValueInt('shop_material_id', $value);
    }
    public function getShopMaterialID(){
        return $this->getValueInt('shop_material_id');
    }

    public function setShopRawID($value){
        $this->setValueInt('shop_raw_id', $value);
    }
    public function getShopRawID(){
        return $this->getValueInt('shop_raw_id');
    }

    public function setFuelID($value){
        $this->setValueInt('fuel_id', $value);
    }
    public function getFuelID(){
        return $this->getValueInt('fuel_id');
    }

    public function setShopProductRubricID($value){
        $this->setValueInt('shop_product_rubric_id', $value);
    }
    public function getShopProductRubricID(){
        return $this->getValueInt('shop_product_rubric_id');
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

    public function setQuantity($value){
        $this->setValueFloat('quantity', $value);
    }
    public function getQuantity(){
        return $this->getValueFloat('quantity');
    }

    public function setPrice($value){
        $this->setValueFloat('price', $value);

        $this->setAmount($this->getPrice() * $this->getQuantity());
    }
    public function getPrice(){
        return $this->getValueFloat('price');
    }

    public function setUnit($value){
        $this->setValue('unit', $value);
    }
    public function getUnit(){
        return $this->getValue('unit');
    }

    public function setBasicShopClientContractID($value){
        $this->setValueInt('basic_shop_client_contract_id', $value);
    }
    public function getBasicShopClientContractID(){
        return $this->getValueInt('basic_shop_client_contract_id');
    }

    public function setIsAddBasicContract($value){
        $this->setValueInt('is_add_basic_contract', $value);
    }
    public function getIsAddBasicContract(){
        return $this->getValueInt('is_add_basic_contract');
    }
}
