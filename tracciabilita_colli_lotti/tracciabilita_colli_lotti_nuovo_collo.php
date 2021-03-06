<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <?php include('../include/validator.php'); ?>
  <head>
    <?php include('../include/header.php'); 
	  	  include("../tracciabilita_colli_lotti/sql/query.php");
	  	  include('../Connessioni/serverdb.php');  
		 
	  	//include('sql/script_colli_lotti.php');
	  
	    ?>
	
  </head>
	 
	  	<meta charset="UTF-8">
  		<meta name="viewport" content="width=device-width, initial-scale=1.0">
  		<meta http-equiv="X-UA-Compatible" content="ie=edge">
 		<script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.1.2/handlebars.min.js"></script>
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	
	 	
	
	 <script type='text/javascript'>
		 var numLotti = 0; 
		 var numProdotti = 0; 
		 
		 var arrayCodiciLotto = []; 
		 var arrayQtaCodLotto = [];
		   
		  function sleep(s){
  			var now = new Date().getTime();
  			while(new Date().getTime() < now + (s*1000)){ /* non faccio niente */ } 
		 	}
		 
		  function aggiungiCodiceLotto(val){
			  
			var codLotto = val.toUpperCase();
			var richiesta = new XMLHttpRequest();  
			var res = "";
			var inserito = false; 
			  
			//Lettura codici lotto e memorizzazione dati nell'array codiciLotto
			for (var i=0; i<numLotti; i++) { 
				var codiceLotto = $("#" + "codiceLotto" + i).text(); 
				if (codiceLotto.includes(codLotto)){
					inserito = true;
				} 
			}
			if (inserito){ 
				
				alert("<?php echo $WarningCodiceLottoInserito ?>");
			} else {
			 
				richiesta.onload = function() {
					res = this.responseText;

					  if(res.includes(codLotto)){  
						  recuperaInfoProdotto(codLotto); 
					  } else {

						  alert("<?php echo $WarningCodiceLottoIncorretto ?>");

					  }
			 
				};
			}

			richiesta.open("get", "moduli/verifica_codice_lotto.php?codLotto="+codLotto, true); 
			richiesta.send();

		 }
		 		 
		 function recuperaInfoProdotto(codLotto){ 
		 			 var nomeProdotto = "";
		 			 var richiesta = new XMLHttpRequest(); 
		 			 richiesta.onload = function() { 
						 
		 				 	nomeProdotto = this.responseText; 
						   
						 	if(nomeProdotto.length>6){ 
								  
								//Modifica Visibilit?? Tabella
								var div = document.getElementById('tCodLotto');
								div.style.visibility = 'visible';
								div = document.getElementById('tElProd');
								div.style.visibility = 'visible';
								div = document.getElementById('tElProd1');
								div.style.visibility = 'visible';
								div = document.getElementById('tElProd2');
								div.style.visibility = 'visible';
								 
								//Eliminazione virgolette nome Prodotto
								nomeProdotto = nomeProdotto.substr(nomeProdotto.indexOf('"')+1, nomeProdotto.length);
								nomeProdotto = nomeProdotto.substr(0, nomeProdotto.indexOf('"'));
								
								
								//Aggiunta Codice Lotto
								var table = document.getElementById('my_table');
								var tbody = table.getElementsByTagName('tbody')[0];
								var colonne = table.getElementsByTagName('th').length; 
								var tr = document.createElement('tr');
								for(var i=0; i<colonne; i++){
									 var td = document.createElement('td');
									 td.setAttribute("class", "cella111");
									 td.setAttribute("id", "codiceLotto" + numLotti);
									 td.setAttribute("name", "codiceLotto" + numLotti);
									 td.setAttribute("colspan", "2"); 
									 var tx = document.createTextNode(codLotto); 
									 td.appendChild(tx);
									 tr.appendChild(td);
								}
								tbody.appendChild(tr);
								numLotti++; 
								 
								if (arrayCodiciLotto.includes(nomeProdotto)){
									 
									//Aggiorna indici  
									var ind = arrayCodiciLotto.indexOf(nomeProdotto)
									arrayQtaCodLotto[ind] = arrayQtaCodLotto[ind] +1;
									document.getElementById('qProd'+ind).innerHTML = arrayQtaCodLotto[ind]; 
				 
									 
								} else {
							 
									
									arrayCodiciLotto.push(nomeProdotto);
									arrayQtaCodLotto.push(1);

									//Aggiunta Codice Lotto
									table = document.getElementById('tab_el_prod');
									tbody = table.getElementsByTagName('tbody')[0];
									colonne = table.getElementsByTagName('th').length; 
					 
									tr = document.createElement('tr'); 
									///////////////// Iserimento Nome prodotto
									var td = document.createElement('td');
									td.setAttribute("class", "cella111");
									td.setAttribute("id", "elencoProd" + numProdotti);
									td.setAttribute("name", "elencoProd" + numProdotti); //" + numProdotti);
									td.setAttribute("colspan", "1"); 
									var tx = document.createTextNode(nomeProdotto.toUpperCase()); 
									td.appendChild(tx);
									tr.appendChild(td);
									///////////////// Inserimento Quantita Prodotto		
									td = document.createElement('td');
									td.setAttribute("class", "cella111");
									td.setAttribute("id", "qProd" + numProdotti);
									td.setAttribute("name", "qProd"  + numProdotti); //" + numProdotti);
									td.setAttribute("colspan", "1"); 
									tx = document.createTextNode("1"); 
									td.appendChild(tx);
									tr.appendChild(td); 
									
									tbody.appendChild(tr);
									numProdotti++; 
								}
								
								
							 	} else {

					  					alert("<?php echo $WarningCodiceProdottoErrato ?>");

				  				}
						 		
						 
		 				}; 
		 
		 			richiesta.open("get", "moduli/recupera_info_codice_lotto.php?codLotto="+codLotto.substring(1, 6), true); 
		 			richiesta.send();
			  
		 }
		 
		 function salva(){ 
			 
 
			 var idCollo = $("#idCollo").text();
			 var codiceCollo = $("#codiceCollo").text();
			 var dataCollo = $("#dataCollo").text();
			 var altezzaCollo = $("#altezzaCollo").val(); 
			 var larghezzaCollo = $("#larghezzaCollo").val();
			 var profonditaCollo = $("#profonditaCollo").val();
			 var pesoCollo = $("#pesoCollo").val();
			 var info1collo = $("#info1Collo").val();
			 var info2collo = $("#info2Collo").val();
			 var info3collo = $("#info3Collo").val();
			 var info4collo = $("#info4Collo").val();
			 var info5collo = $("#info5Collo").val(); 
			  
			 var idUtente = $("#idUtente").text();
			 var idAzienda = $("#idAzienda").text();
			    
			 //Definizione Array contenente i codici lotto 
			 let codiciLotto = [numLotti];
			 
			 //Lettura codici lotto e memorizzazione dati nell'array codiciLotto
			 for (var i=0; i<numLotti; i++) { 
				var codiceLotto = $("#" + "codiceLotto" + i).text(); 
				codiciLotto[i] = codiceLotto; 
			 }
			  
			if (codiceCollo===""){ 
				alert("<?php echo $WarningCodiceColloMancante?>"); 
			} else {
				var abilitaReg = true;
				if (numLotti===0){	 
					abilitaReg = window.confirm("<?php echo $WarningCodiciLottoNonInseriti ?>"); 
				} 
				
				 if(abilitaReg){
					$.ajax({url:"moduli/registra_nuovo_collo.php", 
						type: 'POST',
						data: {	idCollo:idCollo,
							codiceCollo:codiceCollo,  
							dataCollo :dataCollo,  
							altezzaCollo:altezzaCollo,
							larghezzaCollo:larghezzaCollo,
							profonditaCollo:profonditaCollo,  
							pesoCollo :pesoCollo,  
							info1collo:info1collo,  
							info2collo:info2collo,  
							info3collo:info3collo, 
							info4collo:info4collo,  
							info5collo:info5collo,
							idUtente:idUtente,  
							idAzienda:idAzienda,
							codiciLotto:codiciLotto},
						success:function(result){
							$("p").text(result);
						}
						});

					sleep(1);
					location.href = '../tracciabilita_colli_lotti/tracciabilita_colli_lotti.php';
				 }
				}
		 } 
			  
	</script>
	
  <body>
	 
	  
    <div id="tracciabilitaContainer">
 
      <?php 
      	include('../include/menu.php'); 
	 	include("../include/funzioni.php");
      	include('../include/precisione.php');
      	include('../Connessioni/serverdb.php');
      	include('../sql/script.php');
		include('include/funzioni.php');  
		include("../tracciabilita_colli_lotti/include/properties.php");  
		include("../lingue/gestore.php"); 
 		include("../tracciabilita_colli_lotti/library/elenco_classi.php"); 
		     
        ?>
		 
	 <p id=res> </p> 
		
        <div id="tracciabilitaContainer" style=" width:700px; margin:45px auto;">
          <form class="form" id="Ddt" name="Ddt">
            <table width="700px" id='my_table' class='tabella' cellspacing='0' cellpadding='0'>
			<tr>
                <td class="cella33" colspan="2"><?php echo $titoloPaginaNuovoCollo?></td>
            </tr>
           	 	
			<tr>
                <td class="cella22" ><?php echo $titleIdCollo ?> </td>
                <td  class="cella111">
                   <label for="fname" name="idCollo" id="idCollo" style="font-size:16pt; height:30px;width:400px;float: right;text-align:right" ><?php $id = getIdMaxColli(); echo  $id; ?></label></td>
            </tr>
				
			<tr>
                <td class="cella22"><?php echo $titleCodiceCollo?> </td>
                <td  class="cella111">
					<label for="fname" name="codiceCollo" id="codiceCollo" style="font-size:24pt; height:30px;width:400px;float: right;text-align:right"><?php 
																////////////////////////////////////////////////////////////////////////// COSTRUZIONE CODICE COLLO

															 date_default_timezone_set('UTC'); 
															 $res = getCounterColli(date('Y-m-d'));
															 $index =1; 
																if (mysql_num_rows($res) != 0) {
																 while ($colli = mysql_fetch_array($res)) {   
																	$index++; }
																 }

															 while (strlen($index)<3){
																 $index = "0".$index; 
															 }

															echo "CL".date('Ymd').$index;  ?></label></td>
                    <!-- <input class="inputTracc" style="font-size:18pt; height:30px;width:400px; float: right;text-align:right" type="text" name="codiceCollo" id="codiceCollo" onchange=""/></td> -->
            </tr>
			
			<tr>
                <td class="cella22" ><?php echo $titleDataCollo ?> </td>
                <td  class="cella111">
                   <label for="fname" name="dataCollo" id="dataCollo" style="font-size:16pt; height:30px;width:400px;float: right;text-align:right" ><?php date_default_timezone_set('UTC'); echo date('y-m-d h:i:s');?></label></td>
            </tr>
				
			 <tr>
                <td class="cella22"><?php echo $titleAltezzaCollo?> </td>
                <td  class="cella111">
                    <input class="inputTracc" style="font-size:18pt; height:30px;width:100px;float: right;text-align:right" type="text" name="altezzaCollo" id="altezzaCollo" value=""/> 
				<i> <a style="font-size:16pt; height:24px;width:400px;float: right;text-align:right; margin-right:20px;"> <?php echo "cm" ?> </a></i></td> 
             </tr>
				
		    <tr>
                <td class="cella22"><?php echo $titleLarghezzaCollo?> </td>
                <td  class="cella111">
                    <input class="inputTracc" style="font-size:18pt; height:30px;width:100px; float: right;text-align:right" type="text" name="larghezzaCollo" id="larghezzaCollo" value=""/> 
				<i> <a style="font-size:16pt; height:24px;width:400px;float: right;text-align:right; margin-right:20px;"> <?php echo "cm" ?> </a></i></td> 
             </tr>
			
			<tr>
                <td class="cella22"><?php echo $titleProfonditaCollo?> </td>
                <td  class="cella111">
                    <input class="inputTracc" style="font-size:18pt; height:30px;width:100px; float: right;text-align:right" type="text" name="profonditaCollo" id="profonditaCollo" value=""/> 
				<i> <a style="font-size:16pt; height:24px;width:400px;float: right;text-align:right; margin-right:20px;"> <?php echo "cm" ?> </a></i></td> 
              </tr>
				
			<tr>
                <td class="cella22"><?php echo $titlePesoCollo?> </td>
                <td  class="cella111">
                    <input class="inputTracc" style="font-size:18pt; height:30px;width:100px; float: right;text-align:right" type="text" name="pesoCollo" id="pesoCollo" value=""/> 
				<i> <a style="font-size:16pt; height:24px;width:400px;float: right;text-align:right; margin-right:20px;"> <?php echo "kg" ?> </a></i></td>
             </tr>
				
			<tr>
                <td class="cella22"><?php echo $titleInfo1Collo?> </td>
                <td  class="cella111">
					<textarea id="info1Collo" name="info1Collo"style="font-size:12pt; height:30px;width:400px;float: right;text-align:right"> </textarea>
                    <!-- <input class="inputTracc" style="font-size:18pt; height:30px;width:400px;float: right;text-align:right" type="text" name="info1Collo" id="info1Collo" value=""/> -->
				</td> 
             </tr>	
				
			<tr>
                <td class="cella22"><?php echo $titleInfo2Collo?> </td>
                <td  class="cella111">
					<textarea id="info2Collo" name="info2Collo"style="font-size:12pt; height:30px;width:400px;float: right;text-align:right"> </textarea>
                    <!-- <input class="inputTracc" style="font-size:18pt; height:30px;width:400px;float: right; text-align:right" type="text" name="info2Collo" id="info2Collo" value=""/>  -->
				</td> 
             </tr>	
				 
			<tr>
                <td class="cella22"><?php echo $titleInfo3Collo?> </td>
                <td  class="cella111">
					<textarea id="info3Collo" name="info3Collo"style="font-size:12pt; height:30px;width:400px;float: right;text-align:right"> </textarea>
                    <!-- <input class="inputTracc" style="font-size:18pt; height:30px;width:400px;float: right;text-align:right" type="text" name="info3Collo" id="info3Collo" value=""/> -->
				</td> 
             </tr>	
				
			<tr>
                <td class="cella22"><?php echo $titleInfo4Collo?> </td>
                <td  class="cella111">
					<textarea id="info4Collo" name="info4Collo"style="font-size:12pt; height:30px;width:400px;float: right;text-align:right"> </textarea>
                    <!-- <input class="inputTracc" style="font-size:18pt; height:30px;width:400px; float: right; text-align:right" type="text" name="info4Collo" id="info4Collo" value=""/>  -->
				</td> 
             </tr>	
				
			<tr>
                <td class="cella22"><?php echo $titleInfo5Collo?> </td>
                <td  class="cella111">
					<textarea id="info5Collo" name="info5Collo"style="font-size:12pt; height:30px;width:400px;float: right;text-align:right"> </textarea>
                    <!-- <input class="inputTracc" style="font-size:18pt; height:30px;width:400px;float: right; text-align:right" type="text" name="info5Collo" id="info5Collo" value=""/> -->
				</td> 
             </tr>
				
				<tr>
                <td class="cella22" ><?php echo $titleIdUtente ?> </td>
                <td  class="cella111">
                   <label for="fname" name="idAzienda" id="idUtente" ><?php echo $_SESSION['id_utente']; ?></label></td>
            </tr>
				
			<tr>
                <td class="cella22" ><?php echo $titleIdAzienda ?> </td>
                <td  class="cella111">
                   <label for="fname" name="idAzienda" id="idAzienda" ><?php echo $_SESSION['id_azienda'];?></label></td>
            </tr>
				
			<tr>	
				<td class="cella33" colspan="2"><?php echo $titleCodiciLottoAggiungi ?></td> 
			 </tr>
			 
			<tr>	
				<td  class="cella111" colspan="2">
				<input type="text" id="input" style="font-size:28pt; height:40px;width:600px;"></span><script>
					input.onchange = function() {
						aggiungiCodiceLotto(input.value);
						input.value = ""; 
					};
						</script>
				</td> 
			</tr>
			 
			<tr>	
				<th id = "tCodLotto" class="cella33" colspan="2" style="font-size:12pt; height:40px;width:600px; visibility:hidden;"><?php echo $titleCodiciLotto ?></th>
			 </tr>
						 
		</table> 
		 
		 <table width="700px" id='tab_el_prod' class='tabella' style="font-size:12pt; height:40px;" cellspacing='0' cellpadding='0'>
			<tr>
                <td id = "tElProd" class="cella33" colspan="2" style="visibility:hidden;"><?php echo  $titleElencoProdotti ?></td>
            </tr>
           	 	
			<tr>
                <th id = "tElProd1" class="cella22" style="visibility:hidden;"><?php echo $titleNomeProdotti ?> </th>
				<th id = "tElProd2" class="cella22" style="visibility:hidden;"><?php echo $titleQtaProdotti ?> </th> 
            </tr>
						
		</table>  
			<tr > </tr> 	  
			  		<input class = "button2" type='button' style="font-size:18pt;height:420px;width:200px; float: right;" value="<?php echo $titleCodiciLottoSalva ?>" onClick="salva()" />
				 
        </div>  
    </div><!--mainConatainer-->
  </body>
</html>
   