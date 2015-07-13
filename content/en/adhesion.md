/*
Title: COIN: Become a member
Description:
*/
<div id="leftcontent" markdown=1>
## Membership Form
					<form action="https://www.paypal.com/cgi-bin/webscr" onsubmit="return validateForm()" method="post" name="myPayPal">
						<input type="hidden" name="cmd" value="_xclick">
						<input type="hidden" name="business" value="web-account@extra-coin.org">
						<input type="hidden" name="lc" value="EN">
						<input type="hidden" name="item_name" value="COIN annual subscription">
						<input type="hidden" name="button_subtype" value="services">
						<input type="hidden" name="no_note" value="0">
						<input type="hidden" name="currency_code" value="EUR">
						<input type="hidden" name="tax_rate" value="0.000">
						<input type="hidden" name="shipping" value="0.00">
						<input type="hidden" name="notify_url" value="http://extra-coin.org/ipn.php">
						<input type="hidden" name="bn" value="PP-BuyNowBF:btn_paynowCC_LG.gif:NonHostedGuest">
						<table>
						<tr><td><input type="hidden" name="on0" value="Type of membership">Type of membership</td></tr><tr><td><select name="os0" onchange="onTypeAdhesionChange()">
							<option value="Normale">Normal €25.00 EUR</option>
							<option value="Student ou unemployed">Student or unemployed €15.00 EUR</option>
							<option value="Benefactor">Benefactor €100.00 EUR</option>
							<option value="Corporation">Corporation €150.00 EUR</option>
						</select><br /><br /></td></tr>
						</table>
						<div id="bienDiv" style="display:none;">
						<p>Benefactors are normal members. With this type of subscription, you will help us to reinforce the COIN network</p>
						</div>
						<div id="adminDiv" style="display:none;">
						<p>A corporation subscription will provide you memberships for max 10 of your employees. The detailed information will be transmitted by e-mail after the validation of the subscription.</p>
						<p>A corporation subscription is not considered as a sponsorship.</p>
						<table>
						<tr><td><input type="hidden" name="on5" value="Company Name">Company Name:</td></tr><tr><td><input type="text" name="os5" maxlength="200" size="44"></td></tr>
						<tr><td>Address:</td></tr><tr><td><input type="text" name="address1" maxlength="200" size="44"></td></tr>
						<tr><td>Additional address:</td></tr><tr><td><input type="text" name="address2" maxlength="200" size="44"></td></tr>
						<tr><td>Postal Code:</td></tr><tr><td><input type="text" name="zip" maxlength="200" size="44"></td></tr>
						<tr><td>City:</td></tr><tr><td><input type="text" name="city" maxlength="200" size="44"><br /><br /></td></tr>
						<tr><td><b>Administrative contact:</b></td></tr>
						</table>
						</div>
						<table>
						<tr><td><input type="hidden" name="on1" value="Nom">Last Name:</td></tr><tr><td><input type="text" name="os1" maxlength="200" size="44"></td></tr>
						<tr><td><input type="hidden" name="on2" value="Prénom">First Name:</td></tr><tr><td><input type="text" name="os2" maxlength="200" size="44"></td></tr>
						<tr><td><input type="hidden" name="on3" value="E-mail">E-mail:</td></tr><tr><td><input type="text" name="os3" maxlength="200" size="44"></td></tr>
						<tr><td><br /><input type="hidden" name="on4" value="Membership Number">Do you want to renew your subscription? Please input your membership number here:</td></tr><tr><td><input type="text" name="os4" maxlength="200"> (optional)<br /><br /></td></tr>
						</table>

						<input type="hidden" name="currency_code" value="EUR">
						<input type="hidden" name="option_select0" value="Normal">
						<input type="hidden" name="option_amount0" value="25.00">
						<input type="hidden" name="option_select1" value="Student or unemployed">
						<input type="hidden" name="option_amount1" value="15.00">
						<input type="hidden" name="option_select2" value="Benefactor">
						<input type="hidden" name="option_amount2" value="100.00">
						<input type="hidden" name="option_select3" value="Corporation">
						<input type="hidden" name="option_amount3" value="150.00">
						<input type="hidden" name="option_index" value="0">
						<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_paynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online">
						<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
						<br />Safely with Paypal
					</form>
</div><div id="rightcontent" markdown=1>
## The benefits for our members

Our seminars are free for our members. You will also have a priviledged access to our advices in terms of professional orientation and entrepreneurship.

We propose also some benefits for our events, such as the Global Game Jam.


## How to become a member?

To become a COIN member, just fill in this form. The process is fully automatic and you will receive an confirmation mail after completion.
This form will redirect you to Paypal, which will enable you to pay safely with a Credit Card or your Paypal account.

It is also possible to become a COIN member during our seminars and some of our events.

Do you have problems registering online? Feel free to <a href="mailto:contact@extra-coin.org" rel="nofollow" onclick="this.href='mailto:' + 'contact' + '@' + 'extra-coin.org'">contact us</a>.


## Donate to COIN

Do you wish to encourage our activities? One donation can help us to propose better services to our members and to organize better events.
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
					<input type="hidden" name="cmd" value="_donations">
					<input type="hidden" name="business" value="web-account@extra-coin.org">
					<input type="hidden" name="lc" value="EN">
					<input type="hidden" name="item_name" value="Donation">
					<input type="hidden" name="no_note" value="0">
					<input type="hidden" name="currency_code" value="EUR">
					<input type="hidden" name="notify_url" value="http://extra-coin.org/ipn.php">
					<input type="hidden" name="bn" value="PP-DonationsBF:btn_donate_SM.gif:NonHostedGuest">
					<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online">
					<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
					</form>
</div>
