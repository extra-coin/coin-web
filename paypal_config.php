<?php
$config = parse_ini_file('../../secret.ini',true);
$paypal_server = "www.paypal.com"; // "www.paypal.com" si production
$paypal_account = $config['paypal']['account']; // mettre le compte paypal de COIN ici

$coin_new_adhesion_mail = $config['email']['newAdhesion'];



// Database hostname (usually "localhost")

$DBHOST = $config['database']['host'];


// Database user

$DBUSER = $config['database']['username'];


// Database password
$DBPASSWORD = $config['database']['password'];


// Database name

$DBNAME = $config['database']['name'];


?>
