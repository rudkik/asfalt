<section class="content-header">
    <h1>
        Список вьюшек index-файла
        <small style="margin-right: 10px;">редактирование</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Func::getFullURL($siteData, '/shop/edit'); ?>"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li class="active">Список вьюшек index-файла</li>
    </ol>
</section>
<section class="content padding-5">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary padding-t-5">
                <div class="box-body pad table-responsive">
                    <form action="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/site/save_view_statics" method="post" style="padding-right: 5px;">
                        <div id="panel-insert">
                            <?php echo trim($data['view::site/view/static/list/index']); ?>
                        </div>
                        <div class="col-md-7">
                            <div class="row margin-t-15">
                                <div style="display: none">
                                    <input name="id" value="<?php echo Request_RequestParams::getParamInt('id'); ?>" />
                                    <input name="url" value="<?php echo Request_RequestParams::getParamStr('url'); ?>" />
                                    <input name="language" value="<?php echo Request_RequestParams::getParamInt('language'); ?>" />
                                </div>
                                <a class="btn bg-olive pull-right" href="javascript:addPanel('panel-add', 'panel-insert')">Добавить</a>
                                <button class="btn btn-primary" type="submit">Сохранить</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<div hidden="hidden" id="panel-add" data-index="1">
    <!--
    <div class="row margin-b-10">
        <div class="col-md-3">
            <select class="form-control select2" style="width: 100%;" name="views[#index#][name]">
                <?php echo trim($data['view::site/view/list/list']); ?>
            </select>
        </div>
        <div class="col-md-3">
            <input name="views[#index#][title]" type="text" class="form-control" placeholder="Название">
        </div>
        <div class="col-md-3">
            <a data-action="del-view" href="#" class="btn btn-danger btn-insert">Удалить</a>
        </div>
    </div>
    -->
</div>