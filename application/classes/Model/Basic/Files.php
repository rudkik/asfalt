<?php defined('SYSPATH') or die('No direct script access.');

class Model_Basic_Files extends Model_Basic_LanguageObject
{
    // разные файлы для разных языков
    protected $isTranslateFiles = FALSE;

    public function __construct(array $overallLanguageFields, $tableName, $tableID, $isTranslate = TRUE){
        if(!$this->isTranslateFiles) {
            $overallLanguageFields[] = 'image_path';
            $overallLanguageFields[] = 'files';
        }

        parent::__construct($overallLanguageFields, $tableName, $tableID, $isTranslate);
    }

    /**
     * Проверяем поля на ошибки
     * @param array $errorFields - массив ошибок
     * @return boolean
     */
    public function validationFields(array &$errorFields){
        $validation = new Validation($this->getValues());

        $validation->rule('files', 'max_length', array(':value', 65000))
            ->rule('addition_files', 'max_length', array(':value', 65000));

        return $this->_validationFields($validation, $errorFields);
    }

    /**
     * Возвращаем cписок всех переменных
     */
    public function getValues($isGetElement = FALSE, $isParseArray = FALSE, $shopID = NULL)
    {
        $arr = parent::getValues($isGetElement, $isParseArray, $shopID);

        if($isParseArray === TRUE) {
            $arr['files'] = $this->getFilesArray();
            $arr['addition_files'] = $this->getAdditionFilesArray();
        }

        return $arr;
    }

    // Картинка
    public function setImagePath($value){
        $this->setValue('image_path', $value);
    }

    public function getImagePath(){
        return $this->getValue('image_path');
    }

    // Дополнительные файлы
    public function setFiles($value){
        $this->setValue('files', $value);
    }

    public function getFiles(){
        return $this->getValue('files');
    }

    public function setFilesArray(array $value){
        $this->setValueArray('files', $value);
    }

    public function getFilesArray(){
        return $this->getValueArray('files');
    }

    // Дополнительные файлы
    public function setAdditionFiles($value){
        $this->setValue('addition_files', $value);
    }

    public function getAdditionFiles(){
        return $this->getValue('addition_files');
    }

    public function setAdditionFilesArray(array $value){
        $this->setValueArray('addition_files', $value);
    }

    public function getAdditionFilesArray(){
        return $this->getValueArray('addition_files');
    }

    /**
     * Копируем модель
     * @param Model_Basic_BasicObject $model
     * @param $isNew
     */
    public function copy(Model_Basic_BasicObject $model, $isNew)
    {
        if($model instanceof Model_Basic_Files){
            $this->isTranslateFiles = $model->isTranslateFiles;
        }

        parent::copy($model, $isNew);
    }
}
