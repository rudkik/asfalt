<li><a href="<?php echo $siteData->urlBasic.str_replace('/index', '/edit', $siteData->url).URL::query(array('data_language_id' => $data->id, 'id' => '_id_'));?>" class="#class#<?php echo $data->id; ?> text-sm"><i class="fa fa-edit margin-r-5"></i> <?php echo $data->values['name']; ?> #status#<?php echo $data->id; ?></a></li>