<?php echo trim($siteData->globalDatas['view::View_Shop_Car\-trucks-rubrika']); ?>
<header class="header-sales">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="box-catalog">
                    <div class="title"><label>Фильтр</label></div>
                </div>
                <form id="filters" action="/trucks-find" class="box-filters">
                    <?php echo trim($siteData->globalDatas['view::View_Shop_Cars\-trucks-rubriki']); ?>
                    <?php echo trim($siteData->globalDatas['view::View_Shop_Marks\-trucks-marki']); ?>
                    <div class="box-filter">
                        <h3>Регион</h3>
                        <ul class="box-filter-items">
                            <?php echo trim($siteData->globalDatas['view::View_Lands\-trucks-strany-nakhozhdeniya']); ?>
                        </ul>
                    </div>
                </form>
                <script>
                    $(document).ready(function() {
                        function sendData(){
                            var form = $('#filters');
                            var url = form.attr('action');

                            var params = form.serializeArray();

                            jQuery.ajax({
                                url: url,
                                data: params,
                                type: "POST",
                                success: function (data) {
                                    $('#trucks').html(data);
                                },
                                error: function (data) {
                                    console.log(data.responseText);
                                }
                            });
                        }
                        $('[data-action="filter"]').on('ifChecked', function (event) {
                            sendData();
                        }).on('ifUnchecked', function (event) {
                            sendData();
                        });
                    });
                </script>
            </div>
            <div class="col-md-9">
                <h2><span class="yellow">Продажа</span> спецтехники сегодня</h2>
                <p class="info">В данном разделе представлены все предложения на продажу. Продавайте на выгодных условиях.</p>
                <div class="box-show">
                    <div class="navbar-custom-menu">
                        <ul class="nav">
                            <li class="dropdown messages-menu pull-left">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <label class="language-active">
                                        <?php
                                        $tmp = Request_RequestParams::getParamArray('sort_by');
                                        if ($tmp === NULL){
                                            echo 'Новые';
                                        }else{
                                           if(key_exists('name_total', $tmp)){
                                               echo 'По алфавиту';
                                           }elseif (key_exists('id', $tmp)){
                                               if($tmp['id'] == 'desc'){
                                                   echo 'Новые';
                                               }else{
                                                   echo 'Популярные';
                                               }
                                           }else{
                                               echo 'Новые';
                                           }
                                        }
                                        ?>
                                    </label><i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo $siteData->urlBasicLanguage;?>/trucks<?php echo URL::query(array('sort_by' => array('id' => 'desc')));?>">Новые</a></li>
                                    <li><a href="<?php echo $siteData->urlBasicLanguage;?>/trucks<?php echo URL::query(array('sort_by' => array('id' => 'asc')));?>">Популярные</a></li>
                                    <li><a href="<?php echo $siteData->urlBasicLanguage;?>/trucks<?php echo URL::query(array('sort_by' => array('name_total' => 'asc')));?>">По алфавиту</a></li>
                                </ul>
                            </li>
                            <li class="dropdown messages-menu pull-right">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <label class="language-active">Показать</label><i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo $siteData->urlBasicLanguage;?>/trucks<?php echo URL::query(array('limit_page' => 12));?>">12</a></li>
                                    <li><a href="<?php echo $siteData->urlBasicLanguage;?>/trucks<?php echo URL::query(array('limit_page' => 24));?>">24</a></li>
                                    <li><a href="<?php echo $siteData->urlBasicLanguage;?>/trucks<?php echo URL::query(array('limit_page' => 48));?>">48</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <div id="trucks">
                    <?php echo trim($siteData->globalDatas['view::View_Shop_Cars\-trucks-mashiny']); ?>
                </div>
            </div>
        </div>
    </div>
</header>