<?php
session_start();

include('./Connessioni/serverdb.php');
include('./include/precisione.php');
include('./sql/script_utente.php');
include('./sql/script.php');
include('./laboratorio/sql/script_lab_macchina.php');

$liberaMacchina = true;
$deleteUser =true;
$eliminaSessione = true;

begin();

//######### SBLOCCO LA ROSETTA USATA IN LABORATORIO ######
if (isset($_SESSION['lab_macchina'])) {

    $liberaMacchina = modificaStatoRosetta($_SESSION['lab_macchina'], $valRosetLibera);
    $deleteUser=modificaUtenteMacchina($_SESSION['lab_macchina'],'');
}
//######### ELIMINO DAL DB LA SESSIONE ###################
if (isset($_SESSION['id_utente'])) {
    $eliminaSessione = eliminaSessioneOldDb($_SESSION['id_utente']);
}

if(!$liberaMacchina || !$eliminaSessione || !$deleteUser){
    
    rollback();
    //#### ELIMINO LA SESSIONE #################
    session_unset();
    session_destroy();
    echo "ERROR DURING THE LOGOUT! ";
    echo '<a href="/CloudFab/login.php">LOGOUT</a>';
    
} else {
    
    commit();
//#### ELIMINO LA SESSIONE #################
    session_unset();
    session_destroy();
    ?>
<script type="text/javascript">
    location.href = "/CloudFab/login.php";
</script>

<?php } ?>

