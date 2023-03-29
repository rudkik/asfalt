<?php defined('SYSPATH') or die('No direct script access.');

class Model_AutoPart_Shop_Receive_Item extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ap_shop_receive_items';
    const TABLE_ID = '';

    public function __construct(){
        parent::__construct(
            array(
			'shop_product_id',
			'quantity',
			'price',
			'amount',
			'shop_bill_item_id',
			'shop_receive_id',
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
    public function dbGetElements($shopID = 0, $elements = NULL){
        if(($elements !== NULL) && (is_array($elements))){
            foreach($elements as $element){
                switch($element){
                   case 'shop_product_id':
                            $this->_dbGetElement($this->getShopProductID(), 'shop_product_id', new Model_AutoPart_Shop_Product(), $shopID);
                            break;
                   case 'shop_bill_item_id':
                            $this->_dbGetElement($this->getShopBillItemID(), 'shop_bill_item_id', new Model_AutoPart_Shop_Bill_Item(), $shopID);
                            break;
                   case 'shop_receive_id':
                            $this->_dbGetElement($this->getShopReceiveID(), 'shop_receive_id', new Model_AutoPart_Shop_Receive(), $shopID);
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
        $validation->rule('quantity', 'max_length', array(':value',13));

        $validation->rule('price', 'max_length', array(':value',13));

        $validation->rule('amount', 'max_length', array(':value',13));

        $this->isValidationFieldInt('shop_bill_item_id', $validation);
        $this->isValidationFieldInt('shop_receive_id', $validation);

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

        $this->setQuantityBalance($this->getQuantity() - $this->getQuantitySales());
    }
    public function getQuantity(){
        return $this->getValueFloat('quantity');
    }

    public function setQuantitySales($value){
        $this->setValueFloat('quantity_sales', $value);

        $this->setQuantityBalance($this->getQuantity() - $this->getQuantitySales());
    }
    public function getQuantitySales(){
        return $this->getValueFloat('quantity_sales');
    }

    public function setQuantityBalance($value){
        $this->setValueFloat('quantity_balance', $value);
    }
    public function getQuantityBalance(){
        return $this->getValueFloat('quantity_balance');
    }

    public function setPrice($value){
        $this->setValueFloat('price', $value);
    }
    public function getPrice(){
        return $this->getValueFloat('price');
    }

    public function setAmount($value){
        $this->setValueFloat('amount', $value);
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

    public function setShopBillItemID($value){
        $this->setValueInt('shop_bill_item_id', $value);
    }
    public function getShopBillItemID(){
        return $this->getValueInt('shop_bill_item_id');
    }

    public function setShopReceiveID($value){
        $this->setValueInt('shop_receive_id', $value);
    }
    public function getShopReceiveID(){
        return $this->getValueInt('shop_receive_id');
    }

    public function setReturnShopReceiveID($value){
        $this->setValueInt('return_shop_receive_id', $value);
    }
    public function getReturnShopReceiveID(){
        return $this->getValueInt('return_shop_receive_id');
    }
}
