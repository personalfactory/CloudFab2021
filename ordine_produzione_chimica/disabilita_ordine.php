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
		
				//Recupera Elenco Responsabili
				$elenco_resp = []; 
				array_push($elenco_resp, $selResponsabile); 
				$sqlres = recuperaElencoResponsabiliProduzioneChimica(); 
				while ($res = mysql_fetch_array($sqlres)) {  
					array_push($elenco_resp, $res['nome']. " ".$res['cognome']); 

				}	
		?>
		
		<script>  
		function registraAbilita(annullamento) { 
			
			if(document.getElementById('respAbilitaDisabilita').selectedOptions[0].value<=0){//document.getElementById('respAnnullamento').value===""){
			   
				alert("<?php echo $msgErroreOrdine4; ?>");
			   
			} else { 
				var richiesta = new XMLHttpRequest();  
				var dati_abilita = [];
				dati_abilita.push("<?php echo $id; ?>");
				dati_abilita.push(annullamento);  
				dati_abilita.push(document.getElementById('respAbilitaDisabilita').selectedOptions[0].text);  
				richiesta.onload = function() { 
					var res = this.responseText; 
					if (annullamento ===1){
							alert("<?php echo $msgOrdineAbilitato ?>");
						} else {
							alert("<?php echo $msgOrdineDisabilitato ?>");
						}
					location.href = "ordini_produzione.php";
					};  
				richiesta.open("get", "moduli/registra_abilita_ordine.php?dati_abilita="+JSON.stringify(dati_abilita), true); 
				richiesta.send(); 
			}
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
				<td class="cella3" colspan="4" style="font-size: 14px;" id="rep";><?php echo $titleDettaglDisabilitaOrdine; ?></td>
			</tr> 
			<tr> 
				<th class="cella2" colspan="1" style="font-size: 12px;"> <label><?php echo $titleDettagliIdOrdine; ?></label></th> 
				<th class="cella1" colspan="3" style="font-size: 14px; font-weight:normal; "> <?php echo $id; ?></th>  
			</tr>  
			<tr> 
				<th class="cella2" colspan="1" style="font-size: 12px;"> <label><?php echo $titleDettagliCodiceOrdine; ?></label></th> 
				<th class="cella1" colspan="3" style="font-size: 14px; font-weight:normal; "> <?php echo $codice_ordine; ?></th>  
			</tr>  
			<tr> 
				<th class="cella2" colspan="1" style="font-size: 12px;"> <label><?php echo $titleDettagliDataOrdine; ?></label></th> 
				<th class="cella1" colspan="3" style="font-size: 14px; font-weight:normal; "> <?php echo $data; ?></th>  
			</tr> 
			<tr> 
				<th class="cella2" colspan="1" style="font-size: 12px;"> <label><?php echo $titleDettagliOrdineAbilitato; ?></label></th> 
				<th class="cella1" colspan="3" style="font-size: 14px; font-weight:normal; "> <?php echo $abilitato; ?></th>  
			</tr> 
			<tr> 
				<th class="cella2" colspan="1" style="font-size: 12px;"> <label><?php echo $titleDettagliOrdineDataAbilitato; ?></label></th> 
				<th class="cella1" colspan="3" style="font-size: 14px; font-weight:normal; "> <?php echo $dt_abilitato; ?></th>  
			</tr>  
			<tr> 
				<th class="cella2" colspan="1" style="font-size: 12px;"> <label><?php echo $titleDettagliOrdineDataEvasionePrevista; ?></label></th> 
				<th class="cella1" colspan="3" style="font-size: 14px; font-weight:normal; "> <?php echo $data_evasione_prevista; ?></th>  
		 	</tr> 
			 
			<tr> 
				<th class="cella2" colspan="1" style="font-size: 12px;"> <label><?php echo $titleDettagliOrdineNote; ?></label></th> 
				<th class="cella1" colspan="3" style="font-size: 14px; font-weight:normal; "> <?php echo $note; ?></th>  
		 	</tr>
			
			<tr>
				<td class="cella3" colspan="4" style="font-size: 14px;" id="rep";><?php echo $titleDettagliProdottiInOrdine; ?></td>
			</tr> 
			
			<tr>
				<td class="cella2" colspan="1" style="font-size: 14px;" id="rep";><?php echo $titleDettagliProdottiProdotto; ?></td>
				<td class="cella2" colspan="1" style="font-size: 14px;" id="rep";><?php echo $titleDettagliProdottiMagazzino; ?></td>
				<td class="cella2" colspan="1" style="font-size: 14px;" id="rep";><?php echo $titleDettagliProdottiRichiesta; ?></td>
				<td class="cella2" colspan="1" style="font-size: 14px;" id="rep";><?php echo $titleDettagliProdottiDaProdurre; ?></td>
				
			</tr> 
			
			
			<?php 
			for ($i=0; $i<count($prodotti); $i++){?>
				<tr> 
					<th class="cella1" colspan="1" style="font-size: 14px; font-weight:normal; "> <?php echo $prodotti[$i]; ?></th>   
					<th class="cella1" colspan="1" style="font-size: 14px; font-weight:normal; "> <?php echo $q_magazzino[$i]; ?></th>  
					<th class="cella1" colspan="1" style="font-size: 14px; font-weight:normal; "> <?php echo $q_richiesta[$i]; ?></th>  
					<th class="cella1" colspan="1" style="font-size: 14px; font-weight:normal; "> <?php echo $q_produrre[$i]; ?></th>  
		 		</tr>
				
				
			<?php } ?>
			
			 
			<tr>
				<td class="cella3" colspan="4" style="font-size: 14px;" id="rep";><?php echo $titleDettagliMateriePrimeUtilizzate; ?></td>
			</tr> 
			
			<tr>
				<td class="cella2" colspan="2" style="font-size: 14px;" id="rep";><?php echo $titleDettagliMateriePrimeComponente; ?></td>
				<td class="cella2" colspan="2" style="font-size: 14px;" id="rep";><?php echo $titleDettagliMateriePrimeQuantita ; ?></td> 
				
			</tr> 
			
			<?php 
			for ($i=0; $i<count($comp_codice); $i++){ ?>
				<tr> 
					<th class="cella1" colspan="2" style="font-size: 14px; font-weight:normal; "> <?php echo $comp_codice[$i]. " - ". $comp_nome[$i]; ?></th>   
					<th class="cella1" colspan="2" style="font-size: 14px; font-weight:normal; "> <?php echo $comp_quantita[$i]; ?></th>  
		 		</tr>
				
				
			<?php }?>
			<?php if($abilitato) { ?>
			<tr>
				<td class="cella2" colspan="9" style="font-size: 12px; text-align: center; background-color:lawngreen" id="rep";><?php echo $titleStatoOrdineAbilitato; ?></td>
			</tr> 
			  <?php } else { ?>
			<tr>
				<td class="cella2" colspan="9" style="font-size: 12px; text-align: center; background-color:orange" id="rep";><?php echo $titleStatoOrdineDisabilitato; ?></td>
			</tr> 
			<?php }  ?> 
			
			<tr>
				<td class="cella3" colspan="4" style="font-size: 14px;" id="rep";><?php echo $titleDettagliEvasione; ?></td>
			</tr> 
			 
			<tr> 
				<th class="cella2" colspan="1" style="font-size: 12px;"> <label><?php echo $titleDettagliAbilitaDisabilitaData; ?></label></th> 
				<th class="cella1" colspan="3" id="dataEvasione" style="font-size: 14px; font-weight:normal; "> <?php date_default_timezone_set('UTC'); echo date('Y-m-d H:i:s'); ?></th>
			</tr> 
			<tr> 
				<th class="cella2" colspan="1" style="font-size: 12px; width:100%; "><?php echo $titleDettagliAbilitaDisabilitaResponsabile; ?> </th>
				<th  class="cella1 "  colspan="3">
					<select class="select" id="respAbilitaDisabilita" style="font-size:12pt; font-weight:normal; height:20px;width:300px;">  
						<?php for ($i =0; $i<count($elenco_resp); $i++) { ?> 
						<option value="<?php echo $i; ?>"><?php echo $elenco_resp[$i];?></option>  
							<?php } ?>
						</select>  
                <!-- <th  class="cella1"  colspan="3">
					<input id="respOrdine" name="respOrdine" style="font-size:12pt; font-weight:normal; height:20px;width:300px;"> </input> </td>  -->
			</tr> 
			
		</table>
		<br>
		<?php if($abilitato) { ?>
		<input class = "button2" type='button' style="font-size:18pt;height:420px;width:200px; float: right;" value="<?php echo $titleButtonDisabilita; ?>" onClick="registraAbilita(0)" />
			<?php } else { ?>
		<input class = "button2" type='button' style="font-size:18pt;height:420px;width:200px; float: right;" value="<?php echo $titleButtonAbilita; ?>" onClick="registraAbilita(1)" />
			<?php }  ?>
        </div><!--mainContainer--> 
    </body>
</html>