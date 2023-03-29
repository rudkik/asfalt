<?php if($siteData->pages > 0) { ?>
    <?php
    if(empty($urlData)) {
        $urlParams = $_GET;
        $urlParams['page'] = '-pages-';

        if(key_exists('shop_table_catalog_id', $urlParams)){
            $urlParams['type'] = $urlParams['shop_table_catalog_id'];
            unset($urlParams['page']);
        }

        $shopBranchID = intval(Request_RequestParams::getParamInt('shop_branch_id'));
        if ($shopBranchID > 0) {
            $urlParams['shop_branch_id'] = $shopBranchID;
        }

        $url = str_replace('-pages-', '$page$', URL::query($urlParams, FALSE));

        $urlData = $siteData->urlBasic . $siteData->url . $url;
        $urlAction = 'href';
    }else{
        $url = $urlData;
    }
    ?>

<div class="row">
    <div class="col-sm-5">
        <div aria-live="polite" role="status" class="dataTables_info">Показаны с <?php if($siteData->countRecord > 0){echo ($siteData->page - 1) * $siteData->limitPage + 1;}else{echo 0;} ?> по <?php $tmp = (($siteData->page) * $siteData->limitPage); if($siteData->countRecord < $tmp){$tmp = $siteData->countRecord;}  echo $tmp; ?> из <?php echo Func::getCountElementStrRus($siteData->countRecord, 'записей', 'запись', 'записи'); ?></div>
    </div>

    <div class="col-sm-7">
        <div class="dataTables_paginate paging_simple_numbers">
            <ul class="pagination">

                <?php if($siteData->pages > 0) {
                    // $page$ - в место него будет вставлен номер страницы
                    // $url$ - в место ссылки

                    // предыдущая страница
                    $previous_active = '<li id="example2_previous" class="paginate_button previous">
                            <a tabindex="0" data-dt-idx="$page$" aria-controls="example2"'.$urlAction.'="$url$">«</a>
                        </li>';
                    $previous_not_active = '<li id="example2_previous" class="paginate_button previous disabled">
                                <a tabindex="0" data-dt-idx="$page$" aria-controls="example2" '.$urlAction.'="$url$">«</a>
                            </li>';

                    // следующая страница
                    $next_active = '<li id="example2_next" class="paginate_button next">
                        <a tabindex="0" data-dt-idx="$page$" aria-controls="example2" '.$urlAction.'="$url$">»</a>
                    </li>';
                    $next_not_active = '<li id="example2_next" class="paginate_button next disabled">
                            <a tabindex="0" data-dt-idx="$page$" aria-controls="example2" '.$urlAction.'="$url$">»</a>
                        </li>';

                    // текушая страница
                    $current_active = '<li class="paginate_button active">
                            <a tabindex="0" data-dt-idx="$page$" aria-controls="example2" '.$urlAction.'="$url$">$page$</a>
                       </li>';
                    $current_not_active = '<li class="paginate_button">
                                <a tabindex="0" data-dt-idx="$page$" aria-controls="example2" '.$urlAction.'="$url$">$page$</a>
                           </li>';

                    // пропуск страниц
                    $shift = '<li id="example2_ellipsis" class="paginate_button disabled">
                                <a tabindex="0" data-dt-idx="0" aria-controls="example2" href="#">…</a>
                            </li>';


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
                }
                ?>
            </ul>
        </div>
    </div>
</div>
<?php }else{ ?>
<div class="row">
    <div class="col-sm-12 padding-b-10 text-center">
        <div class="contacts-list-msg text-center margin-b-5">Записи не найдены</div>
    </div>
</div>
<?php } ?>
