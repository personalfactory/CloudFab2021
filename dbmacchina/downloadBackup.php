<?php
include('../Connessioni/origamidb.php');

$idMacchina=$_GET['IdMacchina'];

$filename = "origamidb" .$idMacchina."-". date("d-m-Y") . ".sql.gz";
$mime = "application/x-gzip";

header( "Content-Type: " . $mime );
header( 'Content-Disposition: attachment; filename="' . $filename . '"' );

$cmd = "mysqldump -u $username_origamidb --password=$password_origamidb $database_origamidb | gzip --best";   

passthru( $cmd );

exit(0);

?>

