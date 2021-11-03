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
				include('../include/precisione.php');
				include('sql/query.php'); 
		
				$id = $_GET['ordine']; 
		
				//Recupera Elenco Responsabili
				$elenco_resp = []; 
				array_push($elenco_resp, $selResponsabile); 
				$sqlres = recuperaElencoResponsabiliProduzioneChimica(); 
				while ($res = mysql_fetch_array($sqlres)) {  
					array_push($elenco_resp, $res['nome']. " ".$res['cognome']); 

				}	
			 		
		?>
		
		<script> 
			
		var note_prodotto = [];
			 
		function salva(){
			   
			var richiesta = new XMLHttpRequest();  
			var dati_aggiorna_ordine = [];
			 
			var nProd = note_prodotto.length; 
			
			dati_aggiorna_ordine.push("<?php echo $id; ?>"); 
			dati_aggiorna_ordine.push(document.getElementById('noteOrdine').value);
			dati_aggiorna_ordine.push(nProd);
			for (var i=0; i<nProd; i++){
				dati_aggiorna_ordine.push(document.getElementById('noteOrdine'+i).value);
				dati_aggiorna_ordine.push(note_prodotto[i]);
			}  
			
			
			richiesta.onload = function() { 
						var res = this.responseText;  
	
						alert("<?php echo $msgOrdineModificato ?>"); 
 						location.href = "ordini_produzione.php";
			};  
			
			richiesta.open("get", "moduli/aggiorna_note_ordine.php?dati_aggiorna_ordine="+JSON.stringify(dati_aggiorna_ordine), true); 
			richiesta.send();
		
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
				?> <script> note_prodotto.push("<?php echo $res['id'] ?>");</script> <?php
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
			
			$comp_quantita = []; 
			$sqlres = recuperaDettagliOrdine($id,9); 
			while ($res = mysql_fetch_array($sqlres)) {   
				array_push($comp_quantita,$res['valore']); 
			}
			 
            ?>
        <table width="100%" class="table2" id= "dati_odine">
			<tr>
				<td class="cella3" colspan="5" style="font-size: 14px;" id="rep";><?php echo $titleDettaglEvadiOrdine; ?></td>
			</tr> 
			<tr> 
				<th class="cella2" colspan="1" style="font-size: 12px; width:500px;"> <label><?php echo $titleDettagliIdOrdine; ?></label></th> 
				<th class="cella1" colspan="4" style="font-size: 14px; font-weight:normal; "> <?php echo $id; ?></th>  
			</tr>  
			<tr> 
				<th class="cella2" colspan="1" style="font-size: 12px; "> <label><?php echo $titleDettagliCodiceOrdine; ?></label></th> 
				<th class="cella1" colspan="4" style="font-size: 14px; font-weight:normal; "> <?php echo $codice_ordine; ?></th>  
			</tr>  
			<tr> 
				<th class="cella2" colspan="1" style="font-size: 12px; "> <label><?php echo $titleDettagliDataOrdine; ?></label></th> 
				<th class="cella1" colspan="4" style="font-size: 14px; font-weight:normal; "> <?php echo $data; ?></th>  
			</tr> 
			<tr> 
				<th class="cella2" colspan="1" style="font-size: 12px; "> <label><?php echo $titleDettagliOrdineAbilitato; ?></label></th> 
				<th class="cella1" colspan="4" style="font-size: 14px; font-weight:normal; "> <?php echo $abilitato; ?></th>  
			</tr> 
			<tr> 
				<th class="cella2" colspan="1" style="font-size: 12px; "> <label><?php echo $titleDettagliOrdineDataAbilitato; ?></label></th> 
				<th class="cella1" colspan="4" style="font-size: 14px; font-weight:normal; "> <?php echo $dt_abilitato; ?></th>  
			</tr> 
			<tr> 
				<th class="cella2" colspan="1" style="font-size: 12px; "> <label><?php echo $titleDettagliOrdineDataEvasionePrevista; ?></label></th> 
				<th class="cella1" colspan="4" style="font-size: 14px; font-weight:normal; "> <?php echo $data_evasione_prevista; ?></th>  
		 	</tr> 
			 
			<tr> 
				<th class="cella2" colspan="1" style="font-size: 12px; "> <label><?php echo $titleDettagliOrdineNote; ?></label></th> 
				<th  class="cella1" colspan="4" style="font-size: 14px; font-weight:normal; "><textarea id="<?php echo "noteOrdine"; ?>" name="noteOrdine" style="font-size:10pt; font-weight:normal; height:100px;width:800px; text-align:left"><?php echo $note; ?></textarea></th> 
				
				
				
		 	</tr>
			
			<tr>
				<td class="cella3" colspan="5" style="font-size: 14px;" id="rep";><?php echo $titleDettagliProdottiInOrdine; ?></td>
			</tr> 
			
			<tr>
				<td class="cella2" colspan="1" style="font-size: 12px; font-weight: bold; text-align: left;"><?php echo $titleDettagliProdottiProdotto; ?></td>
				<td class="cella2" colspan="1" style="font-size: 12px; font-weight: bold; width:100px; text-align: center;"><?php echo $titleDettagliProdottiMagazzino; ?></td>
				<td class="cella2" colspan="1" style="font-size: 12px; font-weight: bold; width=100px; text-align: center;"><?php echo $titleDettagliProdottiRichiesta; ?></td>
				<td class="cella2" colspan="1" style="font-size: 12px; font-weight: bold; width=100px; text-align: center;"><?php echo $titleDettagliProdottiDaProdurre; ?></td> 
				<td class="cella2" colspan="2" style="font-size: 12px; font-weight: bold; text-align: center;" ><?php echo $titelOrdineNote; ?></td>
				
			</tr> 
			
			
			<?php 
			for ($i=0; $i<count($prodotti); $i++){?>
				<tr> 
					<th class="cella1" colspan="1" style="font-size: 14px; font-weight:normal; "> <?php echo $prodotti[$i]; ?></th>   
					<th class="cella1" colspan="1" style="font-size: 14px; font-weight:normal; "> <?php echo $q_magazzino[$i]; ?></th>  
					<th class="cella1" colspan="1" style="font-size: 14px; font-weight:normal; "> <?php echo $q_richiesta[$i]; ?></th>  
					<th class="cella1" colspan="1" style="font-size: 14px; font-weight:normal; "> <?php echo $q_produrre[$i]; ?></th>   
					<th  class="cella1" colspan="1" style="font-size: 14px; font-weight:normal; "><textarea id="<?php echo "noteOrdine".$i ?>" name="noteOrdine" style="font-size:10pt; font-weight:normal; height:100px; width:500px; text-align:left"><?php print "$note_prodotto[$i]"; ?></textarea></th> 
		 		</tr>
				
				
			<?php } ?>
			
			 
			<tr>
				<td class="cella3" colspan="5" style="font-size: 14px;" id="rep";><?php echo $titleDettagliMateriePrimeUtilizzate; ?></td>
			</tr> 
			
			<tr>
				<td class="cella2" colspan="3" style="font-size: 12px; font-weight: bold; text-align: left;" ><?php echo $titleDettagliMateriePrimeComponente; ?></td>
				<td class="cella2" colspan="2" style="font-size: 12px; font-weight: bold; text-align: center;" ><?php echo $titleDettagliMateriePrimeQuantita ; ?></td> 
				
			</tr> 
			
			<?php 
			for ($i=0; $i<count($comp_codice); $i++){ ?>
				<tr> 
					<th class="cella1" colspan="3" style="font-size: 14px; font-weight:normal; "> <?php echo $comp_codice[$i]. " - ". $comp_nome[$i]; ?></th>   
					<th class="cella1" colspan="2" style="font-size: 14px; font-weight:normal; text-align: center;"> <?php echo $comp_quantita[$i]; ?></th>  
		 		</tr>
				
				
			<?php }?>
			 
			 
			
		</table>
	

	<input class = "button2" type='button' style="font-size:18pt;height:420px;width:200px; float: right;" value="<?php echo $titleButtonAggiornaNote; ?>" onClick="salva()" />
        </div><!--mainContainer--> 
    </body>

 

</html>