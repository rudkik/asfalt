<div class="col-md-12 padding-top-15px">
    <div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/kpp/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <?php $isExit = Request_RequestParams::getParamBoolean('is_exit');?>
            <?php if($isExit === false){ ?>
                <div class="tab-pane active">
                    <?php $siteData->titleTop = 'На территории'; ?>
                    <?php
                    $view = View::factory('ab1/kpp/35/main/_shop/worker/entry-exit/filter/index');
                    $view->siteData = $siteData;
                    $view->data = $data;
                    echo Helpers_View::viewToStr($view);
                    ?>
                </div>
            <?php }else{ ?>
                <?php $siteData->titleTop = 'Вход/выход'; ?>
            <?php } ?>
            <div class="nav-tabs-custom" style="margin-bottom: 0px;">
                <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
                    <li class="<?php if(Arr::path($siteData->urlParams, 'is_delete', '') != 1 && Request_RequestParams::getParamBoolean('is_exit') !== false){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopworkerentryexit/index', array(), array('is_public_ignore' => 1));?>" data-id="is_public_ignore">Все <i class="fa fa-fw fa-info text-blue"></i></a></li>
                    <?php if($isExit !== false){ ?>
                        <li class="pull-left header" style="padding: 0px 10px 0px 0px">
                            <span>
                                <a href="" class="btn bg-green btn-flat" data-toggle="modal" data-target="#dialog-guest">
                                    <i class="fa fa-fw fa-plus"></i>
                                    Вход гостя
                                </a>
                            </span>
                        </li>
                        <li class="pull-left header" style="padding: 0px 10px 0px 0px">
                            <span>
                                <a href="" class="btn bg-blue btn-flat" data-toggle="modal" data-target="#dialog-worker">
                                    <i class="fa fa-fw fa-plus"></i>
                                    Вход работника
                                </a>
                            </span>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="body-table">
                <div class="box-body table-responsive" style="padding-top: 0px;">
                    <?php echo trim($data['view::_shop/worker/entry-exit/list/index']); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="dialog-guest">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Вход гостя</h4>
            </div>
            <form action="<?php echo Func::getFullURL($siteData, '/shopworkerentryexit/save_guest'); ?>" method="get">
                <div class="modal-body">
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                ФИО
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input id="guest-name" name="name" type="text" class="form-control" placeholder="ФИО" required value="">
                        </div>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                ИИН
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input id="guest-iin" name="iin" type="text" class="form-control" placeholder="ИИН" maxlength="12" value="">
                        </div>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Номер карты
                            </label>
                        </div>
                        <div class="col-md-9">
                            <select id="guest-shop_card_id" name="shop_card_id" class="form-control select2" required style="width: 100%;">
                                <option value="0" data-id="0">Без значения</option>
                                <?php echo $siteData->globalDatas['view::_shop/card/list/list']; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                Компания
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input id="guest-company_name" name="company_name" type="text" class="form-control" placeholder="Компания">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary-outline ks-light" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        $('#guest-name').change(function () {
            var  guestName = $(this).val();
            jQuery.ajax({
                url: '/<?php echo $siteData->actionURLName;?>/guest/json?_fields=*',
                data: ({
                    'name_full': (guestName),
                }),
                type: "POST",
                success: function (data) {
                    var obj = jQuery.parseJSON($.trim(data));
                    if(obj.length > 0){
                        obj = obj[0];

                        $('#guest-iin').val(obj.iin);
                        $('#guest-company_name').val(obj.company_name);
                    }
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });
        });
        $('#guest-iin').change(function () {
            var  iin = $(this).val();
            jQuery.ajax({
                url: '/<?php echo $siteData->actionURLName;?>/guest/json?_fields=*',
                data: ({
                    'iin_full': (iin),
                }),
                type: "POST",
                success: function (data) {
                    var obj = jQuery.parseJSON($.trim(data));
                    if(obj.length > 0){
                        obj = obj[0];

                        $('#guest-name').val(obj.name);
                        $('#guest-company_name').val(obj.company_name);
                    }
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });
        });
    </script>
</div>
<div class="modal" id="dialog-worker">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Вход работника</h4>
            </div>
            <form action="<?php echo Func::getFullURL($siteData, '/shopworkerentryexit/save_worker'); ?>" method="post">
                <div class="modal-body">
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Работник
                            </label>
                        </div>
                        <div class="col-md-9">
                            <select id="worker-shop_worker_id" name="shop_worker_id" class="form-control select2" required style="width: 100%;">
                                <option value="0" data-id="0">Без значения</option>
                                <?php echo $siteData->globalDatas['view::_shop/worker/list/list']; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Карта
                            </label>
                        </div>
                        <div class="col-md-9">
                            <select id="worker-shop_card_id" name="shop_card_id" class="form-control select2" required style="width: 100%;">
                                <option value="0" data-id="0">Без значения</option>
                                <?php echo $siteData->globalDatas['view::_shop/card/list/list']; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary-outline ks-light" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>
