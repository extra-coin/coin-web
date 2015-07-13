<?php
	header('Content-type:text/html; charset=utf-8');
	include_once("paypal_config.php");

	$num_ad = $_POST['adherant'];
	$categ = $_POST['os6'];
	$role = $_POST['os1'];
	$tel = $_POST['os5'];
	$comm = $_POST['custom'];
	$tarif = $_POST['os0'];

	$nom = '';
	$prenom = '';
	$mail = '';

	$con = @mysql_connect($DBHOST, $DBUSER, $DBPASSWORD) or die('Could not connect: ' . mysql_error());
	@mysql_select_db($DBNAME) or die( 'Unable to select database: ' . mysql_error());
	mysql_query("SET NAMES utf8");

	// Get adherent
	$date_simple = date('Y-m-d');
	$validite = date("Y-m-d", strtotime(date("Y-m-d", strtotime($date_simple)) . " +1 year"));

	$sql = "SELECT * FROM piwam_membre m, piwam_cotisation c WHERE m.id = $num_ad AND c.membre_id = m.id AND c.date <= '$validite' LIMIT 1"; // + verif adhesion en cours
	$result = mysql_query($sql);
	$count = mysql_numrows($result);
	if ($count > 0) { // exist !
		// on grab mail, nom et prenom
		$array = mysql_fetch_array($result);
		$nom = $array['nom'];
		$prenom = $array['prenom'];
		$mail = $array['email'];

		// on insère dans les inscrits
		$sql = "INSERT INTO " . $config['database']['table']['ggj'] . " VALUES ('', '$nom', '$prenom', '$mail', '$categ', '$role', '$tel', '$comm', '$tarif', '$date_simple')";
		mysql_query($sql);

		// good => mail

		$mail_Subject = "[GGJ] Nouvelle inscription \\o/";
		$entetes  = "MIME-Version: 1.0\r\n";
		$entetes .= "Content-type: text/plain; charset=utf-8\r\n";
		$entetes .= "From: COIN website <" . $config['emails']['newAdhesion'] . ">\r\n";

		$mail_Body = "WOOT! Nous avons enregistré une nouvelle inscription au GGJ.";
		$mail_Body .= "\r\n";
		$mail_Body .= "\r\nVoici les informations sur cette inscription (un récapitulatif est dispo via http://extra-coin.org/recap_ggj.php).\r\n";
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

		mail($coin_new_adhesion_mail, $mail_Subject, $mail_Body, $entetes);

		$mail_Subject = "[GGJ] Votre inscription est validée !";
		$entetes  = "MIME-Version: 1.0\r\n";
		$entetes .= "Content-type: text/plain; charset=utf-8\r\n";
		$entetes .= "From: COIN website <" . $config['emails']['newAdhesion'] . ">\r\n";

		$mail_Body = "Cher jammeur,";
		$mail_Body .= "\r\n";
		$mail_Body .= "\r\nNous avons bien enregistré votre inscription au Global Game Jam !\r\n";
		$mail_Body .= "Nous reviendrons très vite vers vous pour vous fournir les détails d'organisation. En attendant, vous pouvez nous suivre ou nous poser des questions via Twitter et Facebook.\r\n";
		$mail_Body .= "\r\nA très bientôt,";
		$mail_Body .= "\r\nL'équipe du Global Game Jam de l'Est";

		mail($mail, $mail_Subject, $mail_Body, $entetes);


		// redir success check mail
		header('Location: http://www.ggj-est.fr/?q=inscription-ok');
	} else {
		// redir fail check num adhérent + validité, si prob, contact
		header('Location: http://www.ggj-est.fr/?q=inscription-ko');
	}

?>
