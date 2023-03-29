<table>
    <tr>
        <td>Booking Confirmation</td>
        <td style="text-align: right"><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($bill['created_at']); ?></td>
    </tr>
</table>
<p style="text-align: center">Dear Guest!</p>
<p style="text-align: justify">Your have successfully booked a room(s) at Kara Dala Hot Springs Resort. Please quote your Booking Code for check-in and any other correspondence with us. The full payment is required at check-in. Payments are accepted in tenge, by cash or bank card.</p>
<p style="text-align: justify">If you change/cancel your booking 72 hours before your check-in time and later, charges of 20% of the total sum will be applied. Otherwise, cancellation and changes could be made for free.</p>
<p><b>Your Booking Code:</b> <b style="font-size: 20px"><?php echo $bill['id']; ?></b></p>
<table style="font-weight: bold">
    <tr>
        <td style="width:30%">Guest:</td>
        <td style="width:70%"><?php echo Arr::path($bill, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_client_id.name', ''); ?></td>
    </tr>
    <tr>
        <td style="width:30%">Check-in Date:</td>
        <td style="width:70%"><?php echo Helpers_DateTime::getDateFormatRus($bill['date_from']); ?></td>
    </tr>
    <tr>
        <td style="width:30%">Check-out Date:</td>
        <td style="width:70%"><?php echo Helpers_DateTime::getDateFormatRus($bill['date_to']); ?></td>
    </tr>
    <tr>
        <td style="width:30%">Number of nights:</td>
        <td style="width:70%"><?php echo Helpers_DateTime::diffDays($bill['date_to'], $bill['date_from']); ?></td>
    </tr>
    <tr>
        <td style="width:30%">Room(s):</td>
        <td style="width:70%"><?php echo $rooms; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Total:</td>
        <td style="width:70%"><?php echo Func::getNumberStr($bill['amount'], TRUE, 0); ?> тенге</td>
    </tr>
    <tr>
        <td style="width:30%">Paid:</td>
        <td style="width:70%"><?php echo $bill['paid_amount']; ?> тенге</td>
    </tr>
    <tr>
        <td style="width:30%">Due:</td>
        <td style="width:70%"><?php echo Func::getNumberStr($bill['amount'] - $bill['paid_amount'], TRUE, 0); ?> тенге</td>
    </tr>
</table>
<p><b>Please note our check in time is at 3.00pm, and check out - at 12.00 am.</b></p>
<p style="text-align: center"><b>Our Working Hours</b></p>
<table border="1" cellpadding="5">
    <tr>
        <td style="width:35%">Pools</td>
        <td style="width:65%">from 8 am till midnight (Thursday and Friday: cleaning days, i.e. we close three of seven pools each day for cleaning, other pools are opened as usual)</td>
    </tr>
    <tr>
        <td style="width:35%">Домашняя кухня (заказы по меню принимаются заранее по телефонам: +7 702 431 21 35 и +7 707 910 80 79)</td>
        <td style="width:65%">
			<table border="0" cellpadding="2">
				<tr>
					<td style="width: 70px">Breakfast </td>
					<td>from 8.30 am till 10.30 am</td>
				</tr>
				<tr>
					<td style="width: 70px">Lunch </td>
					<td>from 12.00 am till 3 pm</td>
				</tr>
				<tr>
					<td style="width: 70px">Dinner </td>
					<td>from 6 pm till 9 pm</td>
				</tr>
			</table>
		</td>
    </tr>
    <tr>
        <td style="width:35%">Shop</td>
        <td style="width:65%">from 9 am till 9pm</td>
    </tr>
    <tr>
        <td style="width:35%">Barbeque Corner</td>
        <td style="width:65%">from 9 am till midnight</td>
    </tr>
</table>
<p><b>Kara Dala Hot Springs Resort Rules.</b></p>

<table border="1" cellpadding="5">
    <tr>
        <td style="width: 50%">
            <ul>
				<li>Please for your own safety observe a bathing etiquette in thermal pools.</li>
				<li>You are responsible for your health, if needed, please consult your doctor! Take your medicine with you.</li>
                <li>Do not leave your children unattended at any times. We have 7 pools!</li>
            </ul>
        </td>
        <td style="width: 50%">
            <ul>                
				<li>Please keep all our areas clean.</li>
                <li>Please do not drink alcohol in public places.</li>
                <li>Smoking is not allowed except in dedicated places with a Smoking Area sign.</li>
                <li>There is a penalty for damaging resort property.</li>
                <li>Pets are not allowed.</li>
            </ul>
        </td>
    </tr>
</table>
<table><tr><td style="text-align: center">Thank you for choosing Kara Dala Resort and we wish you a pleasant stay!</td></tr></table>