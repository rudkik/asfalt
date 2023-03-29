<?php defined('SYSPATH') or die('No direct script access.');

class Api_MVC{
    /**
     * Получаем выыбор проекта через DB
     * @param array $list
     * @return string
     */
    private static function switchFolder(array &$list): string
    {
        switch ($list[0]) {
            case 'ab':
                $list[0] = 'Ab1';
                $projectName = 'Ab1';
                break;
            case 'ap':
                $list[0] = 'AutoPart';
                $projectName = 'AutoPart';
                break;
            case 'sp':
                $list[0] = 'Magazine';
                $projectName = 'Magazine';
                break;
            default:
                unset($list[0]);
                $projectName = '';
        }
        return $projectName;
    }


    /**
     * Массив с заглавными буквами
     * @param array $list
     * @return array
     */
    public static function ucFirstArray(array $list) : array
    {
        foreach ($list as $key => $arr) {
            $list[$key] = ucfirst($arr);
        }
        return $list;
    }

    /**
     * Создаем и возврощаем путь до файла по названию таблицы
     * @param $tableName
     * @param string $mvc
     * @return string
     */
    private static function createPath($tableName, string $mvc = 'DB') : string
    {
        $list = explode('_', $tableName);
        self::switchFolder($list);
        $list = self::ucFirstArray($list);

        $fileName = $list[count($list) - 1];
        $fileName = substr($fileName,0,-1);
        $fileName .= '.php';

        unset($list[count($list) - 1]);

        $path = implode(DIRECTORY_SEPARATOR, $list);
        $path = Helpers_Path::getPathFile(APPPATH, ['classes', $mvc, $path]);
        Helpers_Path::createPath($path);

        return $path . $fileName;
    }


    /**
     * Получаем название DB_ Model_
     * @param string $tableName
     * @param string $prefix
     * @return string
     */
    public static function getNameObject(string  $tableName, string $prefix = 'DB') : string
    {
        $list = explode('_', substr($tableName,0,-1));
        $projectName = self::switchFolder($list);
        $objectName = self::_getObjectName($list, $projectName, false, $prefix);
        if (!empty($objectName)) {
            return $objectName;
        }
        $list = self::ucFirstArray($list);
        return $prefix . '_' . implode('_', $list);
    }

    /**
     * По списку каталогов получаем название обьекта
     * @param array $catalogs
     * @param $projectName
     * @param bool $isFindProjects
     * @param string $mvc
     * @return string
     */
    private static function _getObjectName(array $catalogs, $projectName, $isFindProjects = true, $mvc = 'DB'){

        $catalogs = self::ucFirstArray($catalogs);

        $path = Helpers_Path::getPathFile(APPPATH, ['classes', $mvc]);

        //Создаем последовательность проектов
        $projects = [];
        if ($projectName != ''){
            $projects[] = [
                'db' => 'DB_' . $projectName . '_',
                'path' => $path . $projectName . DIRECTORY_SEPARATOR
            ];
        }
        $projects[] = [
            'db' => 'DB_',
            'path' => $path
        ];

        // Получаем массив проектов
        if ($isFindProjects) {
            $folders = scandir($path);
            foreach ($folders as $key => $folder) {
                if ($folder == '.' || $folder == '..' || !is_dir($path . $folder)) {
                    unset($folders[$key]);
                }
            }
            foreach ($folders as $folder) {
                if ($projectName != $folder && $folder != 'Shop') {
                    $projects[] = [
                        'db' => 'DB_' . $folder . '_',
                        'path' => $path . $folder . DIRECTORY_SEPARATOR
                    ];
                }
            }
        }

        //Проверим существует файл DB_
        foreach ($projects as $project){
            foreach ($catalogs as $one) {
                $project['path'] .= $one;
                $project['db'] .= $one;

                if (file_exists($project['path'])){
                    $project['path'] .= DIRECTORY_SEPARATOR;
                    $project['db'] .= '_';
                }
            }

            if(mb_substr($project['path'],-1, 1) == DIRECTORY_SEPARATOR){
                $project['path'] = mb_substr($project['path'],0,-1);
                $project['db'] = mb_substr($project['db'],0,-1);
            }
            $project['path'] .='.php';
            if (file_exists($project['path'])){
                return $project['db'];
            }
        }
        return '';
    }

