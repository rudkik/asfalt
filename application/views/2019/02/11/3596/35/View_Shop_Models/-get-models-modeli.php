<option value="-1" data-id="-1">Модели</option>
<?php 
 foreach ($data['view::View_Shop_Model\-get-models-modeli']->childs as $value){
echo $value->str;
}
?>