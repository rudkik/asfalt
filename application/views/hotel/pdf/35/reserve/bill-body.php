<table>
    <tr>
        <td>ПОДТВЕРЖДЕНИЕ БРОНИ</td>
        <td style="text-align: right"><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($bill['created_at']); ?></td>
    </tr>
</table>
<p style="text-align: justify">Уважаемый Гость! Вы успешно забронировали номер(а) на базе отдыха «Кара Дала». Пожалуйста, назовите Ваш <b>код брони</b> при заселении в номер. Заселение осуществляется только после полной оплаты номера(ов).</p>
<table border="1" cellpadding="5">
    <tr>
        <td>Пожалуйста, сообщите заранее, если Вам нужен СЧЕТ-ФАКТУРА! В противном случае, мы не сможем Вам его предоставить.</td>
    </tr>
</table>
<p><b>ВАШ КОД БРОНИ:</b> <b style="font-size: 20px"><?php echo $bill['id']; ?></b></p>
<table style="font-weight: bold">
    <tr>
        <td style="width:30%">Гость:</td>
        <td style="width:70%"><?php echo Arr::path($bill, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_client_id.name', ''); ?></td>
    </tr>
    <tr>
        <td style="width:30%">Дата заезда:</td>
        <td style="width:70%"><?php echo Helpers_DateTime::getDateFormatRus($bill['date_from']); ?></td>
    </tr>
    <tr>
        <td style="width:30%">Дата отъезда:</td>
        <td style="width:70%"><?php echo Helpers_DateTime::getDateFormatRus($bill['date_to']); ?></td>
    </tr>
    <tr>
        <td style="width:30%">Количество суток:</td>
        <td style="width:70%"><?php echo Helpers_DateTime::diffDays($bill['date_to'], $bill['date_from']); ?></td>
    </tr>
    <tr>
        <td style="width:30%">Номер(а):</td>
        <td style="width:70%"><?php echo $rooms; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Сумма заказа:</td>
        <td style="width:70%"><?php echo Func::getNumberStr($bill['amount'], TRUE, 0); ?> тенге</td>
    </tr>
    <tr>
        <td style="width:30%">Оплачено:</td>
        <td style="width:70%"><?php echo $bill['paid_amount']; ?> тенге</td>
    </tr>
    <tr>
        <td style="width:30%">К оплате:</td>
        <td style="width:70%"><?php echo Func::getNumberStr($bill['amount'] - $bill['paid_amount'], TRUE, 0); ?> тенге</td>
    </tr>
</table>
<p><b>РЕЖИМ РАБОТЫ КАРА ДАЛЫ</b></p>
<p><b>РАСЧЕТНЫЙ ЧАС:</b> заезд в 15.00, выезд в 12.00 следующего дня. Часы работы:</p>
<table border="1" cellpadding="5">
    <tr>
        <td style="width:35%">Бассейны</td>
        <td style="width:65%">с 8.00 до 24.00  (четверг и пятница – санитарные дни, когда по очереди спускаются все семь бассейнов. В эти дни гости могут купаться в 3 из 7 бассейнах в обычном режиме).</td>
    </tr>
    <tr>
        <td style="width:35%">Домашняя кухня (заказы по меню принимаются заранее по телефонам: +7 702 431 21 35 и +7 707 910 80 79)</td>
        <td style="width:65%">
			<table border="0" cellpadding="2">
				<tr>
					<td style="width: 70px">Завтрак</td>
					<td>08.30 - 10.30</td>
				</tr>
				<tr>
					<td style="width: 70px">Обед</td>
					<td>12.00 - 15.00</td>
				</tr>
				<tr>
					<td style="width: 70px">Ужин</td>
					<td>18.00 - 21.00</td>
				</tr>
			</table>
		</td>
    </tr>
    <tr>
        <td style="width:35%">Магазин</td>
        <td style="width:65%">с 9.00 до 21.00</td>
    </tr>
    <tr>
        <td style="width:35%">Мангалы</td>
        <td style="width:65%">с 9.00 до 24.00</td>
    </tr>
</table>
<p>Уважаемый Гость, оплачивая бронь номера(ов), Вы соглашаетесь с <b>Правилами обслуживания и размещения гостей на базе отдыха «Кара Дала»</b>, которые опубликованы на сайте <a href="http://karadala.kz">www.karadala.kz</a>.</p>
<table border="1" cellpadding="5">
    <tr>
        <td><b>ВАЖНО!</b> Бесплатно изменить/отменить бронь можно при условии наличия номеров, запрашиваемых на новые даты, только если Вы обратились в срок не позднее 72-х часов до времени заезда по брони. Если бронь была оплачена полностью или частично, то сумма полученной оплаты будет возвращена гостю или станет оплатой новой брони на новые даты/номера.<br>   
Если Вы обратились с просьбой изменить/отменить бронь позже срока, установленного для бесплатного изменения брони (72 часа до времени заезда по брони), то бронь может быть изменена или отменена, но с удержанием штрафа в размере 20% от стоимости заказа. 
Пожалуйста, сохраняйте квитанции или подтверждение брони!
</td>
    </tr>
</table>
<table border="1" cellpadding="5">
    <tr>
        <td style="width: 50%">
            <ul>
				<li>Соблюдайте режим купания в термальной воде.</li>
				<li>Вы несете ответственность за свое здоровье, при необходимости проконсультируйтесь с врачом! Имейте при себе свои лекарства!</li>
                <li>Не оставляйте детей без присмотра, у нас 7 <i>(семь)</i> бассейнов!</li>
            </ul>
        </td>
        <td style="width: 50%">
            <ul>                
				<li>Пожалуйста, убирайте за собой мусор.</li>
                <li>Принимайте пищу в столовой.</li>
                <li>Курите только в отведенном для этого месте!</li>
                <li>Не злоупотребляйте алкоголем!</li>
                <li>Штраф за порчу имущества оплачивается, согласно прайс-листа.</li>
                <li>У нас отдых без животных.</li>
            </ul>
        </td>
    </tr>
</table>
<table><tr><td style="text-align: center">ПРИЯТНОГО ОТДЫХА!</td></tr></table>