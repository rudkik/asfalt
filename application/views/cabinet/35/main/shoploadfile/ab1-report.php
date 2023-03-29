<section class="content-header">
    <h1>
        Загрузка отчета
        <small style="margin-right: 10px;">редактирование</small>
        <?php echo trim($siteData->globalDatas['view::language/list/translate']); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Func::getFullURL($siteData, '/shop/edit'); ?>"><i class="fa fa-dashboard"></i> Главная</a></li>
        <?php if($siteData->branchID){ ?>
            <li><a href="<?php echo Func::getFullURL($siteData, '/shop/edit', array('type' => 'shop_root_table_catalog_id', 'is_group' => 'is_group'), array('is_edit' => 1)); ?>"> <b><?php echo Func::trimTextNew($siteData->branch->getName(), 20); ?></b></a></li>
        <?php } ?>
        <li><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopuser/index?is_public_ignore=1&type=15870&is_group=0<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-dashboard"></i> Клиенты</a></li>
        <li class="active">Загрузка отчета</li>
    </ol>
</section>
<section class="content padding-5">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary padding-t-5">
                <div class="box-body pad table-responsive">
                    <form enctype="multipart/form-data" action="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoploadfile/ab1_save" method="post" style="padding-right: 5px;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#tab4" data-toggle="tab">Описание <i class="fa fa-fw fa-info text-blue"></i></a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="active tab-pane" id="tab4">
                                            <div class="row record-input record-list">
                                                <div class="col-md-3 record-title">
                                                    <span>
                                                        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                                        Дата отчета
                                                        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                                    </span>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input name="report_at" type="datetime" class="form-control pull-right" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row record-input record-tab">
                                                <div class="col-md-3 record-title">
                                                    <label>
                                                        CSV-файл
                                                        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                                    </label>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="file-upload" data-text="Выберите CSV-файл">
                                                        <input type="file" name="file">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div hidden>
                                <input name="type" value="<?php echo Request_RequestParams::getParamInt('type'); ?>">
                                <input name="data_language_id" value="<?php echo $siteData->dataLanguageID; ?>">
                                <?php if($siteData->branchID > 0){ ?>
                                    <input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
                                <?php } ?>
                                <?php if($siteData->superUserID > 0){ ?>
                                    <input name="shop_id" value="<?php echo $siteData->shopID; ?>">
                                <?php } ?>
                            </div>

                            <div class="modal-footer text-center">
                                <button type="submit" class="btn btn-primary">Сохранить</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>