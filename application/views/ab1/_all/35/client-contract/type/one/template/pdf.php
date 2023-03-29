
<link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/_component/CodeMirror/lib/codemirror.css">
<script src="<?php echo $siteData->urlBasic;?>/css/_component/CodeMirror/lib/codemirror.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/_component/CodeMirror/addon/edit/matchbrackets.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/_component/CodeMirror/mode/htmlmixed/htmlmixed.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/_component/CodeMirror/mode/xml/xml.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/_component/CodeMirror/mode/javascript/javascript.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/_component/CodeMirror/mode/css/css.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/_component/CodeMirror/mode/clike/clike.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/_component/CodeMirror/mode/php/php.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/_component/CodeMirror/addon/selection/active-line.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/_component/CodeMirror/addon/edit/closetag.js"></script>

<link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/_component/CodeMirror/addon/fold/foldgutter.css" />
<script src="<?php echo $siteData->urlBasic;?>/css/_component/CodeMirror/addon/fold/foldcode.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/_component/CodeMirror/addon/fold/foldgutter.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/_component/CodeMirror/addon/fold/brace-fold.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/_component/CodeMirror/addon/fold/xml-fold.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/_component/CodeMirror/addon/fold/markdown-fold.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/_component/CodeMirror/addon/fold/comment-fold.js"></script>

<script src="<?php echo $siteData->urlBasic;?>/css/_component/CodeMirror/addon/display/fullscreen.js"></script>

<script src="<?php echo $siteData->urlBasic;?>/css/_component/CodeMirror/addon/edit/matchtags.js"></script>

<script src="<?php echo $siteData->urlBasic;?>/css/_component/CodeMirror/addon/hint/html-hint.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/_component/CodeMirror/addon/hint/show-hint.js"></script>
<link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/_component/CodeMirror/addon/hint/show-hint.css">
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Название
        </label>
    </div>
    <div class="col-md-9">
        <input name="name" type="text" class="form-control" placeholder="Название" required value="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
    </div>
</div>
<ul class="nav nav-tabs">
    <li class="nav-item active">
        <a class="nav-link" data-toggle="tab" href="#tab-contracts">
            Договоры
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#tab-agreements">
            Доп. соглашения
        </a>
    </li>
