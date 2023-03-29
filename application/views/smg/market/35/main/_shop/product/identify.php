<div class="tab-pane active">
    <?php $siteData->titleTop = 'Распознание товаров'; ?>
    <?php
    $view = View::factory('smg/market/35/main/_shop/product/filter/identify');
    $view->siteData = $siteData;
    $view->data = $data;
    echo Helpers_View::viewToStr($view);
    ?>
</div>
<div class="nav-tabs-custom" style="margin-bottom: 0px;">
    <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
        <li class="<?php if(Arr::path($siteData->urlParams, 'is_delete', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopproduct/identify', array(), array('is_public' => null, 'is_not_public' => null, 'is_delete' => 1, 'is_public_ignore' => 1), [], true);?>" data-id="is_delete_public_ignore">Удаленные</a></li>
        <li class="<?php if(Arr::path($siteData->urlParams, 'is_not_public', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopproduct/identify', array(), array('is_public' => null, 'is_delete' => null, 'is_public_ignore' => null, 'is_not_public' => 1), [], true);?>" data-id="is_not_public">Неактивные</a></li>
        <li class="<?php if(Arr::path($siteData->urlParams, 'is_public', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopproduct/identify', array(), array('is_delete' => null, 'is_public_ignore' => null, 'is_not_public' => null, 'is_public' => 1), [], true);?>" data-id="is_public">Активные</a></li>
        <li class="<?php if((Arr::path($siteData->urlParams, 'is_delete', '') != 1) && (Arr::path($siteData->urlParams, 'is_not_public', '') != 1) && (Arr::path($siteData->urlParams, 'is_public', '') != 1)){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopproduct/identify', array(), array('is_delete' => null, 'is_delete' => null, 'is_not_public' => null, 'is_public_ignore' => 1), [], true);?>" data-id="is_public_ignore">Все <i class="fa fa-fw fa-info text-blue"></i></a></li>
    </ul>
</div>
<div class="body-table dataTables_wrapper ">
    <div class="box-body table-responsive" style="padding-top: 0px;">
        <?php echo trim($data['view::_shop/product/list/identify']); ?>
    </div>
</div>

