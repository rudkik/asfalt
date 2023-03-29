<h3 style="margin-top: 3px;"><a href="<?php echo $data->values['site_url'];?>"><?php echo $data->values['title'];?> <?php if(!empty($data->values['url'])){echo '('.$data->values['url'].')';}?></a></h3>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Заголовки страницы</label>
            <textarea style="margin-top: 0px;" type="text" class="form-control" rows="4"  placeholder="Заголовки страницы" name="seo[<?php echo $data->values['url'];?>][site_title]"><?php echo $data->values['site_title'];?></textarea>

        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Ключевые слова</label>
            <textarea style="margin-top: 0px;" type="text" class="form-control" rows="4" placeholder="Ключевые слова" name="seo[<?php echo $data->values['url'];?>][site_keywords]"><?php echo $data->values['site_keywords'];?></textarea>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Описание</label>
            <textarea style="margin-top: 0px;" type="text" class="form-control"  rows="4" placeholder="Описание" name="seo[<?php echo $data->values['url'];?>][site_description]"><?php echo $data->values['site_description'];?></textarea>
        </div>
    </div>
</div>
