<?php

$fieldsDB = [];
$b = false;
foreach ($dbObject::FIELDS as $key => $field){
    //получить список констант из бд после global_id
    if ($b == true){
        if (key_exists('table', $field) && !empty($field['table'])){
            $fieldsDB[$key] = $field;
        }
        continue;
    }
    if ($key == 'global_id' ){
        $b = true;
    }
}
?> defined('SYSPATH') or die('No direct script access.');

class <?php echo $controllerName; ?> extends <?php echo $extendsName; ?> {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = '<?php echo $dbObject::NAME; ?>';
        $this->controllerName = '<?php echo Api_MVC::controllerName($dbObject); ?>';
        $this->tableID = <?php echo $nameModel; ?>::TABLE_ID;
        $this->tableName = <?php echo $nameModel; ?>::TABLE_NAME;

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopID;
        $this->editAndNewBasicTemplate = '<?php echo $editAndNewBasicTemplate; ?>';
    }

    <?php $interfaceName =  mb_strtolower($interfaceName); ?>

    public function action_index()
    {
        $this->_sitePageData->url = '/<?php echo $interfaceName; ?>/<?php echo Api_MVC::controllerName($dbObject); ?>/index';

    <?php foreach ($fieldsDB as $field){?>
        $this->_requestListDB('<?php echo $field['table']; ?>');
    <?php } ?>

        parent::_actionIndex(
            array(
        <?php foreach ($fieldsDB as $key => $field){?>
        '<?php echo $key; ?>' => ['name'],
        <?php } ?>
    )
        );

    }

    public function action_new(){
        $this->_sitePageData->url = '/<?php echo $interfaceName; ?>/<?php echo Api_MVC::controllerName($dbObject); ?>/new';

<?php foreach ($fieldsDB as $field){?>
        $this->_requestListDB('<?php echo $field['table']; ?>');
<?php } ?>

        parent::action_new();
    }

    public function action_edit(){
        $this->_sitePageData->url = '/<?php echo $interfaceName; ?>/<?php echo Api_MVC::controllerName($dbObject); ?>/edit';

        $id = Request_RequestParams::getParamInt('id');
        $model = new <?php echo $nameModel; ?>();
        if (! $this->dublicateObjectLanguage($model, $id, 0, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

<?php foreach ($fieldsDB as $key => $field){?>
        $this->_requestListDB('<?php echo $field['table']; ?>', $model->getValueInt('<?php echo $key ;?>'));
<?php } ?>

        $this->_actionEdit($model, $this->_sitePageData->shopID);
    }

}