<div id="modal-identify" class="modal fade">
    <div class="modal-dialog" style="max-width: 900px; width: 100%" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                <div class="row" style="margin-right: 15px;">
                    <div class="col-md-12" style="margin-top: -16px;">
                        <div class="content">
                            <div class="content-thumb" style="width: 100px; text-align: center;">
                                <img style="max-width: 100px; max-height: 100px; width: auto" data-id="img" src="/img/file-not-found/file_not_found-100x100.png" class="img-responsive">
                            </div>
                            <div class="content-info">
                                <p data-id="integrations" style="margin-bottom: 2px"></p>
                                <p>
                                    <a data-id="name"><strong>Excepteur sint occaecat cupidatat</strong></a>
                                    <a data-id="url" target="_blank" href="#"><strong>Товар</strong></a>
                                </p>
                                <button data-article="" data-index="" data-action="not-identify" type="button" class="btn bg-blue btn-flat" style="margin-top: 5px">Не найден</button>
                                <button data-article="" data-index="" data-action="next-identify" type="button" class="btn bg-green btn-flat pull-right" style="margin-top: 5px">Следующий</button>
                            </div>
                            <div class="row" style="margin-top: 15px">
                                <div class="col-lg-12">
                                    <div class="input-group">
                                        <input data-id="search-name" class="form-control" name="name" placeholder="Поиск" type="text">
                                        <span class="input-group-btn">
                                            <button data-action="search-name" type="button" class="btn bg-orange btn-flat">Поиск</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body" style="overflow-y: auto;max-height: 700px;"></div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('[data-action="search-name"]').click(function (e) {
            e.preventDefault();

            var modal = $('#modal-identify');
            var name = modal.find('[data-id="search-name"]').val();
            var article = modal.data('article');
            var index = modal.data('index');

            var header = modal.find('.modal-header');

            if(name == ''){
                return false;
            }

            jQuery.ajax({
                url: '/smg/kaspi/search_name',
                data: ({
                    'name': (name),
                    'shop_company_id': (1),
                }),
                type: "POST",
                success: function (data) {
                    var obj = jQuery.parseJSON($.trim(data));

                    var parent = modal.find('.modal-body');
                    parent.html('');

                    var child = $('#new');
                    var i = 1;
                    $.each(obj.products, function(k, v) {
                        var html = child.html().replace('<!--', '').replace('-->', '').replace('--!>', '');
                        html = $(html);

                        html.find('[data-id="img"]').attr('src', 'https://kaspi.kz' + v.primaryImage.large);
                        html.find('[data-id="name"]').attr('href', v.productUrl).html(v.name);
                        html.find('[data-action="set-identify"]').data('article', article).data('sku', v.sku).data('index', index);
                        html.find('[data-id="info"]').html(v.description);

                        setIdentify(html.find('[data-action="set-identify"]'));
                        parent.append(html);

                        i = i + 1;
                        if(i > 25){
                            return;
                        }
                    });

                    // удаляем подстветку
                    parent.find('[data-id="info"] span.h_i_g_h, [data-id="name"] span.h_i_g_h').each(function(){
                        $(this).after($(this).html()).remove();
                    });
                    parent.find('[data-id="info"] span.h_i_g_h, [data-id="name"] .h_i_g_h').each(function(){
                        $(this).removeClass('h_i_g_h');
                    });

                    // разбитие по словам
                    var words = header.find('[data-id="name"]').text().split(/[\s|,!#\(\)\/\"\[\]]/);
                    words.sort((a, b) => (a.length < b.length && 1) || (a.length > b.length && -1) || 0); //по убыванию
                    // поиск по названию
                    parent.find('[data-id="info"], [data-id="name"]').each(function (i, valueFind) {
                        $.each(words, function (index, term) {
                            if(term.length > 1) {
                                term = term
                                    .replace(/\\/g, '\\')
                                    .replace(/\//g, '\\/')
                                    .replace(/\[/g, '\\[')
                                    .replace(/\]/g, '\\]')
                                    .replace(/\(/g, '\\(')
                                    .replace(/\)/g, '\\)')
                                    .replace(/\{/g, '\\{')
                                    .replace(/\}/g, '\\}')
                                    .replace(/\?/g, '\\?')
                                    .replace(/\+/g, '\\+')
                                    .replace(/\*/g, '\\*')
                                    .replace(/\|/g, '\\|')
                                    .replace(/\./g, '\\.')
                                    .replace(/\^/g, '\\^')
                                    .replace(/\$/g, '\\$');

                                $(valueFind).html($(valueFind).html().replace(new RegExp(term, 'ig'), '<span class="h_i_g_h">$&</span>')); // выделяем найденные фрагменты
                            }
                        });
                    });
                },
                error: function (data) {
                }
            });
        });

        function identify(e) {
            e.preventDefault();

            var article = $(this).data('article');
            var index = $(this).data('index');
            var modal = $('#modal-identify');
            modal.data('article', article);
            modal.data('index', index);

            modal.find('[data-id="search-name"]').val('');

            var header = modal.find('.modal-header');

            header.find('[data-id="img"]').attr('src', '/img/file-not-found/file_not_found-100x100.png').attr('src', $(this).find('[data-id="img"]').attr('src'));
            header.find('[data-id="name"]').html($(this).find('[data-id="name"]').html());
            header.find('[data-id="integrations"]').html($(this).find('[data-id="integrations"]').html());
            var urlEl = header.find('[data-id="url"]').attr('href', '').attr('href', $(this).find('[data-id="url"]').attr('href'));
            if(urlEl.attr('href') == ''){
                urlEl.css('display', 'none');
            }else{
                urlEl.css('display', 'block');
            }

            header.find('[data-action="not-identify"]').data('article', article).data('index', index);
            header.find('[data-action="next-identify"]').data('article', article).data('index', index);

            jQuery.ajax({
                url: '/smg/kaspi/search_sku',
                data: ({
                    'article': (article),
                    'shop_company_id': (1),
                }),
                type: "POST",
                success: function (data) {
                    var obj = jQuery.parseJSON($.trim(data));

                    var parent = modal.find('.modal-body');
                    parent.html('');

                    var child = $('#new');
                    var i = 1;
                    $.each(obj.products, function(k, v) {
                        var html = child.html().replace('<!--', '').replace('-->', '').replace('--!>', '');
                        html = $(html);

                        html.find('[data-id="img"]').attr('src', 'https://kaspi.kz' + v.primaryImage.large);
                        html.find('[data-id="name"]').attr('href', v.productUrl).html(v.name);
                        html.find('[data-action="set-identify"]').data('article', article).data('sku', v.sku).data('index', index);
                        html.find('[data-id="info"]').html(v.description);

                        setIdentify(html.find('[data-action="set-identify"]'));
                        parent.append(html);

                        i = i + 1;
                        if(i > 25){
                            return;
                        }
                    });

                    // удаляем подстветку
                    parent.find('[data-id="info"] span.h_i_g_h, [data-id="name"] span.h_i_g_h').each(function(){
                        $(this).after($(this).html()).remove();
                    });
                    parent.find('[data-id="info"] span.h_i_g_h, [data-id="name"] .h_i_g_h').each(function(){
                        $(this).removeClass('h_i_g_h');
                    });

                    // разбитие по словам
                    var words = header.find('[data-id="name"]').text().split(/[\s|,!#\(\)\/\"\[\]]/);
                    words.sort((a, b) => (a.length < b.length && 1) || (a.length > b.length && -1) || 0); //по убыванию
                    // поиск по названию
                    parent.find('[data-id="info"], [data-id="name"]').each(function (i, valueFind) {
                        $.each(words, function (index, term) {
                            if(term.length > 1) {
                                term = term
                                    .replace(/\\/g, '\\')
                                    .replace(/\//g, '\\/')
                                    .replace(/\[/g, '\\[')
                                    .replace(/\]/g, '\\]')
                                    .replace(/\(/g, '\\(')
                                    .replace(/\)/g, '\\)')
                                    .replace(/\{/g, '\\{')
                                    .replace(/\}/g, '\\}')
                                    .replace(/\?/g, '\\?')
                                    .replace(/\+/g, '\\+')
                                    .replace(/\*/g, '\\*')
                                    .replace(/\|/g, '\\|')
                                    .replace(/\./g, '\\.')
                                    .replace(/\^/g, '\\^')
                                    .replace(/\$/g, '\\$');

                                $(valueFind).html($(valueFind).html().replace(new RegExp(term, 'ig'), '<span class="h_i_g_h">$&</span>')); // выделяем найденные фрагменты
                            }
                        });
                    });

                    modal.modal('show');
                },
                error: function (data) {
                }
            });
        }
        $('[data-action="identify"]').dblclick(identify);

        var getSelectedText = function() {
            var text = '';
            if (window.getSelection) {
                text = window.getSelection().toString();
            } else if (document.selection) {
                text = document.selection.createRange().text;
            }
            return text;
        }

        function findSelect() {
            var text = $.trim(getSelectedText());

            var modal = $('#modal-identify');

            var header = modal.find('.modal-header');
            var parent = modal.find('.modal-body');

            // удаляем подстветку
            parent.find('[data-id="name"] span.h_i_g_h').each(function(){
                $(this).after($(this).html()).remove();
            });
            parent.find('[data-id="name"] .h_i_g_h').each(function(){
                $(this).removeClass('h_i_g_h');
            });

            if(text == '') {
                // разбитие по словам
                var words = header.find('[data-id="name"]').text().split(/[\s|,!#]/);
                // поиск по названию
                parent.find('[data-id="name"]').each(function (i, valueFind) {
                    $.each(words, function (index, term) {
                        if (term.length > 2) {
                            term = term
                                .replace(/\\/g, '\\')
                                .replace(/\//g, '\\/')
                                .replace(/\[/g, '\\[')
                                .replace(/\]/g, '\\]')
                                .replace(/\(/g, '\\(')
                                .replace(/\)/g, '\\)')
                                .replace(/\{/g, '\\{')
                                .replace(/\}/g, '\\}')
                                .replace(/\?/g, '\\?')
                                .replace(/\+/g, '\\+')
                                .replace(/\*/g, '\\*')
                                .replace(/\|/g, '\\|')
                                .replace(/\./g, '\\.')
                                .replace(/\^/g, '\\^')
                                .replace(/\$/g, '\\$');

                            $(valueFind).html($(valueFind).html().replace(new RegExp(term, 'ig'), '<span class="h_i_g_h">$&</span>')); // выделяем найденные фрагменты
                        }
                    });
                });
            }else{
                var term = text;
                parent.find('[data-id="name"]').each(function (i, valueFind) {
                    term = term
                        .replace(/\\/g, '\\')
                        .replace(/\//g, '\\/')
                        .replace(/\[/g, '\\[')
                        .replace(/\]/g, '\\]')
                        .replace(/\(/g, '\\(')
                        .replace(/\)/g, '\\)')
                        .replace(/\{/g, '\\{')
                        .replace(/\}/g, '\\}')
                        .replace(/\?/g, '\\?')
                        .replace(/\+/g, '\\+')
                        .replace(/\*/g, '\\*')
                        .replace(/\|/g, '\\|')
                        .replace(/\./g, '\\.')
                        .replace(/\^/g, '\\^')
                        .replace(/\$/g, '\\$');

                    $(valueFind).html($(valueFind).html().replace(new RegExp(term, 'ig'), '<span class="h_i_g_h">$&</span>')); // выделяем найденные фрагменты

                });
            }
        }

        $('#modal-identify .modal-header [data-id="name"]').on('mouseup', function(){
            findSelect();
        }).on('dblclick', function(){
            findSelect();
        });

        function setIdentify(element) {
            element.click(function (e) {
                e.preventDefault();

                var index = $(this).data('index');
                var article = $(this).data('article');
                var sku = $(this).data('sku');
                var productURL = $(this).closest('.row').find('[data-id="name"]').attr('href');

                jQuery.ajax({
                    url: '/smg/kaspi/set_map_product',
                    data: ({
                        'page': (index),
                        'article': (article),
                        'sku': (sku),
                        'product_url': (productURL),
                        'shop_company_id': (1),
                        'params': ('<?php
                            $params = $_GET;
                            $params['shop_branch_id'] = $siteData->shopID;

                            unset($params['page']);
                            unset($params['limit']);
                            unset($params['limit_page']);

                            echo URL::query($params, false);
                            ?>'),
                    }),
                    type: "POST",
                    success: function (data) {
                        $('tr[data-article="' + article + '"][data-action="identify"]').remove();

                        if (data == '') {
                            $('#modal-identify').modal('hide');
                        } else {
                            html = $(data);
                            html.dblclick(identify);

                            $('#list').append(html);
                            html.trigger('dblclick');
                        }
                    },
                    error: function (data) {
                    }
                });
            });
        }

        $('[data-action="not-identify"]').click(function (e) {
            e.preventDefault();

            var index = $(this).data('index');
            var article = $(this).data('article');

            jQuery.ajax({
                url: '/smg/kaspi/set_found',
                data: ({
                    'page': (index),
                    'article': (article),
                    'shop_company_id': (1),
                    'params': ('<?php
                        $params = $_GET;
                        $params['shop_branch_id'] = $siteData->shopID;

                        unset($params['page']);
                        unset($params['limit']);
                        unset($params['limit_page']);

                        echo URL::query($params, false);
                        ?>'),
                }),
                type: "POST",
                success: function (data) {
                    $('tr[data-article="' + article + '"][data-action="identify"]').remove();

                    html = $(data);
                    html.dblclick(identify);

                    $('#list').append(html);
                    html.trigger('dblclick');
                },
                error: function (data) {
                }
            });
        });

        $('[data-action="next-identify"]').click(function (e) {
            e.preventDefault();

            var index = $(this).data('index');
            var article = $(this).data('article');

            jQuery.ajax({
                url: '/smg/kaspi/next_product',
                data: ({
                    'page': (index),
                    'article': (article),
                    'shop_company_id': (1),
                    'params': ('<?php
                        $params = $_GET;
                        $params['shop_branch_id'] = $siteData->shopID;

                        unset($params['page']);
                        unset($params['limit']);
                        unset($params['limit_page']);

                        echo URL::query($params, false);
                        ?>'),
                }),
                type: "POST",
                success: function (data) {
                    html = $(data);
                    html.dblclick(identify);

                    $('#list').append(html);
                    html.trigger('dblclick');
                },
                error: function (data) {
                }
            });
        });
    });
</script>
<div id="new" style="display: none">
    <div class="row" style="border-bottom: 1px solid #e5e5e5; padding-bottom: 10px">
        <div class="col-md-5">
            <div class="content">
                <div class="content-thumb" style="width: 100px; text-align: center">
                    <img style="max-height: 83px; width: auto;" data-id="img" src="/img/file-not-found/file_not_found-100x100.png" class="img-responsive">
                </div>
                <div class="content-info">
                    <p>
                        <a data-id="name" target="_blank" href="#"><strong>Excepteur sint occaecat cupidatat</strong></a>
                    </p>
                    <button data-index="" data-article="" data-sku="" data-action="set-identify" type="button" class="btn bg-orange btn-flat" style="margin-top: 5px">Соединить</button>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <p data-id="info"></p>
        </div>
    </div>
</div>
<style>
    .h_i_g_h {
        background-color: #C6D9DB;
        cursor: pointer;
    }
    .modal .content {
        margin-top: 20px;
    }
    .modal .content a {
        color: #428bca;
    }
    .modal .content a:hover {
        text-decoration: underline;
    }
    .modal .content .content-thumb {
        float: left;
        margin-right: 10px;
    }
    .modal .content .content-thumb img {
        width: 100px;
        display: inline-block;
    }
    .modal .content .content-thumb-large {
        float: left;
    }
    .modal .content .content-thumb-large img {
        width: 180px;
        display: inline-block;
        margin-right: 10px;
    }
    .modal .content .content-info {
        overflow: hidden;
        zoom: 1;
    }
</style>
