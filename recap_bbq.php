<!DOCTYPE html>

<html lang="fr-FR">

	<head>
		<meta charset="ISO-8859-1" />
		
		<title>Recap BBQ</title>
	</head>

	<body>

<?php

if (!isset($_GET['allow']) || $_GET['allow'] != 'true') die ('Access error');

$coll = collator_create( 'fr_FR' );

$config = parse_ini_file('../../secret.ini',true);
$dbaddress = $config['database']['host'] ;
$dbname = $config['database']['name'];
$dbuser = $config['database']['username'];
$dbpw = $config['database']['password'];
$tablename = $config['database']['table']['bbq'] ;

$link = mysql_connect($dbaddress, $dbuser, $dbpw) or die('SQL ERROR'.$sql.'<br>'.mysql_error());
mysql_select_db($dbname, $link) or die('SQL ERROR'.$sql.'<br>'.mysql_error());

echo "<table style=\"border: medium solid #000000;\">\n" ;
echo "  <thead>\n" ;
echo "  <tr>\n" ;
echo "    <td style=\"border: thin solid #6495ed;\">id</td>\n" ;
echo "    <td style=\"border: thin solid #6495ed;\">nom</td>\n" ;
echo "    <td style=\"border: thin solid #6495ed;\">prenom</td>\n" ;
echo "    <td style=\"border: thin solid #6495ed;\">mail</td>\n" ;
echo "    <td style=\"border: thin solid #6495ed;\">categ</td>\n" ;
echo "    <td style=\"border: thin solid #6495ed;\">role</td>\n" ;
echo "    <td style=\"border: thin solid #6495ed;\">phone</td>\n" ;
echo "    <td style=\"border: thin solid #6495ed;\">comm</td>\n" ;
echo "    <td style=\"border: thin solid #6495ed;\">tarif</td>\n" ;
echo "    <td style=\"border: thin solid #6495ed;\">date</td>\n" ;
echo "  </tr>\n" ;
echo "  </thead>\n" ;
echo "  <tbody>\n" ;
$query = "SELECT * FROM `". $tablename . "`" ;
$result = mysql_query($query,$link) or die('SQL ERROR'.$sql.'<br>'.mysql_error());
$count = 1;
$newsletter = "";
$visitor_ns = "";
while ($row = mysql_fetch_array($result)) {
    echo "  <tr>\n" ;
    echo "    <td style=\"border: thin solid #6495ed;\">".$count."</td>\n" ;
    echo "    <td style=\"border: thin solid #6495ed;\">".$row['nom']."</td>\n" ;
    echo "    <td style=\"border: thin solid #6495ed;\">".$row['prenom']."</td>\n" ;
    echo "    <td style=\"border: thin solid #6495ed;\">".$row['mail']."</td>\n" ;
    echo "    <td style=\"border: thin solid #6495ed;\">".$row['categ']."</td>\n" ;
    echo "    <td style=\"border: thin solid #6495ed;\">".$row['role']."</td>\n" ;
    echo "    <td style=\"border: thin solid #6495ed;\">".$row['phone']."</td>\n" ;
    echo "    <td style=\"border: thin solid #6495ed;\">".$row['comm']."</td>\n" ;
    echo "    <td style=\"border: thin solid #6495ed;\">".$row['tarif']."</td>\n" ;
    echo "    <td style=\"border: thin solid #6495ed;\">".$row['date']."</td>\n" ;
    echo "  </tr>\n" ;
	if (collator_compare($coll,$row['categ'],'Technoport') == 0)
	{
		$newsletter .= $row['mail'].",";
	}
	else if (collator_compare($coll,$row['categ'],'Blida') == 0)
	{
		$visitor_ns .= $row['mail'].",";
	}
	$count++;
}
echo "  </tbody>\n" ;
echo "</table>\n" ;
echo "Mailing list Technoport (BCC plz!):<br/><br/> ".$newsletter;
echo "<br/><br/>Mailing list Blida (BCC plz!):<br/><br/> ".$visitor_ns;

mysql_close($link) ;

?>

	</body>
</html>
