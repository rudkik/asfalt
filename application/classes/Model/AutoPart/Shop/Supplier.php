<?php defined('SYSPATH') or die('No direct script access.');

class Model_AutoPart_Shop_Supplier extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ap_shop_suppliers';
    const TABLE_ID = '';

    public function __construct(){
        parent::__construct(
            array(
			'order',
			'phone',
			'bin',
			'name_url',
			'is_disable_dumping',
			'min_markup',
			'name_organization',
			'bank_name',
			'bank_id',
			'bank_number',
			'director_name',
			'director_position',
			'legal_address',
			'post_address',
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
                   case 'bank_id':
                            $this->_dbGetElement($this->getBankID(), 'bank_id', new Model_Bank(), $shopID);
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

        $this->isValidationFieldInt('order', $validation);
        $this->isValidationFieldStr('name_url', $validation);
        $this->isValidationFieldBool('is_disable_dumping', $validation);
        $this->isValidationFieldFloat('min_markup', $validation);
        $this->isValidationFieldStr('phone', $validation);
        $this->isValidationFieldStr('name_organization', $validation);
        $this->isValidationFieldStr('bank_name', $validation);
        $this->isValidationFieldInt('bank_id', $validation);
        $this->isValidationFieldStr('bank_number', $validation);
        $this->isValidationFieldStr('director_name', $validation);
        $this->isValidationFieldStr('director_position', $validation);
        $this->isValidationFieldStr('legal_address', $validation);
        $this->isValidationFieldStr('post_address', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setIsDisableDumping($value){
        $this->setValueBool('is_disable_dumping', $value);
    }
    public function getIsDisableDumping(){
        return $this->getValueBool('is_disable_dumping');
    }

    public function setMinMarkup($value){
        $this->setValueFloat('min_markup', $value);
    }
    public function getMinMarkup(){
        return $this->getValueFloat('min_markup');
    }

    public function setNameOrganization($value){
        $this->setValue('name_organization', $value);
    }
    public function getNameOrganization(){
        return $this->getValue('name_organization');
    }

    public function setBankName($value){
        $this->setValue('bank_name', $value);
    }
    public function getBankName(){
        return $this->getValue('bank_name');
    }

    public function setBankID($value){
        $this->setValueInt('bank_id', $value);
    }
    public function getBankID(){
        return $this->getValueInt('bank_id');
    }

    public function setBankNumber($value){
        $this->setValue('bank_number', $value);
    }
    public function getBankNumber(){
        return $this->getValue('bank_number');
    }

    public function setDirectorName($value){
        $this->setValue('director_name', $value);
    }
    public function getDirectorName(){
        return $this->getValue('director_name');
    }

    public function setDirectorPosition($value){
        $this->setValue('director_position', $value);
    }
    public function getDirectorPosition(){
        return $this->getValue('director_position');
    }

    public function setLegalAddress($value){
        $this->setValue('legal_address', $value);
    }
    public function getLegalAddress(){
        return $this->getValue('legal_address');
    }

    public function setPostAddress($value){
        $this->setValue('post_address', $value);
    }
    public function getPostAddress(){
        return $this->getValue('post_address');
    }

    public function setBIN($value){
        $this->setValue('bin', $value);
    }
    public function getBIN(){
        return $this->getValue('bin');
    }

    public function setPhone($value){
        $this->setValue('phone', $value);
    }
    public function getPhone(){
        return $this->getValue('phone');
    }
}
