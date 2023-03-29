<section class="content-header">
    <h1>
        Языки сайта
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Func::getFullURL($siteData, '/shop/edit'); ?>"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li class="active">Языки сайта</li>
    </ol>
</section>
<section class="content padding-5">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary padding-t-5">
                <div class="box-body pad table-responsive">
                    <form action="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/site/save_languages" method="post" style="padding-right: 5px;">
                        <div id="panel-insert">
                            <?php echo trim($siteData->globalDatas['view::site/language/list/list']); ?>
                        </div>
                        <div class="col-md-12">
                            <div class="row margin-t-15">
                                <div style="display: none">
                                    <input name="id" value="<?php echo Request_RequestParams::getParamInt('id'); ?>" />
                                </div>
                                <button class="btn btn-primary" type="submit">Сохранить</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>