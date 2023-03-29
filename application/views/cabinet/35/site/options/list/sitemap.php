<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-body with-border">
                <table id="buket_sobran" class="table table-bordered table-hover table-striped top10">
                    <thead>
                    <tr>
                        <th style="width: 22.5%;">Префикс ссылки</th>
                        <th style="width: 22.5%;">Запрос в БД</th>
                        <th style="width: 22.5%;">Параметры запроса</th>
                        <th style="width: 22.5%;">Постфик ссылки</th>
                        <th style="width: 40px;">Приоритет</th>
                        <th style="width: 70px;"></th>
                    </tr>
                    </thead>
                    <tbody id="body_panel">
                    <?php
                    foreach ($data['view::site/options/one/sitemap']->childs as $value){
                        echo $value->str;
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-10"></div>
    <div class="col-md-2">
        <input type="submit" class="btn btn-success btn-block" value="Добавить" onclick="actionAddTR('body_panel', 'tr_panel')">
    </div>
</div>

<div class="row top20">
    <div class="col-md-3">
        <input type="submit" value="Сохранить" class="btn btn-primary btn-block" onclick="actionSaveObject('<?php echo $siteData->urlBasic.'/cabinet/siteoptions/savesitemaps'?>?', 0,'edit_panel', 'table_panel', false)">
    </div>
    <div class="col-md-2">
        <input type="submit" value="Сохранить и закрыть" class="btn btn-primary btn-block" onclick="actionSaveObject('<?php echo $siteData->urlBasic.'/cabinet/siteoptions/savesitemaps'?>?', 0,'edit_panel', 'table_panel', true)">
    </div>
</div>


<div hidden="hidden" id="tr_panel">
<!--
<tr>
    <td><input name="url_prefix[]" type="text" class="form-control" rows="5" placeholder="Префикс ссылки"></td>
    <td>
        <select class="form-control select2" style="width: 100%;" name="function[]">
            <option></option>
            <?php echo $data['view::siteoptions/sitemap']->additionDatas['view::site/combobox-views']; ?>
        </select>
    </td>
    <td><input name="url_postfix[]" type="text" class="form-control" rows="5" placeholder="Постфикс ссылки"></td>
    <td><input name="priority[]" type="text" class="form-control" rows="5" placeholder="Приоритет"></td>
    <td style="width: 98px;">
        <a data-id="0" buttom-tr="del" href="" class="btn btn-danger btn-sm checkbox-toggle">Удалить</a>
    </td>
</tr>
 -->
</div>