    /**
     * Получаем DB_ по названию поля
     * @param $fieldName
     * @param $projectName
     * @return string
     */
    public static function getTableNameByField($fieldName, $projectName){
        if (stripos($fieldName , '_id') === false || $fieldName == 'global_id' ) {
            return '';
        }

        if ($fieldName == 'create_user_id' || $fieldName == 'update_user_id' || $fieldName == 'delete_user_id') {
            return 'DB_User';
        }
//         if ($fieldName == 'root_id'){ @TODO доделать проверку по полю Root_id
//             return $className;
//         }

        $list = explode('_', $fieldName);
        if ($list[count($list) - 1] != 'id' || $list[0] == ''){
            return '';
        }
        unset($list[count($list) - 1]);

        return self::_getObjectName($list, $projectName);
    }

    /**
     *
     * @param $fileName
     * @param array $params
     * @param string $mvc
     */
    private static function createMVC($fileName, array $params, string $mvc){
        $view = View::factory('template_code' . DIRECTORY_SEPARATOR . $mvc);

        foreach ($params as $key => $param){
            $view->$key = $param;
        }
        $str = Helpers_View::viewToStr($view);
        $str = '<?php' . $str;
        Helpers_Path::createPath(dirname($fileName));
        file_put_contents($fileName, $str);
    }

