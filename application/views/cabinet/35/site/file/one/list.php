<?php $shift = Arr::path($data->additionDatas, 'shift', ''); ?>
<?php if ($data->values['is_directory']){?>
    <option value="<?php echo $data->values['path']; ?>" data-dir="1">_<?php echo $shift.$data->values['name']; ?></option>
    <?php
    foreach ($data->childs as $value) {
        $view = View::factory('cabinet/35/site/file/one/list');
        $value->additionDatas['shift'] = $shift.'  ';
        $view->data = $value;
        $view->siteData = $siteData;
        echo Helpers_View::viewToStr($view);
    }
    ?>
<?php }else{ ?>
    <option value="<?php echo $data->values['path']; ?>" data-dir="0"><?php echo $shift.$data->values['name']; ?></option>
<?php }?>
