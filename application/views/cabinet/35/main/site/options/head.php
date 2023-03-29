<section class="content-header">
    <h1>
        Заголовки страниц сайта
        <small style="margin-right: 10px;">редактирование</small>
        <?php echo trim($siteData->globalDatas['view::language/list/translate']); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Func::getFullURL($siteData, '/shop/edit'); ?>"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li class="active">Заголовки страниц сайта</li>
    </ol>
</section>
<section class="content padding-5">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary padding-t-5">
                <div class="box-body pad table-responsive">
                    <form action="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/siteoptions/save_head" method="post" style="padding-right: 5px;">
                        <?php echo trim($data['view::site/options/list/head']); ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>