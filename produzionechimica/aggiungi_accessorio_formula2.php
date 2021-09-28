<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<?php include('../include/validator.php'); ?>
<head>
<?php include('../include/header.php'); ?>
</head>
<body>
<div id="mainContainer">
<?php
include('../include/menu.php'); 
include('../include/gestione_date.php');
include('../include/precisione.php');
include('../Connessioni/serverdb.php');
include('../sql/script.php');
include('../sql/script_accessorio_formula.php');

$CodiceFormula=$_POST['CodiceFormula'];

//################## Gestione degli errori ##################################
//Verifico che la materia sia stata settata e che non sia vuota
$errore=false;
$messaggio='';

if(!isset($_POST['Accessorio']) || trim($_POST['Accessorio']) =="" ){

	$errore=true;
	$messaggio=$messaggio." ".$msgErrSelectAccessorio.'<br />';

}
if(!is_numeric($_POST['Quantita'])){
	$errore=true;
	$messaggio=$messaggio." " .$msgErrQtaNumerica."<br />";

}
if($_POST['Quantita']<0){
	$errore=true;
	$messaggio=$messaggio." " .$msgErrQtaMagZero."<br />";

}

$CodiceAcc=$_POST['Accessorio'];
$Quantita=$_POST['Quantita'];

	$messaggio = $messaggio . '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';
	$insertAccForm = true;		
	if($errore){
		//Ci sono errori quindi non salvo
		echo $messaggio;
	}else{
		//Inserisco nella tabella generazione_formula
                // la nuova mat prima
            begin();
		$insertAccForm = inserisciAccFormula(
                        $CodiceFormula, 
                        $CodiceAcc, 
                        $Quantita, 
                        $valAbilitato, 
                        dataCorrenteInserimento());	
              
                if(!$insertAccForm) {
                    rollback();
                    echo $msgTransazioneFallita . ' <a href="javascript:history.back()">' . $msgErrContactAdmin . '</a><br/>';
                } else {
                    commit(); ?>
                     <script type="text/javascript">
          location.href="modifica_formula.php?CodiceFormula=<?php echo $CodiceFormula ?>";
        </script>
             <?php    }	
}//fine primo if($errore) controllo degli input relativo al prodotto 
?>

</div>
</body>
</html>