    /**
     * Создает файл DB_ по названию таблицы
     * @param $tableName
     * @param $projectName
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function createDB($tableName, $projectName, Model_Driver_DBBasicDriver $driver){
        $indexesDB = $driver->getSelectSQL('SELECT * FROM pg_indexes WHERE tablename = ' . "'" . $tableName . "'", true);
        $fieldsDB = $driver->getSelectSQL('SELECT col.table_schema AS schema_name, col.table_name, col.column_name, col.character_maximum_length, col.is_nullable, col.numeric_precision, col.numeric_scale, col.datetime_precision, col.ordinal_position, b.atttypmod, b.attndims, col.data_type AS col_type, et.typelem, et.typlen, et.typtype, nbt.nspname AS elem_schema, bt.typname AS elem_name, b.atttypid, col.udt_schema, col.udt_name, col.domain_catalog, col.domain_schema, col.domain_name, col_description(c.oid, col.ordinal_position) AS comment, col.column_default AS col_default, b.attacl, colnsp.nspname AS collation_schema_name, coll.collname, c.relkind, b.attfdwoptions AS foreign_options FROM information_schema.columns AS col LEFT JOIN pg_namespace ns ON ns.nspname = col.table_schema LEFT JOIN pg_class c ON col.table_name = c.relname AND c.relnamespace = ns.oid LEFT JOIN pg_attrdef a ON c.oid = a.adrelid AND col.ordinal_position = a.adnum LEFT JOIN pg_attribute b ON b.attrelid = c.oid AND b.attname = col.column_name LEFT JOIN pg_type et ON et.oid = b.atttypid LEFT JOIN pg_collation coll ON coll.oid = b.attcollation LEFT JOIN pg_namespace colnsp ON coll.collnamespace = colnsp.oid LEFT JOIN pg_type bt ON et.typelem = bt.oid LEFT JOIN pg_namespace nbt ON bt.typnamespace = nbt.oid WHERE col.table_schema = \'public\' AND col.table_name = '."'".$tableName."'".' ORDER BY col.table_schema, col.table_name, col.ordinal_position' , true);
        if (empty($fieldsDB)){
            die();
        }

        $name = self::getNameObject($tableName);
        $path = self::createPath($tableName);
        $fields = [];
        $objectItems = [];
        if (file_exists($path)) {
            $objectFields = $name::FIELDS;
            $objectItems = $name::ITEMS;
        }else {
            $objectFields = [];
        }

        foreach ($fieldsDB['result'] as $fieldDB) {
            if ($fieldDB['udt_name'] == 'int8'){
                $fieldDB['udt_name'] = DB_FieldType::FIELD_TYPE_INTEGER;
            }elseif ($fieldDB['udt_name'] == 'numeric'){
                if ($fieldDB['numeric_precision'] > 1){
                    $fieldDB['udt_name'] = DB_FieldType::FIELD_TYPE_FLOAT;
                }else{
                    $fieldDB['udt_name'] = DB_FieldType::FIELD_TYPE_BOOLEAN;
                }
            }elseif ($fieldDB['udt_name'] == 'timestamp'){
                $fieldDB['udt_name'] = DB_FieldType::FIELD_TYPE_DATE_TIME;
                $fieldDB['numeric_scale'] = 0;
                $fieldDB['numeric_precision'] = $fieldDB['datetime_precision'];
            }elseif ($fieldDB['udt_name'] == 'text'){
                $fieldDB['udt_name'] = DB_FieldType::FIELD_TYPE_STRING;
                $fieldDB['numeric_scale'] = 0;
                $fieldDB['numeric_precision'] = 0;
            }elseif ($fieldDB['udt_name'] == 'date'){
                $fieldDB['udt_name'] = DB_FieldType::FIELD_TYPE_DATE;
                $fieldDB['numeric_scale'] = 0;
                $fieldDB['numeric_precision'] = $fieldDB['datetime_precision'];
            }elseif ($fieldDB['udt_name'] == 'varchar'){
                $fieldDB['udt_name'] = DB_FieldType::FIELD_TYPE_STRING;
                if(!$fieldDB['numeric_precision']){
                    if ($fieldDB['character_maximum_length']){
                        $fieldDB['numeric_precision'] = $fieldDB['character_maximum_length'];
                    }else{
                        $fieldDB['numeric_precision'] = 0;
                    }
                }
                $fieldDB['numeric_scale'] = 0;
            }


            $columnName = $fieldDB['column_name'];
            if (key_exists($columnName, $objectFields)) {
                $fields[$columnName] = $objectFields[$columnName];
            } else {
                $fields[$columnName] = [
                    'type' => $fieldDB['udt_name'],
                    'length' => $fieldDB['numeric_precision'],
                    'decimal' => $fieldDB['numeric_scale'],
                    'is_not_null' => $fieldDB['is_nullable'],
                    'title' => $fieldDB['comment'],
                    'table' => Api_MVC::getTableNameByField($fieldDB['column_name'], $projectName),
                ];
            }
        }

        self::createMVC(
            $path, [ 'tableName' => $tableName, 'fieldsDB' => $fieldsDB, 'name' => $name, 'fields' => $fields, 'items' => $objectItems, 'indexesDB' => $indexesDB, ], 'DB'
        );
    }


    /**
     *  Проверям тип поля и воврощаем его для  Model_
     * @param int $type
     * @return string
     */
    public static function getTypeModel(int $type) : string
    {
        switch ($type){
            case DB_FieldType::FIELD_TYPE_INTEGER:
                $type = 'Int';
                break;
            case DB_FieldType::FIELD_TYPE_BOOLEAN:
                $type =  'Bool';
                break;
            case DB_FieldType::FIELD_TYPE_STRING:
                $type =  '';
                break;
            case DB_FieldType::FIELD_TYPE_DATE_TIME:
                $type =  'DateTime';
                break;
            case DB_FieldType::FIELD_TYPE_DATE:
                $type =  'Date';
                break;
            case DB_FieldType::FIELD_TYPE_TIME:
                $type =  'Time';
                break;
            case DB_FieldType::FIELD_TYPE_FLOAT:
                $type =  'Float';
                break;
            case DB_FieldType::FIELD_TYPE_JSON:
                $type =  'Json';
                break;
            case DB_FieldType::FIELD_TYPE_FILES:
                $type =  'Files';
                break;
            case DB_FieldType::FIELD_TYPE_ARRAY:
                $type =  'Array';
                break;
            default:
                $type =  '';
        }
        return $type;
    }

    /**
     * Получаем название поле DB для Model_
     * @param $name
     * @return string
     */
    public static function getNameField($name) : string
    {
        $list = explode('_', $name);
        $lastPos = $list[count($list)-1];
        if ( $lastPos == 'id' ) {
            $list[count($list)-1] = mb_strtoupper($lastPos);
        }
        $list = self::ucFirstArray($list);

        return implode('', $list);
    }

