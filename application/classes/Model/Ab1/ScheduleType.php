<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_ScheduleType extends Model_Basic_Options{

    const TABLE_NAME = 'ab_schedule_types';
    const TABLE_ID = 422;

    public function __construct(){
        parent::__construct(
            array(
                'period'
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
    public function validationFields(array &$errorFields)
    {
        $validation = new Validation($this->getValues());

        return $this->_validationFields($validation, $errorFields);
    }

    public function setPeriod($value){
        $this->setValue('period', $value);
    }
    public function getPeriod(){
        return $this->getValue('period');
    }

}
