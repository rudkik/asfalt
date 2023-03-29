<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('magazine/bar/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content" style="display: inline-block; width: 100%">
            <div class="row">
                <div class="col-sm-3">
                    <div class="box box-success">
                        <div class="box-header ui-sortable-handle" style="cursor: move;">
                            <i class="fa fa-comments-o"></i>
                            <h3 class="box-title">Закрытие смены</h3>
                        </div>
                        <div class="box-footer">
                            <p><span>Под зарплату:</span> <label><?php echo Func::getNumberStr($siteData->replaceDatas['realization']['worker'], TRUE, 2, FALSE);?> тг</label></p>
                            <p><span>Спецпродукт:</span> <label><?php echo Func::getNumberStr($siteData->replaceDatas['realization']['special'], TRUE, 2, FALSE);?> тг</label></p>
                            <p><span>Наличные:</span> <label><?php echo Func::getNumberStr($siteData->replaceDatas['realization']['cache'], TRUE, 2, FALSE);?> тг</label></p>
                            <p><span>Возврат:</span> <label><?php echo Func::getNumberStr($siteData->replaceDatas['realization']['return'], TRUE, 2, FALSE);?> тг</label></p>

                            <a href="<?php echo Func::getFullURL($siteData, '/shopfinish/report_z'); ?>" class="btn btn-primary">Z-отчет</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="box box-success">
                        <div class="box-header ui-sortable-handle" style="cursor: move;">
                            <i class="fa fa-comments-o"></i>
                            <h3 class="box-title">X-отчет</h3>
                        </div>
                        <div class="box-footer">
                            <p><span>Под зарплату:</span> <label><?php echo Func::getNumberStr($siteData->replaceDatas['realization']['worker'], TRUE, 2, FALSE);?> тг</label></p>
                            <p><span>Спецпродукт:</span> <label><?php echo Func::getNumberStr($siteData->replaceDatas['realization']['special'], TRUE, 2, FALSE);?> тг</label></p>
                            <p><span>Наличные:</span> <label><?php echo Func::getNumberStr($siteData->replaceDatas['realization']['cache'], TRUE, 2, FALSE);?> тг</label></p>
                            <p><span>Возврат:</span> <label><?php echo Func::getNumberStr($siteData->replaceDatas['realization']['return'], TRUE, 2, FALSE);?> тг</label></p>

                            <a href="<?php echo Func::getFullURL($siteData, '/shopfinish/report_x'); ?>" class="btn btn-primary">X-отчет</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>