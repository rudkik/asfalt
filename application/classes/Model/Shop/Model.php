<?php defined('SYSPATH') or die('No direct script access.');


class Model_Shop_Model extends Model_Shop_Basic_Collations{

	const TABLE_NAME = 'ct_shop_models';
	const TABLE_ID = 202;

	public function __construct(){
		parent::__construct(
			array(
				'shop_mark_id',
			),
			self::TABLE_NAME,
			self::TABLE_ID
		);

        $this->isAddUUID = TRUE;
	}

	/**
	 * Получение данных для вспомогательных элементов из базы данных
	 * и добавление его в массив
	 */
	public function dbGetElements($shopID = 0, $elements = NULL){
		if(is_array($elements)){
			foreach($elements as $element){
				switch($element){
                    case 'shop_mark_id':
                        $this->_dbGetElement($this->id, 'shop_mark_id', new Model_Shop_Mark());
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
	public function validationFields(array &$errorFields)
	{
		$validation = new Validation($this->getValues());

		$this->isValidationFieldInt('shop_mark_id', $validation);

		return $this->_validationFields($validation, $errorFields);
	}

    // Марка
    public function setShopMarkID($value){
        $this->setValueInt('shop_mark_id',$value);
    }
    public function getShopMarkID(){
        return $this->getValueInt('shop_mark_id');
    }
}
