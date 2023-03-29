<li <?php if (count($data->childs) > 0){ ?>class="hasChildren"<?php } ?>>
    <a <?php if (count($data->childs) == 0){ ?> class="not-line"<?php } ?> href="<?php echo $siteData->urlBasicLanguage; ?>/catalogs<?php echo $data->values['name_url']; ?>"><?php echo $data->values['name']; ?></a>
    <?php if (count($data->childs) > 0){ ?>
        <ul class="listMenu__subList" id="sublist">
            <li class="goBack"><a href="#">Назад</a></li>
            <?php
            foreach ($data->childs as $child) {
                $view = View::factory($siteData->shopShablonPath . '/' . $siteData->dataLanguageID . '/DB_Shop_Good/basic/derevo-rubrik');
                $view->siteData = $siteData;
                $view->data = $child;
                echo Helpers_View::viewToStr($view);
            }
            ?>
        </ul>
    <?php } ?>
</li>