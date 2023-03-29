<?php defined('SYSPATH') or die('No direct script access.');

class Model_Nur_Shop extends Model_Shop{

	public function __construct(){
        parent::__construct();
	}

	/**
	 * Получение данных для вспомогательных элементов из базы данных
	 * и добавление его в массив
	 */
    public function dbGetElements($shopID = 0, $elements = NULL)
    {
		if(($elements !== NULL) && (is_array($elements))){
            foreach($elements as $element){
                switch($element){
                    case 'organization_type_id':
                        $this->_dbGetElement($this->getOrganizationTypeID(), 'organization_type_id', new Model_OrganizationType());
                        break;
                    case 'organization_tax_type_id':
                        $this->_dbGetElement($this->getOrganizationTaxTypeID(), 'organization_tax_type_id', new Model_Tax_OrganizationTaxType());
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
    public function validationFields(array &$errorFields, $validation = NULL)
    {
        $validation = new Validation($this->getValues());
        $this->isValidationFieldInt('organization_type_id', $validation);
        $this->isValidationFieldInt('organization_tax_type_id', $validation);

        return parent::validationFields($errorFields, $validation);
    }

    /**
     * Возвращаем cписок всех переменных
     */
    public function getValues($isGetElement = FALSE, $isParseArray = FALSE, $shopID = NULL)
    {
        $arr = parent::getValues($isGetElement, $isParseArray, $shopID);

        if($isParseArray) {
            $arr['ecf'] = $this->getECFArray();
        }

        return $arr;
    }

    public function setOrganizationTypeID($value){
        $this->setValueInt('organization_type_id', $value);
    }
    public function getOrganizationTypeID(){
        return $this->getValueInt('organization_type_id');
    }

    public function setShopBookkeeperID($value){
        $this->setValueInt('shop_bookkeeper_id', $value);
    }
    public function getShopBookkeeperID(){
        return $this->getValueInt('shop_bookkeeper_id');
    }

    public function setOrganizationTaxTypeID($value){
        $this->setValueInt('organization_tax_type_id', $value);
    }
    public function getOrganizationTaxTypeID(){
        return $this->getValueInt('organization_tax_type_id');
    }

    public function setBIN($value){
        $this->setValue('bin', $value);
    }
    public function getBIN(){
        return $this->getValue('bin');
    }

    public function setRequisites($value){
        parent::setRequisites($value);

        $requisites = $this->getRequisitesArray();

        $this->setOrganizationTypeID(Arr::path($requisites, 'organization_type_id', 0));
        $this->setOrganizationTaxTypeID(Arr::path($requisites, 'organization_tax_type_id', 0));
        $this->setBIN(Arr::path($requisites, 'bin', 0));
    }

    public function setRequisitesArray(array $value){
        parent::setRequisitesArray($value);

        $requisites = $this->getRequisitesArray();

        $this->setOrganizationTypeID(Arr::path($requisites, 'organization_type_id', 0));
        $this->setOrganizationTaxTypeID(Arr::path($requisites, 'organization_tax_type_id', 0));
        $this->setBIN(Arr::path($requisites, 'bin', 0));
    }

    public function getBankID(){
        return Arr::path($this->getRequisitesArray(), 'bank_id', 0);
    }

    public function getShopTaskGroupIDs(){
        return Arr::path($this->getRequisitesArray(), 'shop_group_task_ids', array());
    }

    public function getShopTaxViewIDs(){
        return Arr::path($this->getRequisitesArray(), 'shop_tax_view_ids', array());
    }

    public function getShopCompanyViewID(){
        return Arr::path($this->getRequisitesArray(), 'shop_company_view_id', 0);
    }

    public function getAuthorityID(){
        return Arr::path($this->getRequisitesArray(), 'authority_id', 0);
    }

    public function getAkimatID(){
        return Arr::path($this->getRequisitesArray(), 'akimat_id', 0);
    }

    // JSON ЭЦП
    public function setECF($value){
        $this->setValue('ecf', $value);
    }
    public function getECF(){
        return $this->getValue('ecf');
    }
    // JSON настройки списка полей
    public function setECFArray(array $value){
        $this->setValueArray('ecf', $value);
    }
    public function getECFArray(){
        return $this->getValueArray('ecf');
    }
    /**
     * @param array $value
     * @param bool $isAddAll - добавлять все записи или только новые
     */
    public function addECFArray(array $value, $isAddAll = TRUE){
        $tmp = $this->getECFArray();

        foreach($value as $k => $v){
            if($isAddAll || (! key_exists($k, $tmp) || empty($tmp[$k]))) {
                $tmp[$k] = $v;
            }
        }

        $this->setECFArray($tmp);
    }
}
