<?php
$fields = Arr::path($data->additionDatas, 'fields', array());

$list = [];
foreach ($fields as $option) {
    $type = $option['type'];
    $title = $option['title'];
    if(!empty($title)){
        if(!key_exists($title, $list)){
            $list[$title] = [
                'title' => $title,
                'is_table' => true,
                'fields' => [],
                'type' => $type,
            ];
        }
        $list[$title]['fields'][] = $option;
    }else{
        $title = $option['name'];
        $list[$title] = [
            'title' => $title,
            'is_table' => false,
            'field' => $option,
            'type' => $type,
        ];
    }
}?>

<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Дата пробы
        </label>
    </div>
    <div class="col-md-3">
        <input name="date" type="datetime"  date-type="datetime"  class="form-control" required >
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Место испытания
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_analysis_place_id" name="shop_analysis_place_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/analysis/place/list/list']; ?>
        </select>
    </div>
</div>
<?php
//echo '<pre>';
//print_r($list);
//die;
foreach ($list as $child) {
    $title = $child['title'];
    $type = $child['type'];
?>
    <?php if($child['is_table']){ ?>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <?php echo $title; ?>
                </label>
            </div>
            <div class="col-md-9">
                <table class="table table-hover table-db table-tr-line" >
                    <tr>
                        <?php foreach ($child['fields'] as $field) { ?>
                            <th class="text-center">
                                <?php echo $field['name']; ?>
                            </th>
                        <?php } ?>
                    </tr>
                    <tbody>
                    <tr>
                        <?php foreach ($child['fields'] as $field) {
                            $title = $child['title'].'_'.$field['name'];
                            ?>
                            <td>
                            <?php if ($type == Model_Ab1_Shop_Analysis_Type::OPTIONS_TYPE_TABLE) {?>
                                <select name="options[<?php echo $title; ?>]">
                                    <option value="0" data-id="0">Без значения</option>
                                    <?php //echo $siteData->globalDatas['view::table/list/list']; ?>
                                </select>
                            <?php }else{ if ($field['quantity_value'] == ''){?>
                                <input name="options[<?php echo $title; ?>]" <?php if ($field['type'] == Model_Ab1_Shop_Analysis_Type::OPTIONS_TYPE_DATE) { ?> type="datetime" date-type="date"  <?php } ?>
                                    <?php if ($field['type'] == Model_Ab1_Shop_Analysis_Type::OPTIONS_TYPE_TIME) { ?> type="datetime" date-type="time" <?php } ?>
                                    <?php if ($field['type'] == Model_Ab1_Shop_Analysis_Type::OPTIONS_TYPE_INTEGER || $field['type'] == Model_Ab1_Shop_Analysis_Type::OPTIONS_TYPE_FLOAT || $field['type'] == Model_Ab1_Shop_Analysis_Type::OPTIONS_TYPE_DOUBLE) { ?> type="phone" <?php } ?>
                                    <?php if ($field['type'] == Model_Ab1_Shop_Analysis_Type::OPTIONS_TYPE_TEXT || $field['type'] == Model_Ab1_Shop_Analysis_Type::OPTIONS_TYPE_TABLE) { ?> type="text"  <?php } ?>
                                    <?php if (!empty($field['formula'])){ ?> type="text" readonly <?php }?> class="form-control" value="<?php echo $field['default_value'];?>"  data-variable="<?php echo $field['variable']; ?>" data-formula="<?php echo $field['formula']; ?>">
                            <?php }else{
                                for ($i=0; $i < $field['quantity_value']; $i++){ ?>
                                <div class="col-md-<?php echo ceil(12 / ($field['quantity_value'] + 1)); ?>" style="padding:0 1px">
                                    <input type="phone"  name="options[<?php echo $title; ?>][value][]" data-all="<?php echo $title; ?>" class="form-control">
                                </div>
                                    <?php } ?>
                                <div class="col-md-<?php echo ceil(12 / ($field['quantity_value'] + 1)); ?>" style="padding:0 1px">
                                    <input name="options[<?php echo $title; ?>][total]" type="phone" data-total="<?php echo $title; ?>" value="<?php echo $field['default_value'];?>" class="form-control" style="background-color: #eee">
                                </div>
                                    <?php }}?>
                            </td>
                        <?php } ?>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    <?php }else{ ?>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <?php echo $title; ?>
                </label>
            </div>
            <div class="col-md-3">
                <?php if ($type == Model_Ab1_Shop_Analysis_Type::OPTIONS_TYPE_TABLE) {?>
                    <select name="options[<?php echo $title; ?>]">
                        <option value="0" data-id="0">Без значения</option>
                        <?php //echo $siteData->globalDatas['view::table/list/list']; ?>
                    </select>
                <?php }else { if ($child['field']['quantity_value'] == ''){?>
                    <input name="options[<?php echo $title; ?>]" <?php if ($type == Model_Ab1_Shop_Analysis_Type::OPTIONS_TYPE_DATE) { ?> type="datetime" date-type="date" <?php } ?>
                        <?php if ($type == Model_Ab1_Shop_Analysis_Type::OPTIONS_TYPE_TIME) { ?> type="datetime" date-type="time" <?php } ?>
                        <?php if ($type == Model_Ab1_Shop_Analysis_Type::OPTIONS_TYPE_INTEGER || $type == Model_Ab1_Shop_Analysis_Type::OPTIONS_TYPE_FLOAT || $type == Model_Ab1_Shop_Analysis_Type::OPTIONS_TYPE_DOUBLE) { ?> type="phone" <?php } ?>
                        <?php if ($type == Model_Ab1_Shop_Analysis_Type::OPTIONS_TYPE_TEXT) { ?> type="text" <?php } ?> class="form-control"  data-variable="<?php echo $child['field']['variable']; ?>"
                        <?php if(($child['field']['formula']) != ''){ ?> type="text" readonly data-formula="<?php echo $child['field']['formula']; ?>" <?php } ?> class="form-control"  data-variable="<?php echo $child['field']['variable']; ?>" value="<?php echo $child['field']['default_value'];?>">
                <?php }else{
                    for ($i=0; $i < $child['field']['quantity_value']; $i++){ ?>
                <div class="col-md-<?php echo ceil(12 / ($child['field']['quantity_value'] + 1)); ?>" style="padding:0 1px">
                        <input type="phone"  name="options[<?php echo $title; ?>][value][]" data-all="<?php echo $title; ?>" class="form-control">
                </div>
                   <?php } ?>
                <div class="col-md-<?php echo ceil(12 / ($child['field']['quantity_value'] + 1)); ?>" style="padding:0 1px;">
                    <input name="options[<?php echo $title; ?>][total]" type="phone" data-total="<?php echo $title; ?>" value="<?php echo $child['field']['default_value'];?>" class="form-control" style="background-color: #eee" >
                </div>
                <?php } }?>
            </div>
        </div>
    <?php } ?>
<?php } ?>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Работник проводивший испытание
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_worker_id" name="shop_worker_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/worker/list/list']; ?>
        </select>
    </div>
