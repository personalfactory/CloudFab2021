<?php 
//if ($DEBUG) 
    ini_set('display_errors', '1');

include('../include/validator.php'); 
include('../Connessioni/serverdb.php');
include('sql/script.php');
include('sql/script_lab_caratteristica_mt.php');
include('sql/script_lab_materie_prime.php');
include('sql/script_lab_matpri_car.php');


$idMat=$_GET['IdMateria'];
$idCar=$_GET['IdCar'];

begin();
$sqlCar = findCaratteristicaById($idCar);
$sqlMat = findMatPrimaById($idMat);
$sqlVal = findRisulatiCarMtByIdMatAndIdCar($idMat,$idCar);
commit();

while ($rowCar = mysql_fetch_array($sqlCar)) {
    $nomeCar = $rowCar['caratteristica'];
    $unMisCar = $rowCar['uni_mis_car'];
    $dimCar = $rowCar['dimensione'];
    $unMisDim = $rowCar['uni_mis_dim'];
}

while ($rowMat = mysql_fetch_array($sqlMat)) {
    $codMat = $rowMat['cod_mat'];
    $descriMat = $rowMat['descri_materia'];
}

$dati = array();
$dati[0][0]=$dimCar;
$dati[0][1]=$nomeCar;


$dati = array();
$dati[0][0] = $dimCar;
$dati[0][1] = $nomeCar;
$i = 1;
while ($rowVal = mysql_fetch_array($sqlVal)) {

    $dati[$i][0] = (string) $rowVal['x']; //Nel db è double X
    $dati[$i][1] = (float) $rowVal['y']; //Nel db è varchar Y

    $i++;
}


//Prima colona array= asseX
//Seconda colonna array =asseY
$dati = json_encode($dati);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <?php include('../include/header.php'); ?>

        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript">
            google.load('visualization', '1', {packages: ['corechart']});
        </script>

       <script type="text/javascript">
            function drawVisualization() {
                
                var data = google.visualization.arrayToDataTable(<?php echo $dati ?>);
                
                // Create and draw the visualization.
                new google.visualization.LineChart(document.getElementById('visualization')).
                        draw(data, {curveType: "function",
                    width: 1000, height: 600,
                    vAxis:{maxValue: 10, title: '<?php echo $unMisCar ?>'},
                    hAxis: {title: '<?php echo $unMisDim ?>'},
                    title: '<?php echo $filtroLabMateriaPrima . ": " . $codMat." ". $descriMat ?>',
                    pointSize: 5});
            }
            
            google.setOnLoadCallback(drawVisualization);
            
        </script>
        
    </head>
    <body>   
        <div id="mainContainer">   
            <div style="text-align: center; font-size: 16px"><?php echo $titoloPaginaLabGraficoCaratteristiche ?></div>
            <div id="visualization" style="width: 500px; height: 400px; text-align: center"></div>
        </div>
    </body>
</html>
​