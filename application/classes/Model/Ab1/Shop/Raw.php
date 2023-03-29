<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Raw extends Model_Shop_Basic_Options{

	const TABLE_NAME = 'ab_shop_raws';
	const TABLE_ID = 417;

	public function __construct(){
		parent::__construct(
			array(
                'shop_raw_rubric_id',
            ),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}

    /**
     * Получение данных для вспомогательных элементов из базы данных
     * и добавление его в массив
     * @param int $shopID
     * @param null $elements
     * @return bool
     */
    public function dbGetElements($shopID = 0, $elements = NULL){
        if(is_array($elements)){
            foreach($elements as $element){
                switch($element){
                    case 'shop_raw_rubric_id':
                        $this->_dbGetElement($this->getShopRawRubricID(), 'shop_raw_rubric_id', new Model_Ab1_Shop_Raw_Rubric());
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
        $validation->rule('name_1c', 'max_length', array(':value', 250));
        $this->isValidationFieldInt('shop_raw_rubric_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

	public function setName1C($value){
		$this->setValue('name_1c', $value);
	}
	public function getName1C(){
		return $this->getValue('name_1c');
	}
	public function setShopRawRubricID($value){
		$this->setValue('shop_raw_rubric_id', $value);
	}
	public function getShopRawRubricID(){
		return $this->getValue('shop_raw_rubric_id');
	}
}
