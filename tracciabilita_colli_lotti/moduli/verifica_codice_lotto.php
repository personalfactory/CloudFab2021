<?php 
	include('../../Connessioni/serverdb.php'); 
	include("../../tracciabilita_colli_lotti/sql/query.php");

    $codiceLottoInserito = $_GET['codLotto']; 
	$index=0;
	$qres = "";
	$qresUsato = "";

	//Verifica Lotto Impegnato - Controllo che il lotto non sia stato già associato ad un collo
	$resUsato = verificaLottoImpegnato($codiceLottoInserito);
    while($row = mysql_fetch_array($resUsato)) {
                    $qresUsato = $row['cod_lotto'];
                    $index++;
    }
    //Verifica che il lotto sia presente nella lista dei colli disponibili
    if ($index==0){
	    $result = verificaLotto($codiceLottoInserito);
	    while($row = mysql_fetch_array($result)) {
					$qres = $row['cod_lotto'];

	    }
	}

   echo json_encode($qres);
 
?>
