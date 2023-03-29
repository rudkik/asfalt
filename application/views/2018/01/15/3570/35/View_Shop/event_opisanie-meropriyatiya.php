<?php if($data->id != 999999999){ ?>
<div class="col-md-7">
    <h4>Уважаемые коллеги</h4>
    <div><?php echo $data->values['info']; ?></div>
</div>
<div class="col-md-5">
    <img src="<?php echo $data->values['file_logotype']; ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>" class="img-responsive">
</div>
<?php } ?>