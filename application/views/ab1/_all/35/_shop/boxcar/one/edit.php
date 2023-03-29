<?php $isShow = !$siteData->operation->getIsAdmin() && Request_RequestParams::getParamBoolean('is_show'); ?>
<div class="row">
    <div class="col-md-12">
        <h3 class="pull-left">Вагон <small style="margin-right: 10px;">редактирование</small></h3>
        <?php if(!$isShow){ ?>
        <a class="pull-right" style="margin-top: 5px;" href="<?php echo Func::getFullURL($siteData, '/shopboxcartrain/edit', array(), array('id' => $data->values['shop_boxcar_train_id']), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Открыть отгрузку</a>
        <?php } ?>
    </div>
</div>
<div class="row">
    <div class="col-md-9">
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    № вагона
                </label>
            </div>
            <div class="col-md-3">
                <input name="number" type="text" class="form-control" placeholder="№ вагона" value="<?php echo htmlspecialchars(Arr::path($data->values, 'number', ''), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
            </div>
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Тоннаж
                </label>
            </div>
            <div class="col-md-3">
                <input data-type="money" data-fractional-length="3" name="quantity" type="phone" class="form-control" placeholder="Тоннаж" value="<?php echo htmlspecialchars(Arr::path($data->values, 'quantity', ''), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Дата подачи
                </label>
            </div>
            <div class="col-md-3">
                <input name="date_arrival" type="text" class="form-control" placeholder="Дата подачи" value="<?php echo Helpers_DateTime::getDateTimeFormatRus(Arr::path($data->values,  'date_arrival', ''));?>" <?php if($isShow){ ?>readonly<?php } ?>>
            </div>
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Дата убытия
                </label>
            </div>
            <div class="col-md-3">
                <input name="date_departure" type="datetime" date-type="datetime" class="form-control" placeholder="Дата убытия" value="<?php echo Helpers_DateTime::getDateTimeFormatRus(Arr::path($data->values, 'date_departure', ''));?>" <?php if($isShow){ ?>readonly<?php } ?>>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Начало разгрузки
                </label>
            </div>
            <div class="col-md-3">
                <input name="date_drain_from" type="datetime" date-type="datetime" class="form-control" value="<?php echo Helpers_DateTime::getDateTimeFormatRus(Arr::path($data->values, 'date_drain_from', ''));?>" <?php if($isShow){ ?>readonly<?php } ?>>
            </div>
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Окончания слива
                </label>
            </div>
            <div class="col-md-3">
                <input name="date_drain_to" type="datetime" date-type="datetime" class="form-control" value="<?php echo Helpers_DateTime::getDateTimeFormatRus(Arr::path($data->values, 'date_drain_to', ''));?>" <?php if($isShow){ ?>readonly<?php } ?>>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    № пломбы
                </label>
            </div>
            <div class="col-md-3">
                <input name="stamp" type="text" class="form-control" placeholder="№ пломбы" value="<?php echo htmlspecialchars(Arr::path($data->values, 'stamp', ''), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
            </div>
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    № отправки
                </label>
            </div>
            <div class="col-md-3">
                <input name="sending" type="text" class="form-control" placeholder="№ отправки" value="<?php echo htmlspecialchars(Arr::path($data->values, 'sending', ''), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    Станция нахождения
                </label>
            </div>
            <div class="col-md-9">
                <input name="options[stations][]" value="" style="display: none">
                <table class="table table-hover table-db table-tr-line">
                    <tr>
                        <th>Станция</th>
                        <?php if(!$isShow){ ?>
                        <th class="tr-header-buttom"></th>
                        <?php } ?>
                    </tr>
                    <tbody id="stations">
                    <?php
                    $i = -1;
                    foreach (Arr::path($data->values['options'], 'stations', array()) as $station){
                        $i++;
                        if(empty($station)){
                            continue;
                        }
                        ?>
                        <tr>
                            <td>
                                <input name="options[stations][<?php echo $i; ?>]" type="text" class="form-control" placeholder="Станция" required value="<?php echo htmlspecialchars($station, ENT_QUOTES); ?>" <?php if($isShow){ ?>readonly<?php } ?>>
                            </td>
                            <?php if(!$isShow){ ?>
                            <td>
                                <ul class="list-inline tr-button ">
                                    <li class="tr-remove"><a href="#" data-action="remove-tr" data-parent-count="4"  class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                                </ul>
                            </td>
                            <?php } ?>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
                <?php if(!$isShow){ ?>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-danger" onclick="addElement('new-station', 'stations', true);">Добавить станцию</button>
                </div>
                <div id="new-station" data-index="0">
                    <!--
                    <tr>
                        <td>
                            <input name="options[stations][_#index#]" type="text" class="form-control" placeholder="Станция" required value="">
                        </td>
                        <td>
                            <ul class="list-inline tr-button delete">
                                <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4" href="#" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                            </ul>
                        </td>
                    </tr>
                    -->
                </div>
                <?php } ?>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    Дополнительные файлы
                </label>
            </div>
            <div class="col-md-9">
                <input name="options[files][]" value="" style="display: none">
                <table class="table table-hover table-db table-tr-line">
                    <tr>
                        <th>Файлы</th>
                        <?php if(!$isShow){ ?>
                            <th class="width-90"></th>
                        <?php } ?>
                    </tr>
                    <tbody id="files">
                    <?php
                    $i = -1;
                    foreach (Arr::path($data->values['options'], 'files', array()) as $file){
                        $i++;
                        if(empty($file)){
                            continue;
                        }
                        ?>
                        <tr>
                            <td>
                                <a target="_blank" href="<?php echo Arr::path($file, 'file', ''); ?>"><?php echo Arr::path($file, 'name', ''); ?></a>
                                <input name="options[files][<?php echo $i; ?>][file]" value="<?php echo Arr::path($file, 'file', ''); ?>" style="display: none">
                                <input name="options[files][<?php echo $i; ?>][name]" value="<?php echo Arr::path($file, 'name', ''); ?>" style="display: none">
                                <input name="options[files][<?php echo $i; ?>][size]" value="<?php echo Arr::path($file, 'size', ''); ?>" style="display: none">
                            </td>
                            <?php if(!$isShow){ ?>
                            <td>
                                <ul class="list-inline tr-button ">
                                    <li class="tr-remove"><a href="#" data-action="remove-tr" data-parent-count="4"  class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                                </ul>
                            </td>
                            <?php } ?>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
                <?php if(!$isShow){ ?>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-danger" onclick="addElement('new-file', 'files', true);">Добавить файл</button>
                </div>
                <div id="new-file" data-index="0">
                    <!--
                    <tr>
                        <td>
                            <div class="file-upload" data-text="Выберите файл" placeholder="Выберите файл">
                                <input type="file" name="options[files][_#index#]" >
                            </div>
                        </td>
                        <td>
                            <ul class="list-inline tr-button delete">
                                <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4" href="#" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                            </ul>
                        </td>
                    </tr>
                    -->
                </div>
                <?php } ?>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Поставщик
                </label>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control"value="<?php echo htmlspecialchars($data->getElementValue('shop_boxcar_client_id'), ENT_QUOTES);?>" readonly>
            </div>
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Сырье
                </label>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control"value="<?php echo htmlspecialchars($data->getElementValue('shop_raw_id'), ENT_QUOTES);?>" readonly>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <?php
        $view = View::factory('ab1/35/_addition/files');
        $view->siteData = $siteData;
        $view->data = $data;
        $view->columnSize = 12;
        echo Helpers_View::viewToStr($view);
        ?>
    </div>
</div>
<?php if(!$isShow){ ?>
<div class="row">
    <div hidden>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>
    </div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>
<?php } ?>