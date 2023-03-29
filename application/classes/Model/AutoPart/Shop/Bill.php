<?php defined('SYSPATH') or die('No direct script access.');


class Model_AutoPart_Shop_Bill extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ap_shop_bills';
    const TABLE_ID = 348;

    public function __construct(){
        parent::__construct(
            array(
                'shop_bill_delivery_type_id',
                'shoop_bill_payment_type_id',
                'shop_bill_payment_source_id',
                'buyer',
                'sum',
                'processing_time',
                'delivery_address',
                'shop_source_id',
                'shop_product_id',
                'quantity',
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
                    case 'shop_buyer_id':
                        $this->_dbGetElement($this->getShopBillBuyerID(), 'shop_buyer_id', new Model_AutoPart_Shop_Bill_Buyer());
                        break;
                    case 'shop_bill_delivery_id':
                        $this->_dbGetElement($this->getShopBillDeliveryAddressID(), 'shop_bill_delivery_id', new Model_AutoPart_Shop_Bill_Delivery_Address());
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

        $this->isValidationFieldInt('shop_bill_delivery_type_id', $validation);
        $this->isValidationFieldInt('shop_bill_payment_type_id', $validation);
        $this->isValidationFieldInt('shop_source_id', $validation);
        $this->isValidationFieldInt('shop_product_id', $validation);
        $this->isValidationFieldInt('shop_bill_payment_source_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopBillDeliveryTypeID($value){
        $this->setValueInt('shop_bill_delivery_type_id', $value);
    }
    public function getShopBillDeliveryTypeID(){
        return $this->getValueInt('shop_bill_delivery_type_id');
    }

    public function setShopBillPaymentSourceID($value){
        $this->setValueInt('shop_bill_payment_source_id', $value);
    }
    public function getShopBillPaymentSourceID(){
        return $this->getValueInt('shop_bill_payment_source_id');
    }

    public function setShopBillDeliveryAddressID($value){
        $this->setValueInt('shop_bill_delivery_address_id', $value);
    }
    public function getShopBillDeliveryAddressID(){
        return $this->getValueInt('shop_bill_delivery_address_id');
    }

    public function setShopBillPaymentTypeID($value){
        $this->setValue('shop_bill_payment_type_id', $value);
    }
    public function getShopBillPaymentTypeID(){
        return $this->getValue('shop_bill_payment_type_id');
    }

    public function setShopBillCancelTypeID($value){
        $this->setValue('shop_bill_cancel_type_id', $value);
    }
    public function getShopBillCancelTypeID(){
        return $this->getValue('shop_bill_cancel_type_id');
    }

    public function setBuyer($value){
        $this->setValue('buyer', $value);
    }
    public function getBuyer(){
        return $this->getValue('buyer');
    }

    public function setAmount($value){
        $this->setValue('amount', $value);
    }
    public function getAmount(){
        return $this->getValue('amount');
    }

    public function setProcessingTime($value){
        $this->setValue('processing_time', $value);
    }
    public function getProcessingTime(){
        return $this->getValue('processing_time');
    }

    public function setDeliveryAddress($value){
        $this->setValue('delivery_address', $value);
    }
    public function getDeliveryAddress(){
        return $this->getValue('delivery_address');
    }

    public function setShopSourceID($value){
        $this->setValue('shop_source_id', $value);
    }
    public function getShopSourceID(){
        return $this->getValue('shop_source_id');
    }

    public function setShopCompanyID($value){
        $this->setValue('shop_company_id', $value);
    }
    public function getShopCompanyID(){
        return $this->getValue('shop_company_id');
    }

    public function setQuantity($value){
        $this->setValueFloat('quantity', $value);
    }
    public function getQuantity(){
        return $this->getValueFloat('quantity');
    }

    public function setDeliveryPlanAt($value){
        $this->setValueDateTime('delivery_plan_at', $value);
    }
    public function getDeliveryPlanAt(){
        return $this->getValueDateTime('delivery_plan_at');
    }

    public function setDeliveryAt($value){
        $this->setValueDateTime('delivery_at', $value);
    }
    public function getDeliveryAt(){
        return $this->getValueDateTime('delivery_at');
    }

    public function setDeliveryAmount($value){
        $this->setValueFloat('delivery_amount', $value);
    }
    public function getDeliveryAmount(){
        return $this->getValueFloat('delivery_amount');
    }

    public function setDeliverySourceAmount($value){
        $this->setValueFloat('delivery_source_amount', $value);
    }
    public function getDeliverySourceAmount(){
        return $this->getValueFloat('delivery_source_amount');
    }

    public function setShopBillStatusID($value){
        $this->setValueInt('shop_bill_status_id', $value);
    }
    public function getShopBillStatusID(){
        return $this->getValueInt('shop_bill_status_id');
    }

    public function setShopBillStatusSourceID($value){
        $this->setValueInt('shop_bill_status_source_id', $value);
    }
    public function getShopBillStatusSourceID(){
        return $this->getValueInt('shop_bill_status_source_id');
    }

    public function setApproveSourceAt($value){
        $this->setValueDateTime('approve_source_at', $value);
    }
    public function getApproveSourceAt(){
        return $this->getValueDateTime('approve_source_at');
    }

    public function setIsDeliverySource($value){
        $this->setValueBool('is_delivery_source', $value);
    }
    public function getIsDeliverySource() {
        return $this->getValueBool('is_delivery_source');
    }

    public function setIsSignSource($value){
        $this->setValueBool('is_sign_source', $value);
    }
    public function getIsSignSource() {
        return $this->getValueBool('is_sign_source');
    }

    public function setCreditSource($value){
        $this->setValueInt('credit_source', $value);
    }
    public function getCreditSource(){
        return $this->getValueInt('credit_source');
    }

    public function setIsPreOrder($value){
        $this->setValueBool('is_pre_order', $value);
    }
    public function getIsPreOrder() {
        return $this->getValueBool('is_pre_order');
    }

    public function setShopBillStateSourceID($value){
        $this->setValueInt('shop_bill_state_source_id', $value);
    }
    public function getShopBillStateSourceID(){
        return $this->getValueInt('shop_bill_state_source_id');
    }

    public function setShopCourierID($value){
        $this->setValueInt('shop_courier_id', $value);
    }
    public function getShopCourierID(){
        return $this->getValueInt('shop_courier_id');
    }

    public function setShopBillBuyerID($value){
        $this->setValueInt('shop_bill_buyer_id', $value);
    }
    public function getShopBillBuyerID(){
        return $this->getValueInt('shop_bill_buyer_id');
    }

    public function setBillSourceID($value){
        $this->setValue('bill_source_id', $value);
    }
    public function getBillSourceID(){
        return $this->getValue('bill_source_id');
    }

    public function setProducts($value){
        $this->setValue('products', $value);
    }
    public function getProducts(){
        return $this->getValue('products');
    }

    public function setShopOtherAddressID($value){
        $this->setValueInt('shop_other_address_id', $value);
    }
    public function getShopOtherAddressID(){
        return $this->getValueInt('shop_other_address_id');
    }
}
