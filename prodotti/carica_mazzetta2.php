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

$CodiceMazzetta = str_replace("'","''",$_POST['CodiceMazzetta']); 
$NomeMazzetta = str_replace("'","''",$_POST['NomeMazzetta']); 
list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);
// ################# Gestione errori di transazione  ######################
$insertMazzetta = true;

//############# Gestione degli errori di input #############################
$errore=false;
$messaggio=$msgErroreVerificato.' <br />';

if(!isset($CodiceMazzetta) || trim($CodiceMazzetta) =="" ){

	$errore=true;
	$messaggio=$messaggio.$msgCampoCodeMazzVuoto.'<br />';

}
if(!isset($NomeMazzetta) || trim($NomeMazzetta) =="" ){

	$errore=true;
	$messaggio=$messaggio.$msgCampoNomeMazzVuoto.'<br />';

}

//Verifica esistenza
//Apro la connessione al db
	include('../Connessioni/serverdb.php');
	include('../sql/script_mazzetta.php');
	include('../sql/script.php');
	
	
	$result = findMazzettaByNomeORCod($NomeMazzetta, $CodiceMazzetta);
	/*
	$query="SELECT * FROM mazzetta WHERE nome_mazzetta = '".$NomeMazzetta."' OR cod_mazzetta = '".$CodiceMazzetta."'";
  	$result=mysql_query($query,$connessione) or die("Errore 119 :" .mysql_error());  
	*/
	if(mysql_num_rows($result)!=0)
	{	
		//Se entro nell'if vuol dire che esiste
		$errore=true;
		$messaggio=$messaggio.$msgDuplicaRecord.'!<br />';
		}

	

	$messaggio = $messaggio . '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';
		
	
	if($errore){
		//Ci sono errori quindi non salvo
		echo $messaggio;
	}else{
		//###################### INIZIO TRANSAZIONE ####################
		
		$insertMazzetta = insertMazzetta($CodiceMazzetta, $NomeMazzetta, dataCorrenteInserimento(),$_SESSION['id_utente'],$IdAzienda);
		/*
		$insertMazzetta=mysql_query("INSERT INTO mazzetta (
                                cod_mazzetta, 
                                nome_mazzetta,
                                abilitato,
                                dt_abilitato) 
				VALUES ( '".$CodiceMazzetta.
						"','".$NomeMazzetta.
						"',1,
						   '".dataCorrenteInserimento()."')");
//                        or die( "ERRORE INSERT INTO mazzetta:" .mysql_error());  
 		*/		
				$selectIdMazzetta = selectIDMazzetta($NomeMazzetta, $CodiceMazzetta);
				/*
                $selectIdMazzetta = mysql_query("SELECT id_mazzetta 
                                                FROM mazzetta
                                                WHERE 
                                                    cod_mazzetta='".$CodiceMazzetta."'
                                                        AND
                                                        nome_mazzetta='".$NomeMazzetta.	"'");
                */
               while ($rowId = mysql_fetch_array($selectIdMazzetta)) {
               
                   $IdMazzetta=$rowId['id_mazzetta'];
                   
               }
               
		if (!$insertMazzetta) {

                    rollback();
                    echo $msgTransazioneFallita.'! '.$msgErrContattareAdmin.'!';
                    
                    echo "<br/>insertMazzetta" . $insertMazzetta;
                } else {

                    commit();
                    mysql_close();
                    ?>
                    <script language="javascript">
                        window.location.href="associa_mazzetta_colore.php?IdMazzetta=<?php echo $IdMazzetta ?>&NomeMazzetta=<?php echo $NomeMazzetta ?>";
                    </script>
        <?php
    }
		
	}
?>
</div>
</body>
</html>
