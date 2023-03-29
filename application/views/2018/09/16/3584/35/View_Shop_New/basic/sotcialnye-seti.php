<li class="nav-item">
	<a class="sm-icon-label-link nav-link" href="<?php echo Arr::path($data->values['options'], 'url', ''); ?>">
    	<i class="fa <?php echo Arr::path($data->values['options'], 'class', ''); ?>"></i> <?php echo $data->values['name']; ?>
	</a>
</li>