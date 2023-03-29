<?php defined('SYSPATH') or die('No direct script access.');

class DB_FieldType {
    const NAME = 'DB_FieldType';

    const FIELD_TYPE_INTEGER = 0;
    const FIELD_TYPE_BOOLEAN = 1;
    const FIELD_TYPE_STRING = 2;
    const FIELD_TYPE_DATE_TIME = 3;
    const FIELD_TYPE_DATE = 4;
    const FIELD_TYPE_TIME = 5;
    const FIELD_TYPE_FLOAT = 6;
    const FIELD_TYPE_JSON = 7;
    const FIELD_TYPE_FILES = 8;
    const FIELD_TYPE_ARRAY = 9;
    const FIELD_TYPE_TEXT = 10;

    /**
     * Преобразуем FIELD_TYPE_ в строку
     * @param int $fieldType
     * @return int|string
     */
    public static function fieldTypeToStr($fieldType){

        switch ($fieldType){
            case self::FIELD_TYPE_INTEGER:
                $fieldType = 'FIELD_TYPE_INTEGER';
                break;
            case self::FIELD_TYPE_BOOLEAN:
                $fieldType = 'FIELD_TYPE_BOOLEAN';
                break;
            case self::FIELD_TYPE_STRING:
                $fieldType = 'FIELD_TYPE_STRING';
                break;
            case self::FIELD_TYPE_DATE_TIME:
                $fieldType = 'FIELD_TYPE_DATE_TIME';
                break;
            case self::FIELD_TYPE_DATE:
                $fieldType = 'FIELD_TYPE_DATE';
                break;
            case self::FIELD_TYPE_TIME:
                $fieldType = 'FIELD_TYPE_TIME';
                break;
            case self::FIELD_TYPE_FLOAT:
                $fieldType = 'FIELD_TYPE_FLOAT';
                break;
            case self::FIELD_TYPE_JSON:
                $fieldType = 'FIELD_TYPE_JSON';
                break;
            case self::FIELD_TYPE_FILES:
                $fieldType = 'FIELD_TYPE_FILES';
                break;
            case self::FIELD_TYPE_ARRAY:
                $fieldType = 'FIELD_TYPE_ARRAY';
                break;
        }
        return $fieldType;
    }
}