<?php
session_start();

//###### INCLUSIONE DEL FILE ###########
include "../../include/" . $_SESSION['lingua'] . ".php";

//Variabili utili nel caso in cui la sessione dell'utente loggato sia scaduta
//e debba essere reindirizzato al form di login
if (isset($_GET['PagChiamante'])) {
    $PagChiamante = $_GET['PagChiamante'];
}
if (isset($_GET['srcFotoSacco'])) {
    $srcFotoSacco = $_GET['srcFotoSacco'];
}
if (isset($_GET['srcFotoGrande'])) {
    $srcFotoGrande = $_GET['srcFotoGrande'];
}
if (isset($_GET['NomeProdotto'])) {
    $NomeProdotto = $_GET['NomeProdotto'];
}


//####### VERIFICE TEMPO DI INATTIVITA SESSIONE ############################
//Tempo di inattivita in secondi
$inactive = 900; //15 minuti

if (isset($_SESSION['timeout']) AND $_SESSION['utente'] != "") {

    $session_life = time() - $_SESSION['timeout'];
    if ($session_life > $inactive) {
        //disconnessione utente
        $_SESSION['utente'] = "";
        ?>


        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html>
            <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
            </head>
            <body>
            <!--Alert sessione scaduta e redirect al form di login-->
            <script type="text/javascript">
                alert("<?php echo $msg17 ?>");
                location.href = "<?php echo $radiceUrl ?>/formLogin.php?PagChiamante=<?php echo $PagChiamante ?>&srcFotoGrande=<?php echo $srcFotoGrande ?>&srcFotoSacco=<?php echo $srcFotoSacco ?>&NomeProdotto=<?php echo $NomeProdotto ?>";
            </script>
            </body>
        </html>
        <?php
    }
}
//Aggiorno il tempo corrente
$_SESSION['timeout'] = time();

//######################## DOWNLOAD ####################################

require_once('../ForceDownload.class.php');

if ($_SESSION['utente'] == "") { // se non si è loggati  
    exit('Access denied!');
}

$dir = "download/";
$file = isset($_GET['nomefile']) ? $_GET['nomefile'] : '';
$download = New ForceDownload($dir, $file);
$download->download() or die($download->get_error());
?>