    /**
     * Получаем Model_ по названию поля
     * @param $fieldName
     * @param $projectName
     * @return string
     */
    public static function getModelName($fieldName, $projectName) : string
    {
        $projectName = explode('_', $projectName);
        $projectName = self::switchFolder($projectName);
        $list = explode('_', $fieldName);
        unset($list[count($list) - 1]);
        $list = self::ucFirstArray($list);


        $path = Helpers_Path::getPathFile(APPPATH, ['classes', 'Model']);

        // Получаем массив проектов
        $folders = scandir($path);
        foreach ($folders as $key =>  $folder){
            if ($folder == '.' || $folder == '..' || !is_dir($path . $folder)){
                unset($folders[$key]);
            }
        }

        //Создаем последовательность проектов
        $projects = [];
        if ($projectName != ''){
            $projects[] = [
                'model' => 'Model_' . $projectName . '_',
                'path' => $path . $projectName . DIRECTORY_SEPARATOR
            ];
        }
        $projects[] = [
            'model' => 'Model_',
            'path' => $path
        ];
        foreach ($folders as $folder){
            if ($projectName != $folder && $folder != 'Shop'){
                $projects[] = [
                    'model' => 'Model_' . $folder . '_',
                    'path' => $path . $folder . DIRECTORY_SEPARATOR
                ];
            }
        }

        //Проверим существует файл Model_
        foreach ($projects as $project){
            foreach ( $list as $one) {
                $project['path'] .= $one;
                $project['model'] .= $one;

                if (file_exists($project['path'])){
                    $project['path'] .= DIRECTORY_SEPARATOR;
                    $project['model'] .= '_';
                }
            }

            if(mb_substr($project['path'],-1, 1) == DIRECTORY_SEPARATOR){
                $project['path'] = mb_substr($project['path'],0,-1);
                $project['model'] = mb_substr($project['model'],0,-1);
            }
            $project['path'] .='.php';
            if (file_exists($project['path'])){
                return $project['model'];
            }
        }
        return '';
    }


    /**
     * @param $dbTableName
     * @return string
     */
    public static function nameModel($dbTableName): string
    {
        $list = explode('_', $dbTableName);
        $list[0] = 'Model';
        return implode('_', $list);
    }

    /**
     * Создаем файл Model_ по названию таблицы
     * @param $dbObject
     */
    public static function createModel($dbObject){
        $dbObject = self::getNameObject($dbObject);

        $path = self::createPath($dbObject::TABLE_NAME,'Model');

        self::createMVC(
            $path, [ 'dbObject' => $dbObject ], 'Model'
        );
    }


    /**
     * Получаем наследование класс Controller_
     * @param $tableName
     * @param $projectName
     * @param $nameInterface
     * @return string
     */
    public static function extendsControllerName($tableName, $projectName, $nameInterface): string
    {

        $name = self::getNameObject($tableName, '');
        //Ab1_Fd_Data
        $list = explode('_',$name);
        unset($list[count($list) -1]);
        unset($list[0]);


        $path = Helpers_Path::getPathFile(APPPATH, ['classes','Controller']) ; // получили путь до папки онтроллер

        // Получаем массив файлов
        $folders = scandir($path);
        foreach ($folders as $key =>  $folder){
            if ($folder == '.' || $folder == '..' || !is_dir($path . $folder)){
                unset($folders[$key]);
            }
        }

        //получили список всех проектов
        $projects = [];
        if ($projectName != ''){
            $projects[] = [
                'controller' => 'Controller_' . $projectName . '_',
                'path' => $path . $projectName . DIRECTORY_SEPARATOR
            ];
        }
        $projects[] = [
            'controller' => 'Controller_',
            'path' => $path
        ];
        foreach ($folders as $folder){
            if ($projectName != $folder ){
                $projects[] = [
                    'controller' => 'Controller_' . $projectName . '_' . $nameInterface . '_',
                    'path' => $path . $projectName . DIRECTORY_SEPARATOR . $nameInterface . DIRECTORY_SEPARATOR
                ];
            }
        }

        foreach ($projects as $project){
            if (file_exists($project['path']  . 'Basic' . $projectName . '.php') ){
                return $project['controller'] .= 'Basic' . $projectName;
            }
            if (file_exists($project['path']  . 'Basic.php')){
                return $project['controller'] .= 'Basic';
            }
        }
        return '';
    }

    /**
     * @param $nameDB
     * @return string
     */
    public static function controllerName($nameDB): string
    {
        $list = explode('_',$nameDB);
        unset($list[0]);
        unset($list[1]);
        foreach ($list as $key => $one){
            $list[$key] = mb_strtolower($one);
        }
        return implode('',$list);
    }

