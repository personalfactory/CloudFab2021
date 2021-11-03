<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
		<meta charset="UTF-8">
  		<meta name="viewport" content="width=device-width, initial-scale=1.0">
  		<meta http-equiv="X-UA-Compatible" content="ie=edge">
 		<script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.1.2/handlebars.min.js"></script>
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
		
        <?php 
				include('../include/header.php'); 
				include('sql/query.php'); 
		
				$id = $_GET['ordine'];  
		?>
		
		<script> 
		function indietro(){
			 
			location.href = "ordini_produzione.php"; 
			 
		}
			 
		
		</script>
	</head>
	
	<body onload="aggiungiRiga()">
        <div id="mainContainer" style = "width:1200px;">
            <?php
            include('../include/menu.php');
            include('../Connessioni/serverdb.php'); 
			 
			$codice_ordine= "";
			$responsabile_ordine= "";
			$data= "";
			$abilitato= "";
			$dt_abilitato= ""; 
			$data_evasione_prevista= "";
			$stato_evasione= "";
			$dt_evasione= "";
			$resp_evasione= "";
			$annullamento= ""; 
			$data_annullamento= "";
			$resp_annullamento= "";
			$note= "";
			$info1= "";
			$info2= "";
			$info3= "";
			$info4= "";
			$info5= "";
			$id_utente= "";
			$id_azienda= "";
			
			
			
            //Recupero il cod stab della bolla
			$sqlres = recuperaInformazioniOrdine($id);
	 
			while ($res = mysql_fetch_array($sqlres)) {   
				
				$codice_ordine = $res['codice_ordine'];
				$resp_ordine = $res['resp_ordine'];
				$data = $res['data'];
				$abilitato = $res['abilitato'];
				$dt_abilitato = $res['dt_abilitato'];
				$data_evasione_prevista = $res['data_evasione_prevista'];
				$stato_evasione = $res['stato_evasione'];
				$dt_evasione = $res['dt_evasione'];
				$resp_evasione = $res['resp_evasione'];
				$annullamento = $res['annullamento'];
				$data_annullamento = $res['data_annullamento'];
				$resp_annullamento = $res['resp_annullamento'];
				$note = $res['note'];
				$note_evasione = $res['note_evasione'];
				$note_annullamento = $res['note_annullamento'];
				$info1 = $res['info1'];
				$info2 = $res['info2'];
				$info3 = $res['info3'];
				$info4 = $res['info4'];
				$info5 = $res['info5'];
				$id_utente = $res['id_utente'];
				$id_azienda = $res['id_azienda'];
			}
			
			//Recupero dettagli ordine
			$prodotti = []; 
			$sqlres = recuperaDettagliOrdine($id,1); 
			while ($res = mysql_fetch_array($sqlres)) {   
				array_push($prodotti,$res['valore']); 
			}
			
			$q_magazzino = []; 
			$sqlres = recuperaDettagliOrdine($id,2); 
			while ($res = mysql_fetch_array($sqlres)) {   
				array_push($q_magazzino,$res['valore']); 
			}
			
			$q_richiesta = []; 
			$sqlres = recuperaDettagliOrdine($id,3); 
			while ($res = mysql_fetch_array($sqlres)) {   
				array_push($q_richiesta,$res['valore']); 
			}
			
			$q_produrre = []; 
			$sqlres = recuperaDettagliOrdine($id,4); 
			while ($res = mysql_fetch_array($sqlres)) {   
				array_push($q_produrre,$res['valore']); 
			}
			
			$note_prodotto = []; 
			$sqlres = recuperaDettagliOrdine($id,5); 
			while ($res = mysql_fetch_array($sqlres)) {   
				array_push($note_prodotto,$res['valore']); 
			}
			
			$comp_codice = []; 
			$sqlres = recuperaDettagliOrdine($id,6); 
			while ($res = mysql_fetch_array($sqlres)) {   
				array_push($comp_codice,$res['valore']); 
			}
			
			$comp_nome = []; 
			$sqlres = recuperaDettagliOrdine($id,7); 
			while ($res = mysql_fetch_array($sqlres)) {   
				array_push($comp_nome,$res['valore']); 
			}
			
			$comp_giacenza = []; 
			$sqlres = recuperaDettagliOrdine($id,8); 
			while ($res = mysql_fetch_array($sqlres)) {   
				array_push($comp_giacenza,$res['valore']); 
			}
							  
			$comp_quantita = []; 
			$sqlres = recuperaDettagliOrdine($id,9); 
			while ($res = mysql_fetch_array($sqlres)) {   
				array_push($comp_quantita,$res['valore']); 
			}
							  
			$comp_costo = []; 
			$sqlres = recuperaDettagliOrdine($id,10); 
			while ($res = mysql_fetch_array($sqlres)) {   
				array_push($comp_costo,$res['valore']); 
			}
							  
			$comp_in_ordini = []; 
			$sqlres = recuperaDettagliOrdine($id,11); 
			while ($res = mysql_fetch_array($sqlres)) {   
				array_push($comp_in_ordini,$res['valore']); 
			}
			
			$comp_fornitore = []; 
			$sqlres = recuperaDettagliOrdine($id,12); 
			while ($res = mysql_fetch_array($sqlres)) {   
				array_push($comp_fornitore,$res['valore']); 
			}	
							  
			$comp_disponibilita = []; 
			$sqlres = recuperaDettagliOrdine($id,13); 
			while ($res = mysql_fetch_array($sqlres)) {   
				array_push($comp_disponibilita,$res['valore']); 
			}				  
			 
			$comp_scorta = []; 
			$sqlres = recuperaDettagliOrdine($id,14); 
			while ($res = mysql_fetch_array($sqlres)) {   
				array_push($comp_scorta,$res['valore']); 
			}
			
			
			 
            ?>
        <table width="100%" class="table2" id= "dati_odine">
			<tr>
				<td class="cella3" colspan="9" style="font-size: 12px;" id="rep";><?php echo $titleDettagOrdine; ?></td>
			</tr> 
			<tr> 
				<th class="cella2" colspan="2" style="font-size: 12px;"> <label><?php echo $titleDettagliIdOrdine; ?></label></th> 
				<th class="cella1" colspan="7" style="font-size: 12px; font-weight:normal; "> <?php echo $id; ?></th>  
			</tr>  
			<tr> 
				<th class="cella2" colspan="2" style="font-size: 12px;"> <label><?php echo $titleDettagliCodiceOrdine; ?></label></th> 
				<th class="cella1" colspan="7" style="font-size: 12px; font-weight:normal; "> <?php echo $codice_ordine; ?></th>  
			</tr>  
			<tr> 
				<th class="cella2" colspan="2" style="font-size: 12px;"> <label><?php echo $titleDettagliDataOrdine; ?></label></th> 
				<th class="cella1" colspan="7" style="font-size: 12px; font-weight:normal; "> <?php echo $data; ?></th>  
			</tr> 
			<tr> 
				<th class="cella2" colspan="2" style="font-size: 12px;"> <label><?php echo $titleDettagliOrdineAbilitato; ?></label></th> 
				<th class="cella1" colspan="7" style="font-size: 12px; font-weight:normal; "> <?php echo $abilitato; ?></th>  
			</tr> 
			<tr> 
				<th class="cella2" colspan="2" style="font-size: 12px;"> <label><?php echo $titleDettagliOrdineDataAbilitato; ?></label></th> 
				<th class="cella1" colspan="7" style="font-size: 12px; font-weight:normal; "> <?php echo $dt_abilitato; ?></th>  
			</tr>  
			<tr> 
				<th class="cella2" colspan="2" style="font-size: 12px;"> <label><?php echo $titleDettagliOrdineDataEvasionePrevista; ?></label></th> 
				<th class="cella1" colspan="7" style="font-size: 12px; font-weight:normal; "> <?php echo $data_evasione_prevista; ?></th>  
		 	</tr>
			<tr> 
				<th class="cella2" colspan="2" style="font-size: 12px;"> <label><?php echo $titleDettagliOrdineNote ; ?></label></th> 
				<th class="cella1" colspan="7" style="font-size: 12px; font-weight:normal; "> <?php echo $note; ?></th>  
		 	</tr>
			
			<?php if ($stato_evasione==='1') { ?>
			<tr>
				<td class="cella3" colspan="9" style="font-size: 12px;" id="rep";><?php echo $titleStatoOrdineEvaso; ?></td>
			</tr> 
		 
			<tr> 
				<th class="cella2" colspan="2" style="font-size: 12px;"> <label><?php echo $titleDettagliEvasioneData ; ?></label></th> 
				<th class="cella1" colspan="7" style="font-size: 12px; font-weight:normal; color:green"> <?php echo $dt_evasione; ?></th>  
		 	</tr> 
			<tr> 
				<th class="cella2" colspan="2" style="font-size: 12px;"> <label><?php echo $titleDettagliEvasioneResponsabile; ?></label></th> 
				<th class="cella1" colspan="7" style="font-size: 12px; font-weight:normal; color:green"> <?php echo $resp_evasione; ?></th>  
		 	</tr> 
			<tr> 
				<th class="cella2" colspan="2" style="font-size: 12px;"> <label><?php echo $titleDettagliEvasioneNote; ?></label></th> 
				<th class="cella1" colspan="7" style="font-size: 12px; font-weight:normal; color:green"> <?php echo $note_evasione; ?></th>  
		 	</tr> 
			<?php } else if ($annullamento==='1') { ?>
			<tr>
				<td class="cella3" colspan="9" style="font-size: 12px;" id="rep";><?php echo $titleStatoOrdineAnnullato; ?></td>
			</tr>
			  
			<tr> 
				<th class="cella2" colspan="2" style="font-size: 12px;"> <label><?php echo $titleDettagliAnnullamentoResponsabile; ?></label></th> 
				<th class="cella1" colspan="7" style="font-size: 12px; font-weight:normal; color:red"> <?php echo $resp_annullamento; ?></th>  
		 	</tr> 
			
			<tr> 
				<th class="cella2" colspan="2" style="font-size: 12px;"> <label><?php echo $titleDettagliAnnullamentoData; ?></label></th> 
				<th class="cella1" colspan="7" style="font-size: 12px; font-weight:normal; color:red"> <?php echo $data_annullamento; ?></th>  
		 	</tr>
			<tr> 
				<th class="cella2" colspan="2" style="font-size: 12px;"> <label><?php echo $titleDettagliAnnullamentoNote; ?></label></th> 
				<th class="cella1" colspan="7" style="font-size: 12px; font-weight:normal;  color:red"> <?php echo $note_annullamento; ?></th>  
		 	</tr>
			
			<?php } else { ?>
			
			<tr>
				<td class="cella2" colspan="9" style="font-size: 12px; text-align: center; background-color:lawngreen" id="rep";><?php echo $titleStatoOrdineInLavorazione; ?></td>
			</tr> 
			
			<?php } ?>
			 
			<tr>
				<td class="cella3" colspan="9" style="font-size: 12px;" id="rep";><?php echo $titleDettagliProdottiInOrdine; ?></td>
			</tr> 
			
			<tr>
				<td class="cella2" colspan="3" style="font-size: 12px;" id="rep";><?php echo $titleDettagliProdottiProdotto; ?></td>
				<td class="cella2" colspan="1" style="font-size: 12px; text-align: center;"><?php echo $titleDettagliProdottiMagazzino." (" .$titlePezzi. ")"; ?></td>
				<td class="cella2" colspan="1" style="font-size: 12px; text-align: center;"><?php echo $titleDettagliProdottiRichiesta." (" .$titlePezzi. ")"; ?></td>
				<td class="cella2" colspan="1" style="font-size: 12px;text-align: center;"><?php echo $titleDettagliProdottiDaProdurre." (" .$titlePezzi. ")"; ?></td>
				<td class="cella2" colspan="3" style="font-size: 12px;text-align: center;"><?php echo $titelOrdineNote; ?></td>
				
			</tr> 
			
			<?php 
			for ($i=0; $i<count($prodotti); $i++){?>
				<tr> 
					<th class="cella1" colspan="3" style="font-size: 12px; font-weight:normal;"> <?php echo $prodotti[$i]; ?></th>   
					<th class="cella1" colspan="1" style="font-size: 12px; font-weight:normal; text-align: center;"><?php echo $q_magazzino[$i] ?></th>  
					<th class="cella1" colspan="1" style="font-size: 12px; font-weight:normal; text-align: center;"><?php echo $q_richiesta[$i]?></th>  
					<th class="cella1" colspan="1" style="font-size: 12px; font-weight:normal; text-align: center;"><?php echo $q_produrre[$i]; ?></th>   
					<th class="cella1" colspan="3" style="font-size: 12px; font-weight:normal; text-align: left;"><?php echo $note_prodotto[$i]; ?></th> 
					
		 		</tr>
				
				
			<?php } ?>
			
			 
			<tr>
				<td class="cella3" colspan="9" style="font-size: 12px;" id="rep";><?php echo $titleDettagliMateriePrimeUtilizzate; ?></td>
			</tr> 
			
			<tr>
				<td class="cella2" colspan="2" style="font-size: 12px; font-weight:bold" id="rep";><?php echo $titleDettagliProd0; ?></td>
				<td class="cella2" colspan="1" style="font-size: 12px; font-weight:bold; text-align: center;" id="rep";><?php echo $titleDettagliProd1; ?></td>
				<td class="cella2" colspan="1" style="font-size: 12px; font-weight:bold; text-align: center;" id="rep";><?php echo $titleDettagliProd2; ?></td>
				<td class="cella2" colspan="1" style="font-size: 12px; font-weight:bold; text-align: center;" id="rep";><?php echo $titleDettagliProd3; ?></td> 
				<td class="cella2" colspan="1" style="font-size: 12px; font-weight:bold; text-align: center;" id="rep";><?php echo $titleDettagliProd4; ?></td>
				<td class="cella2" colspan="1" style="font-size: 12px; font-weight:bold; text-align: center;" id="rep";><?php echo $titleDettagliProd5; ?></td>
				<td class="cella2" colspan="1" style="font-size: 12px; font-weight:bold; text-align: center;" id="rep";><?php echo $titleDettagliProd6; ?></td>
				<td class="cella2" colspan="1" style="font-size: 12px; font-weight:bold; text-align: center;" id="rep";><?php echo $titleDettagliProd7; ?></td>
				
			</tr> 
			
			<?php 
			for ($i=0; $i<count($comp_codice); $i++){  
				$pari = ($i % 2 == 0);
					?>
				<tr > 
					<th class="cella1"  colspan="2" style="font-size: 12px; font-weight:normal; "> <?php echo $comp_codice[$i]. " - ". $comp_nome[$i]; ?></th> 
					<th class="cella1" colspan="1" style="font-size: 12px; font-weight:normal; text-align: center;"> <?php echo $comp_fornitore[$i]; ?></th> 
					<th class="cella1" colspan="1" style="font-size: 12px; font-weight:normal; text-align: center; <?php if ($comp_giacenza[$i]<0) {?> color:red; bgcolor:red; <?php }?> "> <?php echo $comp_giacenza[$i]; ?></th> 
					<th class="cella1" colspan="1" style="font-size: 12px; font-weight:normal; text-align: center;"> <?php echo $comp_quantita[$i]; ?></th>  
					<th class="cella1" colspan="1" style="font-size: 12px; font-weight:normal; text-align: center;"> <?php echo $comp_costo[$i]; ?></th>  
					<th class="cella1" colspan="1" style="font-size: 12px; font-weight:normal; text-align: center;"> <?php echo $comp_in_ordini[$i]; ?></th>  
					<th class="cella1" colspan="1" style="font-size: 12px; font-weight:normal; text-align: center; <?php if ($comp_disponibilita[$i]<0) {?> color:red; <?php }?> "> <?php echo $comp_disponibilita[$i]; ?></th>  
					<th class="cella1" colspan="1" style="font-size: 12px; font-weight:normal; text-align: center;"> <?php echo $comp_scorta[$i]; ?></th> 
		 		</tr>
				
				
			<?php }?> 
		</table>
	<br>
	<input class = "button2" type='button' style="font-size:18pt;height:420px;width:200px; float: right;" value="<?php echo "Indietro"; ?>" onClick="indietro()" />
   
		</div><!--mainContainer--> 
    </body>
</html>