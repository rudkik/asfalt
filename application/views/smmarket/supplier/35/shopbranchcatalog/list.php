<option value="<?php echo $data->values['id'];?>" data-id="<?php echo $data->values['id'];?>"><?php echo Arr::path($data->values, '%%%%%%%###', '').$data->values['name'];?></option>
<?php
foreach ($data->childs as $value) {
    $view = View::factory('cabinet/35/shopbranchcatalog/list');
    $view->data = $value;
    $view->data->values['%%%%%%%###'] = Arr::path($data->values, '%%%%%%%###', '') . '--';
    $view->siteData = $siteData;
    echo Helpers_View::viewToStr($view);
}
?>