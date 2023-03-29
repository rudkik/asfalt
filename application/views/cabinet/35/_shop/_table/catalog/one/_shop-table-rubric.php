<?php $title = Arr::path($data->values['form_data'], $field.'e_rubric.fields_title', array());?>
<div class="box_rubric">
    <h3>Рубрики</h3>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                Название
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <div class="col-md-9">
            <input name="form_data[<?php echo $field;?>_rubric][fields_title][title]" type="text" class="form-control" placeholder="Название"
                   value="<?php echo htmlspecialchars(Arr::path($title, 'title', 'рубрики'), ENT_QUOTES);?>">
        </div>
    </div>
    <?php
    $view = View::factory('cabinet/35/_addition/fields-image-options');
    $view->siteData = $siteData;
    $view->data = $data;
    $view->optionsChild = $field.'_rubric';
    echo Helpers_View::viewToStr($view);
    ?>
    <div class="row record-input record-list margin-t-15">
        <div class="col-md-3 record-title">
            <label>
                Доп. параметры учавствующие в поиске
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <div class="col-md-9">
            <?php
            $view = View::factory('cabinet/35/_addition/params/fields');
            $view->siteData = $siteData;
            $view->data = $data;
            $view->paramsChild = $field.'_rubric';
            echo Helpers_View::viewToStr($view);
            ?>
        </div>
    </div>
    <div class="row record-input record-list margin-t-15">
        <div class="col-md-3 record-title">
            <label>
                Название полей
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <div class="col-md-9">
            <table id="body_panel" class="table table-hover table-db margin-b-5">
                <tr>
                    <th style="width: 200px;">
                        Название
                    </th>
                    <th>
                        Для клиента <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                    </th>
                </tr>
                <tr>
                    <td>Список рубрик</td>
                    <td><input name="form_data[<?php echo $field;?>_rubric][fields_title][name_list]" type="text" class="form-control"
                               value="<?php echo htmlspecialchars(Arr::path($title, 'name_list', 'рубрики'), ENT_QUOTES);?>"></td>
                </tr>
                <tr>
                    <td>Одна рубрика</td>
                    <td><input name="form_data[<?php echo $field;?>_rubric][fields_title][name_one]" type="text" class="form-control"
                               value="<?php echo htmlspecialchars(Arr::path($title, 'name_one', 'рубрика'), ENT_QUOTES);?>"></td>
                </tr>
                <tr>
                    <td>Кнопка добавления</td>
                    <td><input name="form_data[<?php echo $field;?>_rubric][fields_title][button_add]" type="text" class="form-control"
                               value="<?php echo htmlspecialchars(Arr::path($title, 'button_add', 'добавить'), ENT_QUOTES);?>"></td>
                </tr>
                <tr>
                    <td>Название</td>
                    <td><input name="form_data[<?php echo $field;?>_rubric][fields_title][name]" type="text" class="form-control"
                               value="<?php echo htmlspecialchars(Arr::path($title, 'name', 'Название'), ENT_QUOTES);?>"></td>
                </tr>
                <tr>
                    <td>Родитель</td>
                    <td><input name="form_data[<?php echo $field;?>_rubric][fields_title][root]" type="text" class="form-control"
                               value="<?php echo htmlspecialchars(Arr::path($title, 'root', 'Родитель'), ENT_QUOTES);?>"></td>
                </tr>
                <tr>
                    <td>Описание</td>
                    <td><input name="form_data[<?php echo $field;?>_rubric][fields_title][text]" type="text" class="form-control"
                               value="<?php echo htmlspecialchars(Arr::path($title, 'text', 'Описание'), ENT_QUOTES);?>"></td>
                </tr>
            </table>
        </div>
    </div>
</div>