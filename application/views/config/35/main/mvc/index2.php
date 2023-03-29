
<?php $siteData->titleTop = 'Выберите поля для Views';
$tableName = Request_RequestParams::getParamStr('tableName');
$projectName = Request_RequestParams::getParamStr('projectName');
$interfaceName = Request_RequestParams::getParamStr('interfaceName');

    if (!empty($tableName) && !empty($projectName)){
        $objectDB = Api_MVC::getNameObject($tableName);
        $fields = $objectDB::FIELDS;
        foreach ($fields as $key => $field) {
            if ($key == 'id' || $key == 'language_id' || $key = 'global_id') {
                unset($fields[$key]);
            }
        }
?>

<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/mvc/index3'); ?>" method="post" style="padding-right: 5px;">

    <div hidden class="form-group">
        <label class="col-md-2 control-label">
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Название DataBase
        </label>
        <div class="col-md-6">
            <input name="tableName" type="text" class="form-control" placeholder="Название" value="<?php echo $tableName; ?>" required>
        </div>
    </div>
    <div hidden class="form-group">
        <label class="col-md-2 control-label">
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Название проекта
        </label>
        <div class="col-md-6">
            <input name="projectName" type="text" class="form-control" placeholder="Название проекта" value="<?php echo $projectName; ?>" required>
        </div>
    </div>
    <div hidden class="form-group">
        <label class="col-md-2 control-label">
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Название интерфейса
        </label>
        <div class="col-md-6">
            <input name="interfaceName" type="text" class="form-control" placeholder="Название интерфейса" value="<?php echo $interfaceName; ?>" required>
        </div>
    </div>
    <div  class="form-group">
        <label class="col-md-2 control-label">
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Заголовок общего списка
        </label>
        <div class="col-md-6">
            <input name="name-index" type="text" class="form-control" placeholder="Заголовок общего списка">
        </div>
    </div>


    <table class="table table-striped table-bordered table-hover" style="margin-bottom: 5px">
        <thead>
        <tr>
            <th class="tr-header-public">
            <span>
                <a class="link-black">Отображение</a>
            </span>
            </th>
            <th>
                <a class="link-black">Название</a>
            </th>
        </tr>
        </thead>
    </table>
    <div class="form-group" >
        <div class="col-md-12" id="arrange">
    <?php
        foreach ($fields as $key => $field){
            ?>
                <div class="form-group" style="cursor: grab; margin-bottom: 5px">
                    <div class="col-md-1" style="padding-top: 5px; text-align: center;">
                        <label class="span-checkbox">
                            <input name="fields[]" value="<?php echo $key; ?>" checked type="checkbox" class="minimal">
                        </label>
                    </div>
                    <div class="col-md-11" >
                        <input name="titles[<?php echo $key; ?>]" type="text" class="form-control" placeholder="Заголовок для фильтров" value="<?php if (!empty($field['title'])){
                            echo $field['title'];
                        }else{
                            echo $key;
                        } ?>" >
                    </div>
                </div>
    <?php } ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label"></label>
        <div class="col-md-6">
            <label class="span-checkbox">
                <input name="updateIndex" value="1" checked type="checkbox" class="minimal">
                Обновить Index
            </label><br>
        </div>
    </div>
    <div  class="row">
        <div class="modal-footer text-center">
            <button type="submit" class="btn btn-primary">Создать</button>
        </div>
    </div>

</form>
<script>
    $(function() {
        $("#arrange").sortable();
    });
</script>
<?php } ?>