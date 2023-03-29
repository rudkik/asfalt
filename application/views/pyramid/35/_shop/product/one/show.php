<div class="page-header">
    <div class="page-header-title">
        <div class="row">
            <?php
            $day = Request_RequestParams::getParamStr('day');
            if(key_exists($day, $data->values['options']['training'])){
                $day = $data->values['options']['training'][$day];
            }else{
                $day = array_shift($data->values['options']['training']);
            }
            ?>
            <div class="col-md-12">
                <h4 class="sub-title" style="margin-bottom: 20px; width: 100%;">
                    <?php echo $day['name']; ?>
                </h4>
            </div>
            <div class="col-md-12">
                <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/<?php echo $day['video']; ?>?rel=0&enablejsapi=1&loop=1&modestbranding=1&color=white&iv_load_policy=3&showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
            </div>
            <div class="col-md-12">
                <h5 class="sub-title" style="margin: 20px 0px;">Следующие шаги</h5>
            </div>
            <div class="col-md-12 button-page">
                <?php foreach ($day['actions'] as $action){?>
                    <a href="<?php echo $siteData->urlBasic; ?>/pyramid/shopproduct/show?id=<?php echo $data->values['id']; ?>&day=<?php echo $action['day']; ?>" class="btn btn-inverse btn-outline-inverse"><?php echo $action['name']; ?></a>
                <?php }?>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
</div>