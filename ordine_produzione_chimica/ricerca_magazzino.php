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
		
		
		 
		?>
		
		<script> 
			
		//Proprieta
		var txtTitleSize = "16px";
		var txtNormalSize = "14px";
		var txtBigSize = "20px"
		var altezzaRiga = "22px";
		var padding = "4px 12 px";
		var fontFamily = "Helvetica, sans";
			
		var colli = [];
		var lotti = [];
		var lotti_disponibili = [];
		
		function indietro(){
			 
			location.href = "ordini_produzione.php"; 
			 
		}
			
		function disabilita(){
			var lotti_da_disabilitare = []; 
			for (var i=0; i<lotti_disponibili.length; i++){
				if(document.getElementById('id'+i).checked){
					lotti_da_disabilitare.push(lotti_disponibili[i]);	
				}
			}
			
			var richiesta = new XMLHttpRequest();  
			richiesta.onload = function() { 
				var res = this.responseText; 
				alert(res);
				aggiornaDati();
			}
			richiesta.open("get", "moduli/disabilita_codici_lotto.php?codiciLotto=" + JSON.stringify(lotti_da_disabilitare), true); 
			richiesta.send(); 
			
		}
			
		function aggiornaDati(){
			 
			var codice = document.getElementById('prodotti').selectedOptions[0].value;
			//alert(document.getElementById('prodotti').selectedOptions[0].text); 
			var richiesta = new XMLHttpRequest();  
			
			richiesta.onload = function() { 
				var res = this.responseText;    
			 
				lotti_disponibili = decodificaRep(res); 
				var numeroLotti = lotti_disponibili.length;
				
				$("#table_dettagli_lotti tr").remove(); 
				///////////////////////////////////////////////////////////////////////Inserimento elementi Tabella
				var table = document.getElementById('table_dettagli_lotti');
				var tbody = table.getElementsByTagName('tbody')[0];
				var colonne = table.getElementsByTagName('th').length; 
				var tr = document.createElement('tr');
				
				///////////////////////////////////////////////////////////////// titolo numero di lotti disponibili
				var td = document.createElement('td');
				td.setAttribute("class", "cella1"); 
				td.style.textAlign = "right"; 
				td.setAttribute("colspan", "2"); 
				
				var tx = document.createElement("label");
				tx.setAttribute("colspan", "2"); 
				tx.style.width = "80px";
				tx.style.height =  altezzaRiga;
				tx.style.fontFamily = fontFamily;
				tx.style.fontSize = txtNormalSize; 
				tx.textContent = "<?php echo $titleRicercaMagLottiDisponibili ?>";
				td.appendChild(tx);
				tr.appendChild(td); 
				/////////////////////////////////////////////////////////////////numero di lotti disponibili
				td = document.createElement('td');
				td.setAttribute("class", "cella1"); 
				td.style.textAlign = "center"; 
				td.setAttribute("colspan", "1"); 

				//Create and append select list
				tx = document.createElement("label");
				tx.style.width = "60px";
				tx.style.height =  altezzaRiga;
				tx.style.fontFamily = fontFamily;
				tx.style.fontSize = txtNormalSize;  
				tx.textContent = numeroLotti; 
				td.appendChild(tx);
				tr.appendChild(td);
				tbody.appendChild(tr); 
				  
				///////////////////////////////////////////////////////////////// titolo codice lotto
				tr = document.createElement('tr');
				td = document.createElement('td');
				td.setAttribute("class", "cella2"); 
				td.style.textAlign = "center";
			
				tx = document.createElement("label");
				tx.style.width = "80px";
				tx.style.height =  altezzaRiga;
				tx.style.fontFamily = fontFamily;
				tx.style.fontSize = txtNormalSize; 
				tx.textContent = "<?php echo $titleRicercaMagCodiceLotto ?>";
				td.appendChild(tx);
				tr.appendChild(td);
				 
			
				///////////////////////////////////////////////////////////////// titolo codice collo
				td = document.createElement('td');
				td.setAttribute("class", "cella2"); 
				td.style.textAlign = "center";

				//Create and append select list
				tx = document.createElement("label");
				tx.style.width = "60px";
				tx.style.height =  altezzaRiga;
				tx.style.fontFamily = fontFamily;
				tx.style.fontSize = txtNormalSize;  
				tx.textContent = "<?php echo $titleRicercaMagCodiceCollo ?>"; 
				td.appendChild(tx);
				tr.appendChild(td);
				tbody.appendChild(tr); 
				
				///////////////////////////////////////////////////////////////// titolo abilita/disabilita
				td = document.createElement('td');
				td.setAttribute("class", "cella2"); 
				td.style.textAlign = "center";

				//Create and append select list
				tx = document.createElement("label");
				tx.style.width = "60px";
				tx.style.height =  altezzaRiga;
				tx.style.fontFamily = fontFamily;
				tx.style.fontSize = txtNormalSize;  
				tx.textContent = "<?php echo $titleRicercaMagDisabilita ?>";  
				td.appendChild(tx);
				tr.appendChild(td);
				tbody.appendChild(tr); 
				
				for (var i=0; i<numeroLotti; i++){
					
					var cod_collo = "-";
					if (lotti.contains(lotti_disponibili[i])){ 
						cod_collo = colli[lotti.indexOf(lotti_disponibili[i])];
						 
					}
					
					tr = document.createElement('tr');
				 
					/////////////////////////////////////////////////////////////////Codice Lotto
					td = document.createElement('td');
					td.setAttribute("class", "cella11"); 
					td.style.textAlign = "center"; 
					if (cod_collo==='-'){ td.style.backgroundColor= "rgba(255,227,177,1.00)"}
					//Create and append select list
					tx = document.createElement("label");
					tx.id = "codLotto" + i;
					tx.setAttribute("colspan", "1"); 
					//tx.style.width = "80px";
					tx.style.height =  altezzaRiga;
					tx.style.fontFamily = fontFamily;
					tx.style.fontSize = txtNormalSize; 
					tx.textContent = lotti_disponibili[i];
					td.appendChild(tx);
					tr.appendChild(td);
  
					/////////////////////////////////////////////////////////////////Codice Collo
					td = document.createElement('td');
					td.setAttribute("class", "cella11"); 
					td.style.textAlign = "center";
					if (cod_collo==='-'){ td.style.backgroundColor= "rgba(255,227,177,1.00)"}
					//Create and append select list
					tx = document.createElement("label");
					//tx.style.width = "60px";
					tx.style.height =  altezzaRiga;
					tx.style.fontFamily = fontFamily;
					tx.style.fontSize = txtNormalSize;  
					tx.textContent = cod_collo;
					td.appendChild(tx);
					tr.appendChild(td);
					tbody.appendChild(tr); 
					
					/////////////////////////////////////////////////////////////////Codice Collo
					td = document.createElement('td');
					td.setAttribute("class", "cella11"); 
					td.style.textAlign = "center";
					if (cod_collo==='-'){ td.style.backgroundColor= "rgba(255,227,177,1.00)"}
					//Create and append select list
					tx = document.createElement("input");
					tx.type = "checkbox"; 
					tx.id = "id"+i; 
					//tx.style.width = "60px";
					tx.style.height =  altezzaRiga;
					tx.style.fontFamily = fontFamily;
					tx.style.fontSize = txtNormalSize;   
					td.appendChild(tx);
					tr.appendChild(td);
					tbody.appendChild(tr); 
				  
				}
				
				 
			};  
			richiesta.open("get", "moduli/recupera_info_lotti_codice.php?codFormula="+codice, true); 
			richiesta.send(); 
		} 
			 
			
		function recuperaInfoColli(){  
			var richiesta = new XMLHttpRequest();  
			richiesta.onload = function() { 
				var res = this.responseText;   
				var colli_lotti = decodificaRep(res);  
				for (var i=0; i<colli_lotti.length; i++){ 
					lotti.push(colli_lotti[i].substring(0, colli_lotti[i].indexOf("-"))); 
					colli.push(colli_lotti[i].substring(colli_lotti[i].indexOf("-")+1, colli_lotti[i].length)); 
				} 
			};  
			richiesta.open("get", "moduli/recupera_info_lotti_collo.php?codFormula=", true); 
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
		
  
			 
		
		</script>
	</head>
	
	<body onload="recuperaInfoColli();">
        <div id="mainContainer" style = "width:1200px;">
            <?php
            include('../include/menu.php');
            include('../Connessioni/serverdb.php'); 
			
			 //Recupera Elenco Prodotti
		 	$prodotti = []; 
			$codice = []; 
            //Recupero il cod stab della bolla
			array_push($prodotti, "Selezionare Prodotto"); 
			array_push($codice, "-"); 
			$sqlres = recuperaElencoProdottiChimica(); 
			while ($res = mysql_fetch_array($sqlres)) {  
				array_push($prodotti, $res['codice']." - ".$res['descri']); 
				array_push($codice, $res['codice']); 
			}
		 
			?> 
			 
        <table width="100%" class="table2" id= "table_prodotti">
			<tr>
				<td class="cella3" colspan="2" style="font-size: 12px; text-align: center;" id="rep";><?php echo $titleRicercaMagSelezionaProdotto; ?></td>
			</tr> 
			<tr>
				<th  class="cella1 "  colspan="2" style="text-align: center; height:40px; ">
					<select class="select" id="prodotti" style="font-size:30px; text-align: center;font-weight:normal; height:32px; width:400px;" onchange="aggiornaDati(this)" >  
						<?php for ($i =0; $i<count($prodotti); $i++) { ?> 
						<option value="<?php echo $codice[$i]; ?>"><?php echo $prodotti[$i];?></option>  
							<?php } ?>
						</select> 
				</th>
			 </tr> 
		</table> 
		 <table width="100%" class="table2" id= "table_dettagli_lotti">
			<tr> 
			</tr> 
		</table>	
			
	<br>
	<input class = "button2" type='button' style="font-size:18pt;height:420px;width:200px; float: right;" value="<?php echo $buttonRicercaMagIndietro; ?>" onClick="indietro()" />
	<input class = "button2" type='button' style="font-size:18pt;height:420px;width:200px; float: left;" value="<?php echo $buttonRicercaMagDisabilitaSel; ?>" onClick="disabilita()" />
   
		</div><!--mainContainer--> 
    </body>
</html>