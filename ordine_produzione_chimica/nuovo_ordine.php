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
		 
				////////////////////////////////////////////////////////////////////////// COSTRUZIONE CODICE ORDINE
				date_default_timezone_set('UTC'); 
				$res = getCounterOrdini(date('Y-m-d'));
				$index =1;  
				if (mysql_num_rows($res) != 0) {
					while ($ordini = mysql_fetch_array($res)) {   
						$index++; 
					}
				}

				while (strlen($index)<3){
					 $index = "0".$index; 
				}

				$codice = "OR".date('Ymd').$index; 
		
				$idUtente = $_SESSION['id_utente'];
				$idAzienda = $_SESSION['id_azienda'];
	  
	
		?>
    </head>
	<script>
		
		//Proprieta
		var txtTitleSize = "14px";
		var txtNormalSize = "12px";
		var txtBigSize = "16px"
		var altezzaRiga = "22px";
		var padding = "4px 12 px";
		var fontFamily = "Helvetica, sans";
		
		
		var numProdotti = 0;
		var prodotti = [];  
		var lista_prodotti = [];  
		var lotti_disponibili = []; 
		var matPrimeFormula_codice = [];
		var matPrimeFormula_descrizione = [];
		var matPrimeFormula_giacenza = [];
		var matPrimeFormula_quantita_kit = [];
		var matPrimeFormula_prezzo = []; 
		var matPrimeFormula_qta_in_ordine = []; 
		var matPrimeFormula_fornitore = []; 
		var matPrimeFormula_differenza = [];
		var matPrimeFormula_scorta_minima = [];
	
		var arrayProdotti = [];
		var arrayCodici = [];
		var arrayQta = []; 
		
		var codici_in_ordine = [];
		var qta_in_ordine = []; 
		
  	
		function salva(){
			  
			
			if (document.getElementById('nRichiesti0').value==="0"  || document.getElementById('prodotti0').value==="<?php echo $msgInizialeListaProdotti; ?>"){
				
				alert("<?php echo $msgErroreOrdine0; ?>");
				
			} else if (document.getElementById('respOrdine').selectedOptions[0].value<=0){
				
				alert("<?php echo $msgErroreOrdine1; ?>");
				
			} else {
				
				mostraLoading(); 
				var info_ordine = [ <?php echo $idUtente; ?>,
							<?php echo $idAzienda; ?>,
							document.getElementById('idOrdine').innerHTML,
							document.getElementById('codiceOrdine').innerHTML, 
							document.getElementById('dataOrdine').innerHTML,
							document.getElementById('dataEvasione').value,
							document.getElementById('respOrdine').selectedOptions[0].text,
							document.getElementById('noteOrdine').value,
							document.getElementById('info1Ordine').value,
							document.getElementById('info2Ordine').value,
							document.getElementById('info3Ordine').value,
							document.getElementById('info4Ordine').value,
							document.getElementById('info5Ordine').value];

				var info_produzioni_prodotti = [];
				var info_produzioni_nMagazzino = [];
				var info_produzioni_nRichiesti = [];
				var info_produzioni_qProdurre = [];
				var info_produzioni_note = [];
				
				for (var i = 0; i < numProdotti-1; i++) {  
					info_produzioni_prodotti.push(document.getElementById('prodotti'+i).selectedOptions[0].text);//document.getElementById('prodotti'+i).text);
					info_produzioni_nMagazzino.push(document.getElementById('nMagazzino'+i).value);
					info_produzioni_nRichiesti.push( document.getElementById('nRichiesti'+i).value);
					info_produzioni_qProdurre.push(document.getElementById('qProdurre'+i).innerHTML);
					info_produzioni_note.push(document.getElementById('note'+i).value); 
				}
				 
				info_ordine.push(info_produzioni_prodotti);
				info_ordine.push(info_produzioni_nMagazzino);
				info_ordine.push(info_produzioni_nRichiesti);
				info_ordine.push(info_produzioni_qProdurre); 
				info_ordine.push(info_produzioni_note);
				 
				info_ordine.push(matPrimeFormula_codice);
				info_ordine.push(matPrimeFormula_descrizione);
				info_ordine.push(matPrimeFormula_giacenza);
				info_ordine.push(matPrimeFormula_quantita_kit);
				info_ordine.push(matPrimeFormula_prezzo);
				info_ordine.push(matPrimeFormula_qta_in_ordine);  
				info_ordine.push(matPrimeFormula_fornitore);
				info_ordine.push(matPrimeFormula_differenza);
				info_ordine.push(matPrimeFormula_scorta_minima);
			  
				registraInfoOrdine(info_ordine); 
			} 
		}
		
		function registraInfoOrdine(info_ordine) {
		   
				var richiesta = new XMLHttpRequest();  
				richiesta.onload = function() { 
						var res = this.responseText;  
						alert("<?php echo $msgOrdineRegistrato ?>"); 
 						location.href = "ordini_produzione.php";
					};  
				richiesta.open("get", "moduli/registra_dettagli_ordine.php?infoOrdine="+JSON.stringify(info_ordine), true); 
				richiesta.send();
		
		}
		
		///////////////////////////////////////////////////////////////////////decodifica risposta json
		function decodificaRep(rep){
			var array_res = [];
			var temp_str=""; 
				if (rep.length>0){ 
					rep = rep.substr(rep.indexOf("[")+2,rep.indexOf("]")-2);  
					while (rep.length>0){   
						if (rep.indexOf('","')>0){ 
							temp_str = rep.substr(0,rep.indexOf('","')); 
							rep = rep.substr(rep.indexOf('","')+3,rep.length);  
						} else {
							temp_str = rep.substr(0,rep.indexOf("]")-1); 
							rep = 0;
						}   
						array_res.push(temp_str); 
					}  
				} 
			return array_res;  
		}
		///////////////////////////////////////////////////////////////////////decodifica stringa dati materie prime
		function decodificaStringaDatiMateriePrime(str){
		 
			var array_res = [];
			var temp="";  
			for (var i = 0; i < str.length; i++) { 
				if (str.charAt(i)==="%"){
					array_res.push(temp); 
					temp="";
				} else {
					temp = temp + str.charAt(i);
				} 
			}
			array_res.push(temp); 
			 	  
			return array_res;  
		}
		 
		function aggiornaDatiProdotto(){
			  
			arrayProdotti = [];
			arrayCodici = [];
			arrayQta = []; 
			
			matPrimeFormula_codice = [];
			matPrimeFormula_descrizione = [];
			matPrimeFormula_giacenza = [];
			matPrimeFormula_quantita_kit = [];
			matPrimeFormula_prezzo = [];
			matPrimeFormula_qta_in_ordine = []; 
			matPrimeFormula_fornitore = [];
			matPrimeFormula_differenza = [];
			matPrimeFormula_scorta_minima = []; 
			
			//recupero informazioni prodotti e quantità
			for (var k = 0; k< numProdotti; k++) { 
				var indice = document.getElementById('prodotti'+k).selectedOptions[0].value;
				var prodotto = prodotti[indice]; 
				//var qta = document.getElementById('qProdurre'+k).innerText; 
				var qta = document.getElementById('nRichiesti'+k).value;
				var codice = prodotto.substr(1,5);  
				arrayProdotti.push(prodotto);
				arrayCodici.push(codice);
				arrayQta.push(qta); 
			} 
			   
			ricercaDettagliFormula(arrayCodici, arrayQta);
		 
		}
		
		function aggiornaQtaProdurre(indice){ 
			
				var inMagazzino = document.getElementById('nMagazzino'+indice).value;
				var req = document.getElementById('nRichiesti'+indice).value;
				var daProdurre = 0;
				if ((req-inMagazzino)>0) {
					daProdurre = req-inMagazzino;
				} 
				document.getElementById('qProdurre'+indice).innerText = daProdurre;
			 
		}
		
		function inserisciDatiTabellaMateriaPrima(){
			
				$("#table_dettagli tr").remove();
				
				var table = document.getElementById('table_dettagli');
				var tbody = table.getElementsByTagName('tbody')[0];
				var colonne = table.getElementsByTagName('th').length; 
				var tr = document.createElement('tr');
				
				/////////////////////////////////////////////////////////////////////////// Intestazione tabella
				tr = document.createElement('tr'); 
				//Inserimento codice e nome compoennte
				var td = document.createElement('td');
				td.setAttribute("class", "cella3"); 
				td.setAttribute("colspan", "8");  
				td.style.height = "50px";
				td.style.textAlign ="center";
				td.style.fontSize = txtTitleSize;  
				var tx = document.createTextNode("<?php echo $titoloDettagliNuovoOrdine ?>"); 
				td.appendChild(tx);
				tr.appendChild(td);
				tbody.appendChild(tr);
				
				tr = document.createElement('tr'); 
				//Inserimento codice e nome compoennte
				var td = document.createElement('td');
				td.setAttribute("class", "cella2"); 
				td.setAttribute("colspan", "1"); 	
				td.style.width = "250px";
				td.style.height = altezzaRiga;
				td.style.textAlign ="center";
				td.style.fontSize = txtNormalSize; 
				td.style.fontWeight = "bold";
				var tx = document.createTextNode("<?php echo $titleDettagliProd0; ?>");  
				td.appendChild(tx);
				tr.appendChild(td);
			
				var td = document.createElement('td');
				td.setAttribute("class", "cella2"); 
				td.setAttribute("colspan", "1"); 	
				td.style.width = "20px";
				td.style.height =  altezzaRiga;
				td.style.textAlign ="center";
				td.style.fontSize = txtNormalSize;
				td.style.fontWeight = "bold";   
				var tx = document.createTextNode("<?php echo $titleDettagliProd1; ?>");  
				td.appendChild(tx); 
				tr.appendChild(td);
				
				var td = document.createElement('td');
				td.setAttribute("class", "cella2"); 
				td.setAttribute("colspan", "1"); 	
				td.style.width = "40px";
				td.style.height =  altezzaRiga;
				td.style.textAlign ="center";
				td.style.fontSize = txtNormalSize;
				td.style.fontWeight = "bold";  
				var tx = document.createTextNode("<?php echo $titleDettagliProd2; ?>");  
				td.appendChild(tx); 
				tr.appendChild(td);
			 
				var td = document.createElement('td');
				td.setAttribute("class", "cella2"); 
				td.setAttribute("colspan", "1"); 	
				td.style.width = "40px";
				td.style.height =  altezzaRiga;
				td.style.textAlign ="center";
				td.style.fontSize = txtNormalSize; 
				td.style.fontWeight = "bold";  
				var tx = document.createTextNode("<?php echo $titleDettagliProd3; ?>");  
				td.appendChild(tx); 
				tr.appendChild(td);
				
				var td = document.createElement('td');
				td.setAttribute("class", "cella2"); 
				td.setAttribute("colspan", "1"); 	
				td.style.width = "40px";
				td.style.height =  altezzaRiga;
				td.style.textAlign ="center";
				td.style.fontSize = txtNormalSize; 
				td.style.fontWeight = "bold";  
				var tx = document.createTextNode("<?php echo $titleDettagliProd4; ?>");  
				td.appendChild(tx); 
				tr.appendChild(td);
			
				var td = document.createElement('td');
				td.setAttribute("class", "cella2"); 
				td.setAttribute("colspan", "1"); 	
				td.style.width = "40px";
				td.style.height =  altezzaRiga;
				td.style.textAlign ="center";
				td.style.fontSize = txtNormalSize; 
				td.style.fontWeight = "bold";  
				var tx = document.createTextNode("<?php echo $titleDettagliProd5; ?>");  
				td.appendChild(tx); 
				tr.appendChild(td);
			 
				var td = document.createElement('td');
				td.setAttribute("class", "cella2"); 
				td.setAttribute("colspan", "1"); 	
				td.style.width = "20px";
				td.style.height =  altezzaRiga;
				td.style.textAlign = "center";
				td.style.fontSize = txtNormalSize;
				td.style.fontWeight = "bold";  
				var tx = document.createTextNode("<?php echo $titleDettagliProd6; ?>");  
				td.appendChild(tx); 
				tr.appendChild(td);
				
				var td = document.createElement('td');
				td.setAttribute("class", "cella2"); 
				td.setAttribute("colspan", "1"); 	
				td.style.width = "40px";
				td.style.height =  altezzaRiga;
				td.style.textAlign ="center";
				td.style.fontSize = txtNormalSize;
				td.style.fontWeight = "bold";  
				var tx = document.createTextNode("<?php echo $titleDettagliProd7; ?>");  
				td.appendChild(tx); 
				tr.appendChild(td);
				
				tbody.appendChild(tr);
			  

				for (var i = 0; i < matPrimeFormula_codice.length; i++) {
			 
						var grayed = matPrimeFormula_quantita_kit[i]==0;
						var evidenza = matPrimeFormula_differenza[i]<=0;
						tr = document.createElement('tr'); 
						
						//Inserimento codice e nome compoennte
						var td = document.createElement('td');
						td.setAttribute("class", "cella1");
						td.setAttribute("id", "dettagliNome" + i); 
						td.setAttribute("colspan", "1");  
						td.style.height =  altezzaRiga;
						td.style.fontFamily = fontFamily;
						td.style.fontSize = txtNormalSize;
						if (grayed) { td.style.backgroundColor = "#949490"; } else if (evidenza) {td.style.backgroundColor = "#DEE906"; } 
						var tx = document.createTextNode(matPrimeFormula_codice[i] + " - " + matPrimeFormula_descrizione[i]); 
						td.appendChild(tx);
						tr.appendChild(td);
					 
						//Inserimento Fornitore
					 	var td = document.createElement('td');
						td.setAttribute("class", "cella1");
						td.setAttribute("id", "dettagliFornitore" + i); 
						td.setAttribute("colspan", "1"); 
						td.style.height =  altezzaRiga;
						td.style.fontFamily = fontFamily;
						td.style.fontSize = txtNormalSize;
						td.style.textAlign = "center"; 
						if (grayed) { td.style.backgroundColor = "#949490"; } else if (evidenza) {td.style.backgroundColor = "#DEE906"; } 
						var tx = document.createTextNode(matPrimeFormula_fornitore[i]); 
						td.appendChild(tx);
						tr.appendChild(td);
					
						//Inserimento Giacenza	
						var td = document.createElement('td');
						td.setAttribute("class", "cella1");
						td.setAttribute("id", "dettagliGiacenza" + i); 
						td.setAttribute("colspan", "1");   
						td.style.height =  altezzaRiga;
						td.style.fontFamily = fontFamily;
						td.style.fontSize = txtNormalSize;
						td.style.textAlign = "center"; 
						if (grayed) { td.style.backgroundColor = "#949490"; } else if (evidenza) {td.style.backgroundColor = "#DEE906"; } 
						var tx = document.createTextNode(matPrimeFormula_giacenza[i]);  
						td.appendChild(tx);
						tr.appendChild(td);
					
						//Inserimento Quantita Necessaria
						 var td = document.createElement('td');
						td.setAttribute("class", "cella1");
						td.setAttribute("id", "dettagliQNecessaria" + i); 
						td.setAttribute("colspan", "1");  
						td.style.height =  altezzaRiga;
						td.style.fontFamily = fontFamily;
						td.style.fontSize = txtNormalSize;
						td.style.textAlign = "center"; 
						if (grayed) { td.style.backgroundColor = "#949490"; } else if (evidenza) {td.style.backgroundColor = "#DEE906"; } 
						var tx = document.createTextNode(matPrimeFormula_quantita_kit[i]); 
						td.appendChild(tx);
						tr.appendChild(td);
					
						//Inserimento Costo
						 var td = document.createElement('td');
						td.setAttribute("class", "cella1");
						td.setAttribute("id", "dettagliCosto" + i); 
						td.setAttribute("colspan", "1"); 
						td.style.height =  altezzaRiga;
						td.style.fontFamily = fontFamily;
						td.style.fontSize = txtNormalSize;
						td.style.textAlign = "center"; 
						if (grayed) { td.style.backgroundColor = "#949490"; } else if (evidenza) {td.style.backgroundColor = "#DEE906"; } 
						var tx = document.createTextNode(matPrimeFormula_prezzo[i]); 
						td.appendChild(tx);
						tr.appendChild(td);
					
						//Inserimento Qta in Ordine
						var td = document.createElement('td');
						td.setAttribute("class", "cella1");
						td.setAttribute("id", "dettagliQtaInOrdine" + i); 
						td.setAttribute("colspan", "1"); 
						td.style.height =  altezzaRiga;
						td.style.fontFamily = fontFamily;
						td.style.fontSize = txtNormalSize;
						td.style.textAlign = "center"; 
						if (grayed) { td.style.backgroundColor = "#949490"; } else if (evidenza) {td.style.backgroundColor = "#DEE906"; }  
						var tx = document.createTextNode(matPrimeFormula_qta_in_ordine[i]); 
						td.appendChild(tx);
						tr.appendChild(td); 
					
						//Inserimento Differenza
						 var td = document.createElement('td');
						td.setAttribute("class", "cella1");
						td.setAttribute("id", "dettagliDifferenza" + i); 
						td.setAttribute("colspan", "1"); 
						td.style.height =  altezzaRiga;
						td.style.fontFamily = fontFamily;
						td.style.fontSize =txtNormalSize;
						td.style.textAlign = "center"; 
						if (matPrimeFormula_differenza[i]>0) { td.style.color = "green"; } else { td.style.color = "red"; } 
						if (grayed) { td.style.backgroundColor = "#949490"; } else if (evidenza) {td.style.backgroundColor = "#DEE906"; } 
						var tx = document.createTextNode(matPrimeFormula_differenza[i]); 
						td.appendChild(tx);
						tr.appendChild(td);
					
						//Inserimento Scorta Minima
						 var td = document.createElement('td');
						td.setAttribute("class", "cella1");
						td.setAttribute("id", "DettagliScorta" + i); 
						td.setAttribute("colspan", "1"); 
						td.style.height =  altezzaRiga;
						td.style.fontFamily = fontFamily;
						td.style.fontSize = txtNormalSize;
						td.style.textAlign = "center"; 
						if (grayed) { td.style.backgroundColor = "#949490"; } else if (evidenza) {td.style.backgroundColor = "#DEE906"; } 
						var tx = document.createTextNode(matPrimeFormula_scorta_minima[i]); 
						td.appendChild(tx);
						tr.appendChild(td); 
					 
						tbody.appendChild(tr);
					  
				} 
		}
		
		function aggiornaDettagliMagazzino(i) {
		 
			 
				var richiesta = new XMLHttpRequest();  
				richiesta.onload = function() { 
						var res = this.responseText;   
						lotti_disponibili = decodificaRep(res);   
						document.getElementById("nMagazzino"+i).value = lotti_disponibili[i]; 
					};  
				richiesta.open("get", "moduli/recupera_lotti_disponibili.php?codFormula="+arrayCodici, true); 
				richiesta.send();
		
		} 
		
		 
		function ricercaDettagliFormula(arrayCodici, arrayQta){
			  
			var richiesta = new XMLHttpRequest();  
			richiesta.onload = function() { 
				var res = this.responseText;     
				var dati_formula = decodificaRep(res); 
				
				for (var i = 0; i < dati_formula.length; i++) {
					
					var dati_comp = decodificaStringaDatiMateriePrime(dati_formula[i]); 
					
					var cod = dati_comp[0];
					var descri = dati_comp[1];  
					var giacenza = parseFloat(dati_comp[2]); 
					var qta = parseFloat((parseFloat(dati_comp[3])/parseFloat(dati_comp[6])) /1000); 
					var prezzo = parseFloat(dati_comp[4]) * parseFloat(qta);
					var qta_mancante = 0; //if (qta> giacenza){ qta_mancante = qta - giacenza; } 
					
					var quantita_ordine = 0;     // Leggere da db
					var scorta_minima = parseFloat(dati_comp[5]);  
					var fornitore = dati_comp[7];
					
					//Eliminazione carattere & se prensente perchè blocca la trasmissione dei dati 
					fornitore = fornitore.replace('&','e');
					  
					if (codici_in_ordine.indexOf(cod)>=0){ 
						quantita_ordine = parseFloat(qta_in_ordine[codici_in_ordine.indexOf(cod)]);
					}
					
					var differenza = parseFloat(giacenza-qta-quantita_ordine); 
					if (differenza<0) { qta_mancante = differenza*-1;}
					
					if (codici_in_ordine.indexOf(cod)>=0){ 
						quantita_ordine = qta_in_ordine[codici_in_ordine.indexOf(cod)];
					}
					
					var differenza = giacenza-qta-quantita_ordine; 
					if (differenza<0) { qta_mancante = differenza*-1;}
					 
					if (matPrimeFormula_codice.includes(dati_comp[0])){ 

						var ind = matPrimeFormula_codice.indexOf(cod);  
						matPrimeFormula_quantita_kit[ind] =  (parseFloat(matPrimeFormula_quantita_kit[ind]) + qta).toFixed(2);
						matPrimeFormula_prezzo[ind] = (parseFloat(matPrimeFormula_prezzo[ind]) + prezzo).toFixed(2); 
						matPrimeFormula_qta_in_ordine[ind] = parseFloat(quantita_ordine).toFixed(2); 
						matPrimeFormula_differenza[ind] =  (parseFloat(matPrimeFormula_differenza[ind]) - qta).toFixed(2) ; 


					} else { 
						matPrimeFormula_codice.push(cod);
						matPrimeFormula_descrizione.push(descri);
						matPrimeFormula_giacenza.push(parseFloat(giacenza).toFixed(2)); //Math.round(giacenza));
						matPrimeFormula_quantita_kit.push(parseFloat(qta).toFixed(2));//qta);
						matPrimeFormula_prezzo.push(parseFloat(prezzo).toFixed(2));//prezzo); 
						matPrimeFormula_qta_in_ordine.push(parseFloat(quantita_ordine).toFixed(2)); 
						matPrimeFormula_differenza.push(parseFloat(differenza).toFixed(2));//differenza);
						matPrimeFormula_scorta_minima.push(parseFloat(scorta_minima).toFixed(2));//scorta_minima);
						matPrimeFormula_fornitore.push(fornitore); 
					} 
				} 
				
				inserisciDatiTabellaMateriaPrima();
				
			};  
			richiesta.open("get", "moduli/recupera_info_componenti_formula.php?codFormula="+arrayCodici+"&quantita="+arrayQta, true); 
			richiesta.send(); 
		} 
		 
		
		function recuperaListaProdotti(){
			var res = "";
			var richiesta = new XMLHttpRequest();  
			richiesta.onload = function() {   
				res = this.responseText;  
				//Inizializza array
				prodotti=[];  
				prodotti.push("<?php echo $msgInizialeListaProdotti ?>");  
				///////////////////////////////////////////////////////////////////////decodifica risposta json
				if (res.length>0){
					var temp = ""; 
					res = res.substr(res.indexOf("[")+2,res.indexOf("]")-2);   
					while (res.length>0){ 
					if (res.indexOf(",")>0){ 
						temp = res.substr(0,res.indexOf(",")-1); 
						res = res.substr(res.indexOf(",")+2,res.length);  
					} else {
						temp = res.substr(0,res.indexOf("]")-1); 
						res = 0;
					}    
						prodotti.push(temp);

					}  
				}

				aggiungiRiga();
			
			}; 

			richiesta.open("get", "moduli/recupera_info_produzioni.php", true); 
			richiesta.send();
			
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////aggiungiRiga()
		function aggiungiRiga(){  
			
				lista_prodotti = [];
			
				///////////////////////////////////////////////////////////////////////Inserimento elementi Tabella
				var table = document.getElementById('my_table');
				var tbody = table.getElementsByTagName('tbody')[0];
				var colonne = table.getElementsByTagName('th').length; 
				var tr = document.createElement('tr');

				/////////////////////////////////////////////////////////////////selectBox lista prodotti
				var td = document.createElement('td');
				td.setAttribute("class", "cella11");
				td.setAttribute("id", "nomeProdotto" + numProdotti);
				td.setAttribute("name", "nomeProdotto" + numProdotti);
				td.style.textAlign = "left";
				td.style.height = altezzaRiga;

				var tx = document.createElement("select");
				tx.id = "prodotti" + numProdotti;
				tx.setAttribute("colspan", "1"); 
				tx.style.width = "500px";
				tx.style.height =  altezzaRiga;
				tx.style.fontFamily = fontFamily;
				tx.style.fontSize = txtBigSize;
				tx.style.padding = "8px 16 px";
				tx.style.border = "1px solid transparent";
				tx.style.borderColor = "transparent transparent rgba(0, 0, 0, 0.1) transparent";
				tx.style.cursor = "pointer";
			 
				for (var i = 0; i < prodotti.length; i++) {
					 
					var selezionato= false;  
					for (var j = 0; j < numProdotti; j++) { 
						 
						if(selezionato === false) { 
								if(document.getElementById('prodotti'+j).selectedOptions[0].text===prodotti[i]){
									selezionato = true;
									break;
								}
							} 
					}   
					
					if (!selezionato){
						var option = document.createElement("option");
						option.value = i;
						option.text = prodotti[i];
						lista_prodotti.push(prodotti[i]);
						tx.appendChild(option); 
						tx.onchange = function() {  
							var index = (this.id).replace("prodotti","");  
							aggiornaQtaProdurre(index);  
							aggiornaDatiProdotto();  
							aggiornaDettagliMagazzino(index); 
						};
					}  
				} 
				td.appendChild(tx);
				tr.appendChild(td);
				
				/////////////////////////////////////////////////////////////////Unita Quantita Magazzino
				td = document.createElement('td');
				td.setAttribute("class", "cella11"); 
				td.style.textAlign = "center";

				//Create and append select list
				tx = document.createElement("input");
				tx.id = 'nMagazzino'+numProdotti;
				tx.defaultValue = 0;
				tx.setAttribute("colspan", "1"); 
				tx.type="number"; 
				tx.style.width = "50px";
				tx.style.color = "#E97C00";
				tx.style.background = "#E0E0E0";
				tx.style.height = altezzaRiga;
				tx.style.fontFamily = fontFamily;
				tx.style.fontSize = txtNormalSize;
				tx.style.padding = padding;
				tx.onchange = function() {  
					if(this.value===""){
						this.value=0;
					} else {
						var index = (this.id).replace("nMagazzino",""); 
						aggiornaQtaProdurre(index);  
						aggiornaDatiProdotto();  
					}
				}; 
				tx.onkeyup = function() {
					this.value=this.value.replace(/[^\d]/,'0');
				}
				td.appendChild(tx);
				tr.appendChild(td); 
				
				/////////////////////////////////////////////////////////////////editBox quantita richiesta
				td = document.createElement('td');
				td.setAttribute("class", "cella11");
				td.setAttribute("id", "numPezzi" + numProdotti);
				td.setAttribute("value", "numPezzi" + numProdotti);
				td.setAttribute("name", "numPezzi" + numProdotti);
				td.style.textAlign = "center";

				//Create and append select list
				var tx = document.createElement("input");
				tx.id = "nRichiesti" + numProdotti;
				tx.defaultValue = 0;
				tx.setAttribute("colspan", "1"); 
				tx.style.width = "50px";
				tx.type="number"; 
				tx.style.height = altezzaRiga;
				tx.style.fontFamily = fontFamily;
				tx.style.fontSize = txtNormalSize;
				tx.style.padding = padding;
				tx.style.cursor = "pointer"; 

				tx.onchange = function() {  
					if(this.value===""){
						this.value=0;
					} else {
						var index = (this.id).replace("nRichiesti",""); 
						if ((numProdotti-index)===1){   
							aggiungiRiga();
						}  
						aggiornaQtaProdurre(index); 
						aggiornaDatiProdotto();  
					}
				}; 
				
				tx.onkeyup = function() {
					this.value=this.value.replace(/[^\d]/,'0'); 
				}
				td.appendChild(tx);
				tr.appendChild(td);
				
				/////////////////////////////////////////////////////////////////label da Produrre
				td = document.createElement('td');
				td.setAttribute("class", "cella11"); 
				td.style.textAlign = "center"; 
				//Create and append select list
				tx = document.createElement("label");
				tx.id = "qProdurre" + numProdotti;
				tx.setAttribute("colspan", "1"); 
				tx.style.width = "80px";
				tx.type="number"; 
				tx.style.height =  altezzaRiga;
				tx.style.fontFamily = fontFamily;
				tx.style.fontSize = txtNormalSize; 
				tx.textContent = "0";
				td.appendChild(tx);
				tr.appendChild(td);
				 
				/////////////////////////////////////////////////////////////////label "Pezzi"
				td = document.createElement('td');
				td.setAttribute("class", "cella11"); 
				td.style.textAlign = "center";

				//Create and append select list
				tx = document.createElement("label");
				tx.setAttribute("colspan", "1"); 
				tx.style.width = "60px";
				tx.style.height =  altezzaRiga;
				tx.style.fontFamily = fontFamily;
				tx.style.fontSize = txtNormalSize;  
				tx.textContent = "<?php echo $titlePezzi ?>";
				td.appendChild(tx);
				tr.appendChild(td);
				
				/////////////////////////////////////////////////////////////////label Note
				td = document.createElement('td');
				td.setAttribute("class", "cella11"); 
				td.style.textAlign = "center";
				//Create and append select list
				var tx = document.createElement("textarea");
				tx.id = "note" + numProdotti; 
				tx.setAttribute("colspan", "1"); 
				tx.style.width = "200px";
				tx.style.height =  altezzaRiga;
				tx.style.float = "right";
				tx.style.fontFamily = fontFamily;
				tx.style.fontSize = txtNormalSize;
				tx.style.border = "1px solid transparent";
				tx.style.borderColor = "transparent transparent rgba(0, 0, 0, 0.1) transparent";
				tx.style.cursor = "pointer"; 
				td.appendChild(tx);
				tr.appendChild(td);

				//Incremento numProdotti selezionati
				numProdotti++;  
				//Aggiunta componenti alla tabella
				tbody.appendChild(tr); 
  
			  	
		}
		
		function mostraLoading(){
			document.getElementById("my_table").style.display = 'none';
			document.getElementById("table_dettagli").style.display = 'none'; 
			document.getElementById("dati_ordine").style.display = 'none';
			document.getElementById("buttonConferma").style.display = 'none';
			document.getElementById("loading-image").style.display = 'inline';
		}
		 
		
    </script>
    <body onload="recuperaListaProdotti()">
        <div id="mainContainer" style = "width:1200px;">
            <?php
            include('../include/menu.php');
            include('../Connessioni/serverdb.php'); 
			 
			$codici = [];
			$descri = [];
            //Recupero il cod stab della bolla
			$sqlres = recuperaElencoProdottiChimica(); 
			while ($res = mysql_fetch_array($sqlres)) {  
				array_push($codici, $res['codice']);
				array_push($descri, $res['descri']); 
			}
							  
			//Recupero l'id dell'ordine
			$sqlres = recuperaMaxId(); 
			$maxId = 0;				  
			while ($res = mysql_fetch_array($sqlres)) {  
				$maxId = $res['max(id)']; 
			}
 			$maxId++;
							  
			//Recupero elementi in Ordine 
			$in_ordine = [];
			$sqlres = recuperaComponentiOrdine(); 
			while ($res = mysql_fetch_array($sqlres)) {  
				array_push($in_ordine, $res['valore']); 
			}	
							  
			$componenti_in_ordine = [];
			$qta_in_ordine = [];
			for ($i = 0; $i<count($in_ordine); $i++) {  
				if (in_array($in_ordine[$i],$componenti_in_ordine)){ 
					$id = array_search($in_ordine[$i], $componenti_in_ordine); 
					$qta_in_ordine [$id] = $qta_in_ordine[$id] +$in_ordine[$i+1] ;
					 
						
				} else {  
					array_push($componenti_in_ordine, $in_ordine[$i]); 
					array_push($qta_in_ordine, $in_ordine[$i+1]);  
					 
				}
				 
				 $i++; 
			} 
			for ($i = 0; $i<count($componenti_in_ordine); $i++) {  
			?>
				<script> 
					codici_in_ordine.push("<?php echo $componenti_in_ordine [$i];?>");
					qta_in_ordine.push("<?php echo $qta_in_ordine [$i];?>"); 
					
				</script>
				
			<?php
			} 
		  
			$elenco_resp = []; 
			array_push($elenco_resp, $selResponsabile); 
			$sqlres = recuperaElencoResponsabiliProduzioneChimica(); 
			while ($res = mysql_fetch_array($sqlres)) {  
				array_push($elenco_resp, $res['nome']. " ".$res['cognome']); 
				
			}	
			 				  
							 
            ?>
		 
		
		
        <table width="100%" class="table2" id= "dati_ordine">
			<tr>
				<td class="cella3" colspan="3" style="font-size: 14px;" id="rep";><?php echo $titleNuovoOrdine; ?></td>
			</tr> 
			<tr> 
				<th class="cella2" colspan="1" style="font-size: 12px;"> <label><?php echo "ID"; ?></label></th> 
				<th class="cella1" colspan="1" id ="idOrdine" style="font-size: 14px; font-weight:normal; "> <?php echo $maxId; ?></th>  
			</tr>  
			<tr> 
				<th class="cella2" colspan="1" style="font-size: 12px;"> <label><?php echo $titleNumeroOrdine; ?></label></th> 
				<th class="cella1" colspan="1" id ="codiceOrdine" style="font-size: 14px; font-weight:normal; "> <?php echo $codice; ?></th>  
			</tr>  
			<tr> 
				<th class="cella2" colspan="1" style="font-size: 12px;"> <label><?php echo $titleDataOrdine; ?></label></th> 
				<th class="cella1" colspan="1" id ="dataOrdine" style="font-size: 14px; font-weight:normal; "> <?php date_default_timezone_set('UTC'); echo date('Y-m-d H:i:s'); ?></th>
			</tr> 
			<tr> 
				<th class="cella2" colspan="1" style="font-size: 12px;"> <label><?php echo $dataEvasioneOrdine?></label></th> 
				<th class="cella1" colspan="1" style="font-size: 12px; font-weight:normal; "> 
					<input id ="dataEvasione" value="<?php date_default_timezone_set('UTC'); echo date('Y-m-d'); ?>"></input></th>
			</tr> 
			<tr> 
				<th class="cella2" colspan="1" style="font-size: 12px; width:100%; "><?php echo $titleResponsabileOrdine?> </th>
                <th  class="cella1 ">
					<select class="select" id="respOrdine" style="font-size:12pt; font-weight:normal; height:20px;width:300px;">  
						<?php for ($i =0; $i<count($elenco_resp); $i++) { ?> 
						<option value="<?php echo $i; ?>"><?php echo $elenco_resp[$i];?></option>  
							<?php } ?>
						</select>  
					<!-- <input id="respOrdine" name="respOrdine" style="font-size:12pt; font-weight:normal; height:20px;width:300px;"> </input> </td> -->
			</tr>
			<tr> 
				<th class="cella2" colspan="1" style="font-size: 12px; width:100%; "><?php echo $titelOrdineNote?> </th>
                <th  class="cella1 ">
					<textarea id="noteOrdine" name="noteOrdine" style="font-size:12pt; font-weight:normal; height:100px;width:800px; float: right;text-align:right"> </textarea> </td> 
			</tr> 
			<tr> 
				<th class="cella2" colspan="1" style="font-size: 12px; width:100%; "><?php echo $titleInfo1Ordine?> </th>
                <th  class="cella1 ">
					<textarea id="info1Ordine" name="info1Ordine" style="font-size:12pt; font-weight:normal; height:20px;width:800px; float: right;text-align:right"> </textarea> </td> 
			</tr>
			<tr> 
				<th class="cella2" colspan="1" style="font-size: 12px; width:100%; "><?php echo $titleInfo2Ordine?> </th>
                <th  class="cella1 ">
					<textarea id="info2Ordine" name="info2Ordine" style="font-size:12pt; font-weight:normal; height:20px;width:800px; float: right;text-align:right"> </textarea> </td> 
			</tr>
			<tr> 
				<th class="cella2" colspan="1" style="font-size: 12px; width:100%; "><?php echo $titleInfo3Ordine?> </th>
                <th  class="cella1 ">
					<textarea id="info3Ordine" name="info3Ordine" style="font-size:12pt; font-weight:normal; height:20px;width:800px; float: right;text-align:right"> </textarea> </td> 
			</tr>
			<tr> 
				<th class="cella2" colspan="1" style="font-size: 12px; width:100%; "><?php echo $titleInfo4Ordine?> </th>
                <th  class="cella1 ">
					<textarea id="info4Ordine" name="info4Ordine" style="font-size:12pt; font-weight:normal; height:20px;width:800px; float: right;text-align:right"> </textarea> </td> 
			</tr>
			<tr> 
				<th class="cella2" colspan="1" style="font-size: 12px; width:100%; "><?php echo $titleInfo5Ordine?> </th>
                <th  class="cella1 ">
					<textarea id="info5Ordine" name="info5Ordine" style="font-size:12pt; font-weight:normal; height:20px;width:800px; float: right;text-align:right"> </textarea> </td> 
			</tr>
		 
		</table>  
		<br> 
		<table width="100%" class="table2" id= "my_table">
			<tr>
				<td class="cella3" colspan="6" style="font-size: 14px;" ><?php echo $titoloSceltaProdotti ?></td>
			</tr>
			<tr> 
				<th class="cella2" colspan="1" style="font-size: 12px; height: 50px; text-align:center;"> <label><?php echo $titleArticolo; ?></label></th> 
				<th class="cella2" colspan="1" style="font-size: 12px; height: 50px; text-align:center;"> <label><?php echo $titleQtaMagazzino ?></label></th>
				<th class="cella2" colspan="1" style="font-size: 12px; height: 50px; text-align:center;"> <label><?php echo $titleQtaRichiesta ?></label></th>
				<th class="cella2" colspan="1" style="font-size: 12px; height: 50px; text-align:center;"> <label><?php echo $titleQtaDaProdurre ?></label></th> 
				<th class="cella2" colspan="1" style="font-size: 12px; height: 50px; text-align:center;"> <label><?php echo $titleUnita; ?></label></th>
       			<th class="cella2" colspan="1" style="font-size: 12px; height: 50px; text-align:center;"> <label><?php echo $titleNote; ?></label></th>  	
				
			</tr> 
		</table>
			
		<table width="100%" class="table2" id= "dati_magazzino">
			<tr>
				<th></th>
			</tr>    
		</table> 	 
			 
		<table width="100%" class="table2" id= "table_dettagli"> 
			<tr>
				<th></th>
			</tr>   
		</table> 
		
				<input id= "buttonConferma" class = "button2" type='button' style="font-size:18pt;height:420px;width:200px; float: right;" value="<?php echo $titleOrdineConferma; ?>" onClick="salva()" />

        </div><!--mainContainer--> 
	
		<div id="loading-image" style ="position:absolute; align-content: center; left: 0px; top: 200px; height: 100%; width: 100%; text-align: center; display:none;" >
 			 <img src="../images/giphy.gif" alt="Loading..."> </img>
			<br>
			<label><?php echo $titleMsgRegistraOrdine; ?></label>
		</div>
    </body>
</html>

