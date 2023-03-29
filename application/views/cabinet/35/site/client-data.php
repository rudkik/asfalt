<strong class="add-magazin-title"><?php if(empty($data->values['url_title'])){echo 'Для всех страниц';}else{echo $data->values['url_title'];}?></strong>
<strong class="add-magazin-title"><a href="<?php echo $data->values['url'];?>"><?php $data->values['url'];?></a></strong>
<div class="add-magazin-instr" style="margin-bottom: 0px;">
    <ol>
        <?php
        foreach ($data->values['views'] as $value) {
            echo '<li>'.$value['title'].'</li>';
        }
        ?>
    </ol>
</div>