</div>
<div class="row">
    <input name="shop_analysis_type_id" value="<?php echo Request_RequestParams::getParamInt('shop_analysis_type_id') ?>" style="display: none">
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>

<script>
    var all = $('[data-all]:not([data-all =""])');
    var total = $('[data-total]:not([data-total =""])');

    $(all).each(function (index){
        all[index].addEventListener('input', averageValue);
    });
    function averageValue(e) {
        $(total).each(function (index){
            var sum = 0, count = 0;
            console.log(total[index]['dataset']['total']);
            $(all).each(function (index2){ // 1 2 3 4
                if (total[index]['dataset']['total'] == all[index2]['dataset']['all']){
                    sum += Number(all[index2]['value']);
                    count++;
                }
            });
            total[index]['value']  = sum/count;
        });
    }


    var formulas = $('[data-formula]:not([data-formula=""])');
    var variables = $('[data-variable]:not([data-variable=""])');

    $(variables).each(function (index){
        variables[index].addEventListener('input', valueFormula);
    });
    function valueFormula(e) {
        $(formulas).each(function (index2){
            var formula = formulas[index2]['dataset']['formula'];
            var changeVariable = true;
            $(variables).each(function( index ) {
                // true
                var key = variables[index]['dataset']['variable'];
                var value = variables[index]['value'];
                if(formula.indexOf(key) > -1){
                    if(value != ''){
                        formula = formula.replace(key, value);
                    }else{
                        changeVariable = false;
                    }
                }
            });
            if (changeVariable == true){
                formulas[index2]['value'] = eval(formula);
            }
        });
    }
</script>