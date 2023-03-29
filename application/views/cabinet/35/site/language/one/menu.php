<li class="treeview active">
    <a href="#">
        <i class="fa fa-language text-aqua"></i> <span><?php echo $data->values['name']; ?></span>
        <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu" style="display: none;">
        <?php foreach($data->additionDatas['urls'] as $kURL => $url){ ?>
            <li><a class="text-light-blue" href="<?php echo Func::getFullURL($siteData, '/site/views', array('id' => 'id'), array('url' => $kURL, 'language' => $data->id)); ?>"><i class="fa fa-level-down"></i> <?php echo $url['title']; ?></a></li>
            <?php if(count($url['data']) > 0){ ?>
            <li>
                <a href="#"><i class="fa fa-plus"></i> Список вьюшек <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <?php foreach($url['data'] as $kView => $view){ ?>
                        <li><a class="text-purple" href="<?php echo Func::getFullURL($siteData, '/site/view', array('id' => 'id'), array('url' => $kURL, 'language' => $data->id, 'view' => $kView)); ?>"><i class="fa fa-space-shuttle"></i> <?php echo $view['title']; ?></a></li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
        <?php } ?>
    </ul>
</li>

