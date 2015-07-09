
<!DOCTYPE html>

<html lang="fr-FR">

	<head>
		<meta charset="ISO-8859-1" />
		<script src="./Chart.min.js"></script>
		<title>Stats GGJ</title>
        <style>
            #left {
                float: left;
                width: 45%;
            }
            #right {
                margin-left:50%;
                width: 45%;

            }
            h1 {
                text-align: center;
            }
            #legend {
                clear:both;
            }
            .doughnut-legend {
                list-style: outside none none;
                position: absolute;
                right: 8px;
                top: 0px;
            }
            .doughnut-legend li {
              display: block;
              padding-left: 30px;
              position: relative;
              margin-bottom: 4px;
              border-radius: 5px;
              padding: 2px 8px 2px 28px;
              font-size: 14px;
              cursor: default;
              -webkit-transition: background-color 200ms ease-in-out;
              -moz-transition: background-color 200ms ease-in-out;
              -o-transition: background-color 200ms ease-in-out;
              transition: background-color 200ms ease-in-out;
            }
            .doughnut-legend li:hover {
              background-color: #fafafa;
            }
            .doughnut-legend li span {
              display: block;
              position: absolute;
              left: 0;
              top: 0;
              width: 20px;
              height: 100%;
              border-radius: 5px;
            }
        </style>
	</head>

	<body>

<?php
error_reporting(E_ALL);



$config = parse_ini_file('../../secret.ini',true);
$dbaddress = $config['database']['host'] ;
$dbname = $config['database']['name'];
$dbuser = $config['database']['username'];
$dbpw = $config['database']['password'];
$tablename = $config['database']['table']['ggj'] ;

$link = mysql_connect($dbaddress, $dbuser, $dbpw);
mysql_select_db($dbname, $link);


$query = "SELECT * FROM `ggj_inscription`" ;
$result = mysql_query($query,$link) ;
$total = 0;
$count = array();
$count['Nancy'] = array();
$count['Esch'] = array();
$colors = array(
    'I' => '#c44d58',
    'M' => '#4ecdc4',
    'A' => '#c7f464',
    'G' => '#ff6b6b',
    'D' => '#556270'
);

while ($row = mysql_fetch_array($result)) {
    if ($row['categ'] == 'Nancy') {
        $count['Nancy']['Total']++;
        $count['Nancy'][$row['role']]++; 
    } else {
        $count['Esch']['Total']++;
        $count['Esch'][$row['role']]++;
    }
	$total++;
}
ksort($count['Nancy']);
ksort($count['Esch']);
mysql_close($link) ;

?>

<script>

    var options = {'responsive': true, animateRotate: false};
    var nancyData = [
<?php $first = true ; $i = 0; foreach ($count['Nancy'] as $k => $v) {
    if ($k != 'Total') { 
        if ($first) {
            $first = false;   
        } else {
            echo ',';
        }

        echo '{';
        echo 'value: '.$v.',';
        echo 'label: \''.$k.'\',';

        echo 'color: \''.$colors[substr($k, 0, 1)].'\'';
        echo '}';
        $i++;
}
} ?>    
];

    var eschData = [
<?php $first = true ; $i = 0; foreach ($count['Esch'] as $k => $v) {
    if ($k != 'Total') { 
        if ($first) {
            $first = false;   
        } else {
            echo ',';
        }

        echo '{';
        echo 'value: '.$v.',';
        echo 'label: \''.$k.'\',';
        echo 'color: \''.$colors[substr($k, 0, 1)].'\'';
        echo '}';
        $i++;
}
} ?>    
];

</script>
    <div id="total">
        <h1>Total: <?php echo $total; ?></h1>
        
    </div>
    <div id="left">
        <h1>Nancy: <?php echo $count['Nancy']['Total']; ?></h1>
            <canvas id="nancy" width="400" height="400"></canvas>
            
    </div>
    <div id="right">
        <h1>Esch: <?php echo $count['Esch']['Total']; ?></h1>
            <canvas id="esch" width="400" height="400"></canvas>
            
    </div>
    <div id="legend">
    </div>
    <script>
            window.onload = function(){
            var ctx = document.getElementById("nancy").getContext("2d");
            var nancy = new Chart(ctx).Doughnut(nancyData,options);
            var ctx2 = document.getElementById("esch").getContext("2d");
            var esch = new Chart(ctx2).Doughnut(eschData,options);
            document.getElementById("legend").innerHTML = esch.generateLegend();
        };
    </script>

	</body>
</html>
