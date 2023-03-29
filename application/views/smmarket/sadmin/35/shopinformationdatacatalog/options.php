<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border"><b style="font-size: 18px;">Дополнительные поля</b></div>
            <div class="box-body with-border">
                <table id="buket_sobran" class="table table-bordered table-hover table-striped top10">
                    <thead>
                    <tr>
                        <th>Заголовок</th>
                        <th>Название</th>
                        <th style="width: 88px;"></th>
                    </tr>
                    </thead>
                    <tbody id="body_panel">
                    <?php
                    if(key_exists('options', $data->values)) {
                        $tmp = $data->values['options'];
                    }else{
                        $tmp = array();
                    }
                    foreach ($tmp as $value):?>
                        <tr>
                            <td><input name="option_titles[]" type="text" class="form-control" value="<?php echo $value['title'];?>"></td>
                            <td><input name="option_names[]" type="text" class="form-control" value="<?php echo $value['field'];?>"></td>
                            <td style="width: 88px;">
                                <a data-id="0" buttom-tr="del" href="" class="btn btn-danger btn-sm checkbox-toggle">Удалить</a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-9"></div>
    <div style="float: right;" class="col-md-3">
        <input type="submit" class="btn btn-success btn-block" value="Добавить поле" onclick="actionAddTR('body_panel', 'tr_panel')">
    </div>
</div>

<div hidden="hidden" id="tr_panel">
    <!--
<tr>
    <td><input name="option_titles[]" type="text" class="form-control" value=""></td>
    <td><input name="option_names[]" type="text" class="form-control" value=""></td>
    <td style="width: 88px;">
    	<a buttom-tr="del" data-id="0" href="" class="btn btn-danger btn-sm checkbox-toggle">Удалить</a>
    </td>
</tr>
 -->
</div>