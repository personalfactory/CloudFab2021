<!DOCTYPE html>
<html>
<head>
<style>
table {
  width: 100%;
  border-collapse: collapse;
}

table, td, th {
  border: 1px solid black;
  padding: 5px;
}

th {text-align: left;}
</style>
</head>
<body>

<?php
include('../Connessioni/serverdb.php'); 
$q = intval($_GET['q']);
 
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}
  
$id_collo = 16;	
$stringSql = "SELECT * FROM serverdb.collo_lotti id_collo=".$id_collo.";";
    $resul = mysql_query($stringSql)
            or die("ERROR IN FUNCTION  recuperaDateBolla - " . $stringSql . " - " . mysql_error());

echo "<table>
<tr>
<th>id</th>
<th>id_collo</th>
<th>cod_lotto</th>
<th>abilitato</th>
<th>dt_abiltato</th>
</tr>";
while($row = mysqli_fetch_array($result)) {
  echo "<tr>";
  echo "<td>" . $row['id'] . "</td>";
  echo "<td>" . $row['id_collo'] . "</td>";
  echo "<td>" . $row['cod_lotto'] . "</td>";
  echo "<td>" . $row['abilitato'] . "</td>";
  echo "<td>" . $row['dt_abiltato'] . "</td>";
  echo "</tr>";
}
echo "</table>";
mysqli_close($con);
?>
</body>
</html>