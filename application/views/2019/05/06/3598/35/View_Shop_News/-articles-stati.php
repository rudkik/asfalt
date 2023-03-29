<div class="row">
    <?php
    $i = 1;
    $left = '';
    $right = '';
    foreach ($data['view::View_Shop_New\-articles-stati']->childs as $value){
        switch ($i){
            case 1:
                $left .= str_replace('<div class="col-md-6 box-article">', '<div class="col-md-12 box-article">', $value->str);
                break;
            case 2:
                $right .= '<div class="col-md-12"><div class="row">';
                $right .= $value->str;
                break;
            case 3:
                $right .= $value->str;
                $right .= '</div></div>';
                break;
            case 4:
                $left .= '<div class="col-md-12"><div class="row">';
                $left .= $value->str;
                break;
            case 5:
                $left .= $value->str;
                $left .= '</div></div>';
                break;
            case 6:
                $right .= str_replace('<div class="col-md-6 box-article">', '<div class="col-md-12 box-article">', $value->str);
                $i = 0;
                break;
        }
        $i++;
    }
    switch ($i){
        case 3:
            $right .= '</div></div>';
            break;
        case 5:
            $right .= '</div></div>';
            break;
    }
    echo '<div class="col-md-6"><div class="row">';
    echo $left;
    echo '</div></div>';
    echo '<div class="col-md-6"><div class="row">';
    echo $right;
    echo '</div></div>';
    ?>
</div>
<?php if($siteData->pages > 1) { ?>
    <ul class="box-pagination">
        <?php
        $urlParams = $_GET;
        unset($urlParams['page']);
        $url = $siteData->urlBasic . $siteData->url . URL::query($urlParams, FALSE);

        // $page$ - в место него будет вставлен номер страницы
        // $url$ - в место ссылки

        // предыдущая страница
        $previous_active = '<li class="next"><a href="$url$"><img src="img/left.png"></a></li>';
        $previous_not_active = '';

        // следующая страница
        $next_active = '<li class="next"><a href="$url$"><img src="img/right.png"></a></li>';
        $next_not_active = '';

        // текушая страница
        $current_active = '<li class="active"><a href="$url$">$page$</a></li>';
        $current_not_active = '<li><a href="$url$">$page$</a></li>';

        // пропуск страниц
        $shift = '<li><span>...</span></li>';


        $page = $siteData->page;
        $pages = $siteData->pages;
        $limit = $siteData->limitPage;

        // вывод данных

        // вставляем предыдущую страницу
        if ($page > 1) {
            echo str_replace('$page$', $page - 1, str_replace('$url$', $url, $previous_active));
        } else {
            echo str_replace('$page$', '1', str_replace('$url$', $url, $previous_not_active));
        }

        // вставляем первую страницу
        if ($page == 1) {
            echo str_replace('$page$', '1', str_replace('$url$', $url, $current_active));
        } else {
            echo str_replace('$page$', '1', str_replace('$url$', $url, $current_not_active));
        }

        if ($pages < 10) {
            for ($i = 2; $i < $pages; $i++) {
                if ($i == $page) {
                    echo str_replace('$page$', $i, str_replace('$url$', $url, $current_active));
                } else {
                    echo str_replace('$page$', $i, str_replace('$url$', $url, $current_not_active));
                }
            }
        } else {
            if ($page > 4) {
                echo $shift;
            }

            if ($page < 5) {
                for ($i = 2; $i < 8; $i++) {
                    if ($i == $page) {
                        echo str_replace('$page$', $i, str_replace('$url$', $url, $current_active));
                    } else {
                        echo str_replace('$page$', $i, str_replace('$url$', $url, $current_not_active));
                    }
                }
            } elseif ($pages - $page < 4) {
                for ($i = $pages - 6; $i < $pages; $i++) {
                    if ($i == $page) {
                        echo str_replace('$page$', $i, str_replace('$url$', $url, $current_active));
                    } else {
                        echo str_replace('$page$', $i, str_replace('$url$', $url, $current_not_active));
                    }
                }
            } else {
                for ($i = $page - 2; $i <= $page + 2; $i++) {
                    if ($i == $page) {
                        echo str_replace('$page$', $i, str_replace('$url$', $url, $current_active));
                    } else {
                        echo str_replace('$page$', $i, str_replace('$url$', $url, $current_not_active));
                    }
                }
            }

            if ($pages - $page > 3) {
                echo $shift;
            }
        }

        // вставляем последнюю страницу
        if (($page <= $pages) &&($pages > 1))  {
            if ($page == $pages) {
                echo str_replace('$page$', $pages, str_replace('$url$', $url, $current_active));
            } else {
                echo str_replace('$page$', $pages, str_replace('$url$', $url, $current_not_active));
            }
        }

        // вставляем следующую страницу
        if ($page < $pages) {
            echo str_replace('$page$', $page + 1, str_replace('$url$', $url, $next_active));
        } else {
            echo str_replace('$page$', $pages, str_replace('$url$', $url, $next_not_active));
        }
        ?>
    </ul>
<?php } ?>
