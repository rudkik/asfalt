<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Register_Raw extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_register_raws';
	const TABLE_ID = 339;

	public function __construct(){
		parent::__construct(
			array(
                'quantity',
                'price',
                'amount',
                'shop_transport_company_id',
                'shop_storage_id',
                'shop_subdivision_id',
                'shop_heap_id',
                'shop_raw_id',
                'shop_object_id',
                'shop_formula_material_id',
                'shop_formula_raw_id',
                'root_shop_register_material_id',
                'root_shop_register_raw_id',
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
                    case 'shop_raw_id':
                        $this->_dbGetElement($this->getShopFormulaProductID(), 'shop_raw_id', new Model_Ab1_Shop_Raw(), $shopID);
                        break;
                    case 'shop_transport_company_id':
                        $this->_dbGetElement($this->getShopFormulaProductID(), 'shop_transport_company_id', new Model_Ab1_Shop_Transport_Company());
                        break;
                    case 'shop_head_id':
                        $this->_dbGetElement($this->getShopHeapID(), 'shop_head_id', new Model_Ab1_Shop_Heap());
                        break;
                    case 'shop_subdivision_id':
                        $this->_dbGetElement($this->getShopSubdivisionID(), 'shop_subdivision_id', new Model_Ab1_Shop_Subdivision());
                        break;
                    case 'shop_storage_id':
                        $this->_dbGetElement($this->getShopStorageID(), 'shop_storage_id', new Model_Ab1_Shop_Storage());
                        break;
                    case 'shop_object_id':
                        $this->_dbGetElement($this->getShopObjectID(), 'shop_object_id', Model_Ab1_ModelList::createModel($this->getTableID(), $this->getDBDriver()));
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
        $validation->rule('quantity', 'max_length', array(':value', 12))
			->rule('price', 'max_length', array(':value', 12))
			->rule('amount', 'max_length', array(':value', 12));

        $this->isValidationFieldInt('shop_object_id', $validation);
        $this->isValidationFieldInt('shop_transport_company_id', $validation);
        $this->isValidationFieldInt('shop_subdivision_id', $validation);
        $this->isValidationFieldInt('shop_storage_id', $validation);
        $this->isValidationFieldInt('shop_heap_id', $validation);
        $this->isValidationFieldInt('shop_raw_id', $validation);
        $this->isValidationFieldInt('table_id', $validation);
        $this->isValidationFieldInt('root_shop_register_raw_id', $validation);
        $this->isValidationFieldInt('root_shop_register_material_id', $validation);
        $this->isValidationFieldInt('level', $validation);
        $this->isValidationFieldInt('shop_formula_material_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setLevel($value){
        $this->setValueInt('level', $value);
    }
    public function getLevel(){
        return $this->getValueInt('level');
    }

    public function setRootShopRegisterRawID($value){
        $this->setValueInt('root_shop_register_raw_id', $value);
    }
    public function getRootShopRegisterRawID(){
        return $this->getValueInt('root_shop_register_raw_id');
    }

    public function setRootShopRegisterMaterialID($value){
        $this->setValueInt('root_shop_register_material_id', $value);
    }
    public function getRootShopRegisterMaterialID(){
        return $this->getValueInt('root_shop_register_material_id');
    }

    public function setShopFormulaMaterialID($value){
        $this->setValueInt('shop_formula_material_id', $value);
    }
    public function getShopFormulaMaterialID(){
        return $this->getValueInt('shop_formula_material_id');
    }

    public function setQuantity($value){
        $this->setValueFloat('quantity', round($value, 3));
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
        $this->setValueFloat('amount', $value);
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

    public function setShopObjectID($value){
        $this->setValueInt('shop_object_id', $value);
    }
    public function getShopObjectID(){
        return $this->getValueInt('shop_object_id');
    }

    public function setShopTransportCompanyID($value){
        $this->setValueInt('shop_transport_company_id', $value);
    }
    public function getShopTransportCompanyID(){
        return $this->getValueInt('shop_transport_company_id');
    }

    public function setShopStorageID($value){
        $this->setValueInt('shop_storage_id', $value);
    }
    public function getShopStorageID(){
        return $this->getValueInt('shop_storage_id');
    }

    public function setShopSubdivisionID($value){
        $this->setValueInt('shop_subdivision_id', $value);
    }
    public function getShopSubdivisionID(){
        return $this->getValueInt('shop_subdivision_id');
    }

    public function setShopHeapID($value){
        $this->setValueInt('shop_heap_id', $value);
    }
    public function getShopHeapID(){
        return $this->getValueInt('shop_heap_id');
    }

    public function setShopFormulaRawID($value){
        $this->setValueInt('shop_formula_raw_id', $value);
    }
    public function getShopFormulaRawID(){
        return $this->getValueInt('shop_formula_raw_id');
    }

    public function setShopRawID($value){
        $this->setValueInt('shop_raw_id', $value);
    }
    public function getShopRawID(){
        return $this->getValueInt('shop_raw_id');
    }

    public function setShopBallastCrusherID($value)
    {
        $this->setValueInt('shop_ballast_crusher_id', $value);
    }
    public function getShopBallastCrusherID()
    {
        return $this->getValueInt('shop_ballast_crusher_id');
    }

}
