<?php defined('SYSPATH') or die('No direct script access.');


class Model_Magazine_Shop_Revise extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'sp_shop_revises';
	const TABLE_ID = 253;

	public function __construct(){
		parent::__construct(
			array(
                'quantity_actual',
                'quantity',
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

        $this->isValidationFieldFloat('quantity_actual', $validation);
        $this->isValidationFieldFloat('quantity', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setQuantity($value){
        $this->setValueFloat('quantity', $value);
    }
    public function getQuantity(){
        return $this->getValueFloat('quantity');
    }

    public function setQuantityActual($value){
        $this->setValueFloat('quantity_actual', $value);
    }
    public function getQuantityActual(){
        return $this->getValueFloat('quantity_actual');
    }
}
