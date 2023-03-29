<?php defined('SYSPATH') or die('No direct script access.');


class Model_Shop_Calendar extends Model_Shop_Basic_Collations{

	const TABLE_NAME = 'ct_shop_calendars';
	const TABLE_ID = 152;

	public function __construct(){
		parent::__construct(
			array(
                'is_group',
                'date_from',
                'date_to',
                'time_options',
                'calendar_event_type_id',
			),
			self::TABLE_NAME,
			self::TABLE_ID
		);
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
                    case 'shop_table_preview_id':
                        $this->_dbGetElement($this->id, 'shop_table_preview', new Model_Shop_Table_Preview());
                        break;
                    case 'calendar_event_type_id':
                        $this->_dbGetElement($this->getCalendarEventTypeID(), 'calendar_event_type_id', new Model_CalendarEventType());
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

		$validation->rule('is_group', 'max_length', array(':value', 1))
			->rule('download_file_path', 'max_length', array(':value', 250))
			->rule('download_file_name', 'max_length', array(':value', 250));

		if ($this->isFindFieldAndIsEdit('is_group')) {
			$validation->rule('is_group', 'digit');
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
            $arr['time_options'] = $this->getTimeOptionsArray();
        }

        return $arr;
    }


    // Группа ли
	public function setIsGroup($value){
		$this->setValueBool('is_group', $value);
	}
	public function getIsGroup(){
		return $this->getValueBool('is_group');
	}

	public function setDownloadFilePath($value){
		$this->setValue('download_file_path', $value);
	}
	public function getDownloadFilePath(){
		return $this->getValue('download_file_path');
	}
	public function setDownloadFileName($value){
		$this->setValue('download_file_name', $value);
	}
	public function getDownloadFileName(){
		return $this->getValue('download_file_name');
	}

    public function setDateFrom($value){
        $this->setValueDate('date_from', $value);
    }
    public function getDateFrom(){
        return $this->getValueDateTime('date_from');
    }

    public function setDateTo($value){
        $this->setValueDate('date_to', $value);
    }
    public function getDateTo(){
        return $this->getValueDateTime('date_to');
    }

    // JSON настройки списка полей
    public function setTimeOptions($value){
        $this->setValue('time_options', $value);
    }

    public function getTimeOptions(){
        return $this->getValue('time_options');
    }

    // JSON настройки списка полей
    public function setTimeOptionsArray(array $value){
        $this->setValueArray('time_options', $value);
    }

    public function getTimeOptionsArray(){
        return $this->getValueArray('time_options');
    }

    /**
     * @param array $value
     * @param bool $isAddAll - добавлять все записи или только новые
     */
    public function addTimeOptionsArray(array $value, $isAddAll = TRUE){
        $tmp = $this->getTimeOptionsArray();

        foreach($value as $k => $v){
            if($isAddAll || (! key_exists($k, $tmp) || empty($tmp[$k]))) {
                $tmp[$k] = $v;
            }
        }

        $this->setTimeOptionsArray($tmp);
    }

    public function setCalendarEventTypeID($value){
        $this->setValueInt('calendar_event_type_id', $value);
    }
    public function getCalendarEventTypeID(){
        return $this->getValueInt('calendar_event_type_id');
    }
}
