<?php defined('SYSPATH') or die('No direct script access.');


class Model_Magazine_Shop_Receive_Item_GTD extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'sp_shop_receive_item_gtds';
	const TABLE_ID = 285;

	public function __construct(){
		parent::__construct(
			array(
			    'shop_supplier_id',
                'shop_receive_id',
                'shop_receive_item_id',
                'amount',
                'price',
                'quantity',
                'esf',
                'is_esf',
                'quantity_balance',
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
                    case 'shop_supplier_id':
                        $this->_dbGetElement($this->getShopSupplierID(), 'shop_supplier_id', new Model_Magazine_Shop_Supplier(), $shopID);
                        break;
                    case 'shop_receive_id':
                        $this->_dbGetElement($this->getShopReceiveID(), 'shop_receive_id', new Model_Magazine_Shop_Receive());
                        break;
                    case 'shop_receive_item_id':
                        $this->_dbGetElement($this->getShopReceiveItemID(), 'shop_receive_item_id', new Model_Magazine_Shop_Receive_Item());
                        break;
                    case 'shop_product_id':
                        $this->_dbGetElement($this->getShopProductID(), 'shop_product_id', new Model_Magazine_Shop_Product(), $shopID);
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
        $this->isValidationFieldInt('shop_receive_id', $validation);
        $this->isValidationFieldInt('shop_supplier_id', $validation);
        $this->isValidationFieldInt('shop_receive_item_id', $validation);
        $this->isValidationFieldFloat('amount', $validation);
        $this->isValidationFieldFloat('price', $validation);
        $this->isValidationFieldFloat('quantity', $validation);
        $this->isValidationFieldFloat('quantity_balance', $validation);
        $this->isValidationFieldFloat('quantity_invoice', $validation);
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
        $this->setValueInt('catalog_tru_id', $value);
    }
    public function getCatalogTruID(){
        return $this->getValueInt('catalog_tru_id');
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

    public function setShopProductID($value){
        $this->setValueInt('shop_product_id', $value);
    }
    public function getShopProductID(){
        return $this->getValueInt('shop_product_id');
    }

    public function setQuantity($value){
        $this->setValueFloat('quantity', $value);

        $this->setAmount($this->getQuantity() * $this->getPrice());
        $this->setQuantityBalance($this->getQuantity() - $this->getQuantityInvoice());
    }
    public function getQuantity(){
        return $this->getValueFloat('quantity');
    }

    public function setQuantityInvoice($value){
        $this->setValueFloat('quantity_invoice', $value);
        $this->setQuantityBalance($this->getQuantity() - $this->getQuantityInvoice());
    }
    public function getQuantityInvoice(){
        return $this->getValueFloat('quantity_invoice');
    }

    public function setQuantityBalance($value){
        $this->setValueFloat('quantity_balance', $value);
    }
    public function getQuantityBalance(){
        return $this->getValueFloat('quantity_balance');
    }

    public function setPrice($value){
        $this->setValueFloat('price', $value);
        $this->setAmount($this->getQuantity() * $this->getPrice());
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

    public function setShopReceiveID($value){
        $this->setValueInt('shop_receive_id', $value);
    }
    public function getShopReceiveID(){
        return $this->getValueInt('shop_receive_id');
    }

    public function setShopReceiveItemID($value){
        $this->setValueInt('shop_receive_item_id', $value);
    }
    public function getShopReceiveItemID(){
        return $this->getValueInt('shop_receive_item_id');
    }

    public function setShopSupplierID($value){
        $this->setValueInt('shop_supplier_id', $value);
    }
    public function getShopSupplierID(){
        return $this->getValueInt('shop_supplier_id');
    }

    // Данные ЭСФ
    public function setESFObject(Helpers_ESF_Unload_Product_Record $value){
        $value->setShopReceiveItemID($this->id);
        $this->setIsESF($value->getQuantity() == $this->getQuantity() && $value->getPrice() == $this->getPrice());
        $this->setValueArray('esf', $value->saveInArray());
    }
    public function getESFObject(){
        $result = new Helpers_ESF_Unload_Product_Record();
        $result->loadToArray($this->getValueArray('esf'));
        return $result;
    }

    public function setESFArray(array $value){
        $this->setValueArray('esf', $value);
    }
    public function getESFArray(){
        return $this->getValueArray('esf');
    }

    public function setESF($value){
        $this->setValue('esf', $value);

        if(empty($value)){
            $this->setIsESF(FALSE);
        }
    }
    public function getESF(){
        return $this->getValue('esf');
    }

    public function setIsESF($value){
        $this->setValueBool('is_esf', $value);
    }
    public function getIsESF(){
        return $this->getValueBool('is_esf');
    }
}