    /**
     * Создание Controller
     * @param $tableName
     * @param $projectName
     * @param $interfaceName
     * @param false $isAllEdit
     */
    public static function createController($tableName, $projectName, $interfaceName, bool $isAllEdit = false){
        $dbObject = self::getNameObject($tableName);
        if ($projectName == 'AutoPart'){
            $projectName = 'Smg';
        }
        $controllerName = DB_Basic::getControllerName($dbObject, $projectName, $interfaceName);

        $editAndNewBasicTemplate = '';
        if ($isAllEdit){
            $editAndNewBasicTemplate = strtolower($interfaceName).'/_all';
        }

        $view = View::factory('template_code' . DIRECTORY_SEPARATOR . 'Controller');
        $view->dbObject = $dbObject;
        $view->controllerName = $controllerName;
        $view->nameModel = DB_Basic::getModelName($dbObject);
        $view->extendsName = self::extendsControllerName($dbObject, $projectName, $interfaceName);
        $view->interfaceName = $interfaceName;
        $view->editAndNewBasicTemplate = $editAndNewBasicTemplate;
        $strView = '<?php' . Helpers_View::viewToStr($view);

        $path = Helpers_Path::getPathFile(APPPATH,['classes','Controller',$projectName]);
        if (!empty($interfaceName)){
            $path .= $interfaceName . DIRECTORY_SEPARATOR;
            $controllerName = str_replace('Controller_' . $projectName . '_' . $interfaceName . '_','', $controllerName);

        }else{
            $controllerName = str_replace('Controller_' . $projectName . '_','', $controllerName);
        }

        file_put_contents( $path . ucfirst(strtolower($controllerName)) . '.php', $strView);

    }


    /**
     * @param $dbObject
     * @param $projectName
     * @return string
     */
    private static function getFolderViews($dbObject, $projectName): string
    {

        $list = explode('_',$dbObject);
        foreach ($list as $key => $one){
            $list[$key] = strtolower($one);
        }

        unset($list[1]);
        unset($list[0]);
        if($list[2] == 'shop'){
            $list[2] = '_shop';
        }

        return implode('/',$list);
    }

    /**
     * @param $fieldName
     * @return string
     */
    public static function pathView($fieldName): string
    {
        $list = explode('_', $fieldName);

        if ($list[count($list)-1] == 'id'){
            unset($list[count($list)-1]);
        }
        if ($list[0] == 'shop'){
            $list[0] = '_shop';
        }

        return implode('/', $list);
    }

    /**
     * создаем и записываем файла Views
     * @param $fileName
     * @param $path
     * @param $projectName
     * @param array $params
     * @param int $languageID
     */
    private static function createView($fileName, $path, $projectName, array $params, int $languageID = 35 ){
        $view = View::factory('template_code' . DIRECTORY_SEPARATOR . $projectName . DIRECTORY_SEPARATOR . $languageID . DIRECTORY_SEPARATOR . $path);

        foreach ($params as $key => $param){
            $view->$key = $param;
        }
        $str = Helpers_View::viewToStr($view);

        Helpers_Path::createPath(dirname($fileName));

        file_put_contents($fileName, $str);
    }


