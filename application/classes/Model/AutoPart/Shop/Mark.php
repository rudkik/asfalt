<?php defined('SYSPATH') or die('No direct script access.');


class Model_AutoPart_Shop_Mark extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ap_shop_models';
    const TABLE_ID = 348;

    public function __construct(){
        parent::__construct(
            array(
                'is_translates',
                'name_url',
            ),
            self::TABLE_NAME,
            self::TABLE_ID
        );

        $this->isAddCreated = TRUE;
    }

    /**
     * Проверяем поля на ошибки
     * @param array $errorFields - массив ошибок
     * @return boolean
     */
    public function validationFields(array &$errorFields)
    {
        $validation = new Validation($this->getValues());
        $this->isValidationFieldStr('name_url', $validation);
        $this->isValidationFieldBool('is_translates', $validation);
        return $this->_validationFields($validation, $errorFields);
    }

    public function setNameURL($value){
        $this->setValue('name_url', $value);
    }
    public function getNameURL(){
        return $this->getValue('name_url');
    }
    public function setIsTranslates($value){
        $this->setValue('is_translates', $value);
    }
    public function getIsTranslates(){
        return $this->getValue('is_translates');
    }
}
