<?php if(!empty($data->values['name'])){?>
    <li><a class="btn btn-block btn-danger btn-lg btn-red" data-toggle="tab" href="#panel<?php echo $data->values['id']; ?>"><?php echo $data->values['name']; ?></a></li>
<?php }?>