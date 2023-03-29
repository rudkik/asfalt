<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Ballast_Crusher extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_ballast_crushers';
	const TABLE_ID = 204;

	public function __construct(){
		parent::__construct(
			array(
			    'is_storage',
                'is_move',
                'is_balance',
            ),
			self::TABLE_NAME,
			self::TABLE_ID
		);

		$this->isAddCreated = TRUE;
	}

	/**
	 * Получение данных для вспомогательных элементов из базы данных
	 * и добавление его в массив
	 */
	public function dbGetElements($shopID = 0, $elements = NULL){
		parent::dbGetElements($shopID, $elements);
	}

    /**
     * Проверяем поля на ошибки
     * @param array $errorFields - массив ошибок
     * @return boolean
     */
    public function validationFields(array &$errorFields)
    {
        $validation = new Validation($this->getValues());

        $this->isValidationFieldBool('is_storage', $validation);
        $this->isValidationFieldBool('is_move', $validation);
        $this->isValidationFieldBool('is_balance', $validation);
        return $this->_validationFields($validation, $errorFields);
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

    public function setIsStorage($value){
        $this->setValueBool('is_storage', $value);
    }
    public function getIsStorage(){
        return $this->getValueBool('is_storage');
    }

    public function setIsMove($value){
        $this->setValueBool('is_move', $value);
    }
    public function getIsMove(){
        return $this->getValueBool('is_move');
    }

    public function setIsBalance($value){
        $this->setValueBool('is_balance', $value);
    }
    public function getIsBalance(){
        return $this->getValueBool('is_balance');
    }
}
