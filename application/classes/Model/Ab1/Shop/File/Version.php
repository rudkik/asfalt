<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_File_Version extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ed_shop_file_versions';
	const TABLE_ID = 122;

	public function __construct(){
		parent::__construct(
			array(
                'shop_file_id',
                'version',
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
		if(($elements === NULL) || (! is_array($elements))){
		}else{
			foreach($elements as $element){
				switch($element){
                    case 'shop_file_id':
                        $this->_dbGetElement($this->getShopFileID(), 'shop_file_id', new Model_Ab1_Shop_File());
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
        $validation->rule('shop_file_id', 'max_length', array(':value', 11))
			->rule('version', 'max_length', array(':value', 11));

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopFileID($value){
        $this->setValueInt('shop_file_id', $value);
    }
    public function getShopFileID(){
        return $this->getValueInt('shop_file_id');
    }

    public function setVersion($value){
        $this->setValueInt('version', $value);
    }
    public function getVersion(){
        return $this->getValueInt('version');
    }

}
