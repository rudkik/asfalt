<?php if (!empty($className)){ ?>
    <div class="row record-input2 <?php echo $className; ?>">
<?php } ?>
    <?php
    if(! is_array($params)){
        $params = array();
    }
    foreach ($params as $key => $param){
        if((strpos($key, 'param') === FALSE)
            || (!$param['is_public'])){
            continue;
        }
        $key = intval(str_replace('param', '', $key));
        if ($key < 1){
            continue;
        }
        $name = 'shop_table_param_'.$key.'_id';
        $title = $param['name'];

        $value = Arr::path($data->values, $name, '');
    ?>
        <div class="col-md-3 record-title">
            <label>
                <?php echo $title; ?>
            </label>
        </div>
        <div class="col-md-3">
            <select name="<?php echo $name; ?>" class="form-control select2" style="width: 100%;">
                <option value="0" data-id="0">Без значения</option>
                <?php echo trim($siteData->globalDatas['view::_shop/_table/param/'.$key.'/list/list']); ?>
            </select>
        </div>
    <?php }?>
<?php if (!empty($className)){ ?>
    </div>
<?php } ?>