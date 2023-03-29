<div class="body-find-partner">
    <div class="container">
        <div class="row">
            <div class="col-md-9 margin-bottom-10px">
                <form method="get" class="row">
                    <input name="id" value="<?php echo Request_RequestParams::getParamInt('id'); ?>" hidden>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Название товара</label>
                            <input name="name" placeholder="Введите название товара" class="form-control" type="text" value="<?php echo htmlspecialchars(Request_RequestParams::getParamStr('name'), ENT_QUOTES); ?>">
                        </div>
                        <div class="form-group">
                            <label>Категория</label>
                            <select class="form-control select2" name="shop_table_rubric_id" style="width: 100%;">
                                <option value="-1" data-id="-1">Выберите категорию</option>
                                <option value="0" data-id="-1">Без категории</option>
                                <?php
                                $tmp = 'data-id="'.Request_RequestParams::getParamInt('shop_table_rubric_id').'"';
                                echo str_replace($tmp, $tmp.' selected', trim($siteData->replaceDatas['view::shopgoodcatalogs/list']));
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row checkbox-bock">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>
                                        <input name="is_discount" value="1" data-id="1" type="checkbox" class="minimal" <?php if(Request_RequestParams::getParamBoolean('is_discount')){ echo 'checked';} ?>>
                                        Скидки
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>
                                        <input name="good_select_type_id" value="3723" data-id="3723" type="checkbox" class="minimal" <?php if(Request_RequestParams::getParamInt('good_select_type_id') == 3723){ echo 'checked';} ?>>
                                        Новинки
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="btn-clear">
                                    <a href="/customer/shopbranch/edit?id=<?php echo Request_RequestParams::getParamInt('id'); ?>" class="btn btn-success" style="margin-right: 5px;">Очистить</a>
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-search"></i> Поиск</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-3">
                <div class="cart">
                    <?php if($siteData->shop->getIsActive() &&  $siteData->shop->getIsPublic()){ ?>
                        <a href="/customer/shopcart/index"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/cart-goods.png" class="img img-responsive"></a>
                        <div class="cart-title">
                            <a href="/customer/shopcart/index"><i class="fa fa-fw fa-shopping-cart"></i></a>
                            <a class="text-red" href="/customer/shopcart/index">Товаров : <span class="cart-count"><?php echo $siteData->globalDatas['view::cart_count']; ?> шт.</span> (<span class="cart-price"><?php echo $siteData->globalDatas['view::cart_amount_str']; ?></span>)</a>
                        </div>
                    <?php }else{ ?>
                        <label class="text-red">Ваш аккаунт не активирован</label>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/select2/select2.min.css">
<link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/iCheck/all.css">

<link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/dist/css/base.min.css">
<script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/iCheck/icheck.min.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/select2/select2.full.min.js"></script>
<script>
    $(function () {
        $(".select2").select2();

        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });
    });
</script>
<div class="body-partner-goods">
    <div class="container">
        <?php echo trim($data['view::shopbranch/edit']); ?>
    </div>
</div>
<!--[if !IE]><!-->
<style>
    @media only screen and (max-width: 720px),(max-device-width: 720px)  {
        .table-column-5 td {
            padding-left: 150px !important;
        }
        .table-column-5 td:nth-of-type(1):before { content: "ID"; }
        .table-column-5 td:nth-of-type(2):before { content: "ФИО"; }
        .table-column-5 td:nth-of-type(3):before { content: "E-mail"; }
        .table-column-5 td:nth-of-type(4):before { content: "Телефон"; }
        .table-column-5 td:nth-of-type(7):before { content: ""; }
    }
</style>
<!--<![endif]-->