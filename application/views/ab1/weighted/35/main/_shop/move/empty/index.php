<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/weighted/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <div class="tab-pane active">
                <?php $siteData->titleTop = 'Пустые машины'; ?>
                <?php
                $view = View::factory('ab1/weighted/35/main/_shop/move/empty/filter');
                $view->siteData = $siteData;
                $view->data = $data;
                echo Helpers_View::viewToStr($view);
                ?>
            </div>
            <div class="nav-tabs-custom" style="margin-bottom: 0px;">
                <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
                    <li class="<?php if(Arr::path($siteData->urlParams, 'is_delete', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopmoveempty/index', array(), array('is_delete' => 1, 'is_public_ignore' => 1));?>" data-id="is_delete_public_ignore">Удаленные</a></li>
                    <li class="<?php if((Arr::path($siteData->urlParams, 'is_delete', '') != 1) && (Arr::path($siteData->urlParams, 'is_not_public', '') != 1) && (Arr::path($siteData->urlParams, 'is_public', '') != 1)){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopmoveempty/index', array(), array('is_public_ignore' => 1));?>"  data-id="is_public_ignore">Все <i class="fa fa-fw fa-info text-blue"></i></a></li>
                    <li class="pull-left header">
                        <a data-action="new-auto" href="<?php echo Func::getFullURL($siteData, '/shopmoveempty/new', array());?>" class="btn bg-purple btn-flat">
                            <i class="fa fa-fw fa-plus"></i>
                            Добавить
                        </a>
                    </li>
                </ul>
            </div>
            <div class="body-table">
                <div class="box-body table-responsive" style="padding-top: 0px;">
                    <?php echo trim($data['view::_shop/move/empty/list/index']); ?>
                </div>
            </div>
        </div>
	</div>
</div>
<script>
    function PrintTTN(id, pages) {
        jQuery.ajax({
            url: '/weighted/data/save',
            data: ({
                'action': ('print'),
                'type': ('ttn_material'),
                'table_id': ('<?php echo Model_Ab1_Shop_Move_Empty::TABLE_ID; ?>'),
                'pages': (pages),
                'id': (id)
            }),
            type: "GET",
            success: function (dataBrutto) {
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    }

    function PrintTalon(id) {
        jQuery.ajax({
            url: '/weighted/data/save',
            data: ({
                'action': ('print'),
                'type': ('talon'),
                'table_id': ('<?php echo Model_Ab1_Shop_Move_Empty::TABLE_ID; ?>'),
                'id': (id)
            }),
            type: "GET",
            success: function (dataBrutto) {
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    }

    $('[data-action="new-auto"]').click(function() {
        jQuery.ajax({
            url: '/weighted/data/get',
            data: ({}),
            type: "GET",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));
                window.location.href = ('<?php echo Func::getFullURL($siteData, '/shopmoveempty/new', array());?>'+'?number='+obj.number+'&weight='+obj.weight);
            },
            error: function (data) {
                console.log(data.responseText);
                alert('Ошибка запроса веса и номера машины.');
            }
        });

        return false;
    });
    $('[data-action="clone-auto"]').click(function() {
        url = $(this).attr('href');
        jQuery.ajax({
            url: '/weighted/data/get',
            data: ({}),
            type: "GET",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));
                window.location.href = (url+'&number='+obj.number+'&weight='+obj.weight);
            },
            error: function (data) {
                console.log(data.responseText);
                alert('Ошибка запроса веса и номера машины.');
            }
        });

        return false;
    });

    $(document).ready(function () {
        $('#find_number').keyup(function (e) {
            $('tr[data-name]').removeClass('tr-select');

            var number = $(this).val().toUpperCase();
            if (number != '') {
                trs = $('tr[data-name*="' + number + '"]');
                if (trs.length > 0) {
                    trs.addClass('tr-select');

                    if (e.keyCode == 13) {
                        $('html, body').animate({scrollTop: trs.children(0).offset().top}, 500);
                    }
                }
            }
        })
    });
</script>