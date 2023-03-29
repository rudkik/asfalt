<?php $data = $data['view::_shop/transport/waybill/work/car/one/index']; ?>
<?php if(count($data->childs) > 0){?>
<tr>
    <td colspan="2">
        <b></b><?php echo $data->additionDatas['transport']['name']; ?></td>
    </td>
</tr>
<?php
foreach ($data->childs as $value) {
    echo $value->str;
}
?>
<?php }?>
