<li><a href="<?php echo $siteData->urlBasicLanguage; ?>/products<?php echo $data->values['name_url']; ?>" title="<?php echo $data->values['name']; ?>"><?php echo $data->values['name']; ?></a></li>
<?php if (count($data->childs) > 0){ ?>
    <ul>
        <?php
        $i = 1;
        foreach ($data->childs as $child){
            $view = View::factory('2018/11/22/3590/801/View_Shop_Good/-sitemapforsite-rubriki');
            $view->siteData = $siteData;
            $view->data = $child;

            if ($i == 1){
                echo str_replace('<li>', '<li class="first">', Helpers_View::viewToStr($view));
                $i++;
            }else {
                echo Helpers_View::viewToStr($view);
            }
        }
        ?>
    </ul>
<?php } ?>