<?php defined('SYSPATH') or die('No direct script access.');

class Model_Shop_Image extends Model_Shop_Table_Basic_Object{

	const TABLE_NAME='ct_shop_images';
	const TABLE_ID = 26;

	public function __construct(){
		parent::__construct(
			array(
                'image_type_id',
			),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}
	
	/**
	 * Проверяем поля на ошибки
	 * @param array $errorFields - массив ошибок
	 * @return boolean
	 */
	public function validationFields(array &$errorFields){
		$validation = new Validation($this->getValues());
	
		if ($this->id < 1){
			$validation->rule('table_id', 'not_empty');
		}
	
		$validation->rule('table_id', 'max_length', array(':value', 11))
            ->rule('file_name', 'max_length', array(':value', 250))
            ->rule('image_type_id', 'max_length', array(':value', 11))
            ->rule('width', 'max_length', array(':value', 11))
            ->rule('height', 'max_length', array(':value', 11))
            ->rule('file_size', 'max_length', array(':value', 11))
            ->rule('shop_object_language_ids', 'max_length', array(':value', 650000))
            ->rule('options', 'max_length', array(':value', 650000));

        if ($this->isFindFieldAndIsEdit('image_type_id')) {
            $validation->rule('image_type_id', 'digit');
        }

        if ($this->isFindFieldAndIsEdit('width')) {
            $validation->rule('width', 'digit');
        }

        if ($this->isFindFieldAndIsEdit('height')) {
            $validation->rule('height', 'digit');
        }

        if ($this->isFindFieldAndIsEdit('file_size')) {
            $validation->rule('file_size', 'digit');
        }

        if ($this->isFindFieldAndIsEdit('table_id')) {
            $validation->rule('table_id', 'digit');
        }
	
		return $this->_validationFields($validation, $errorFields);
	}

    /**
     * Возвращаем cписок всех переменных
     */
    public function getValues($isGetElement = FALSE, $isParseArray = FALSE, $shopID = NULL)
    {
        $arr = parent::getValues($isGetElement, $isParseArray, $shopID);

        if($isParseArray === TRUE) {
            $arr['options'] = $this->getOptionsArray();
            $arr['shop_object_language_ids'] = $this->getShopObjectLanguageIDsArray();
        }

        return $arr;
    }

    //ID типа акции
    public function setImageTypeID($value){
        $this->setValueInt('image_type_id', $value);
    }

    public function getImageTypeID(){
        return $this->getValueInt('image_type_id');
    }

    // Размер файла
    public function setFileSize($value){
        $this->setValueInt('file_size', $value);
    }

    public function getFileSize(){
        return $this->getValueInt('file_size');
    }

    // Ширина картинки
    public function setWidth($value){
        $this->setValueInt('width', $value);
    }

    public function getWidth(){
        return $this->getValueInt('width');
    }

    // Высота картинки
    public function setHeight($value){
        $this->setValueInt('height', $value);
    }

    public function getHeight(){
        return $this->getValueInt('height');
    }
	
	// Название таблицы
	public function setTableID($value){
		$this->setValueInt('table_id', $value);
	}
	public function getTableID(){
		return $this->getValueInt('table_id');
	}

    // Название файла
    public function setFileName($value){
        $this->setValue('file_name', $value);
    }
    public function getFileName(){
        return $this->getValue('file_name');
    }

	// Картинка
	public function setImagePath($value){
		$this->setValue('image_path', $value);
	}

	public function getImagePath(){
		return $this->getValue('image_path');
	}

	// массив привязаных записей
	public function setShopObjectLanguageIDs($value){
		$this->setValue('shop_object_language_ids', $value);
	}

	public function getShopObjectLanguageIDs(){
		return $this->getValue('shop_object_language_ids');
	}

    public function setShopObjectLanguageIDsArray(array  $value){
        $this->setValueArray('shop_object_language_ids', $value);
    }

    public function getShopObjectLanguageIDsArray(){
        return $this->getValueArray('shop_object_language_ids');
    }

    // Дополнительные поля
    public function setOptions($value){
        $this->setValue('options', $value);
    }

    public function getOptions(){
        return $this->getValue('options');
    }

    public function setOptionsArray(array $value){
        $this->setValueArray('options', $value);
    }

    public function getOptionsArray(){
        return $this->getValueArray('options');
    }
}
