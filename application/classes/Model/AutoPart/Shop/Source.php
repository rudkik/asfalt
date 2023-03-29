<?php defined('SYSPATH') or die('No direct script access.');


class Model_AutoPart_Shop_Source extends Model_Shop_Table_Basic_Table{

    const SHOP_SOURCE_KASPI_KZ = 1;

	const TABLE_NAME = 'ap_shop_sources';
    const TABLE_ID = 433;

    public function __construct(){
        parent::__construct(
            array(
                'order',
                'code',
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
        $this->isValidationFieldInt('order', $validation);
        $this->isValidationFieldStr('code', $validation);
        return $this->_validationFields($validation, $errorFields);
    }

    // Путь для каталога
   public function setOrder($value){
        $this->setValueInt('order',$value);
    }
    public function getOrder(){
        return $this->getValueInt('order');
    }

    public function setCode($value){
        $this->setValue('code',$value);
    }
    public function getCode(){
        return $this->getValue('code');
    }
}
