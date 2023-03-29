<?php $siteData->titleTop = 'Источник (добавление)'; ?>



<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/mvc/index2'); ?>" method="post" style="padding-right: 5px;">
    <div class="form-group">
        <label class="col-md-2 control-label">
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Название таблицы
        </label>
        <div class="col-md-6">
            <input name="tableName" type="text" class="form-control" placeholder="Название таблицы" required>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Название проекта
        </label>
        <div class="col-md-6">
            <input name="projectName" type="text" class="form-control" placeholder="Название проекта" required>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Название интерфейса
        </label>
        <div class="col-md-6">
            <input name="interfaceName" type="text" class="form-control" placeholder="Название интерфейса" value="" required>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-2 control-label"></label>
        <div class="col-md-6">
            <label class="span-checkbox">
                <input name="updateDB" value="1" checked type="checkbox" class="minimal">
                Обновить DB
            </label> <br>
            <label class="span-checkbox">
                <input name="updateModel" value="1" checked type="checkbox" class="minimal">
                Обновить Model
            </label><br>
            <label class="span-checkbox">
                <input name="updateController" value="1" checked type="checkbox" class="minimal">
                Обновить Controller
            </label>
        </div>
    </div>
    <div class="row">
        <div class="modal-footer text-center">
            <button type="submit" class="btn btn-primary">Следующий шаг</button>
        </div>
    </div>
</form>
