<link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/base/lease.css">
<style>
    body {
        background-repeat:no-repeat;
        -webkit-background-size: 100%;
        background-size: 100%;
        background-position: right top;
        background-image: url('<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/page/bg.jpg');
    }
    @media screen and (max-width: 767px) {
        body {
            background-size: 140% auto;
            -webkit-background-size: 140% auto;
        }
    }
</style>
<main class="lease">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h3 class="main__page__news__title section_title">Условия аренды</h3>
			</div>
		</div>
		<div class="row lease__wrap no-gutters">
			<div class="col-12 col-lg-4">
				<div class="lease__conditions">
					<header class="lease__conditions__header">
						Расчет ежемесячной оплаты
					</header>
					<div class="lease__conditions__body">
						Используйте наш калькулятор, чтобы рассчитать приблизительную сумму платежей за Ваш предмет аренды.
						<br>
						Размер фактического платежа может меняться в зависимости от различных других параметров. Данные расчёты помогут Вам для определения приблизительной суммы платежей
					</div>
					<span class="btn">
						<a href="#" download>
							Скачать договор аренды
						</a>
					</span>
				</div>
			</div>
			<div class="col-12 col-lg-5">
				<div class="lease__calc">
					<button class="lease__calc__select btn" id="lease_select">
						<span class="lease__calc__select__preview">
							Выберете модель
						</span>
						<ul class="lease__calc__select__list">
							<?php echo trim($siteData->globalDatas['view::View_Shop_Goods\lease-produktciya']); ?>
						</ul>
					</button>
					<div class="lease__calc__price">
						Стоимость: <span id="lease_price" class="lease__calc__price__value lease_price">0 тг.</span>
					</div>
					<div class="lease__calc__block">
						<div class="lease__calc__block__wrap">
							<label class="lease__calc__block__label" for="lease_date">Срок аренды: 
								<span id="lease_date_text" class="lease__calc__block__label__bold lease_price"></span>
							</label>
							<input type="range"  id="lease_date" class="lease__calc__block__input" min="0" max="0" step="1">
							<div id="lease_date_post" class="lease__calc__block__postinput">
							</div>
							<style class="lease_calc_style"></style>
						</div>
						<div class="lease__calc__block__wrap">
							<label class="lease__calc__block__label" for="lease_first_installment">Первоначальный взнос: 
								<span id="lease_first_installment_text" class="lease__calc__block__label__bold lease_price"></span>
							</label>
							<input id="lease_first_installment" type="range" class="lease__calc__block__input" min="0" max="0" step="1">
							<div id="lease_first_installment_post" class="lease__calc__block__postinput"></div>
							<style class="lease_calc_style"></style>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 col-lg-3 align-self-end">
				<div class="lease__subtotal">
					<div class="lease__subtotal__block">
						<span class="lease__subtotal__title">
							Первоначальный взнос:
						</span>
						<span id="lease_subtotal_first" class="lease_price lease__subtotal__price">123</span>
					</div>
					<div class="lease__subtotal__block">
						<span class="lease__subtotal__title">
							Ежемесячный платеж:
						</span>
						<span id="lease_subtotal_mount" class="lease_price lease__subtotal__price">124124</span>
					</div>
					<div class="lease__subtotal__block">
						<span class="lease__subtotal__title">
							Общая сумма договора:
						</span>
						<span id="lease_subtotal_total" class="lease_price lease__subtotal__price">123123 123213 123</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/lease.js" defer></script>
<script>
	var appStart = function () {
		if (typeof window.App === 'undefined') {
			setTimeout(appStart, 100)
		} else {
			var app = new App.Lease()
		}
	}
	appStart()
</script>