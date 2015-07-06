<?php
	header('Content-type:text/html; charset=utf-8');
	include_once("paypal_config.php");

	// STEP 1: Read POST data
	 
	// reading posted data from directly from $_POST causes serialization 
	// issues with array data in POST
	// reading raw POST data from input stream instead. 
	$raw_post_data = file_get_contents('php://input');
	$raw_post_array = explode('&', $raw_post_data);
	$myPost = array();
	foreach ($raw_post_array as $keyval) {
		$keyval = explode ('=', $keyval);
		if (count($keyval) == 2)
			$myPost[$keyval[0]] = urldecode($keyval[1]);
	}
	// read the post from PayPal system and add 'cmd'
	$req = 'cmd=_notify-validate';
	if(function_exists('get_magic_quotes_gpc')) {
		$get_magic_quotes_exists = true;
	} 
	$count = 0;
	foreach ($myPost as $key => $value) {        
		if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) { 
			$value = urlencode(stripslashes($value)); 
		} else {
			$value = urlencode($value);
		}
		$req .= "&$key=$value";
		$count++;
	}
	
	if ($count == 0) die ('');
	 
	// STEP 2: Post IPN data back to paypal to validate
	 
	$ch = curl_init('https://'.$paypal_server.'/cgi-bin/webscr');
	curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
	 
	// In wamp like environments that do not come bundled with root authority certificates,
	// please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set the directory path 
	// of the certificate as shown below.
	// curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');
	if( !($res = curl_exec($ch)) ) {
		// error_log("Got " . curl_error($ch) . " when processing IPN data");
		curl_close($ch);
		exit;
	}
	curl_close($ch);
	
	
	// STEP 3: Inspect IPN validation result and act accordingly
	 
	if (strcmp ($res, "VERIFIED") == 0) {
		// check whether the payment_status is Completed
		// check that txn_id has not been previously processed
		// check that receiver_email is your Primary PayPal email
		// check that payment_amount/payment_currency are correct
		// process payment

		// assign posted variables to local variables
	
		$user_type = $_POST['option_selection1'];
		$user_name = $_POST['option_selection2'];
		$user_prename = $_POST['option_selection3'];
		$user_email = $_POST['option_selection4'];
		$user_numAd = $_POST['option_selection5'];
		$payment_amount = $_POST['mc_gross'];	
		$user_raison = $_POST['option_selection6'];
		$user_street = $_POST['address_street'];
		$user_zip = $_POST['address_zip'];
		$user_city = $_POST['address_city'];
		$user_country = $_POST['residence_country'];
		$item_name = $_POST['item_name'];
		$mail_don = $_POST['payer_email'];
		
		if ($item_name == 'Inscription GGJ') {
		
			$con = @mysqli_connect($DBHOST, $DBUSER, $DBPASSWORD, $DBNAME);
			mysqli_query($con,"SET NAMES utf8");
			
			// insert inscription
			$date_simple = date('Y-m-d');
			$date = date('Y-m-d H:i:s');
			$nom = mysqli_real_escape_string ($con, $_POST['option_selection3']);
			$prenom = mysqli_real_escape_string ($con, $_POST['option_selection4']);
			$mail = mysqli_real_escape_string ($con, $_POST['option_selection5']);
			$categ = $_POST['option_selection7'];
			$role = mysqli_real_escape_string ($con, $_POST['option_selection2']);
			$tel = mysqli_real_escape_string ($con, $_POST['option_selection6']);
			$comm = mysqli_real_escape_string ($con, $_POST['custom']);
			$tarif = $_POST['option_selection1'];
			

			
			$sql = "INSERT INTO ggj_inscription VALUES ('', '$nom', '$prenom', '$mail', '$categ', '$role', '$tel', '$comm', '$tarif', '$date_simple')";
			mysqli_query($con,$sql);
			
			// insert recette
			$sql = "INSERT INTO piwam_recette VALUES ('', 'Inscription GGJ15', '1', '$payment_amount' , '3' , '12', '$date_simple', '1', '1', '1', '$date', '$date')";
			mysqli_query($con,$sql);
			$montant = $payment_amount * 0.034 + 0.25;
			$sql = "INSERT INTO piwam_depense VALUES ('', 'Frais Paypal inscription GGJ15', '$montant', '1' , '3' , '6', '$date_simple', '1', '1', '1', '$date', '$date')";
			mysqli_query($con,$sql);
			
			mysqli_close($con);
			
			// mail inscription
			$mail_Subject = "[GGJ] Votre inscription est validée !";
			$entetes  = "MIME-Version: 1.0\r\n";
			$entetes .= "Content-type: text/plain; charset=utf-8\r\n";
			$entetes .= "From: COIN website <contact@extra-coin.fr>\r\n";

			$mail_Body = "Cher jammeur,";
			$mail_Body .= "\r\n";
			$mail_Body .= "\r\nNous avons bien enregistré votre inscription au Global Game Jam !\r\n";
			$mail_Body .= "Nous reviendrons très vite vers vous pour vous fournir les détails d'organisation. En attendant, vous pouvez nous suivre ou nous poser des questions via Twitter et Facebook.\r\n";
			$mail_Body .= "\r\nA très bientôt,";
			$mail_Body .= "\r\nL'équipe du Global Game Jam de l'Est";
			
			mail($mail, $mail_Subject, $mail_Body, $entetes);
			
			// mail coin
			$mail_Subject = "[GGJ] Nouvelle inscription \\o/";
			$entetes  = "MIME-Version: 1.0\r\n";
			$entetes .= "Content-type: text/plain; charset=utf-8\r\n";
			$entetes .= "From: COIN website <contact@extra-coin.fr>\r\n";

			$mail_Body = "WOOT! Nous avons enregistré une nouvelle inscription au GGJ.";
			$mail_Body .= "\r\n";
			$mail_Body .= "\r\nVoici les informations sur cette inscription (un récapitulatif est dispo via http://extra-coin.fr/recap_ggj.php?allow=true).\r\n";
			$mail_Body .= "\r\nLes éventuelles recettes ont été ajoutées à Piwam.\r\n";
			$mail_Body .= "\r\n";
			$mail_Body .= "\r\n====================================================";
			$mail_Body .= "\r\n";
			$mail_Body .= "Nom : ".$nom."\r\n";
			$mail_Body .= "Prénom : ".$prenom."\r\n";
			$mail_Body .= "Mail : ".$mail."\r\n";
			$mail_Body .= "Catégorie : ".$categ."\r\n";
			$mail_Body .= "Rôle : ".$role."\r\n";
			$mail_Body .= "Tel : ".$tel."\r\n";
			$mail_Body .= "Commentaire : ".$comm."\r\n";
			$mail_Body .= "Tarif : ".$tarif."\r\n";
			$mail_Body .= "\r\n";
			$mail_Body .= "\r\n====================================================";
			
			$emailtext = "\r\n\r\nDonnées brutes de Paypal (à conserver en cas de problème de transaction) :\r\n\r\n";
			foreach ($_POST as $key => $value){
				$emailtext .= $key . " = " .$value ."\r\n";
			}
			
			mail($coin_new_adhesion_mail, $mail_Subject, $mail_Body.$emailtext, $entetes);
		}
		else if ($item_name == 'Inscription BBQ GJ') {
			// insert inscription
			$date_simple = date('Y-m-d');
			$date = date('Y-m-d H:i:s');
			$nom = $_POST['option_selection3'];
			$prenom = $_POST['option_selection4'];
			$mail = $_POST['option_selection5'];
			$categ = $_POST['option_selection7'];
			$role = $_POST['option_selection2'];
			$tel = $_POST['option_selection6'];
			$comm = $_POST['custom'];
			$tarif = $_POST['option_selection1'];
			
			$con = @mysql_connect($DBHOST, $DBUSER, $DBPASSWORD) or die('Could not connect: ' . mysql_error());
			@mysql_select_db($DBNAME) or die( 'Unable to select database: ' . mysql_error());
			mysql_query("SET NAMES utf8");
			
			$sql = "INSERT INTO bbq_inscription VALUES ('', '$nom', '$prenom', '$mail', '$categ', '$role', '$tel', '$comm', '$tarif', '$date_simple')";
			mysql_query($sql);
			
			// insert recette
			$sql = "INSERT INTO piwam_recette VALUES ('', 'Inscription BBQ15', '1', '$payment_amount' , '3' , '14', '$date_simple', '1', '1', '1', '$date', '$date')";
			mysql_query($sql);
			$montant = $payment_amount * 0.034 + 0.25;
			$sql = "INSERT INTO piwam_depense VALUES ('', 'Frais Paypal inscription BBQ15', '$montant', '1' , '3' , '6', '$date_simple', '1', '1', '1', '$date', '$date')";
			mysql_query($sql);
			
			mysql_close($con);
			
			// mail inscription
			$mail_Subject = "[BBQ] Votre inscription au BBQ Game Jam est validée !";
			$entetes  = "MIME-Version: 1.0\r\n";
			$entetes .= "Content-type: text/plain; charset=utf-8\r\n";
			$entetes .= "From: COIN website <contact@extra-coin.org>\r\n";

			$mail_Body = "Cher jammeur,";
			$mail_Body .= "\r\n";
			$mail_Body .= "\r\nNous avons bien enregistré votre inscription au BBQ Game Jam !\r\n";
			$mail_Body .= "Nous reviendrons très vite vers vous pour vous fournir les détails d'organisation. En attendant, vous pouvez nous suivre ou nous poser des questions via Twitter et Facebook.\r\n";
			$mail_Body .= "\r\nA très bientôt,";
			$mail_Body .= "\r\nL'équipe du BBQ Game Jam";
			
			mail($mail, $mail_Subject, $mail_Body, $entetes);
			
			// mail coin
			$mail_Subject = "[BBQ] Nouvelle inscription \\o/";
			$entetes  = "MIME-Version: 1.0\r\n";
			$entetes .= "Content-type: text/plain; charset=utf-8\r\n";
			$entetes .= "From: COIN website <contact@extra-coin.org>\r\n";

			$mail_Body = "WOOT! Nous avons enregistré une nouvelle inscription au BBQ.";
			$mail_Body .= "\r\n";
			$mail_Body .= "\r\nVoici les informations sur cette inscription (un récapitulatif est dispo via http://extra-coin.org/recap_bbq.php?allow=true).\r\n";
			$mail_Body .= "\r\nLes éventuelles recettes ont été ajoutées à Piwam.\r\n";
			$mail_Body .= "\r\n";
			$mail_Body .= "\r\n====================================================";
			$mail_Body .= "\r\n";
			$mail_Body .= "Nom : ".$nom."\r\n";
			$mail_Body .= "Prénom : ".$prenom."\r\n";
			$mail_Body .= "Mail : ".$mail."\r\n";
			$mail_Body .= "Catégorie : ".$categ."\r\n";
			$mail_Body .= "Rôle : ".$role."\r\n";
			$mail_Body .= "Tel : ".$tel."\r\n";
			$mail_Body .= "Commentaire : ".$comm."\r\n";
			$mail_Body .= "Tarif : ".$tarif."\r\n";
			$mail_Body .= "\r\n";
			$mail_Body .= "\r\n====================================================";
			
			$emailtext = "\r\n\r\nDonnées brutes de Paypal (à conserver en cas de problème de transaction) :\r\n\r\n";
			foreach ($_POST as $key => $value){
				$emailtext .= $key . " = " .$value ."\r\n";
			}
			
			mail($coin_new_adhesion_mail, $mail_Subject, $mail_Body.$emailtext, $entetes);
		}
		else if ($item_name == 'Don') {
			$mail_Subject = "[COIN] Don reçu via PAYPAL";
			$entetes  = "MIME-Version: 1.0\r\n";
			$entetes .= "Content-type: text/plain; charset=utf-8\r\n";
			$entetes .= "From: COIN website <contact@extra-coin.fr>\r\n";

			$mail_Body = "WOOT! Un don a été réalisé et validé via PAYPAL.";
			$mail_Body .= "\r\n";
			$mail_Body .= "\r\nVoici les informations sur ce don (qui ont été ajoutées à Piwam, normalement).\r\n";
			$mail_Body .= "\r\n";
			$mail_Body .= "\r\n====================================================";
			$mail_Body .= "\r\n";
			$mail_Body .= "Montant reçu : ".$payment_amount."€\r\n";
			$mail_Body .= "\r\n";
			$mail_Body .= "\r\n====================================================";
			
			$emailtext = "\r\n\r\nDonnées brutes de Paypal (à conserver en cas de problème de transaction) :\r\n\r\n";
			foreach ($_POST as $key => $value){
				$emailtext .= $key . " = " .$value ."\r\n";
			}
			
			mail($coin_new_adhesion_mail, $mail_Subject, $mail_Body.$emailtext, $entetes);
			
			// Piwam, GOOOOO
			
			$con = @mysql_connect($DBHOST, $DBUSER, $DBPASSWORD) or die('Could not connect: ' . mysql_error());
			@mysql_select_db($DBNAME) or die( 'Unable to select database: ' . mysql_error());
			mysql_query("SET NAMES utf8");
			
			$date_simple = date('Y-m-d');
			$date = date('Y-m-d H:i:s');
			
			$sql = "INSERT INTO piwam_recette VALUES ('', 'Don PAYPAL', '1', '$payment_amount' , '3' , '5', '$date_simple', '1', '1', '1', '$date', '$date')";
			mysql_query($sql);
			
			
			
			$mail_Subject = "[COIN] Merci pour votre don !";
			$entetes  = "MIME-Version: 1.0\r\n";
			$entetes .= "Content-type: text/plain; charset=utf-8\r\n";
			$entetes .= "From: COIN website <contact@extra-coin.fr>\r\n";

			$mail_Body = "Cher donateur,";
			$mail_Body .= "\r\n";
			$mail_Body .= "\r\nAu nom de toute l'équipe de COIN, nous vous remercions chaleureusement pour votre don.\r\n";
			$mail_Body .= "Votre action sera mise à contribution pour améliorer nos services, nos séminaires & nos événements.\r\n";
			$mail_Body .= "\r\nMerci encore,";
			$mail_Body .= "\r\nL'équipe COIN";
			
			mail($mail_don, $mail_Subject, $mail_Body, $entetes);
			
			$montant = $payment_amount * 0.034 + 0.25;
			$sql = "INSERT INTO piwam_depense VALUES ('', 'Frais Paypal don', '$montant', '1' , '3' , '6', '$date_simple', '1', '1', '1', '$date', '$date')";
			mysql_query($sql);
			
			mysql_close($con);
		}
		else {
		
			$mail_Subject = "[COIN] Une nouvelle adhésion a été reglée via PAYPAL";
			$entetes  = "MIME-Version: 1.0\r\n";
			$entetes .= "Content-type: text/plain; charset=utf-8\r\n";
			$entetes .= "From: COIN website <contact@extra-coin.fr>\r\n";

			$mail_Body = "Une nouvelle adhésion a été réalisée et validée via PAYPAL.";
			$mail_Body .= "\r\n";
			$mail_Body .= "\r\nVoici les informations sur notre nouveau membre (qui ont été ajoutées à Piwam, normalement).\r\n";
			$mail_Body .= "\r\nUn e-mail de bienvenue lui a été envoyé.\r\n";
			$mail_Body .= "\r\n";
			$mail_Body .= "\r\n====================================================";
			$mail_Body .= "\r\n";
			$mail_Body .= "Type d'adhésion : ".$user_type." (".$payment_amount."€)\r\n";
			if (!empty($user_raison)) {
				$mail_Body .= "Raison sociale : ".$user_raison."\r\n";
				$mail_Body .= "Adresse 1 : ".$user_street."\r\n";
				$mail_Body .= "Code postal : ".$user_zip."\r\n";
				$mail_Body .= "Ville : ".$user_city."\r\n";
				$mail_Body .= "\r\n";
				$mail_Body .= "Contact administratif :\r\n";
			}
			$mail_Body .= "Nom : ".$user_name."\r\n";
			$mail_Body .= "Prénom : ".$user_prename."\r\n";
			$mail_Body .= "E-Mail : ".$user_email."\r\n";
			$mail_Body .= "Numéro d'adhérant (si renouvellement) : ".$user_numAd."\r\n";
			$mail_Body .= "\r\n";
			$mail_Body .= "\r\n====================================================";
			
			$emailtext = "\r\n\r\nDonnées brutes de Paypal (à conserver en cas de problème de transaction) :\r\n\r\n";
			foreach ($_POST as $key => $value){
				$emailtext .= $key . " = " .$value ."\r\n";
			}
			
			mail($coin_new_adhesion_mail, $mail_Subject, $mail_Body.$emailtext, $entetes);
			
			// Piwam, GOOOOO
			
			$con = @mysql_connect($DBHOST, $DBUSER, $DBPASSWORD) or die('Could not connect: ' . mysql_error());
			@mysql_select_db($DBNAME) or die( 'Unable to select database: ' . mysql_error());
			mysql_query("SET NAMES utf8");

			// vérifions si l'utilisateur existe
			$member_exist = false;
			$member_id = -1;
			if (!empty($user_numAd)) {
				$sql = "SELECT * FROM piwam_membre WHERE id = $user_numAd";
				$result = mysql_query($sql);
				$count = mysql_numrows($result);
				if ($count > 0) { // exist !
					$member_exist = true;
					// on maj son email
					$array = mysql_fetch_array($result);
					$member_id = $array['id'];
					$member_stat = $array['statut_id'];
					if ($member_stat == '9') $member_stat = 4; // un membre d'une boite peut devenir membre séparé
					$date = date('Y-m-d H:i:s');
					$sql = "UPDATE piwam_membre SET email = '$user_email', updated_at = '$date', statut_id = '$member_stat' WHERE id = $member_id";
					mysql_query($sql);
				}
			}
			$date_simple = date('Y-m-d');
			$date = date('Y-m-d H:i:s');
			if (!$member_exist) { // on créé si il n'existe pas
				$type = 4;
				if ($payment_amount == '150.00') $type = 8;
				$sql = "INSERT INTO piwam_membre VALUES ('', '".$user_name."', '".$user_prename."', NULL , NULL , '$type', '$date_simple', '0', NULL , NULL , NULL , '$user_country' , '', '$user_email', NULL , NULL , NULL , '1', '1', NULL , NULL , '$date', '$date')";
				if ($type == 8)
					$sql = "INSERT INTO piwam_membre VALUES ('', '".$user_raison."', '".$user_name." ".$user_prename."', NULL , NULL , '$type', '$date_simple', '0', '$user_street', '$user_zip' , '$user_city' , '$user_country' , '', '$user_email', NULL , NULL , NULL , '1', '1', NULL , NULL , '$date', '$date')";
				mysql_query($sql);
				$member_id = mysql_insert_id(); 
			}
			
			// utilisateur OK, insérer cotisation
			$type = 1; // normale
			if ($payment_amount == '15.00') $type = 2; // étudiant
			if ($payment_amount == '100.00') $type = 3; // bienfaiteur
			if ($payment_amount == '150.00') $type = 4; // entreprise
			$date_simple = date('Y-m-d');
			$sql = "INSERT INTO piwam_cotisation VALUES('', '3', '$type', '$member_id', '$date_simple', '1', '$payment_amount', NULL, '$date', '$date')";
			mysql_query($sql);
			
			
			
			// Mail de bienvenue !
			$mail_Subject = "[COIN] Votre nouvelle adhésion";
			$entetes  = "MIME-Version: 1.0\r\n";
			$entetes .= "Content-type: text/plain; charset=utf-8\r\n";
			$entetes .= "From: COIN website <contact@extra-coin.fr>\r\n";
			
			$validite =  date("d/m/Y", strtotime(date("Y-m-d", strtotime($date_simple)) . " +1 year"));

			$mail_Body = "Bonjour ".stripslashes($user_prename)." et bienvenue dans COIN,\r\n";
			$mail_Body .= "\r\n";
			$mail_Body .= "Votre adhésion a bien été validée et nous remercions pour votre intérêt dans COIN !\r\n";
			$mail_Body .= "\r\nVos informations ont été enregistrées et voici votre numéro unique d'adhérent :\r\n";
			$mail_Body .= "\r\n";
			$mail_Body .= "N° d'adhérent : ".$member_id."\r\n";
			$mail_Body .= "\r\n";
			$mail_Body .= "Gardez ce numéro au chaud, car il vous permettra de bénéficier de vos avantages de membre.\r\n";
			$mail_Body .= "\r\n";
			$mail_Body .= "Votre adhésion est valide jusqu'au ".$validite."\r\n";
			$mail_Body .= "\r\n";
			$mail_Body .= "\r\n";
			if (!empty($user_raison)) {
				$mail_Body .= "Vous vous êtes inscrit en tant que Personne Morale, nous vous permettons d'avoir jusqu'à 10 de vos employés de bénéficier du statut de membre. A ce titre, nous vous demandons de nous communiquer les informations suivantes concernant ces personnes (en répondant à ce mail) :\r\n";
				$mail_Body .= "- Nom\r\n";
				$mail_Body .= "- Prénom\r\n";
				$mail_Body .= "- E-mail\r\n";
				$mail_Body .= "\r\n";
				$mail_Body .= "Cette liste peut être incomplète et pourra être complétée par la suite, tout au long de la validité de votre cotisation. Nous ne pourrons cependant pas retirer des personnes avant un éventuel renouvellement de cotisation.\r\n";
				$mail_Body .= "Veuillez noter que le contact administratif spécifié ne bénéficie pas automatiquement du statut de membre.\r\n";
				$mail_Body .= "\r\n";
				$mail_Body .= "\r\n";
			}
			$mail_Body .= "Pour vous tenir informé au sujet de nos séminaires et événements, vous pouvez suivre notre actualités sur :\r\n";
			$mail_Body .= "Facebook : https://www.facebook.com/pages/Comit%C3%A9-dOrganisation-des-Interactivit%C3%A9s-Num%C3%A9riques/424596440934844# \r\n";
			$mail_Body .= "Twitter : https://twitter.com/extracoin \r\n";
			$mail_Body .= "\r\n";
			$mail_Body .= "A très bientôt,\r\n";
			$mail_Body .= "L'équipe de COIN\r\n";
			
			mail($user_email, $mail_Subject, $mail_Body, $entetes);
			
			$libel = 'normale';
			if ($payment_amount == '15.00') $libel = 'étudiant'; // étudiant
			if ($payment_amount == '100.00') $libel = 'bienfaiteur'; // bienfaiteur
			if ($payment_amount == '150.00') $libel = 'entreprise'; // entreprise
			$montant = $payment_amount * 0.034 + 0.25;
			$sql = "INSERT INTO piwam_depense VALUES ('', 'Frais Paypal adhésion $libel', '$montant', '1' , '3' , '6', '$date_simple', '1', '1', '1', '$date', '$date')";
			mysql_query($sql);
			
			mysql_close($con);
		}
		
	} else if (strcmp ($res, "INVALID") == 0) {
		// log for manual investigation
		// Envoi du mail de confirmation pour COIN
		$mail_Subject = "[COIN] PAYPAL a invalidé une transaction";
		$entetes  = "MIME-Version: 1.0\r\n";
		$entetes .= "Content-type: text/plain; charset=utf-8\r\n";
		$entetes .= "From: COIN website <contact@extra-coin.fr>\r\n";

		$mail_Body = "Une nouvelle adhésion a été demandée (ou un don a été fait), mais PAYPAL n'a pas validé la transaction.";
		$mail_Body .= "\r\n";
		$mail_Body .= "\r\nIl faut donc vérifier sur le compte PAYPAL si une transaction a eu lieu et se connecter à Piwam pour ajouter l'adhesion/don si besoin.\r\n";
		$mail_Body .= "\r\nIl faut également prendre contact avec la personne si besoin (voir dans les données brutes). Si elle a bien voulu adhérer, il faut lui envoyer manuellement le mail de bienvenue.\r\n";
		$mail_Body .= "\r\nSi les données ci-dessous sont vides ou étranges, cela signifie qu'un accès non autorisé a été fait sur http://extra-coin.fr/ipn.php (ne pas cliquer sur ce lien, sinon un autre mail d'erreur sera envoyé).\r\n";
		$mail_Body .= "\r\n====================================================";
		
		$emailtext = "\r\n\r\nDonnées brutes de Paypal (à conserver en cas de problème de transaction) :\r\n\r\n";
		foreach ($_POST as $key => $value){
			$emailtext .= $key . " = " .$value ."\r\n";
		}
		
		mail($coin_new_adhesion_mail, $mail_Subject, $mail_Body.$emailtext, $entetes);
	} else {
		// Envoi du mail de confirmation pour COIN
		$mail_Subject = "[COIN] Une erreur inconnue est survenue lors d'une transaction PAYPAL";
		$entetes  = "MIME-Version: 1.0\r\n";
		$entetes .= "Content-type: text/plain; charset=utf-8\r\n";
		$entetes .= "From: COIN website <contact@extra-coin.fr>\r\n";

		$mail_Body = "Une erreur inconnue est survenue lors d'une transaction PAYPAL.";
		$mail_Body .= "\r\n";
		$mail_Body .= "\r\nPAYPAL n'a pas pu être contacté pour valider la transaction, il faut donc vérifier sur le compte PAYPAL si une transaction a eu lieu. Si les données ci-dessous sont vides ou étranges, cela signifie qu'un accès non autorisé a été fait sur http://extra-coin.fr/ipn.php (ne pas cliquer sur ce lien, sinon un autre mail d'erreur sera envoyé).\r\n";
		$mail_Body .= "\r\nIl faut également prendre contact avec la personne si besoin (voir dans les données brutes). Si elle a bien voulu adhérer, il faut lui envoyer manuellement le mail de bienvenue.\r\n";
		$mail_Body .= "\r\n";
		$mail_Body .= "\r\n====================================================";
		
		$emailtext = "\r\n\r\nDonnées brutes de Paypal (à conserver en cas de problème de transaction) :\r\n\r\n";
		foreach ($_POST as $key => $value){
			$emailtext .= $key . " = " .$value ."\r\n";
		}
		
		mail($coin_new_adhesion_mail, $mail_Subject, $mail_Body.$emailtext, $entetes);
	}	
	

?>
