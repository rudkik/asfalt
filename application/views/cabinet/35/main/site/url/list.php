<section class="content-header">
    <h1>
        Страницы сайта
        <small style="margin-right: 10px;">редактирование</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Func::getFullURL($siteData, '/shop/edit'); ?>"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li class="active">Страницы сайта</li>
    </ol>
</section>
<section class="content padding-5">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary padding-t-5">
                <div class="box-body pad table-responsive">
                    <form action="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/site/save_urls" method="post" style="padding-right: 5px;">
                        <div id="panel-insert">
                            <?php echo trim($siteData->globalDatas['view::site/url/list/index']); ?>
                        </div>
                        <div class="col-md-7">
                            <div class="row margin-t-15">
                                <div style="display: none">
                                    <input name="id" value="<?php echo Request_RequestParams::getParamInt('id'); ?>" />
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
        <div class="col-md-2">
            <input name="urls[#index#][url]" type="text" class="form-control" placeholder="URL">
        </div>
        <div class="col-md-2">
            <input name="urls[#index#][title]" type="text" class="form-control" placeholder="Название">
        </div>
        <div class="col-md-8">
            <a data-action="del-view" href="#" class="btn btn-danger btn-insert">Удалить</a>
        </div>
    </div>
    -->
</div>