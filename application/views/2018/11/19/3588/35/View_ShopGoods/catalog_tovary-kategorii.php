<div class="row products">
	<?php 
	 foreach ($data['view::View_ShopGood\catalog_tovary-kategorii']->childs as $value){
	echo $value->str;
	}
	?>    
</div>
<?php if($siteData->pages > 1) {
    if(empty($urlData)) {
        $urlParams = $siteData->urlParams;
        $urlParams['page'] = '';
        $url = str_replace('page=', 'page=$page$', $siteData->urlBasic . $siteData->url . URL::query($urlParams, FALSE));
    }else{
        $url = $urlData;
    }

    if(empty($urlAction)){
        $urlAction = 'href';
    }
    ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="dataTables_paginate paging_simple_numbers">
                <ul class="pagination">
                    <?php
                    if(empty($urlData)) {
                        $urlParams = $siteData->urlParams;
                        $urlParams['page'] = '';
                        $url = str_replace('page=', 'page=$page$', $siteData->urlBasic . $siteData->url . URL::query($urlParams, FALSE));
                    }else{
                        $url = $urlData;
                    }

                    if(empty($urlAction)){
                        $urlAction = 'href';
                    }

                    // $page$ - в место него будет вставлен номер страницы
                    // $url$ - в место ссылки

                    // предыдущая страница
                    $previous_active = '<li class="paginate_button previous"><a href="$url$"><img src="'.$siteData->urlBasic.'/css/'.$siteData->shopShablonPath.'/img/previous.png" class="img-responsive" alt=""> <span>Предыдущая</span></a></li>';
                    $previous_not_active = '';

                    // следующая страница
                    $next_active = '<li class="paginate_button next"><a href="$url$"><span>Следующая</span> <img src="'.$siteData->urlBasic.'/css/'.$siteData->shopShablonPath.'/img/next.png" class="img-responsive" alt=""></a></li>';
                    $next_not_active = '';

                    // текушая страница
                    $current_active = '<li class="paginate_button active"><a href="$url$">$page$</a></li>';
                    $current_not_active = '<li class="paginate_button"><a href="$url$">$page$</a></li>';

                    // пропуск страниц
                    $shift = '<li class="paginate_button disabled"><a>...</a></li>';


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
            </div>
        </div>
    </div>
<?php } ?>