<?php if ($data->values['is_directory']) { ?>
    <li class="has-child"><?php echo $data->values['name']; ?> <a
            href="<?php echo $siteData->urlBasic; ?>/cabinet/site/deletedir?directory=<?php echo $data->values['path']; ?>&id=<?php echo Request_RequestParams::getParamInt('id'); ?>">Удалить</a>
        <a href="<?php echo $siteData->urlBasic; ?>/cabinet/site/downloadfile?filename=<?php echo $data->values['path']; ?>&id=<?php echo Request_RequestParams::getParamInt('id'); ?>">Скачать</a>
        <a href="#"><?php echo View::factory('cabinet/35/site/file-upload'); ?></a>
        <ul>
            <?php
            foreach ($data->childs as $value) {
                $view = View::factory('cabinet/35/site/file/one/list');
                $view->data = $value;
                $view->siteData = $siteData;
                echo Helpers_View::viewToStr($view);
            }
            ?>
        </ul>
    </li>
<?php } else { ?>
    <li><?php echo $data->values['name']; ?>
        <a href="<?php echo $siteData->urlBasic; ?>/cabinet/site/deletefile?filename=<?php echo $data->values['path']; ?>&id=<?php echo Request_RequestParams::getParamInt('id'); ?>">Удалить</a>
        <a href="<?php echo $siteData->urlBasic; ?>/cabinet/site/downloadfile?filename=<?php echo $data->values['path']; ?>&id=<?php echo Request_RequestParams::getParamInt('id'); ?>">Скачать</a>
        <a href="#"><?php echo View::factory('cabinet/35/site/file-preview'); ?></a>
    </li>
<?php } ?>
