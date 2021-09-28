<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <?php include('../include/validator.php'); ?>
  <head>
    <?php  
	  	include("../tracciabilita_colli_lotti/sql/query.php");
	    include('../Connessioni/serverdb.php');
      	include('../sql/script.php');
		include('include/funzioni.php');  
		include("../tracciabilita_colli_lotti/include/properties.php");  
		include("../lingue/gestore.php"); 
 		include("../tracciabilita_colli_lotti/library/elenco_classi.php");  
 
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
						
						//Eliminazione virgolette nome Prodotto
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
							td.style.color = "gray";
							td.style.fontSize = "11pt"; 
							td.style.height = "20px";
							td.setAttribute("align", "center");
							td.setAttribute("id", "elencoProd" + numProdotti);
							td.setAttribute("name", "elencoProd" + numProdotti); //" + numProdotti);
							td.setAttribute("colspan", "1"); 
							var tx = document.createTextNode(nomeProdotto.toUpperCase()); 
							td.appendChild(tx);
							tr.appendChild(td);
							///////////////// Inserimento Quantita Prodotto		
							td = document.createElement('td');
							td.style.color = "gray";
							td.style.fontSize = "11pt";
							td.style.height = "20px";
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
	  
	<div width=450>
	  	<table width=450>  
			<tr>   
 				<td colspan="2">
			 		 <center><img src="../object/barcode/barcode.php?Codice=<?php echo $iformazioniCollo->getCodiceCollo()?>"><center> 
				</td>
	 		</tr> 
			
			<tr> 
				<td style="color:black;font-size:14px;" colspan="2" align="right"><b><?php echo $titleDettaglioCollo ?></b></td> 
			</tr>
			<tr> <td colspan=2> <hr> </hr> </td></tr> 
			

			<tr>
                <td style="color:gray;font-size:15px;"><b><?php echo $titleIdCollo ?></b></td>
                <td>
                   <label style="color:gray;font-size:15px;"><?php echo  $iformazioniCollo->getId(); ?></label></td>
            </tr>
			<!--<tr> <td colspan=2> <hr> </hr> </td></tr>  -->	
			

			<tr>
                <td style="color:gray; font-size:15px;"><b><?php echo $titleCodiceCollo?></b></td>
                <td>
					 <label style="color:gray; font-size:15px;" ><?php echo $iformazioniCollo->getCodiceCollo(); ?></label></td>
            </tr> 
	  		<!-- <tr> <td colspan=2> <hr> </hr> </td></tr> -->
			
			<tr>
                <td style="color:gray;font-size:15px;"><b><?php echo $titleDataCollo ?></b></td>
                <td>
					<label style="color:gray;font-size:15px;"><?php echo $iformazioniCollo->getData() ?></label></td> 
            </tr>
			<!-- <tr> <td colspan=2> <hr> </hr> </td></tr> -->
				
			<tr>
                <td style="color:gray;font-size:15px;"><b><?php echo $titleAltezzaCollo?></b></td>
                <td>
					<label style="color:gray;font-size:15px;"><?php echo $iformazioniCollo->getAltezza()."cm"; ?></label></td> 
				
            </tr>
			<!-- <tr> <td colspan=2> <hr> </hr> </td></tr> -->
		    
			<tr>
                <td style="color:gray;font-size:15px;"><b><?php echo $titleLarghezzaCollo?></b></td>
                <td> 
					<label style="color:gray;font-size:15px;"><?php echo $iformazioniCollo->getLarghezza()."cm"; ?></label></td> 
             </tr>
			<!-- <tr> <td colspan=2> <hr> </hr> </td></tr> -->
			
			<tr>
                <td style="color:gray;font-size:15px;"><b><?php echo $titleProfonditaCollo?></b></td>
                <td>
					<label style="color:gray;font-size:15px;"><?php echo $iformazioniCollo->getProfondita()."cm"; ?></label></td>    
			</tr>
			<!-- <tr> <td colspan=2> <hr> </hr> </td></tr> -->
			
			<tr>
                <td style="color:gray;font-size:15px;"><b><?php echo $titlePesoCollo?></b></td>
                <td>
					<label style="color:gray;font-size:15px;"><?php echo $iformazioniCollo->getPeso()."kg"; ?></label></td>  
            </tr>
			<!-- <tr> <td colspan=2> <hr> </hr> </td></tr> -->	
			
			<tr>
                <td style="color:gray;font-size:15px;"><b><?php echo $titleInfo1Collo?></b> </td>
                <td> 
					<label style="color:gray;font-size:15px;"><?php echo $iformazioniCollo->getInfo1(); ?></label></td>  
            </tr>	
			<!-- <tr> <td colspan=2> <hr> </hr> </td></tr> -->
			
			<tr>
                <td style="color:gray;font-size:15px;"><b> <?php echo $titleInfo2Collo?></b></td>
                <td>
                   <label style="color:gray;font-size:15px;"><?php echo $iformazioniCollo->getInfo2(); ?></label></td>  
            </tr>	
			<!-- <tr> <td colspan=2> <hr> </hr> </td></tr>  --> 
			
			<tr>
                <td style="color:gray;font-size:15px;"><b> <?php echo $titleInfo3Collo?></b> </td>
                <td> 
					<label style="color:gray;font-size:15px;"><?php echo $iformazioniCollo->getInfo3(); ?></label></td> 
            </tr>	
			<!-- <tr> <td colspan=2> <hr> </hr> </td></tr> -->
			
			<tr>
                <td style="color:gray;font-size:15px;"><b><?php echo $titleInfo4Collo?></b> </td>
                <td>
                   <label style="color:gray;font-size:15px;"><?php echo $iformazioniCollo->getInfo4(); ?></label></td>  
            </tr>	
			<!-- <tr> <td colspan=2> <hr> </hr> </td></tr> -->
			
			<tr>
                <td style="color:gray;font-size:15px;"><b><?php echo $titleInfo5Collo?></b></td>
                <td>
                   <label style="color:gray;font-size:15px;"><?php echo $iformazioniCollo->getInfo5(); ?></label></td>  
			</tr> 
			<!-- <tr> <td colspan=2> <hr> </hr> </td></tr> -->

			<tr>
				<td style="color:black;font-size:14px;" colspan="2" align="right"> <b><?php echo $titleCodiciLotto ?></b></td> 
			</tr>

			<tr> <td colspan=2> <hr> </hr> </td></tr>
			
			<tr>  
				<td style="color:gray;font-size:14px;" align="center" height="40" colspan="2"><?php for($i = 0; $i<count($lottiCollo); ++$i) { 
				if ($i===count($lottiCollo)-1) {
					echo $lottiCollo[$i]->getCodLotto();
				} else {echo $lottiCollo[$i]->getCodLotto()." "." ". " / " ." "." ";} 

			}?> </td>
			</tr> 
			
	  </table> 
<!-- style="visibility:hidden;" -->
		 <table width="450px" id='tab_el_prod' class='tabella' cellspacing='0' cellpadding='0'>
			<tr style="height:5px;"> <td colspan=2> <br> </br> </td></tr>	
			 <tr>
                <td id = "tElProd" colspan="2" style="color:black;font-size:14px;" align="right"><b><?php echo  $titleElencoProdotti ?></b></td>
            </tr>
           	<tr> <td colspan=2> <hr> </hr> </td></tr>	
			<tr>
                <th id = "tElProd1" style="color:gray; font-size:12px; height:20px;"><?php echo $titleNomeProdotti ?> </th>
				<th id = "tElProd2" style="color:gray; font-size:12px; height:20px;"><?php echo $titleQtaProdotti ?> </th> 
            </tr>
						
		</table>  
	</div>  
		<?php for ($i = 0; $i<count($lottiCollo); ++$i) { ?>	
				<script> 
						recuperaInfoProdottoCodLottoInseriti('<?php echo $lottiCollo[$i]->getCodLotto() ?>');
					</script> 
		<?php }?> 
  </body>
</html>