<section class="content-header">
    <h1>
        <?php
        switch(Request_RequestParams::getParamInt('table_id')){
            case Model_Shop_Good::TABLE_ID:
                $title = 'Вид товаров / услуг';
                break;
            case Model_Shop_New::TABLE_ID:
                $title = 'Вид статей / новостей';
                break;
            case Model_Shop_File::TABLE_ID:
                $title = 'Вид файлов / документов';
                break;
            case Model_Shop_Gallery::TABLE_ID:
                $title = 'Вид галерей';
                break;
            case Model_Shop_Bill::TABLE_ID:
                $title = 'Вид заказов';
                break;
            case Model_Shop_Client::TABLE_ID:
                $title = 'Вид клиентов';
                break;
            case Model_Shop_Comment::TABLE_ID:
                $title = 'Вид комментариев';
                break;
            case Model_Shop_Coupon::TABLE_ID:
                $title = 'Вид купонов';
                break;
            case Model_Shop_Message::TABLE_ID:
                $title = 'Вид сообщений';
                break;
            case Model_Shop_Operation::TABLE_ID:
                $title = 'Вид операторов';
                break;
            case Model_Shop_Question::TABLE_ID:
                $title = 'Вид вопросов / ответов';
                break;
            case Model_Shop_Subscribe::TABLE_ID:
                $title = 'Вид рассылок';
                break;
            case Model_Shop::TABLE_ID:
                $title = 'Вид филиалов';
                break;
            case Model_Shop_Client::TABLE_ID:
                $title = 'Вид клиентов';
                break;
            default:
                $title = '';
        }
        echo $title;
        ?>
        <small style="margin-right: 10px;">редактирование</small>
        <?php echo trim($siteData->globalDatas['view::language/list/translate']); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Func::getFullURL($siteData, '/shop/edit'); ?>"><i class="fa fa-dashboard"></i> Главная</a></li>
        <?php if($siteData->branchID){ ?>
            <li><a href="<?php echo Func::getFullURL($siteData, '/shop/edit', array('type' => 'shop_root_table_catalog_id', 'is_group' => 'is_group'), array('is_edit' => 1)); ?>"> <b><?php echo Func::trimTextNew($siteData->branch->getName(), 20); ?></b></a></li>
        <?php } ?>
        <li><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoptablecatalog/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-dashboard"></i> <?php echo $title; ?> каталог</a></li>
        <li class="active"><?php echo $title; ?></li>
    </ol>
</section>
<section class="content padding-5">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary padding-t-5">
                <div class="box-body pad table-responsive">
                    <form enctype="multipart/form-data" action="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoptablecatalog/save" method="post" style="padding-right: 5px;">
                        <?php echo trim($data['view::_shop/_table/catalog/one/edit']); ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>