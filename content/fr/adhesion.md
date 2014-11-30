/*
Title: COIN: Adhesion
Description: 
*/
<div id="leftcontent" markdown=1>
## Formulaire d'adhesion
					<form action="https://www.paypal.com/cgi-bin/webscr" onsubmit="return validateForm()" method="post" name="myPayPal">
						<input type="hidden" name="cmd" value="_xclick">
						<input type="hidden" name="business" value="web-account@extra-coin.fr">
						<input type="hidden" name="lc" value="FR">
						<input type="hidden" name="item_name" value="Cotisation annuelle COIN">
						<input type="hidden" name="button_subtype" value="services">
						<input type="hidden" name="no_note" value="0">
						<input type="hidden" name="currency_code" value="EUR">
						<input type="hidden" name="tax_rate" value="0.000">
						<input type="hidden" name="shipping" value="0.00">
						<input type="hidden" name="notify_url" value="http://extra-coin.fr/ipn.php">
						<input type="hidden" name="bn" value="PP-BuyNowBF:btn_paynowCC_LG.gif:NonHostedGuest">
						<table>
						<tr><td><input type="hidden" name="on0" value="Type d'adhesion">Type d'adhesion</td></tr><tr><td><select name="os0" onchange="onTypeAdhesionChange()">
							<option value="Normale">Normale €25.00 EUR</option>
							<option value="Etudiant ou demandeur d'emploi">Etudiant ou demandeur d'emploi €15.00 EUR</option>
							<option value="Bienfaiteur">Bienfaiteur €100.00 EUR</option>
							<option value="Personne morale">Personne morale €150.00 EUR</option>
						</select><br /><br /></td></tr>
						</table>
						<div id="bienDiv" style="display:none;">
						<p>Les membres bienfaiteurs sont des membres comme les autres. En choisissant ce type de cotisation, vous nous aidez à faire de COIN un réseau plus solide.</p>
						</div>
						<div id="adminDiv" style="display:none;">
						<p>Une adhésion en tant que personne morale donne la qualité de membre à un maximum de 10 de vos employés. Les informations détaillées vous seront transmises par e-mail à validation de la cotisation.</p>
						<p>Adhérer en tant que personne morale n'est pas considéré comme un sponsoring.</p>
						<table>
						<tr><td><input type="hidden" name="on5" value="Raison sociale">Raison sociale :</td></tr><tr><td><input type="text" name="os5" maxlength="200" size="44"></td></tr>
						<tr><td>Adresse :</td></tr><tr><td><input type="text" name="address1" maxlength="200" size="44"></td></tr>
						<tr><td>Complément d'adresse :</td></tr><tr><td><input type="text" name="address2" maxlength="200" size="44"></td></tr>
						<tr><td>Code postal :</td></tr><tr><td><input type="text" name="zip" maxlength="200" size="44"></td></tr>
						<tr><td>Ville :</td></tr><tr><td><input type="text" name="city" maxlength="200" size="44"><br /><br /></td></tr>
						<tr><td><b>Contact administratif :</b></td></tr>
						</table>						
						</div>
						<table>
						<tr><td><input type="hidden" name="on1" value="Nom">Nom :</td></tr><tr><td><input type="text" name="os1" maxlength="200" size="44"></td></tr>
						<tr><td><input type="hidden" name="on2" value="Prénom">Prénom :</td></tr><tr><td><input type="text" name="os2" maxlength="200" size="44"></td></tr>
						<tr><td><input type="hidden" name="on3" value="E-mail">E-mail :</td></tr><tr><td><input type="text" name="os3" maxlength="200" size="44"></td></tr>
						<tr><td><br /><input type="hidden" name="on4" value="Numéro adhérent">Vous renouvellez votre adhésion ? Spécifiez votre numéro d'adhérent :</td></tr><tr><td><input type="text" name="os4" maxlength="200"> (optionnel)<br /><br /></td></tr>
						</table>

						<input type="hidden" name="currency_code" value="EUR">
						<input type="hidden" name="option_select0" value="Normale">
						<input type="hidden" name="option_amount0" value="25.00">
						<input type="hidden" name="option_select1" value="Etudiant ou demandeur d'emploi">
						<input type="hidden" name="option_amount1" value="15.00">
						<input type="hidden" name="option_select2" value="Bienfaiteur">
						<input type="hidden" name="option_amount2" value="100.00">
						<input type="hidden" name="option_select3" value="Personne morale">
						<input type="hidden" name="option_amount3" value="150.00">
						<input type="hidden" name="option_index" value="0">
						<input type="image" src="https://www.paypalobjects.com/fr_FR/FR/i/btn/btn_paynowCC_LG.gif" border="0" name="submit" alt="PayPal - la solution de paiement en ligne la plus simple et la plus sécurisée !">
						<img alt="" border="0" src="https://www.paypalobjects.com/fr_XC/i/scr/pixel.gif" width="1" height="1">
						<br />En toute sécurité via Paypal
					</form>
</div><div id="rightcontent" markdown=1>
## Quels avantages pour nos adherents ?

Nos adhérents bénéficient de la gratuité de nos séminaires et d'un accès privilégié à nos conseils en matière d'orientation et d'entreprenariat.

Nous proposons également des avantages lors de certains événements, tel que lors du Global Game Jam.
Comment adherer au COIN ?

Pour adhérer au COIN, le moyen le plus simple est le formulaire ci-contre. Il est entièrement automatique et vous recevrez un e-mail d'information après complétion.
Ce formulaire vous redirigera vers Paypal qui vous permettra de régler votre cotisation par Carte Bancaire ou un compte Paypal en toute sécurité.

Il est également possible d'adhérer au COIN durant nos séminaires et certains de nos événements.

Vous avez des difficultés à vous inscrire en ligne ? N'hésitez pas à <a href="mailto:contact@extra-coin.fr" rel="nofollow" onclick="this.href='mailto:' + 'contact' + '@' + 'extra-coin.fr'">nous contacter</a>.


## Faire un don

Vous souhaitez encourager notre activité ? Un don peut nous aider à proposer de meilleurs services à nos membres et organiser de meilleurs événements.
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
					<input type="hidden" name="cmd" value="_donations">
					<input type="hidden" name="business" value="web-account@extra-coin.fr">
					<input type="hidden" name="lc" value="FR">
					<input type="hidden" name="item_name" value="Don">
					<input type="hidden" name="no_note" value="0">
					<input type="hidden" name="currency_code" value="EUR">
					<input type="hidden" name="notify_url" value="http://extra-coin.fr/ipn.php">
					<input type="hidden" name="bn" value="PP-DonationsBF:btn_donate_SM.gif:NonHostedGuest">
					<input type="image" src="https://www.paypalobjects.com/fr_FR/FR/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - la solution de paiement en ligne la plus simple et la plus sécurisée !">
					<img alt="" border="0" src="https://www.paypalobjects.com/fr_FR/i/scr/pixel.gif" width="1" height="1">
					</form>
</div>


