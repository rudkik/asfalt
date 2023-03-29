<?php defined('SYSPATH') or die('No direct script access.');


class Model_Nur_Shop_Tax_View extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'nr_shop_tax_views';
	const TABLE_ID = 265;

	public function __construct(){
		parent::__construct(
			array(
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

        return $this->_validationFields($validation, $errorFields);
    }
}
