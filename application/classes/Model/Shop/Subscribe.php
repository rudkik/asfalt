<?php defined('SYSPATH') or die('No direct script access.');

class Model_Shop_Subscribe extends Model_Shop_Table_Basic_Table
{

    const TABLE_NAME = 'ct_shop_subscribes';
    const TABLE_ID = 281;

    public function __construct()
    {
        parent::__construct(
            array(
                'email',
            ),
            self::TABLE_NAME,
            self::TABLE_ID,
            FALSE
        );
    }

    /**
     * Проверяем поля на ошибки
     * @param array $errorFields - массив ошибок
     * @return boolean
     */
    public function validationFields(array &$errorFields)
    {
        $validation = new Validation($this->getValues());
        $validation->rule('email', 'max_length', array(':value', 150));
        return $this->_validationFields($validation, $errorFields);
    }

    public function setEMail($value)
    {
        $this->setValue('email', $value);
    }

    public function getEMail()
    {
        return $this->getValue('email');
    }
}

