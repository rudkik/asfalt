<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Ballast_Distance_Tariff extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_ballast_distance_tariffs';
	const TABLE_ID = 205;

	public function __construct(){
		parent::__construct(
			array(
                'price',
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
     * @param null $elements
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
        $this->isValidationFieldFloat('price', $validation);
        return $this->_validationFields($validation, $errorFields);
    }

    public function setPrice($value){
        $this->setValueFloat('price', $value);
    }
    public function getPrice(){
        return $this->getValueFloat('price');
    }
}