</ul>
<div class="tab-content">
    <div class="tab-pane fade active in" id="tab-contracts" style="padding-top: 20px;">
        <ul class="nav nav-tabs">
            <?php
            $i = 0;
            $listPrint = Arr::path($data->values['options'], 'contract', array());
            foreach ($listPrint as $key => $print){
            ?>
                <li class="nav-item <?php if($i++ == 0){?>active<?php } ?>">
                    <a class="nav-link" data-toggle="tab" href="#contract_<?php echo $key;?>"><?php echo Arr::path($print, 'title'); ?></a>
                </li>
            <?php } ?>
        </ul>
        <div class="tab-content">
            <?php
            $i = 0;
            $listPrint = Arr::path($data->values['options'], 'contract', array());
            foreach ($listPrint as $key => $print){
            ?>
                <div class="tab-pane fade <?php if($i++ == 0){?>active in<?php }else{ ?>active in hideAfterRendering<?php } ?>" id="contract_<?php echo $key;?>" style="padding-top: 20px;">
                    <div class="text-right" style="margin-bottom: 15px;">
                        <button type="button" class="btn bg-green" onclick="duplicateContract('contract.<?php echo $key;?>');">Дублировать</button>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Название вкладки
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input name="contract[<?php echo $key;?>][title]" type="text" class="form-control" value="<?php echo Arr::path($print, 'title', '');?>">
                        </div>
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Название кнопки
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input name="contract[<?php echo $key;?>][bottom]" type="text" class="form-control" value="<?php echo Arr::path($print, 'bottom', '');?>">
                        </div>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Начало
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input name="contract[<?php echo $key;?>][date_from]" type="datetime" date-type="date" class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus(Arr::path($print, 'date_from', '2000-01-01'));?>">
                        </div>
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Окончание
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input name="contract[<?php echo $key;?>][date_to]" type="datetime" date-type="date" class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus(Arr::path($print, 'date_to', '2222-01-01'));?>">
                        </div>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Название файла (должно быть уникальным)
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input name="contract[<?php echo $key;?>][file]" type="text" class="form-control" value="<?php echo Arr::path($print, 'file', '');?>">
                        </div>
                    </div>

                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                Параметры из договора/клиента
                            </label>
                        </div>
                        <div class="col-md-9">
                            <table class="table table-hover table-db table-tr-line" >
                                <tr>
                                    <th>Ключ</th>
                                    <th>Заголовок</th>
                                    <th>Ссылка для редактирования</th>
                                    <th>Название поля</th>
                                    <th class="width-90"></th>
                                </tr>
                                <tbody id="contract_<?php echo $key;?>_contract_template_others">
                                <?php foreach (Arr::path($print, 'contract_template_others', array()) as $keyItem => $item){ ?>
                                    <tr>
                                        <td>
                                            <input name="contract[<?php echo $key;?>][contract_template_others][<?php echo $keyItem;?>][key]" type="text" class="form-control" placeholder="Ключ (должен быть уникальным)" value="<?php echo htmlspecialchars($keyItem, ENT_XML1); ?>">
                                        </td>
                                        <td>
                                            <input name="contract[<?php echo $key;?>][contract_template_others][<?php echo $keyItem;?>][name]" type="text" class="form-control" placeholder="Заголовок" value="<?php echo htmlspecialchars(Arr::path($item, 'name', $item), ENT_XML1); ?>">
                                        </td>
                                        <td>
                                            <input name="contract[<?php echo $key;?>][contract_template_others][<?php echo $keyItem;?>][url]" type="text" class="form-control" placeholder="Ссылка для редактирования" value="<?php echo htmlspecialchars(Arr::path($item, 'url', ''), ENT_XML1); ?>">
                                        </td>
                                        <td>
                                            <input name="contract[<?php echo $key;?>][contract_template_others][<?php echo $keyItem;?>][field]" type="text" class="form-control" placeholder="Название поля" value="<?php echo htmlspecialchars(Arr::path($item, 'field', ''), ENT_XML1); ?>">
                                        </td>
                                        <td>
                                            <ul class="list-inline tr-button delete">
                                                <li><a href="#" data-action="remove-tr" data-parent-count="4" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger pull-right" onclick="addElement('contract_new-<?php echo $key;?>_contract_template_others', 'contract_<?php echo $key;?>_contract_template_others', true);">Добавить строчку</button>
                            </div>
                            <div id="contract_new-<?php echo $key;?>_contract_template_others" data-index="0">
                                <!--
                                <tr>
                                        <td>
                                            <input name="contract[<?php echo $key;?>][contract_template_others][_#index#][key]" type="text" class="form-control" placeholder="Ключ (должен быть уникальным)">
                                        </td>
                                    <td>
                                         <input name="contract[<?php echo $key;?>][contract_template_others][_#index#][name]" type="text" class="form-control" placeholder="Заголовок">
                                    </td>
                                    <td>
                                         <input name="contract[<?php echo $key;?>][contract_template_others][_#index#][url]" type="text" class="form-control" placeholder="Ссылка для редактирования">
                                    </td>
                                    <td>
                                         <input name="contract[<?php echo $key;?>][contract_template_others][_#index#][field]" type="text" class="form-control" placeholder="Название поля">
                                    </td>
                                    <td>
                                         <ul class="list-inline tr-button delete">
                                             <li><a href="#" data-action="remove-tr" data-parent-count="4" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                                         </ul>
                                    </td>
                                </tr>
                                -->
                            </div>
                        </div>
                    </div>

                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                Изменяемые параметры
                            </label>
                        </div>
                        <div class="col-md-9">
                            <table class="table table-hover table-db table-tr-line" >
                                <tr>
                                    <th style="width: 20%;">Ключ</th>
                                    <th style="width: 20%;">Заголовок</th>
                                    <th>Значения</th>
                                    <th class="width-90"></th>
                                </tr>
                                <tbody id="contract_<?php echo $key;?>_contract_template_params">
                                <?php foreach (Arr::path($print, 'contract_template_params', array()) as $keyItem => $item){ ?>
                                    <tr>
                                        <td>
                                            <input name="contract[<?php echo $key;?>][contract_template_params][<?php echo $keyItem;?>][key]" type="text" class="form-control" placeholder="Ключ (должен быть уникальным)" value="<?php echo htmlspecialchars($keyItem, ENT_XML1); ?>">
                                        </td>
                                        <td>
                                            <input name="contract[<?php echo $key;?>][contract_template_params][<?php echo $keyItem;?>][title]" type="text" class="form-control" placeholder="Заголовок" value="<?php echo htmlspecialchars(Arr::path($item, 'title', $item), ENT_XML1); ?>">
                                        </td>
                                        <td>
                                                <table class="table table-hover table-db table-tr-line" >
                                                    <tr>
                                                        <th>Значения</th>
                                                        <th class="width-90"></th>
                                                    </tr>
                                                    <tbody id="contract_<?php echo $key;?>contract_template_params_<?php echo $keyItem;?>_values">
                                                    <?php foreach (Arr::path($item, 'values', array()) as $keyValue => $value){ ?>
                                                        <tr>
                                                            <td>
                                                                <input name="contract[<?php echo $key;?>][contract_template_params][<?php echo $keyItem;?>][values][<?php echo $keyValue;?>]" type="text" class="form-control" placeholder="Значение" value="<?php echo htmlspecialchars($value, ENT_XML1); ?>">
                                                            </td>
                                                            <td>
                                                                <ul class="list-inline tr-button delete">
                                                                    <li><a href="#" data-action="remove-tr" data-parent-count="4" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                                                                </ul>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                    </tbody>
                                                </table>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger pull-right" onclick="addElement('contract_new-<?php echo $key;?>_contract_template_params_<?php echo $keyItem;?>_values', 'contract_<?php echo $key;?>contract_template_params_<?php echo $keyItem;?>_values', true);">Добавить строчку</button>
                                                </div>
                                                <div id="contract_new-<?php echo $key;?>_contract_template_params_<?php echo $keyItem;?>_values" data-index="0">
                                                    <!--
                                                    <tr>
                                                        <td>
                                                           <input name="contract[<?php echo $key;?>][contract_template_params][<?php echo $keyItem;?>][values][_#index#]" type="text" class="form-control" placeholder="Значение">
                                                        </td>
                                                        <td>
                                                             <ul class="list-inline tr-button delete">
                                                                 <li><a href="#" data-action="remove-tr" data-parent-count="4" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                                                             </ul>
                                                        </td>
                                                    </tr>
                                                    -->
                                                </div>
                                        </td>
                                        <td>
                                            <ul class="list-inline tr-button delete">
                                                <li><a href="#" data-action="remove-tr" data-parent-count="4" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger pull-left" onclick="addElement('contract_new-<?php echo $key;?>_contract_template_params', 'contract_<?php echo $key;?>_contract_template_params', true, false, '#index_param#');">Добавить строчку</button>
                            </div>
                            <div id="contract_new-<?php echo $key;?>_contract_template_params" data-index="0">
                                <!--
                                <tr>
                                        <td>
                                            <input name="contract[<?php echo $key;?>][contract_template_params][_#index_param#][key]" type="text" class="form-control" placeholder="Ключ (должен быть уникальным)">
                                        </td>
                                        <td>
                                            <input name="contract[<?php echo $key;?>][contract_template_params][_#index_param#][title]" type="text" class="form-control" placeholder="Заголовок">
                                        </td>
                                        <td>
                                                <table class="table table-hover table-db table-tr-line" >
                                                    <tr>
                                                        <th>Значения</th>
                                                        <th class="width-90"></th>
                                                    </tr>
                                                    <tbody id="contract_<?php echo $key;?>contract_template_params__#index_param#_values">
                                                    </tbody>
                                                </table>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger pull-right" onclick="addElement('contract_new-<?php echo $key;?>_contract_template_params__#index_param#_values', 'contract_<?php echo $key;?>contract_template_params__#index_param#_values', true);">Добавить строчку</button>
                                                </div>
                                                <div id="contract_new-<?php echo $key;?>_contract_template_params__#index_param#_values" data-index="0">
                                                    #--
                                                    <tr>
                                                        <td>
                                                           <input name="contract[<?php echo $key;?>][contract_template_params][_#index_param#][values][_#index#]" type="text" class="form-control" placeholder="Значение">
                                                        </td>
                                                        <td>
                                                             <ul class="list-inline tr-button delete">
                                                                 <li><a href="#" data-action="remove-tr" data-parent-count="4" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                                                             </ul>
                                                        </td>
                                                    </tr>
                                                    --#
                                                </div>
                                        </td>
                                        <td>
                                            <ul class="list-inline tr-button delete">
                                                <li><a href="#" data-action="remove-tr" data-parent-count="4" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                -->
                            </div>
                        </div>
                    </div>

                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                Верхний колонтитул
                            </label>
                        </div>
                        <div class="col-md-9">
                            <textarea data-action="html" name="contract[<?php echo $key;?>][header]" placeholder="Верхний колонтитул" rows="7" class="form-control"><?php echo htmlspecialchars(Arr::path($print, 'header', ''), ENT_QUOTES);?></textarea>
                        </div>
                    </div>

                    <div id="contract_<?php echo $key;?>_contract_templates">
                        <?php foreach (Arr::path($print, 'contract_templates.body', array()) as $keyItem => $item){ ?>
                            <div class="row record-input record-list">
                                <div class="col-md-3 record-title">
                                    <label>
                                        Тип записи
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <select name="contract[<?php echo $key;?>][contract_templates][body][<?php echo $keyItem;?>][type]" class="form-control select2" >
                                        <option value="text" <?php if(Arr::path($item, 'type', '') == 'text'){?>selected<?php }?>>Текст</option>
                                        <option value="goods" <?php if(Arr::path($item, 'type', '') == 'goods'){?>selected<?php }?>>Товары</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row record-input record-list">
                                <div class="col-md-3 record-title">
                                    <label>
                                        Текст
                                    </label>
                                </div>
                                <div class="col-md-9">
                                    <textarea data-action="html" name="contract[<?php echo $key;?>][contract_templates][body][<?php echo $keyItem;?>][text]" placeholder="Текст" rows="7" class="form-control"><?php echo htmlspecialchars(Arr::path($item, 'text', ''), ENT_QUOTES);?></textarea>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger pull-right" onclick="addElementHTML('contract_new-<?php echo $key;?>_contract_templates', 'contract_<?php echo $key;?>_contract_templates', true);">Добавить строчку</button>
                    </div>
                    <div id="contract_new-<?php echo $key;?>_contract_templates" data-index="0">
                        <!--
                        <div class="row record-input record-list">
                            <div class="col-md-3 record-title">
                                <label>
                                    Тип записи
                                </label>
                            </div>
                            <div class="col-md-3">
                                <select name="contract[<?php echo $key;?>][contract_templates][body][_#index#][type]" class="form-control select2" >
                                    <option value="text" selected>Текст</option>
                                    <option value="goods">Товары</option>
                                </select>
                            </div>
                        </div>
                        <div class="row record-input record-list">
                            <div class="col-md-3 record-title">
                                <label>
                                    Текст
                                </label>
                            </div>
                            <div class="col-md-9">
                                <textarea data-action="html" name="contract[<?php echo $key;?>][contract_templates][body][_#index#][text]" placeholder="Текст" rows="7" class="form-control"></textarea>
                            </div>
                        </div>
                          -->
                    </div>

                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                Нижний колонтитул
                            </label>
                        </div>
                        <div class="col-md-9">
                            <textarea data-action="html" name="contract[<?php echo $key;?>][footer]" placeholder="Нижний колонтитул" rows="7" class="form-control"><?php echo htmlspecialchars(Arr::path($print, 'footer', ''), ENT_QUOTES);?></textarea>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="tab-pane fade active in hideAfterRendering" id="tab-agreements" style="padding-top: 20px;">
        <ul class="nav nav-tabs">
            <?php
            $i = 0;
            $listPrint = Arr::path($data->values['options'], 'agreement', array());
            foreach ($listPrint as $key => $print){
            ?>
                <li class="nav-item <?php if($i++ == 0){?>active<?php } ?>">
                    <a class="nav-link" data-toggle="tab" href="#agreement_<?php echo $key;?>"><?php echo $print['title']; ?></a>
                </li>
            <?php } ?>
        </ul>

        <div class="tab-content">
            <?php
            $i = 0;
            $listPrint = Arr::path($data->values['options'], 'agreement', array());
            foreach ($listPrint as $key => $print){
                ?>
                <div class="tab-pane fade <?php if($i++ == 0){?>active in<?php }else{ ?>active in hideAfterRendering<?php } ?>" id="agreement_<?php echo $key;?>" style="padding-top: 20px;">
                    <div class="text-right form-control" style="margin-bottom: 15px;">
                        <button type="button" class="btn bg-green" onclick="duplicateContract('agreement.<?php echo $key;?>');">Дублировать</button>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Название вкладки
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input name="agreement[<?php echo $key;?>][title]" type="text" class="form-control" value="<?php echo Arr::path($print, 'title', '');?>">
                        </div>
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Название кнопки
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input name="agreement[<?php echo $key;?>][bottom]" type="text" class="form-control" value="<?php echo Arr::path($print, 'bottom', '');?>">
                        </div>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Начало
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input name="agreement[<?php echo $key;?>][date_from]" type="datetime" date-type="date" class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus(Arr::path($print, 'date_from', '2000-01-01'));?>">
                        </div>
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Окончание
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input name="agreement[<?php echo $key;?>][date_to]" type="datetime" date-type="date" class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus(Arr::path($print, 'date_to', '2222-01-01'));?>">
                        </div>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Название файла (должно быть уникальным)
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input name="agreement[<?php echo $key;?>][file]" type="text" class="form-control" value="<?php echo Arr::path($print, 'file', '');?>">
                        </div>
                    </div>

                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                Параметры из договора/клиента
                            </label>
                        </div>
                        <div class="col-md-9">
                            <table class="table table-hover table-db table-tr-line" >
                                <tr>
                                    <th>Ключ</th>
                                    <th>Заголовок</th>
                                    <th>Ссылка для редактирования</th>
                                    <th>Название поля</th>
                                    <th class="width-90"></th>
                                </tr>
                                <tbody id="agreement_<?php echo $key;?>_contract_template_others">
                                <?php foreach (Arr::path($print, 'contract_template_others', array()) as $keyItem => $item){ ?>
                                    <tr>
                                        <td>
                                            <input name="agreement[<?php echo $key;?>][contract_template_others][<?php echo $keyItem;?>][key]" type="text" class="form-control" placeholder="Ключ (должен быть уникальным)" value="<?php echo htmlspecialchars($keyItem, ENT_XML1); ?>">
                                        </td>
                                        <td>
                                            <input name="agreement[<?php echo $key;?>][contract_template_others][<?php echo $keyItem;?>][name]" type="text" class="form-control" placeholder="Заголовок" value="<?php echo htmlspecialchars(Arr::path($item, 'name', $item), ENT_XML1); ?>">
                                        </td>
                                        <td>
                                            <input name="agreement[<?php echo $key;?>][contract_template_others][<?php echo $keyItem;?>][url]" type="text" class="form-control" placeholder="Ссылка для редактирования" value="<?php echo htmlspecialchars(Arr::path($item, 'url', ''), ENT_XML1); ?>">
                                        </td>
                                        <td>
                                            <input name="agreement[<?php echo $key;?>][contract_template_others][<?php echo $keyItem;?>][field]" type="text" class="form-control" placeholder="Название поля" value="<?php echo htmlspecialchars(Arr::path($item, 'field', ''), ENT_XML1); ?>">
                                        </td>
                                        <td>
                                            <ul class="list-inline tr-button delete">
                                                <li><a href="#" data-action="remove-tr" data-parent-count="4" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger pull-right" onclick="addElement('agreement_new-<?php echo $key;?>_contract_template_others', 'agreement_<?php echo $key;?>_contract_template_others', true);">Добавить строчку</button>
                            </div>
                            <div id="agreement_new-<?php echo $key;?>_contract_template_others" data-index="0">
                                <!--
                                <tr>
                                        <td>
                                            <input name="agreement[<?php echo $key;?>][contract_template_others][_#index#][key]" type="text" class="form-control" placeholder="Ключ (должен быть уникальным)">
                                        </td>
                                    <td>
                                         <input name="agreement[<?php echo $key;?>][contract_template_others][_#index#][name]" type="text" class="form-control" placeholder="Заголовок">
                                    </td>
                                    <td>
                                         <input name="agreement[<?php echo $key;?>][contract_template_others][_#index#][url]" type="text" class="form-control" placeholder="Ссылка для редактирования">
                                    </td>
                                    <td>
                                         <input name="agreement[<?php echo $key;?>][contract_template_others][_#index#][field]" type="text" class="form-control" placeholder="Название поля">
                                    </td>
                                    <td>
                                         <ul class="list-inline tr-button delete">
                                             <li><a href="#" data-action="remove-tr" data-parent-count="4" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                                         </ul>
                                    </td>
                                </tr>
                                -->
                            </div>
                        </div>
                    </div>

                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                Изменяемые параметры
                            </label>
                        </div>
                        <div class="col-md-9">
                            <table class="table table-hover table-db table-tr-line" >
                                <tr>
                                    <th style="width: 20%;">Ключ</th>
                                    <th style="width: 20%;">Заголовок</th>
                                    <th>Значения</th>
                                    <th class="width-90"></th>
                                </tr>
                                <tbody id="agreement_<?php echo $key;?>_contract_template_params">
                                <?php foreach (Arr::path($print, 'contract_template_params', array()) as $keyItem => $item){ ?>
                                    <tr>
                                        <td>
                                            <input name="agreement[<?php echo $key;?>][contract_template_params][<?php echo $keyItem;?>][key]" type="text" class="form-control" placeholder="Ключ (должен быть уникальным)" value="<?php echo htmlspecialchars($keyItem, ENT_XML1); ?>">
                                        </td>
                                        <td>
                                            <input name="agreement[<?php echo $key;?>][contract_template_params][<?php echo $keyItem;?>][title]" type="text" class="form-control" placeholder="Заголовок" value="<?php echo htmlspecialchars(Arr::path($item, 'title', $item), ENT_XML1); ?>">
                                        </td>
                                        <td>
                                            <table class="table table-hover table-db table-tr-line" >
                                                <tr>
                                                    <th>Значения</th>
                                                    <th class="width-90"></th>
                                                </tr>
                                                <tbody id="agreement_<?php echo $key;?>contract_template_params_<?php echo $keyItem;?>_values">
                                                <?php foreach (Arr::path($item, 'values', array()) as $keyValue => $value){ ?>
                                                    <tr>
                                                        <td>
                                                            <input name="agreement[<?php echo $key;?>][contract_template_params][<?php echo $keyItem;?>][values][<?php echo $keyValue;?>]" type="text" class="form-control" placeholder="Значение" value="<?php echo htmlspecialchars($value, ENT_XML1); ?>">
                                                        </td>
                                                        <td>
                                                            <ul class="list-inline tr-button delete">
                                                                <li><a href="#" data-action="remove-tr" data-parent-count="4" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger pull-right" onclick="addElement('agreement_new-<?php echo $key;?>_contract_template_params_<?php echo $keyItem;?>_values', 'agreement_<?php echo $key;?>contract_template_params_<?php echo $keyItem;?>_values', true);">Добавить строчку</button>
                                            </div>
                                            <div id="agreement_new-<?php echo $key;?>_contract_template_params_<?php echo $keyItem;?>_values" data-index="0">
                                                <!--
                                                    <tr>
                                                        <td>
                                                           <input name="agreement[<?php echo $key;?>][contract_template_params][<?php echo $keyItem;?>][values][_#index#]" type="text" class="form-control" placeholder="Значение">
                                                        </td>
                                                        <td>
                                                             <ul class="list-inline tr-button delete">
                                                                 <li><a href="#" data-action="remove-tr" data-parent-count="4" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                                                             </ul>
                                                        </td>
                                                    </tr>
                                                    -->
                                            </div>
                                        </td>
                                        <td>
                                            <ul class="list-inline tr-button delete">
                                                <li><a href="#" data-action="remove-tr" data-parent-count="4" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger pull-left" onclick="addElement('agreement_new-<?php echo $key;?>_contract_template_params', 'agreement_<?php echo $key;?>_contract_template_params', true, false, '#index_param#');">Добавить строчку</button>
                            </div>
                            <div id="agreement_new-<?php echo $key;?>_contract_template_params" data-index="0">
                                <!--
                                <tr>
                                        <td>
                                            <input name="agreement[<?php echo $key;?>][contract_template_params][_#index_param#][key]" type="text" class="form-control" placeholder="Ключ (должен быть уникальным)">
                                        </td>
                                        <td>
                                            <input name="agreement[<?php echo $key;?>][contract_template_params][_#index_param#][title]" type="text" class="form-control" placeholder="Заголовок">
                                        </td>
                                        <td>
                                                <table class="table table-hover table-db table-tr-line" >
                                                    <tr>
                                                        <th>Значения</th>
                                                        <th class="width-90"></th>
                                                    </tr>
                                                    <tbody id="agreement_<?php echo $key;?>contract_template_params__#index_param#_values">
                                                    </tbody>
                                                </table>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger pull-right" onclick="addElement('agreement_new-<?php echo $key;?>_contract_template_params__#index_param#_values', 'agreement_<?php echo $key;?>contract_template_params__#index_param#_values', true);">Добавить строчку</button>
                                                </div>
                                                <div id="agreement_new-<?php echo $key;?>_contract_template_params__#index_param#_values" data-index="0">
                                                    #--
                                                    <tr>
                                                        <td>
                                                           <input name="agreement[<?php echo $key;?>][contract_template_params][_#index_param#][values][_#index#]" type="text" class="form-control" placeholder="Значение">
                                                        </td>
                                                        <td>
                                                             <ul class="list-inline tr-button delete">
                                                                 <li><a href="#" data-action="remove-tr" data-parent-count="4" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                                                             </ul>
                                                        </td>
                                                    </tr>
                                                    --#
                                                </div>
                                        </td>
                                        <td>
                                            <ul class="list-inline tr-button delete">
                                                <li><a href="#" data-action="remove-tr" data-parent-count="4" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                -->
                            </div>
                        </div>
                    </div>

                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                Верхний колонтитул
                            </label>
                        </div>
                        <div class="col-md-9">
                            <textarea data-action="html" name="agreement[<?php echo $key;?>][header]" placeholder="Верхний колонтитул" rows="7" class="form-control"><?php echo htmlspecialchars(Arr::path($print, 'header', ''), ENT_QUOTES);?></textarea>
                        </div>
                    </div>

                    <div id="agreement_<?php echo $key;?>_contract_templates">
                        <?php foreach (Arr::path($print, 'contract_templates.body', array()) as $keyItem => $item){ ?>
                            <div class="row record-input record-list">
                                <div class="col-md-3 record-title">
                                    <label>
                                        Тип записи
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <select name="agreement[<?php echo $key;?>][contract_templates][body][<?php echo $keyItem;?>][type]" class="form-control select2" >
                                        <option value="text" <?php if(Arr::path($item, 'type', '') == 'text'){?>selected<?php }?>>Текст</option>
                                        <option value="goods" <?php if(Arr::path($item, 'type', '') == 'goods'){?>selected<?php }?>>Товары</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row record-input record-list">
                                <div class="col-md-3 record-title">
                                    <label>
                                        Текст
                                    </label>
                                </div>
                                <div class="col-md-9">
                                    <textarea data-action="html" name="agreement[<?php echo $key;?>][contract_templates][body][<?php echo $keyItem;?>][text]" placeholder="Текст" rows="7" class="form-control"><?php echo htmlspecialchars(Arr::path($item, 'text', ''), ENT_QUOTES);?></textarea>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger pull-right" onclick="addElementHTML('agreement_new-<?php echo $key;?>_contract_templates', 'agreement_<?php echo $key;?>_contract_templates', true);">Добавить строчку</button>
                    </div>
                    <div id="agreement_new-<?php echo $key;?>_contract_templates" data-index="0">
                        <!--
                        <div class="row record-input record-list">
                            <div class="col-md-3 record-title">
                                <label>
                                    Тип записи
                                </label>
                            </div>
                            <div class="col-md-3">
                                <select name="agreement[<?php echo $key;?>][contract_templates][body][_#index#][type]" class="form-control select2" >
                                    <option value="text" selected>Текст</option>
                                    <option value="goods">Товары</option>
                                </select>
                            </div>
                        </div>
                        <div class="row record-input record-list">
                            <div class="col-md-3 record-title">
                                <label>
                                    Текст
                                </label>
                            </div>
                            <div class="col-md-9">
                                <textarea data-action="html" name="agreement[<?php echo $key;?>][contract_templates][body][_#index#][text]" placeholder="Текст" rows="7" class="form-control"></textarea>
                            </div>
                        </div>
                          -->
                    </div>

                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                Нижний колонтитул
                            </label>
                        </div>
                        <div class="col-md-9">
                            <textarea data-action="html" name="agreement[<?php echo $key;?>][footer]" placeholder="Нижний колонтитул" rows="7" class="form-control"><?php echo htmlspecialchars(Arr::path($print, 'footer', ''), ENT_QUOTES);?></textarea>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<div class="row">
    <div hidden>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>
        <input name="duplicate" value="">
        <input id="is_close" name="is_close" value="1" style="display: none">
    </div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn bg-green" data-action="form-apply">Применить</button>
        <button type="submit" class="btn btn-primary" data-action="form-save">Сохранить</button>
    </div>
</div>
<script>
    $('textarea[data-action="html"]').each(function(index) {
        var editor_list = CodeMirror.fromTextArea(this, {
            styleActiveLine: true,
            lineNumbers: true,
            lineWrapping: true,
            matchBrackets: true,
            matchTags: {bothTags: true},
            mode: "application/x-httpd-php",
            extraKeys: {"Ctrl-Space": "autocomplete"},
            autoCloseTags: true,
            indentUnit: 4,
            indentWithTabs: true,
            enterMode: "keep",
            tabMode: "shift",
            extraKeys: {
                "Ctrl-Q": function(cm){
                    cm.foldCode(cm.getCursor());
                },
                "F11": function(cm) {
                    cm.setOption("fullScreen", !cm.getOption("fullScreen"));
                },
                "Esc": function(cm) {
                    if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
                },
                "Ctrl-J": "toMatchingTag"
            },
            foldGutter: true,
            gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"],
            matchTags: {bothTags: true},
        });
    });

    $('.hideAfterRendering').each( function () {
        $(this).removeClass('active').removeClass('in');
    });

    function duplicateContract(path) {
        $('input[name="duplicate"]').val(path);
        $('[data-action="form-apply"]').trigger('click');
    }
</script>