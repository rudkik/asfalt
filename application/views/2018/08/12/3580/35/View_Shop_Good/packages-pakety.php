<div class="listar-pricingplan">
    <div class="listar-pricingplanhead">
        <h2><?php echo Arr::path($data->values['options'], 'title', '');?></h2>
    </div>
    <div class="listar-pricingplanbody">
        <h3><?php echo Func::getNumberStr($data->values['price'], TRUE, 0);?> <sup>тг</sup></h3>
        <h4><?php echo Arr::path($data->values['options'], 'period', '');?></h4>
        <ul>
            <?php if($data->values['shop_table_rubric_id'] == 4570){?>
            <li>
                <i class="icon-checkmark"></i>
                <span>Ведение первичных документов</span>
            </li>
            <li>
                <i class="icon-checkmark"></i>
                <span>Учет договоров</span>
            </li>

            <li>
                <i class="icon-checkmark"></i>
                <span>Платежные поручения по налогам и отчислениям</span>
            </li>
            <li>
                <i class="icon-checkmark"></i>
                <span>Платежные поручения оплаты поставщикам и подрядчикам</span>
            </li>
            <li>
                <i class="icon-checkmark"></i>
                <span>Учет наличных денежных средств (касса)</span>
            </li>
            <li>
                <i class="icon-checkmark"></i>
                <span>Учет доходов и расходов</span>
            </li>
            <li>
                <i class="icon-checkmark"></i>
                <span>Учет склада</span>
            </li>
            <li>
                <i class="icon-checkmark"></i>
                <span>Учет сотрудников (отдел кадров)</span>
            </li>
            <li>
                <i class="icon-checkmark"></i>
                <span>Калькулятор заработных плат + автоматический расчет налогов по зарплате</span>
            </li>
            <li>
                <i class="icon-checkmark"></i>
                <span>Автоматическое заполнение и сдача (в один клик прямо из личного кабинет) ФНО 910, 200, 300</span>
            </li>
            <li>
                <i class="icon-checkmark"></i>
                <span>Налоговый календарь</span>
            </li>
            <li>
                <i class="icon-checkmark"></i>
                <span>Бесплатные онлайн-консультации экспертов</span>
            </li>
            <?php }else{?>
            <li>
                <i class="icon-checkmark"></i>
                <span>Ведение первичных документов</span>
            </li>
            <li>
                <i class="icon-checkmark"></i>
                <span>Учет договоров</span>
            </li>
            <li>
                <i class="icon-checkmark"></i>
                <span>Учет доходов и расходов</span>
            </li>
            <li>
                <i class="icon-checkmark"></i>
                <span>Учет склада</span>
            </li>
            <li>
                <i class="icon-checkmark"></i>
                <span>Налоговый календарь</span>
            </li>
            <li>
                <i class="icon-checkmark"></i>
                <span>Бесплатные онлайн-консультации экспертов</span>
            </li>
            <?php }?>
        </ul>
    </div>
    <div class="listar-pricingplanfoot">
        <a class="listar-btn listar-btngreen" href="<?php echo $siteData->urlBasic; ?>/client/register">Подключить</a>
    </div>
</div>