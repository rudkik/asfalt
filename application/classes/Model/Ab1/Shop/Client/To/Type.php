<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Client_To_Type extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_client_to_types';
	const TABLE_ID = 418;

	public function __construct(){
		parent::__construct(
			array(
			    'shop_client_id',
                'client_type_id',
            ),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}

    /**
     * Получение данных для вспомогательных элементов из базы данных
     * и добавление его в массив
     * @param int $shopID
     * @param null | array $elements
     * @return bool
     */
    public function dbGetElements($shopID = 0, $elements = NULL){
        if(($elements === NULL) || (! is_array($elements))){
            return FALSE;
        }

        foreach($elements as $key => $element){
            if (is_array($element)){
                $element = $key;
            }

            switch ($element) {
                case 'shop_client_id':
                    $this->_dbGetElement($this->getShopClientID(), 'shop_client_id', new Model_Ab1_Shop_Client(), $shopID);
                    break;
                case 'client_type_id':
                    $this->_dbGetElement($this->getClientTypeID(), 'client_type_id', new Model_Ab1_ClientType(), $shopID);
                    break;
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
        $this->isValidationFieldInt('shop_client_id', $validation);
        $this->isValidationFieldInt('client_type_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    /**
     * Возвращаем cписок всех переменных
     */
    public function getValues($isGetElement = FALSE, $isParseArray = FALSE, $shopID = NULL)
    {
        $arr = parent::getValues($isGetElement, $isParseArray, $shopID);
        return $arr;
    }

     public function setShopClientID($value){
        $this->setValueInt('shop_client_id', $value);
    }
    public function getShopClientID(){
        return $this->getValueInt('shop_client_id');
    }

    public function setClientTypeID($value){
        $this->setValueInt('client_type_id', $value);
    }
    public function getClientTypeID(){
        return $this->getValueInt('client_type_id');
    }

   }
