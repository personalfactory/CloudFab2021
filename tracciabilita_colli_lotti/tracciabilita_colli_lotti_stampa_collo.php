<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <?php include('../include/validator.php'); ?>
  <head>
    <?php 
	  //include('../include/header.php'); 
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
	  	//include('sql/script_colli_lotti.php');
 
	      if (isset($_GET["idCollo"])) { 
			  $idCollo = $_GET["idCollo"]; 
		  
		  }  
	    ?>
	
  </head>
	
	  	<meta charset="UTF-8">
  		<meta name="viewport" content="width=device-width, initial-scale=1.0">
  		<meta http-equiv="X-UA-Compatible" content="ie=edge">
 		<script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.1.2/handlebars.min.js"></script>
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	 	<link rel="stylesheet" type="text/css" href='../css/styleAdmin.css?ts=<?=time()?>&quot' />
	 
	<script type='text/javascript'>
	 
		var numLotti = 0;   
		var numProdotti = 0; 
		var arrayCodiciLotto = []; 
		var arrayQtaCodLotto = [];
		
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
						 
						nomeProdotto = nomeProdotto.substr(nomeProdotto.indexOf('"')+1, nomeProdotto.length);
						nomeProdotto = nomeProdotto.substr(0, nomeProdotto.indexOf('"'));
 
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
							td.setAttribute("font-size", "18pt");
							td.setAttribute("height", "40px");
							td.setAttribute("align", "center");
							td.setAttribute("id", "elencoProd" + numProdotti);
							td.setAttribute("name", "elencoProd" + numProdotti); //" + numProdotti);
							td.setAttribute("colspan", "1"); 
							var tx = document.createTextNode(nomeProdotto.toUpperCase()); 
							td.appendChild(tx);
							tr.appendChild(td);
							///////////////// Inserimento Quantita Prodotto		
							td = document.createElement('td');
							td.setAttribute("font-size", "18pt");
							td.setAttribute("height", "40px");
							td.setAttribute("align", "center");
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
	 
	
	</script>
	
  <body>
	 
	  
    <div id="tracciabilitaContainer">
 
      <?php 
      	
		 
		
		$iformazioniCollo = array();
		$listaCodlotti = array();
		$iformazioniCollo = getInfoCollo($idCollo);
		$lottiCollo = getLottiCollo($idCollo);
 
		for($i = 0; $i < count($lottiCollo); ++$i) { 
		 ?>
			 <script>
				 aggiornaCodLotti('<?php 
										echo $lottiCollo[$i]->getCodLotto()
								  ?>');
			</script> 
		<?php 
			}  
		?> 
		<script>
		 	aggiornaNumLotti(<?php echo count($lottiCollo)?>);
		 	
		 </script>
	
        <div id="tracciabilitaContainer" style=" width:700px; margin:45px auto;">
          <form class="form" id="Ddt" name="Ddt">
            <table width="700px" id='my_table' class='tabella' cellspacing='0' cellpadding='0'>
			<tr>
                <td class="cella33" colspan="2"><?php echo "DETTAGLIO COLLO" ?></td>
            </tr>
		 
			<tr  height="30">
                <td><?php echo $titleIdCollo ?> </td>
                <td>
                   <label for="fname" name="idCollo" id="idCollo" ><?php echo  $iformazioniCollo->getId(); ?></label></td>
            </tr>
			<tr> <td colspan=2> <hr> </hr> </td></tr> 	
			<tr>
                <td><?php echo $titleCodiceCollo?> </td>
                <td>
					 <label for="fname" name="idCollo" id="idCollo" ><?php echo $iformazioniCollo->getCodiceCollo(); ?></label></td>
            </tr>
			<tr> <td colspan=2> <hr> </hr> </td></tr>
			<tr>  
				 <td> </td>
				 <td>
					 <center><img src="../object/barcode/barcode.php?Codice=<?php echo $iformazioniCollo->getCodiceCollo()?>"><center> </td>
            </tr>
	  		<tr> <td colspan=2> <hr> </hr> </td></tr>
			<tr>
                <td><?php echo $titleDataCollo ?> </td>
                <td>
					<label for="fname" name="idCollo" id="idCollo" ><?php echo $iformazioniCollo->getData() ?></label></td> 
            </tr>
			<tr> <td colspan=2> <hr> </hr> </td></tr>
				
			 <tr>
                <td><?php echo $titleAltezzaCollo?> </td>
                <td>
					<label><?php echo $iformazioniCollo->getAltezza()."cm"; ?></label></td> 
				
             </tr>
				<tr> <td colspan=2> <hr> </hr> </td></tr>
		    <tr>
                <td><?php echo $titleLarghezzaCollo?> </td>
                <td> 
				<label><?php echo $iformazioniCollo->getLarghezza()."cm"; ?></label></td> 
             </tr>
			<tr> <td colspan=2> <hr> </hr> </td></tr>
			<tr>
                <td><?php echo $titleProfonditaCollo?> </td>
                <td>
					<label><?php echo $iformazioniCollo->getProfondita()."cm"; ?></label></td>    
              </tr>
				<tr> <td colspan=2> <hr> </hr> </td></tr>
			<tr>
                <td><?php echo $titlePesoCollo?> </td>
                <td>
					<label ><?php echo $iformazioniCollo->getPeso()."kg"; ?></label></td>  
             </tr>
			<tr> <td colspan=2> <hr> </hr> </td></tr>	
			<tr>
                <td><?php echo $titleInfo1Collo?> </td>
                <td> 
					<label><?php echo $iformazioniCollo->getInfo1(); ?></label></td>  
				</td> 
             </tr>	
				<tr> <td colspan=2> <hr> </hr> </td></tr>
			<tr>
                <td><?php echo $titleInfo2Collo?> </td>
                <td>
                   <label><?php echo $iformazioniCollo->getInfo2(); ?></label></td>  
				</td> 
             </tr>	
				<tr> <td colspan=2> <hr> </hr> </td></tr> 
			<tr>
                <td><?php echo $titleInfo3Collo?> </td>
                <td> 
					<label><?php echo $iformazioniCollo->getInfo3(); ?></label></td>  
				</td> 
             </tr>	
				<tr> <td colspan=2> <hr> </hr> </td></tr>
			<tr>
                <td><?php echo $titleInfo4Collo?> </td>
                <td>
                   <label><?php echo $iformazioniCollo->getInfo4(); ?></label></td>  
				</td> 
             </tr>	
				<tr> <td colspan=2> <hr> </hr> </td></tr>
			<tr>
                <td><?php echo $titleInfo5Collo?> <br> </td>
                <td>
                   <label><?php echo $iformazioniCollo->getInfo5(); ?></label></td>  
				</td> 
             </tr> 
			
			</table> 
            <br>

	 		<table width="700px" id='my_table2' class='tabella' cellspacing='0' cellpadding='0'>
				<?php
					if (count($lottiCollo)>0) {
						?> 
				<tr>	
				<td class="cella22" colspan="2"><?php echo $titleCodiciLotto ?></td> 
			</tr>
				<?php } ?> 
		
				
				<?php
					for ($i = 0; $i<count($lottiCollo); ++$i) {
						?> 
			<tr>
					<td colspan="2" align="center" height="40"><?php echo $lottiCollo[$i]->getCodLotto() ?></td>
					  
		
				<?php
				}
					?> 
			</tr> 
		</table> 
			<!-- style="visibility:hidden;"-->
			<table width="700px" id='tab_el_prod' class='tabella' style="font-size:12pt;" cellspacing='0' cellpadding='0'>
			<tr>
                <td id = "tElProd" class="cella22" colspan="2" style="visibility:hidden;"><?php echo  $titleElencoProdotti ?></td>
            </tr>
           	 	
			<tr>
                <th id = "tElProd1" class="cella22" style="visibility:hidden; height:40px;"><?php echo $titleNomeProdotti ?> </th>
				<th id = "tElProd2" class="cella22" style="visibility:hidden; height:40px;"><?php echo $titleQtaProdotti ?> </th> 
            </tr>
						
		</table> 

			</form> 
		</div>
 	<p> </p>

			<?php for ($i = 0; $i<count($lottiCollo); ++$i) { ?>	
						<script> 
								recuperaInfoProdottoCodLottoInseriti('<?php echo $lottiCollo[$i]->getCodLotto() ?>');
							</script> 
				<?php }?> 
    </div><!--mainConatainer-->
  </body>
</html>