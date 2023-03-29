<?php if (!empty($className)){ ?>
    <div class="row record-input2 <?php echo $className; ?>">
<?php } ?>
    <?php
    if(! is_array($fields)){
        $fields = array();
    }
    foreach ($fields as $field){
        switch (Arr::path($field, 'type', 0)){
            case Model_Shop_Table_Basic_Table::PARAM_TYPE_INT:
                $name = '_int';
                break;
            case Model_Shop_Table_Basic_Table::PARAM_TYPE_FLOAT:
                $name = '_float';
                break;
            case Model_Shop_Table_Basic_Table::PARAM_TYPE_STR:
                $name = '_str';
                break;
            default:
                continue 2;
        }
        $name = 'param_'.$field['field'].$name;

        $value = Arr::path($data->values, $name, '');
    ?>
        <div class="col-md-3 record-title">
            <label>
                <?php echo $field['title']; ?>
                <?php if(!Func::_empty(Arr::path($field, 'hint', ''))){ ?>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                <?php } ?>
            </label>
        </div>
        <div class="col-md-3">
            <input name="<?php echo $name; ?>" type="text" class="form-control" placeholder="<?php echo htmlspecialchars($field['title'], ENT_QUOTES); ?>" value="<?php echo htmlspecialchars($value, ENT_QUOTES); ?>">
        </div>
    <?php }?>
<?php if (!empty($className)){ ?>
    </div>
<?php } ?>