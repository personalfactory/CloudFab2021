<?php 
	
	include('../../Connessioni/serverdb.php'); 
	include("../../ordine_produzione_chimica/sql/query.php");

 	$infoOrdine = json_decode($_GET['infoOrdine']); 
	
echo $infoOrdine;

	$idUtente = $infoOrdine[0];
	$idAzienda = $infoOrdine[1];
   
	$id =$infoOrdine[2];
	$codice = $infoOrdine[3]; 
	$dataOrdine = $infoOrdine[4];
	$dataEvasione = $infoOrdine[5];
	$respOrdine = $infoOrdine[6];
	$noteOrdine = $infoOrdine[7];
 	$info1Ordine = $infoOrdine[8];
	$info2Ordine = $infoOrdine[9];
	$info3Ordine = $infoOrdine[10];
	$info4Ordine = $infoOrdine[11];
 	$info5Ordine = $infoOrdine[12]; 
	$numProdotti = count($infoOrdine[13]); 

	$array_prodotti = $infoOrdine[13];
	$array_nMagazzino = $infoOrdine[14];
	$array_nRichiesti = $infoOrdine[15];
	$array_qProdurre = $infoOrdine[16];
	$array_note = $infoOrdine[17];
 
	$numComponenti = count($infoOrdine[18]); 
 
	$array_componente_codice = $infoOrdine[18];
	$array_componente_descrizione = $infoOrdine[19];
	$array_componente_giacenza = $infoOrdine[20];
	$array_componente_quantita_kit = $infoOrdine[21];
	$array_componente_prezzo = $infoOrdine[22];
	$array_componente_qta_in_ordine = $infoOrdine[23]; 
	$array_componente_fornitore = $infoOrdine[24];
	$array_componente_differenza = $infoOrdine[25];
	$array_componente_scorta_minima = $infoOrdine[26];
	date_default_timezone_set('UTC');
	$dt_abilitato = date('Y-m-d H:i:s');
  
	 inserisciOrdine($id,$codice,$respOrdine,$dataOrdine,$dataEvasione,$noteOrdine,$info1Ordine,$info2Ordine,$info3Ordine,$info4Ordine,$info5Ordine,$idUtente,$idAzienda);
  
	for ($i = 0; $i<count($array_prodotti); $i++) {  
		 
		inserisciDettaglioOrdine($id,'1','codice articolo da produrre', $array_prodotti[$i],$idUtente,$idAzienda,$dt_abilitato);
		inserisciDettaglioOrdine($id,'2','qta Magazzino', $array_nMagazzino[$i],$idUtente,$idAzienda,$dt_abilitato);
		inserisciDettaglioOrdine($id,'3','qta Richiesta', $array_nRichiesti[$i],$idUtente,$idAzienda,$dt_abilitato);
		inserisciDettaglioOrdine($id,'4','qProdurre', $array_qProdurre[$i],$idUtente,$idAzienda,$dt_abilitato);
		inserisciDettaglioOrdine($id,'5','note', $array_note[$i],$idUtente,$idAzienda,$dt_abilitato);
	}
 
	for ($i = 0; $i<count($array_componente_codice); $i++) {  
		 
		inserisciDettaglioOrdine($id,'6','componente codice', $array_componente_codice[$i],$idUtente,$idAzienda,$dt_abilitato);
		inserisciDettaglioOrdine($id,'7','componente descrizione', $array_componente_descrizione[$i],$idUtente,$idAzienda,$dt_abilitato);
		inserisciDettaglioOrdine($id,'8','componente giacenza', $array_componente_giacenza[$i],$idUtente,$idAzienda,$dt_abilitato); 
		inserisciDettaglioOrdine($id,'9','componente quantita', $array_componente_quantita_kit[$i],$idUtente,$idAzienda,$dt_abilitato);
		inserisciDettaglioOrdine($id,'10','componente prezzo', $array_componente_prezzo[$i],$idUtente,$idAzienda,$dt_abilitato);
		inserisciDettaglioOrdine($id,'11','componente qta in ordini', $array_componente_qta_in_ordine[$i],$idUtente,$idAzienda,$dt_abilitato);
		inserisciDettaglioOrdine($id,'12','componente fornitore', $array_componente_fornitore[$i],$idUtente,$idAzienda,$dt_abilitato);
		inserisciDettaglioOrdine($id,'13','componente differenza', $array_componente_differenza[$i],$idUtente,$idAzienda,$dt_abilitato);
		inserisciDettaglioOrdine($id,'14','componente scorta min', $array_componente_scorta_minima[$i],$idUtente,$idAzienda,$dt_abilitato);
		  
	}
 

?>