<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/bookkeeping/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <div class="tab-pane active">
                <?php
                $view = View::factory('ab1/bookkeeping/35/main/_shop/act/service/filter');
                $view->siteData = $siteData;
                $view->data = $data;
                echo Helpers_View::viewToStr($view);
                ?>
            </div>
            <div class="nav-tabs-custom" style="margin-bottom: 0px;">
                <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
                    <li class="<?php if(Request_RequestParams::getParamBoolean('is_send_esf')){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopactservice/index', array(), array('is_send_esf' => 1));?>" data-id="is_not_public">ЭСФ</a></li>
                    <li class="<?php if(Request_RequestParams::getParamBoolean('is_last_day')){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopactservice/index', array(), array('is_last_day' => 1));?>" data-id="is_public">К сдаче ЭСФ</a></li>
                    <li class="<?php if((!Request_RequestParams::getParamBoolean('is_send_esf')) && (!Request_RequestParams::getParamBoolean('is_last_day'))){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopactservice/index', array(), array('is_public_ignore' => 1));?>">Текущие <i class="fa fa-fw fa-info text-blue"></i></a></li>
                </ul>
            </div>
            <div class="body-table">
                <div class="box-body table-responsive" style="padding-top: 0px;">
                    <?php echo trim($data['view::_shop/act/service/list/index']); ?>
                </div>
            </div>
        </div>
	</div>
</div>
