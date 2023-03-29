<?php defined('SYSPATH') or die('No direct script access.');


class Model_Magazine_Shop_Invoice_Item_GTD extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'sp_shop_invoice_item_gtds';
	const TABLE_ID = 286;

	public function __construct(){
		parent::__construct(
			array(
                'shop_production_id',
                'shop_product_id',
                'amount_realization',
                'price_realization',
                'quantity',
                'amount_receive',
                'price_receive',
                'is_esf',
                'esf_receive',
                'shop_realization_item_id',
                'shop_realization_return_item_id',
                'shop_receive_item_id',
                'shop_receive_item_gtd_id',
                'shop_invoice_id',
                'shop_invoice_item_id',
                'shop_receive_id',
                'tru_origin_code',
                'product_declaration',
                'product_number_in_declaration',
                'catalog_tru_id',
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
		if(is_array($elements)){
            foreach($elements as $element){
                switch($element){
                    case 'shop_production_id':
                        $this->_dbGetElement($this->getShopProductionID(), 'shop_production_id', new Model_Magazine_Shop_Production(), $shopID);
                        break;
                    case 'shop_product_id':
                        $this->_dbGetElement($this->getShopProductID(), 'shop_product_id', new Model_Magazine_Shop_Product(), $shopID);
                        break;
                    case 'shop_invoice_id':
                        $this->_dbGetElement($this->getShopInvoiceID(), 'shop_invoice_id', new Model_Magazine_Shop_Invoice());
                        break;
                    case 'shop_realization_item_id':
                        $this->_dbGetElement($this->getShopRealizationItemID(), 'shop_realization_item_id', new Model_Magazine_Shop_Realization_Item(), $shopID);
                        break;
                    case 'shop_receive_item_id':
                        $this->_dbGetElement($this->getShopReceiveItemID(), 'shop_receive_item_id', new Model_Magazine_Shop_Receive_Item(), $shopID);
                        break;
                    case 'shop_receive_item_gtd_id':
                        $this->_dbGetElement($this->getShopReceiveItemGTDID(), 'shop_receive_item_gtd_id', new Model_Magazine_Shop_Receive_Item_GTD(), $shopID);
                        break;
                    case 'shop_invoice_item_id':
                        $this->_dbGetElement($this->getShopInvoiceItemID(), 'shop_invoice_item_id', new Model_Magazine_Shop_Invoice_Item());
                        break;
                    case 'shop_receive_id':
                        $this->_dbGetElement($this->getShopReceiveItemID(), 'shop_receive_id', new Model_Magazine_Shop_Invoice_Item());
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
        $this->isValidationFieldInt('shop_invoice_id', $validation);
        $this->isValidationFieldInt('shop_invoice_item_id', $validation);
        $this->isValidationFieldInt('shop_realization_item_id', $validation);
        $this->isValidationFieldInt('shop_realization_return_item_id', $validation);
        $this->isValidationFieldInt('shop_receive_item_id', $validation);
        $this->isValidationFieldInt('shop_receive_item_gtd_id', $validation);
        $this->isValidationFieldInt('shop_receive_id', $validation);
        $this->isValidationFieldFloat('amount_realization', $validation);
        $this->isValidationFieldFloat('price_realization', $validation);
        $this->isValidationFieldFloat('quantity', $validation);
        $this->isValidationFieldFloat('amount_receive', $validation);
        $this->isValidationFieldFloat('price_receive', $validation);
        $this->isValidationFieldBool('is_esf', $validation);
        $this->isValidationFieldInt('tru_origin_code', $validation);
        $this->isValidationFieldStr('product_declaration', $validation);
        $this->isValidationFieldStr('product_number_in_declaration', $validation);
        $this->isValidationFieldStr('catalog_tru_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    /**
     * Возвращаем список всех переменных
     * @param bool $isGetElement
     * @param bool $isParseArray
     * @param null $shopID
     * @return array
     */
    public function getValues($isGetElement = FALSE, $isParseArray = FALSE, $shopID = NULL)
    {
        $arr = parent::getValues($isGetElement, $isParseArray, $shopID);

        if($isParseArray === TRUE) {
            // $arr['esf'] = $this->getESFArray();
        }

        return $arr;
    }

    // Идентификатор товара, работ, услуг
    public function setCatalogTruID($value){
        $this->setValue('catalog_tru_id', $value);
    }
    public function getCatalogTruID(){
        return $this->getValue('catalog_tru_id');
    }

    public function setProductNumberInDeclaration($value){
        $this->setValue('product_number_in_declaration', $value);
    }
    public function getProductNumberInDeclaration(){
        return $this->getValue('product_number_in_declaration');
    }

    public function setProductDeclaration($value){
        $this->setValue('product_declaration', $value);
    }
    public function getProductDeclaration(){
        return $this->getValue('product_declaration');
    }

    public function setTruOriginCode($value){
        $this->setValueInt('tru_origin_code', $value);
    }
    public function getTruOriginCode(){
        return $this->getValueInt('tru_origin_code');
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

    public function setQuantity($value){
        $this->setValueFloat('quantity', $value);

        $this->setAmountRealization($this->getQuantity() * $this->getPriceRealization());
        $this->setAmountReceive($this->getQuantity() * $this->getPriceReceive());
    }
    public function getQuantity(){
        return $this->getValueFloat('quantity');
    }

    public function setPriceRealization($value){
        $this->setValueFloat('price_realization', $value);
        $this->setAmountRealization($this->getQuantity() * $this->getPriceRealization());
    }
    public function getPriceRealization(){
        return $this->getValueFloat('price_realization');
    }

    public function setAmountRealization($value){
        $this->setValueFloat('amount_realization', $value);
    }
    public function getAmountRealization(){
        return $this->getValueFloat('amount_realization');
    }

    public function setPriceReceive($value){
        $this->setValueFloat('price_receive', $value);
        $this->setAmountReceive($this->getQuantity() * $this->getPriceReceive());
    }
    public function getPriceReceive(){
        return $this->getValueFloat('price_receive');
    }

    public function setAmountReceive($value){
        $this->setValueFloat('amount_receive', $value);
    }
    public function getAmountReceive(){
        return $this->getValueFloat('amount_receive');
    }

    public function setShopInvoiceID($value){
        $this->setValueInt('shop_invoice_id', $value);
    }
    public function getShopInvoiceID(){
        return $this->getValueInt('shop_invoice_id');
    }

    public function setShopInvoiceItemID($value){
        $this->setValueInt('shop_invoice_item_id', $value);
    }
    public function getShopInvoiceItemID(){
        return $this->getValueInt('shop_invoice_item_id');
    }

    public function setShopRealizationItemID($value){
        $this->setValueInt('shop_realization_item_id', $value);
    }
    public function getShopRealizationItemID(){
        return $this->getValueInt('shop_realization_item_id');
    }

    public function setShopRealizationReturnItemID($value){
        $this->setValueInt('shop_realization_return_item_id', $value);
    }
    public function getShopRealizationReturnItemID(){
        return $this->getValueInt('shop_realization_return_item_id');
    }

    public function setShopReceiveItemID($value){
        $this->setValueInt('shop_receive_item_id', $value);
    }
    public function getShopReceiveItemID(){
        return $this->getValueInt('shop_receive_item_id');
    }

    public function setShopReceiveID($value){
        $this->setValueInt('shop_receive_id', $value);
    }
    public function getShopReceiveID(){
        return $this->getValueInt('shop_receive_id');
    }

    public function setShopReceiveItemGTDID($value){
        $this->setValueInt('shop_receive_item_gtd_id', $value);
    }
    public function getShopReceiveItemGTDID(){
        return $this->getValueInt('shop_receive_item_gtd_id');
    }

    public function setIsESF($value){
        $this->setValueBool('is_esf', $value);
    }
    public function getIsESF(){
        return $this->getValueBool('is_esf');
    }

    // Данные ЭСФ
    public function setESFReceiveObject(Helpers_ESF_Unload_Product_Record $value){
        $this->setIsESF($value->getQuantity() == $this->getQuantity() && $value->getPrice() == $this->getPriceReceive());
        $this->setValueArray('esf_receive', $value->saveInArray());
    }
    public function getESFReceiveObject(){
        $result = new Helpers_ESF_Unload_Product_Record();
        $result->loadToArray($this->getValueArray('esf_receive'));
        return $result;
    }

    public function setESFReceiveArray(array $value){
        $this->setValueArray('esf_receive', $value);
    }
    public function getESFReceiveArray(){
        return $this->getValueArray('esf_receive');
    }

    public function setESFReceive($value){
        $this->setValue('esf_receive', $value);

        if(empty($value)){
            $this->setIsESF(FALSE);
        }
    }
    public function getESFReceive(){
        return $this->getValue('esf_receive');
    }
}