    /**
     * * Создание всех представлений Views
     * @param $tableName
     * @param $projectName
     * @param $interfaceName
     * @param $titleIndex
     * @param $titleNew
     * @param $titleEdit
     * @param $titleFilter
     * @param $typeFilter
     * @param array $requiredFields
     * @param array $titles
     * @param int $languageID
     * @param bool $isAllEdit
     */
    public static function createViews($tableName, $projectName, $interfaceName, $titleIndex, $titleNew, $titleEdit,
                                       $titleFilter, $typeFilter, array $requiredFields, array $titles, $type, $languageID = 35, $isAllEdit = true)
    {
        if ($projectName == 'AutoPart'){
            $projectName = 'Smg';
        }
        $projectName = lcfirst($projectName);
        $interfaceName = lcfirst($interfaceName);
        $dbObject = self::getNameObject($tableName);  //DB_AutoPart_Shop_Product_Status

        $fieldsDB = self::requiredFields($dbObject, $requiredFields, $titles);

        $pathView = self::getFolderViews($dbObject, $projectName);
        $pathViewStr = substr(str_replace('/', '', $pathView), 1);

        if ($type == 'index'){

            $path = Helpers_Path::getPathFile(VIEWPATH, [$projectName, $interfaceName, $languageID , $pathView, 'list']);
            // Создаем View list
            self::createView(
                $path . 'index.php', 'list', $projectName,
                ['pathView' => $pathView, 'pathViewStr' => $pathViewStr, 'fieldsDB' => $fieldsDB], $languageID
            );

            $path = Helpers_Path::getPathFile(VIEWPATH, [$projectName, $interfaceName, $languageID , $pathView, 'one']);
            // Создаем View one
            self::createView(
                $path . 'index.php', 'one', $projectName,
                ['pathView' => $pathView, 'pathViewStr' => $pathViewStr, 'fieldsDB' => $fieldsDB], $languageID
            );

            $path = Helpers_Path::getPathFile(VIEWPATH, [$projectName, $interfaceName, '35', 'main' , $pathView]);
            // Создаем View index
            self::createView(
                $path . 'index.php', 'main/index', $projectName,
                ['pathView' => $pathView, 'pathViewStr' => $pathViewStr, 'fieldsDB' => $fieldsDB, 'interfaceName' => $interfaceName, 'projectName' => $projectName, 'title' => $titleIndex], $languageID
            );
        }

        if ($type == 'edit') {
            if ($projectName != 'smg') {
                if ($isAllEdit) {
                    $path = Helpers_Path::getPathFile(VIEWPATH, [$projectName, '_all', $languageID, $pathView, 'one']);
                } else {
                    $path = Helpers_Path::getPathFile(VIEWPATH, [$projectName, $interfaceName, $languageID, $pathView]);
                }

                // Создаем View новой записи
                self::createView(
                    $path . 'new.php', 'new', $projectName,
                    ['pathView' => $pathView, 'fieldsDB' => $fieldsDB], $languageID
                );

                // Создаем View редактирование записи
                self::createView(
                    $path . 'edit.php', 'edit', $projectName,
                    ['pathView' => $pathView, 'pathViewStr' => $pathViewStr, 'fieldsDB' => $fieldsDB], $languageID
                );
            }

            $path = Helpers_Path::getPathFile(VIEWPATH, [$projectName, $interfaceName, '35', 'main' , $pathView]);
            // Создаем View edit
            self::createView(
                $path . 'edit.php', 'main/edit', $projectName,
                ['pathView' => $pathView, 'pathViewStr' => $pathViewStr, 'title' => $titleEdit], $languageID
            );
            // Создаем View new
            self::createView(
                $path . 'new.php', 'main/new', $projectName,
                ['pathView' => $pathView, 'pathViewStr' => $pathViewStr, 'title' => $titleNew], $languageID
            );

            $path = Helpers_Path::getPathFile(VIEWPATH, [$projectName, $interfaceName, $languageID , $pathView, 'one']);
            if ($projectName == 'smg') {
                self::createView(
                    $path . 'new.php', 'new', $projectName,
                    ['pathView' => $pathView, 'fieldsDB' => $fieldsDB], $languageID
                );
                // Создаем View редактирование записи
                self::createView(
                    $path . 'edit.php', 'edit', $projectName,
                    ['pathView' => $pathView, 'pathViewStr' => $pathViewStr, 'fieldsDB' => $fieldsDB], $languageID
                );
            }
        }

        if ($type == 'filter'){
            $path = Helpers_Path::getPathFile(VIEWPATH, [$projectName, $interfaceName, '35', 'main' , $pathView]);
            // Создаем View filter
            self::createView(
                $path . 'filter.php', 'main/filter', $projectName,
                ['pathView' => $pathView, 'pathViewStr' => $pathViewStr, 'fieldsDB' => $fieldsDB , 'title' => $titleFilter, 'typeFilter' => $typeFilter], $languageID
            );
        }
    }

    /**
     * Получаем поля которые надо вывести в View
     * @param $dbObject
     * @param array $fields
     * @param array $titles
     * @return array
     */
    public static function requiredFields($dbObject, array $fields, array $titles) : array
    {
        $requiredFields = [];
        foreach ($fields as $field){
            if (key_exists($field, $dbObject::FIELDS)) {
                $requiredFields[$field] = $dbObject::FIELDS[$field];
            }
            foreach ($titles as $key => $title){
                if ($field == $key){
                    $requiredFields[$field]['title'] = $title;
                }
            }
        }
        return $requiredFields ;
    }

}