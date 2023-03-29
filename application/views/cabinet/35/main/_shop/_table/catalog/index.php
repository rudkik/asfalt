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
		<small style="margin-right: 10px;">каталог</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo Func::getFullURL($siteData, '/shop/edit'); ?>"><i class="fa fa-dashboard"></i> Главная</a></li>
		<?php if($siteData->branchID){ ?>
			<li><a href="<?php echo Func::getFullURL($siteData, '/shop/edit', array('type' => 'shop_root_table_catalog_id', 'is_group' => 'is_group'), array('is_edit' => 1)); ?>"> <b><?php echo Func::trimTextNew($siteData->branch->getName(), 20); ?></b></a></li>
		<?php } ?>
		<li class="active"><?php echo $title; ?></li>
	</ol>
</section>
<section class="content padding-5">
	<div class="row">
		<div class="col-md-12">
			<?php
			$view = View::factory('cabinet/35/main/_shop/_table/catalog/filter');
			$view->siteData = $siteData;
			$view->data = $data;
			echo Helpers_View::viewToStr($view);
			?>
		</div>
		<div class="col-md-12">
            <?php
            $view = View::factory('cabinet/35/_common/tab');
            $view->siteData = $siteData;
            $view->name = 'shop_table_catalog';
            $view->isIndexEdit = FALSE;
            $view->add = 'Добавить';
            $view->params = array(
                'table_id' => 'table_id',
            );
            echo Helpers_View::viewToStr($view);
            ?>
			<div class="box box-primary padding-t-5">
				<div class="box-body table-responsive no-padding">
					<?php echo trim($data['view::_shop/_table/catalog/list/index']); ?>
				</div>
			</div>
		</div>
	</div>
</section>