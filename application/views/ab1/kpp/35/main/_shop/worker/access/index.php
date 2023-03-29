<div class="col-md-12 padding-top-15px">
    <div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/kpp/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <div class="tab-pane active">
                <?php $siteData->titleTop = 'Доступы'; ?>
                <?php
                $view = View::factory('ab1/kpp/35/main/_shop/worker/access/filter');
                $view->siteData = $siteData;
                $view->data = $data;
                echo Helpers_View::viewToStr($view);
                ?>
            </div>
            <div class="nav-tabs-custom" style="margin-bottom: 0px;">
                <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
                    <li class="<?php if(Arr::path($siteData->urlParams, 'is_delete', '') != 1 && Request_RequestParams::getParamBoolean('is_exit') !== false){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopworkerentryexit/index', array(), array('is_public_ignore' => 1));?>" data-id="is_public_ignore">Все <i class="fa fa-fw fa-info text-blue"></i></a></li>
                    <li class="pull-left header" style="padding: 0px 10px 0px 0px">
                        <span>
                                <a href="<?php echo Func::getFullURL($siteData, '/shopworkeraccess/new', array());?>" class="btn bg-purple btn-flat">
                                    <i class="fa fa-fw fa-plus"></i>
                                    Добавить работника
                                </a>
                            </span>
                    </li>
                </ul>
            </div>
            <div class="body-table">
                <div class="box-body table-responsive" style="padding-top: 0px;">
                    <?php echo trim($data['view::_shop/worker/access/list/index']); ?>
                </div>
            </div>
        </div>
    </div>
</div>
