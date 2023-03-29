<li>
    <span class="time"><?php echo Arr::path($data->values['options'], 'time', ''); ?></span> - <?php echo $data->values['name']; ?>
	<?php if(!empty($data->values['download_file_path'])){ ?>
    <span class="pdfdownload">
        <a href="<?php echo $data->values['download_file_path']; ?>"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> <?php echo $data->values['download_file_name']; ?></a>
    </span>
	<?php } ?>
</li>