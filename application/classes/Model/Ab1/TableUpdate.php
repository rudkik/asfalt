<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_TableUpdate extends Model_Basic_DBValue{

	const TABLE_NAME = 'ab_table_updates';
	const TABLE_ID = 368;

    public function __construct(){
        parent::__construct(
            array(
                'sql',
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
        $this->isValidationFieldStr('sql', $validation);
        return $this->_validationFields($validation, $errorFields);
    }

    public function setSQL($value){
        $this->setValue('sql', $value);
    }
    public function getSQL(){
        return $this->getValue('sql');
    }

}