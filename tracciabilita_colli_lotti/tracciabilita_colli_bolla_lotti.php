<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <?php include('../include/validator.php'); ?>
  <head>
    <?php 
		include('../include/header.php'); 
		include("../tracciabilita_colli_lotti/sql/query.php");
		include('../include/menu.php'); 
		include("../include/funzioni.php");
		include('../include/precisione.php');
		include('../Connessioni/serverdb.php');
		include('../sql/script.php');
		include('include/funzioni.php');  
		include("../tracciabilita_colli_lotti/include/properties.php");  
		include("../lingue/gestore.php"); 
		include("../tracciabilita_colli_lotti/library/elenco_classi.php");  
	  
	  
	    if (isset($_POST['NumDdt'])) {  

			$NumDdt = $_POST['NumDdt'];
			$DataEmi = $_POST['DataEmi'];
			$valCatMerLotti = "1";
			$CodStab =0;
			$IdMacchina =0;

			$articoli= array();
			$descri_articoli= array();
			$quanti= array();
			$sqlNumTotLotti = 0;
			 
			  
			//Recupero il cod stab della bolla
			$sqlCodStab = trovaInfoMovByDdtCatMer($NumDdt,$DataEmi,$valCatMerLotti); 
			while ($res = mysql_fetch_array($sqlCodStab)) {
				$CodStab=  $res['clfoco'];   
				$sqlNumTotLotti = $sqlNumTotLotti + $res['quanti']; 
				array_push($articoli, $res['artico']);
				array_push($descri_articoli, $res['descri_artico']);
				array_push($quanti, $res['quanti']); 
			}

			//Recupero idMacchina
			$sqlIdMacchina = trovaMacchinaByCodice($CodStab);   
			while ($res = mysql_fetch_array($sqlIdMacchina)) { 
				$IdMacchina = $res['id_macchina'];
			} 
			   
		  }  
	    ?>
	
  </head>
	
	  	<meta charset="UTF-8">
  		<meta name="viewport" content="width=device-width, initial-scale=1.0">
  		<meta http-equiv="X-UA-Compatible" content="ie=edge">
 		<script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.1.2/handlebars.min.js"></script>
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	
	<script type='text/javascript'>
	 
	//Inserimento Dati
	var numColli = 0; 
	var numColli = 0; 
	var numLotti = 0;   
	var numProdotti = 0; 
	var arrayCodiciLotto = []; 
	var arrayQtaCodLotto = [];

	//Verifica
	var prodReq = [];
	var qReq = [];
	var prodVer = [];
	var qVer = [];
	var index = 0;
	var lottiVerSize =0 ;

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// FUNZIONI INSERIMENTO DATI 	 
	/////////////////////////////////////////////////////////////////////////////////////////////////// recuperaInfoProdottoCodLottoInseriti
	function recuperaInfoProdottoCodLottoInseriti(codLotto){ 
  
		var nomeProdotto = "";
		var richiesta = new XMLHttpRequest(); 

		richiesta.onload = function() {   
			nomeProdotto = this.responseText;

				if(nomeProdotto.length>6){ 
					 
					//Modifica Visibilità Tabella 
					var div = document.getElementById('tElProd');
					div.style.visibility = 'visible';
					div = document.getElementById('tElProd1');
					div.style.visibility = 'visible';
					div = document.getElementById('tElProd2');
					div.style.visibility = 'visible';

					//Eliminazione virgolette nome Prodotto
					nomeProdotto = nomeProdotto.substr(nomeProdotto.indexOf('"')+1, nomeProdotto.length);
					nomeProdotto = nomeProdotto.substr(0, nomeProdotto.indexOf('"'));

					if (arrayCodiciLotto.includes(nomeProdotto)){ 
						//Incremento quantita codici lotto
						var ind = arrayCodiciLotto.indexOf(nomeProdotto)
						arrayQtaCodLotto[ind] = arrayQtaCodLotto[ind] +1;
						document.getElementById('qProd'+ind).innerHTML = arrayQtaCodLotto[ind];  
					} else { 
						//Inderimento nuovo codice
						arrayCodiciLotto.push(nomeProdotto);
						arrayQtaCodLotto.push(1); 
						//Aggiunta Codice Lotto
						table = document.getElementById('tab_el_prod');
						tbody = table.getElementsByTagName('tbody')[0];
						colonne = table.getElementsByTagName('th').length; 

						tr = document.createElement('tr'); 
						//Inserimento Nome prodotto
						var td = document.createElement('td');
						td.setAttribute("class", "cella111");
						td.setAttribute("id", "elencoProd" + numProdotti);
						td.setAttribute("name", "elencoProd" + numProdotti);
						td.setAttribute("colspan", "1"); 
						var tx = document.createTextNode(nomeProdotto.toUpperCase()); 
						td.appendChild(tx);
						tr.appendChild(td);
						//Inserimento Quantita Prodotto		
						td = document.createElement('td'); 
						td.setAttribute("class", "cella111");
						td.setAttribute("id", "qProd" + numProdotti);
						td.setAttribute("name", "qProd"  + numProdotti);
						td.setAttribute("colspan", "1"); 
						tx = document.createTextNode("1"); 
						td.appendChild(tx);
						tr.appendChild(td); 

						tbody.appendChild(tr);
						numProdotti++;  
					} 
					
					//Aggiorna quantita Associata
					if (prodReq.contains(nomeProdotto)){ 
						var id_prod = prodReq.indexOf(nomeProdotto); 
						document.getElementById("quanti_res"+id_prod).innerHTML = parseInt($("#quanti_res"+id_prod).text())+1; 
						if ($("#quanti_res"+id_prod).text()===$("#quanti"+id_prod).text()){
					 
							  document.getElementById("quanti_res"+id_prod).style.color='green';  
							  }
					}
					
				} else {
					//Visualizzazione Messaggio Codice Prodotto Errato
					alert("<?php echo $WarningCodiceProdottoErrato ?>");
				} 
			}; 

		richiesta.open("get", "moduli/recupera_info_codice_lotto.php?codLotto="+codLotto.substring(1, 6), true); 
		richiesta.send();
			 
	}  
		
	/////////////////////////////////////////////////////////////////////////////////////////////////// getLotto()
	function getLottiCollo(codice) {
			  
			var codCollo = codice;
			var richiesta = new XMLHttpRequest();  
			var res = "";
			var inserito = false;  
			  
			richiesta.onload = function() {
				res = this.responseText;  
				var lotti = [];
				var temp = "";
				if (res.length>0){ 
					var div = document.getElementById('tCodLotto');
					div.style.visibility = 'visible'; 
					////////////////////////////////////////////////////////////// Decodifica Risposta ----- DA MIGLIORARE
					res = res.substr(res.indexOf("[")+2,res.indexOf("]")-2);  
					while (res.length>0){
							if (res.indexOf(",")>0){
								temp = res.substr(0,res.indexOf(",")-1); 
								res = res.substr(res.indexOf(",")+2,res.length); 
							} else {
								temp = res.substr(0,res.indexOf("]")-1); 
								res = 0;
							} 
							lotti.push(temp);
					}

					for (var j=0; j<lotti.length; j++) {  
							var table = document.getElementById('tabella_lotti');
							var tbody = table.getElementsByTagName('tbody')[0];
							var colonne = table.getElementsByTagName('th').length; 
							var tr = document.createElement('tr');

							for(var i=0; i<colonne; i++){ 
								var td = document.createElement('td');
								td.setAttribute("class", "cella111");
								td.setAttribute("id", "codLotto" + numLotti);
								td.setAttribute("name", "codLotto" + numLotti);
								td.setAttribute("colspan", "2"); 
								var tx = document.createTextNode(lotti[j]); 
								td.appendChild(tx);
								tr.appendChild(td);
							}
							tbody.appendChild(tr);
							numLotti++;

						recuperaInfoProdottoCodLottoInseriti(lotti[j]);
						}  
					  document.getElementById("numTotLottiInseriti").innerHTML =numLotti;


					}
			};
				 
			richiesta.open("get", "moduli/recupera_lotti_json.php?codCollo="+codCollo, true); 
			richiesta.send(); 

	}
		 
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// FUNZIONI VERIFICA CODICE COLLO	
	
	/////////////////////////////////////////////////////////////////////////////////////////////////// verificaCodiceCollo
	function verificaCodiceCollo(id_table, val){

		var codCollo = val.toUpperCase();
		var richiesta = new XMLHttpRequest();  
		var res = "";
		var inserito = false;  
 
		//Verifica che il codice lotto non sia stato già inserito 
		for (var i=0; i<numColli; i++) { 
			var codiceCollo = $("#codCollo" + i).text(); 
			if (codiceCollo.includes(codCollo)){
				inserito = true;
			} 
		}

		if (inserito){ 
			//Visualizzazione messaggio codice collo già inserito
			alert("<?php echo $WarningCodiceColloInserito ?>");
		} else {   
			recuperaLottiColloPerVerifica(codCollo); 
		}	 

	}
	/////////////////////////////////////////////////////////////////////////////////////////////////// recuperaLottiColloPerVerifica
	function recuperaLottiColloPerVerifica(codCollo) { 
		
		var richiesta = new XMLHttpRequest();  
		var res = "";   
		var lottiVerifica = [];

		richiesta.onload = function() {
			res = this.responseText;  
			var codLotto = "";   
			lottiVerSize = 0;
			if (res.length>0){
					res = res.substr(res.indexOf("[")+2,res.indexOf("]")-2); 

					while (res.length>0){
						if (res.indexOf(",")>0){
							codLotto = res.substr(0,res.indexOf(",")-1); 
							res = res.substr(res.indexOf(",")+2,res.length); 
						} else {
							codLotto = res.substr(0,res.indexOf("]")-1); 
							res = 0;
						} 
						recuperaInfoProdottoColloPerVerifica(codLotto, codCollo);
						lottiVerifica.push(codLotto);
						lottiVerSize++;
					}  
			} 

		};

		richiesta.open("get", "moduli/recupera_lotti_json.php?codCollo="+codCollo, true); 
		richiesta.send(); 
 
	}	
		
	/////////////////////////////////////////////////////////////////////////////////////////////////// recuperaInfoProdottoColloPerVerifica	
	function recuperaInfoProdottoColloPerVerifica(codLotto, codCollo){ 
  
		var nomeProdotto = "";  
		var richiesta = new XMLHttpRequest(); 

			richiesta.onload = function() { 

				nomeProdotto = this.responseText; 

				//Eliminazione virgolette nome Prodotto
				nomeProdotto = nomeProdotto.substr(nomeProdotto.indexOf('"')+1, nomeProdotto.length);
				nomeProdotto = nomeProdotto.substr(0, nomeProdotto.indexOf('"'));

				if (prodVer.includes(nomeProdotto)){ 
					var ind = prodVer.indexOf(nomeProdotto)
					qVer[ind] = qVer[ind] +1;  
				} else { 
					prodVer.push(nomeProdotto);
					qVer.push(1); 
				}

				if (index===lottiVerSize-1){ 
					verificaDatiPerInserimento(codCollo); 
				} else {index++;}
			}; 


		richiesta.open("get", "moduli/recupera_info_codice_lotto.php?codLotto="+codLotto.substring(1, 6), true); 
		richiesta.send();
			
			 
	}
		
	/////////////////////////////////////////////////////////////////////////////////////////////////// recuperaInfoProdottoColloPerVerifica
	function verificaDatiPerInserimento(codCollo) {

		var richiesta = new XMLHttpRequest();  
		var codice_lotto_non_richiesto = false; 
		var numero_lotti_eccessivo = false; 
		var rep = "";
		var repQ1 = "";
		var repQ2 = "";
		var qAss = [];

		//Aggiorna numero prodotti già associati
		for (var j=0; j<prodReq.length; j++) {  
			 qAss.push($("#quanti_res"+j).text());

		}  
		
		//Verifica lotto prodotto richiesto e num lotti non eccessivo
		for (var i=0; i<prodVer.length; i++) {
			 
			 if(prodReq.contains(prodVer[i])){ 
				  var id = prodReq.indexOf(prodVer[i]);
				  if (qVer[i]>(qReq[id] - qAss[id])){ 
					  numero_lotti_eccessivo = true;
					  rep = prodVer[i];
					  repQ1 = qVer[i];
					  repQ2 = qReq[id] - qAss[id]; 
					  break;
				  }   
			 } else { 
				 codice_lotto_non_richiesto = true;
				 rep = prodVer[i];
				 break;
			 } 
		} 

		if (codice_lotto_non_richiesto){ 
			var msg1 = "<?php echo $msgErroreInserimentoCollo1." " ?>";
			var msg2 = "<?php echo " ".$msgErroreInserimentoCollo2 ?>";
			alert(msg1 + rep + msg2); 
		} else if (numero_lotti_eccessivo){ 
			var msg1 = "<?php echo $msgErroreInserimentoCollo3." " ?>";
			var msg2 = "<?php echo " ".$msgErroreInserimentoCollo4." " ?>";
			var msg3 = "<?php echo " ".$msgErroreInserimentoCollo5." " ?>";
			alert(msg1 + rep + msg2 + repQ2 + msg3 + repQ1);

		} else { 
			//Verifica Superata - Inserimento dati
			richiesta.onload = function() {
			res = this.responseText;  
						if(res.includes(codCollo)){    
							var table = document.getElementById('my_table');
							var tbody = table.getElementsByTagName('tbody')[0];
							var colonne = table.getElementsByTagName('th').length; 
							var tr = document.createElement('tr');
							for(var i=0; i<colonne; i++){
								 var td = document.createElement('td'); 
								 td.setAttribute("class", "cella111");
								 td.setAttribute("id", "codCollo" + numColli);
								 td.setAttribute("name", "codCollo" + numColli);
								 td.setAttribute("colspan", "3"); 
								 var tx = document.createTextNode(codCollo.toUpperCase()); 
								 td.appendChild(tx);
								 tr.appendChild(td);
							}
							tbody.appendChild(tr);
							numColli++;
							getLottiCollo(codCollo.toUpperCase());

					} else { 
						  alert("<?php echo $WarningCodiceColloIncorretto ?>");
					}

			};

			richiesta.open("get", "moduli/verifica_codice_collo.php?codCollo="+codCollo, true); 
			richiesta.send();
 
		}
 
		//Inizializzazione Array
		prodVer = [];
		qVer = []; 
	    index = 0;
	    lottiVerSize =0 ;
		codice_lotto_non_richiesto = false; 
		numero_lotti_eccessivo = false; 
		
	 }
		  
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// FUNZIONI GENERICHE
	/////////////////////////////////////////////////////////////////////////////////////////////////// sleep()
	function sleep(s){
		var now = new Date().getTime();
		while(new Date().getTime() < now + (s*1000)){ /* non faccio niente */ } 
	}
		   
	/////////////////////////////////////////////////////////////////////////////////////////////////// annulla()
	function annulla() { 
		  location.href = '../tracciabilita_colli_lotti/tracciabilita_colli_bolla.php'; 
	}
		 
	/////////////////////////////////////////////////////////////////////////////////////////////////// salva()
	function salva() {
		var i=0; 
		var codiciLottoStr = "";
		var codiciColloStr = ""; 
		let codici = [];
		let contatore = [];
 
		//Verifica numero_lotti_richiesti - numero_lotti_inseriti
		var num_lotti_non_sufficiente;
		for(var i=0; i<prodReq.length; i++){
			if ($("#quanti"+i).text()!==$("#quanti_res"+i).text()){
				num_lotti_non_sufficiente = true;
				alert("<?php echo $WarningNumLottiNonCorretto ?>");
				break;
			}  
		}
		  
		if (!num_lotti_non_sufficiente){
			
			//Numero lotti richiesti dalla bolla
			var numeroLottiRichiesti = $("#numTotLottiRichiesti").text(); 

			//Numero lotti inseriti
			var numeroLottiInseriti= $("#numTotLotti").text(); 

			while ($("#codLotto"+i).text()!==""){   
				codiciLottoStr = codiciLottoStr + $("#codLotto"+i).text() + "-"; 
				i++;
			}

			i=0; 
			while ($("#codCollo"+i).text()!==""){ 
				codiciColloStr = codiciColloStr + $("#codCollo"+i).text() + "-"; 
				i++;
			} 
			i=0;  
			while ($("#codLotto"+i).text()!==""){ 
				codiciLottoStr = codiciLottoStr + $("#codLotto"+i).text() + "-";  
				i++;
			}

			i=0; 
			while ($("#codCollo"+i).text()!==""){ 
				codiciColloStr = codiciColloStr + $("#codCollo"+i).text() + "-"; 
				i++;
			}

			//Numero Ddt
			var numDdt = $("#numDdt").text(); 

			//Data emissione documento di trasporto
			var dataEmi = $("#dataEmi").text(); 

			//Codice Stabilimento
			var codiceStab = $("#codStab").text();

			//idMacchina
			var idMacchina = $("#idMacchina").text(); 

			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				 
			  if (this.readyState == 4 && this.status == 200) {
				 alert("<?php echo $msgAssocciazioneBollaEseguita ?>");
				 location.href = '../tracciabilita_colli_lotti/tracciabilita_colli_bolla.php';
				}
			};
			xmlhttp.open("GET","moduli/associa_bolla.php?numDdt="+numDdt+"&dataEmi="+dataEmi+"&codiceStab="+codiceStab
						 +"&idMacchina="+idMacchina +"&codiciColloStr="+codiciColloStr+"&codiciLottoStr="+codiciLottoStr,true);
			xmlhttp.send();
 
			
		}  
	}
		   
	</script>
	
  <body> 
		
	   <div id="tracciabilitaContainer" style=" width:700px; margin:45px auto;">
      
          <table width="700px" id='my_table' class='tabella' cellspacing='0' cellpadding='0'>
			<tr>
                <td class="cella33" colspan="3"><?php echo $titleInfoDdt; ?></td>
            </tr>
           	 	
			<tr>
                <td class="cella22" ><?php echo $titleNumDdt ?> </td>
                <td  class="cella111" colspan="2" >
                   <label for="fname" name="numDdt" id="numDdt"  ><?php echo $NumDdt ?></label></td>
            </tr>
				
			<tr>
                <td class="cella22" ><?php echo $titleDataEmi  ?> </td>
                <td  class="cella111" colspan="2" >
                   <label for="fname" name="dataEmi" id="dataEmi"><?php echo $DataEmi ?></label></td>
            </tr>	
				
			<tr>
                <td class="cella22" ><?php echo $titleCodiceStab?> </td>
                <td  class="cella111" colspan="2" >
                   <label for="fname" name="codStab" id="codStab" ><?php echo $CodStab ?></label></td>
            </tr>	
				
			<tr>
                <td class="cella22" ><?php echo $titleIdMacchina ?> </td>
                <td  class="cella111" colspan="2" >
                   <label for="fname" name="idMacchina" id="idMacchina" colspan="2" ><?php echo $IdMacchina ?></label></td>
            </tr>		
				
			<tr>
                <td class="cella33" ><?php echo $titleLottiDaCaricare ?></td>
				<td class="cella33" style="font-size:10pt;"><?php echo "DA ASSOCIARE" ?></td>
				<td class="cella33" style="font-size:10pt;" ><?php echo "ASSOCIATI"?></td>
            </tr>
				
			<?php for ($i = 0; $i < count($articoli); ++$i) { ?>
				<tr>
					<td  class="cella111">
					   <label for="fname" name="artico" id="artico" ><?php 
															 			echo $articoli[$i]." - ".$descri_articoli[$i];
																			?><script> 
						   														prodReq.push("<?php echo $descri_articoli[$i]; ?>"); 
						   														qReq.push("<?php echo $quanti[$i]; ?>");  
						   													</script><?php
						   											?></label></td>
					<td  class="cella111">
					   <label for="fname" name="quanti" id="quanti<?php echo $i?>" ><?php echo $quanti[$i] ?></label></td>
					<td  class="cella111">
					   <label for="fname" name="quanti_res" id="quanti_res<?php echo $i?>" style ="color:crimson"><?php echo "0" ?></label></td>
				</tr>
			<?php }?>
				
			<tr>
				<td class="cella22" style="text-align:right"><?php echo $titleNumTotaleLotti ?> </td>
				<td  class="cella22" colspan="2">
				   <label for="fname" name="numTotLottiRichiesti" id="numTotLottiRichiesti" ><?php echo $sqlNumTotLotti ?></label></td>
			</tr>
			  <tr>
				<td class="cella22" style="text-align:right"><?php echo $titleNumTotaleLottiInseriti ?> </td>
				<td  class="cella22" colspan="2">
				   <label for="fname" name="numTotLottiRichiesti" id="numTotLottiInseriti" ><?php echo "0" ?></label></td>
			</tr>
				 
			<tr>	
				<td class="cella33" colspan="3"><?php echo $titleAggiungiCollo ?></td> 
			 </tr>
			
			<tr>	 
				<td  class="cella111" colspan="3">
				<input type="text" id="input" style="font-size:28pt; height:40px;width:600px;" ></span><script>
					input.onchange = function() { 
						verificaCodiceCollo('my_table', input.value); 
	  					input.value = "";  
					};
						</script>
				</td> 
			</tr>
				  
	  		<tr>	
				<th class="cella33" colspan="3" style="font-size:14pt;" ><?php echo $titleCodiciColli ?></th>
			 </tr>  
	  		
				
		</table> 
	
			<table width="700px" id='tabella_lotti' class='tabella' cellspacing='0' cellpadding='0'>
			<tr>
                <th id = "tCodLotto" class="cella33" colspan="2" style="visibility:hidden; font-size:14pt;"><?php echo $titoloCodiciLotto ?></th>
            </tr>
		</table>
	
		</table> 
			<!-- style="visibility:hidden;"-->
			<table width="700px" id='tab_el_prod' class='tabella' style="font-size:15pt;" cellspacing='0' cellpadding='0'>
			<tr>
                <td id = "tElProd" class="cella33" colspan="2" style="visibility:hidden;"><?php echo  $titleElencoProdotti ?></td>
            </tr>
           	 	
			<tr>
                <th id = "tElProd1" class="cella22" style="visibility:hidden; height:50px;"><?php echo $titleNomeProdotti ?> </th>
				<th id = "tElProd2" class="cella22" style="visibility:hidden; height:50px;"><?php echo $titleQtaProdotti ?> </th> 
            </tr>
						
		</table> 
	
			<tr name="tbody" colspan="2" > </tr> 	 
			  		<!--<input class = "button1" type='button' value="<?php //echo $titleCodiciLottoAggiungi ?>" onClick="aggiungiRiga('my_table')" /> -->
	  				<br>
	  				<input class = "button" style="font-size:18pt;height:420px;width:200px; float: right;" type='button' value="<?php echo $titleCodiciLottoBolloSalva?>" onClick="salva()" />
			  		<input class = "button" style="font-size:18pt;height:420px;width:200px; float: right;" type='button' value="<?php echo $titleCodiciLottoBolloAnnulla ?>" onClick="annulla()" /> 

	</div>  
	
      
  </body>
</html>

