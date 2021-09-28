<head> 
		<?php   
		
			include("../include/funzioni.php");
			include("../lingue/gestore.php"); 
			include("../tracciabilita_colli_lotti/include/properties.php");  
	  		include("../tracciabilita_colli_lotti/sql/query.php");
			include("../tracciabilita_colli_lotti/library/elenco_classi.php"); 
			
		?> 
	
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
  		<meta http-equiv="X-UA-Compatible" content="ie=edge">
 		<script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.1.2/handlebars.min.js"></script>
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

		<script> 
 
			function searchTable(tableId, inputId, id) {
				 
				 
				var input = document.getElementById(inputId);
				var filter = input.value.toUpperCase();
				var table = document.getElementById(tableId);
				var tr = table.getElementsByTagName("tr");
				var td;
				for (var i = 0; i < tr.length; i++) {
					td = tr[i].getElementsByTagName("td")[id];
					if (td) {
						if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
							tr[i].style.display = "";
						} else {
							tr[i].style.display = "none";
						}
					}
				}
			}
			
			
			$(document).ready(function(){
			"use strict";
			var table_name = "#myTable";
	    
			$('th[id^="order"]').click(function(){
 
				var table = $(this).parents('table').eq(0);
		 
				
				var rows = table.find('tr:gt(2)').toArray().sort(comparer($(this).index()));
 
				this.asc = !this.asc;
  
				$('#orderId').text('-');
				$('#orderCodiceCollo').text('-');
				$('#orderData').text('-');
				$('#orderDtAbilitato').text('-');
				$('#orderAssociato').text('-');
				$('#orderNumBolla').text('-');
				$('#orderDtBolla').text('-');
				$('#orderAbilitato').text('-');
				$('#orderAltezza').text('-');
				$('#orderLarghezza').text('-');
				$('#orderProfondita').text('-');
				$('#orderPeso').text('-');
				$('#orderInfo1').text('-');
				$('#orderInfo2').text('-');
				$('#orderInfo3').text('-');
				$('#orderInfo4').text('-');
				$('#orderInfo5').text('-');
				$('#orderIdUtente').text('-');
				$('#rderIdAzienda').text('-');
				
				
				
				if($(this).index()===0) { if (!this.asc){ $('#orderId').text('↑');} else { $('#orderId').text('↓'); } }
				if($(this).index()===1) { if (!this.asc){ $('#orderCodiceCollo').text('↑');} else { $('#orderCodiceCollo').text('↓'); } }
				if($(this).index()===2) { if (!this.asc){ $('#orderData').text('↑');} else { $('#orderData').text('↓'); } }
				if($(this).index()===3) { if (!this.asc){ $('#orderDtAbilitato').text('↑');} else { $('#orderDtAbilitato').text('↓'); } }
				if($(this).index()===4) { if (!this.asc){ $('#orderAssociato').text('↑');} else { $('#orderAssociato').text('↓'); } }
				if($(this).index()===5) { if (!this.asc){ $('#orderNumBolla').text('↑');} else { $('#orderNumBolla').text('↓'); } }
				if($(this).index()===6) { if (!this.asc){ $('#orderDtBolla').text('↑');} else { $('#orderDtBolla').text('↓'); } }
				if($(this).index()===7) { if (!this.asc){ $('#orderAbilitato').text('↑');} else { $('#orderAbilitato').text('↓'); } }
				if($(this).index()===8) { if (!this.asc){ $('#orderAltezza').text('↑');} else { $('#orderAltezza').text('↓'); } }
				if($(this).index()===9) { if (!this.asc){ $('#orderLarghezza').text('↑');} else { $('#orderLarghezza').text('↓'); } }
				if($(this).index()===10) { if (!this.asc){ $('#orderProfondita').text('↑');} else { $('#orderProfondita').text('↓'); } }
				if($(this).index()===11) { if (!this.asc){ $('#orderPeso').text('↑');} else { $('#orderPeso').text('↓'); } }
				if($(this).index()===12) { if (!this.asc){ $('#orderInfo1').text('↑');} else { $('#orderInfo1').text('↓'); } }
				if($(this).index()===13) { if (!this.asc){ $('#orderInfo2').text('↑');} else { $('#orderInfo2').text('↓'); } }
				if($(this).index()===14) { if (!this.asc){ $('#orderInfo3').text('↑');} else { $('#orderInfo3').text('↓'); } }
				if($(this).index()===15) { if (!this.asc){ $('#orderInfo4').text('↑');} else { $('#orderInfo4').text('↓'); } }
				if($(this).index()===16) { if (!this.asc){ $('#orderInfo5').text('↑');} else { $('#orderInfo5').text('↓'); } }
				if($(this).index()===17) { if (!this.asc){ $('#orderIdUtente').text('↑');} else { $('#orderIdUtente').text('↓'); } }
				if($(this).index()===18) { if (!this.asc){ $('#rderIdAzienda').text('↑');} else { $('#rderIdAzienda').text('↓'); } }
				
				 
				if (!this.asc){
					rows = rows.reverse();
				}
				for (var i = 0; i < rows.length; i++){
					table.append(rows[i]);
				}
			});


			function comparer(index) {
				return function(a, b) {
					var valA = getCellValue(a, index), valB = getCellValue(b, index);
					return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.toString().localeCompare(valB);
				};
			}
			function getCellValue(row, index){ 
				return $(row).children('td').eq(index).text();
			} 
		});
  
			</script>  
		 
</head>
 
<?php
////// <link rel="stylesheet" type="text/css" href='../css/gestione_colli.css?ts=<?=time()?//>&quot' />
////////////////////////////////////////////////////////////////////////////// LARGHEZZA COLONNE
$wId= "15%"; 
$wCodiceCollo= "20%"; 
$wData= "10%";  
$wDtAbilitato= "5%"; 
$wAssociato= "5%"; 
$wNumBolla= "5%";
$wDtBolla= "10%";
$wAbiitato= "5%";  
$wAltezza= "10%";
$wLarghezza= "10%"; 
$wProfondita= "10%";
$wPeso= "10%"; 
$wInfo1= "15%"; 
$wInfo2= "15%";  
$wInfo3= "15%"; 
$wInfo4= "15%";
$wInfo5= "15%";
$wIdUtente= "5%";
$wIdAzienda= "5%";
$wStrumenti= "20%";
 
?>

<div style="float:none;">
<table class="table3">
    <th colspan="14"><?php echo $titoloPaginaGestioneColli ?></th>
    <tr>
        <td colspan="14" style="text-align:center;"> 
            <a id="4" name="4" href="tracciabilita_colli_lotti_nuovo_collo.php" ><?php echo $nuovoCollo ?></a>      
        </td>
    </tr>
</table>
    </div>
<div>  
	<form method="POST" action="" name="bottone1_2"> 
		<?php   
			//// GESTIONE PULSANTI 
			if (isset($_GET["u"]) && isset($_GET["p"])) {
				$idUtente = $_GET['u'];
				$idPulsante = $_GET['p'];
				 
				if ($idPulsante ==='1'){
					//Abilitazione Utente
					abilitazioneUtente($idUtente,false);
				} else if ($idPulsante ==='2'){
					//Disabilitazione Utente
					abilitazioneUtente($idUtente,true); 
				}
			}
			//// RECUPERA ELENCO COMPLETO UTENTE (Abilitati e disabilitati)
			$elencoColli = array();
			$elencoColli = getElencoColli();
			
		
		
		?>
		<div class="limiter">
			<div class="container-table">
				<div class="wrap-table">
			 		<div class="table m-b-110">
						<br>
						<table id="tableFilter">
							<thead>	
								<tr class="row head" id ="head">
									<th class="cella3" id="myButton" style="width:<?php echo $wId ?>"><?php print $title_id?> </th> 
									<th class="cella3" style="width:<?php echo $wCodiceCollo ?>"><?php print $title_codiceCollo?> </th>
									<th class="cella3" style="width:<?php echo $wData ?>"><?php print $title_data?> </th> 
									<th class="cella3" style="width:<?php echo $wDtAbilitato ?>"><?php print $title_dtAbilitato?> </th>
									<th class="cella3" style="width:<?php echo $wAssociato ?>"><?php print $title_associato?> </th>  
									<th class="cella3" style="width:<?php echo $wNumBolla ?>"><?php print $title_numBolla?> </th>  
									<th class="cella3" style="width:<?php echo $wDtBolla ?>"><?php print $title_dtBolla?>  </th>  
									<th class="cella3" style="width:<?php echo $wAbiitato ?>"><?php print $title_abilitato?> </th>  
									<th class="cella3" style="width:<?php echo $wAltezza ?>"><?php print $title_altezza?>  </th>  
									<th class="cella3" style="width:<?php echo $wLarghezza ?>"><?php print $title_larghezza?> </th>  
									<th class="cella3" style="width:<?php echo $wProfondita ?>"><?php print $title_profondita?> </th>  
									<th class="cella3" style="width:<?php echo $wPeso ?>"><?php print $title_peso?> </th>  
									<th class="cella3" style="width:<?php echo $wInfo1 ?>"><?php print $title_info1?> </th>  
									<th class="cella3" style="width:<?php echo $wInfo2 ?>"><?php print $title_info2?> </th>  
									<th class="cella3" style="width:<?php echo $wInfo3 ?>"><?php print $title_info3?> </th>  
									<th class="cella3" style="width:<?php echo $wInfo4 ?>"><?php print $title_info4?> </th>  
									<th class="cella3" style="width:<?php echo $wInfo5 ?>"><?php print $title_info5?>  </th> 
									<th class="cella3" style="width:<?php echo $wIdUtente ?>"><?php print $title_idUtente?> </th>  
									<th class="cella3" style="width:<?php echo $wIdAzienda ?>"><?php print $title_idAzienda?> </th>
					   				<th class="cella3" style="width:<?php echo $wStrumenti ?>" style rowspan="3" ><?php print $title_strumenti?></th>
								</tr>
								 
							
								<tr class="row filter" id="head" >
									<th class="cella2" >  
										<input type="text" id="searchId" onkeyup="searchTable('myTable', 'searchId','0');" placeholder=""> </th>
									<th class="cella2">  
										<input type="text" id="searchCodiceCollo" onkeyup="searchTable('myTable', 'searchCodiceCollo','1');" placeholder=""> </th>
									<th class="cella2">
										<input type="text" id="searchData" onkeyup="searchTable('myTable', 'searchData','2');" placeholder=""> </th>
									<th class="cella2">
										<input type="text" id="searchDtAbilitato" onkeyup="searchTable('myTable', 'searchDtAbilitato','3');" placeholder=""> </th>
									<th class="cella2" >
										<input type="text" id="searchAssociato" onkeyup="searchTable('myTable', 'searchAssociato','4');" placeholder=""> </th>
									<th class="cella2"> 
										<input type="text" id="searchNumBolla" onkeyup="searchTable('myTable', 'searchNumBolla','5');" placeholder=""> </th>
									<th class="cella2">
										<input type="text" id="searchDtBolla" onkeyup="searchTable('myTable', 'searchDtBolla','6');" placeholder=""> </th>
									<th class="cella2">
										<input type="text" id="searchAbilitato" onkeyup="searchTable('myTable', 'searchAbilitato','7');" placeholder=""> </th>
									<th class="cella2">
										<input type="text" id="searchAltezza" onkeyup="searchTable('myTable', 'searchAltezza','8');" placeholder=""> </th> 
									<th class="cella2">
										<input type="text" id="searchLarghezza" onkeyup="searchTable('myTable', 'searchLarghezza','9');" placeholder=""> </th>
									<th class="cella2">
										<input type="text" id="searchProfondita" onkeyup="searchTable('myTable', 'searchProfondita','10');" placeholder=""> </th>
									<th class="cella2">
										<input type="text" id="searchPeso" onkeyup="searchTable('myTable', 'searchPeso','11');" placeholder=""> </th>
									<th class="cella2"> 
										<input type="text" id="searchInfo1" onkeyup="searchTable('myTable', 'searchInfo1','12');" placeholder=""> </th>
									<th class="cella2"> 
										<input type="text" id="searchInfo2" onkeyup="searchTable('myTable', 'searchInfo2','13');" placeholder=""> </th>
									<th class="cella2">
										<input type="text" id="searchInfo3" onkeyup="searchTable('myTable', 'searchInfo3','14');" placeholder="."> </th>
									<th class="cella2"> 
										<input type="text" id="searchInfo4" onkeyup="searchTable('myTable', 'searchInfo4','15');" placeholder=""> </th>
									<th class="cella2"> 
										<input type="text" id="searchInfo5" onkeyup="searchTable('myTable', 'searchInfo5','16');" placeholder=""> </th>
									<th class="cella2">
										<input type="text" id="searchIdUtente" onkeyup="searchTable('myTable', 'searchIdUtente','17');" placeholder=""> </th>
									<th class="cella2"> 
										<input type="text" id="searchIdAzienda" onkeyup="searchTable('myTable', 'searchIdAzienda','18');" placeholder=""> </th>
								
								  </tr>
								
								<tr class="row head" id="head">
									<th class="cella45" style="width:<?php echo $wId ?>; cursor: pointer;" id="orderId" align="center"> <?php print "-" ?> </th> 
									<th class="cella45" style="width:<?php echo $wCodiceCollo ?>; cursor: pointer;" id="orderCodiceCollo"> <?php print "-" ?></th> 
									<th class="cella45" style="width:<?php echo $wData ?>; cursor: pointer;" id="orderData"><?php print "-" ?></th> 
									<th class="cella45" style="width:<?php echo $wDtAbilitato ?>; cursor: pointer;" id="orderDtAbilitato"><?php print "-" ?></th> 
									<th class="cella45" style="width:<?php echo $wAssociato ?>; cursor: pointer;" id="orderAssociato"><?php print "-" ?> </th>  
									<th class="cella45" style="width:<?php echo $wNumBolla ?>; cursor: pointer;" id="orderNumBolla"><?php print "-" ?></th> 
									<th class="cella45" style="width:<?php echo $wDtBolla ?>; cursor: pointer;" id="orderDtBolla"><?php print "-" ?></th> 
									<th class="cella45" style="width:<?php echo $wAbilitato ?>; cursor: pointer;" id="orderAbilitato"><?php print "-" ?></th> 
									<th class="cella45" style="width:<?php echo $wAltezza ?>; cursor: pointer;" id="orderAltezza"><?php print "-" ?></th> 
									<th class="cella45" style="width:<?php echo $wLarghezza ?>; cursor: pointer;" id="orderLarghezza"><?php print "-" ?></th> 
									<th class="cella45" style="width:<?php echo $$wProfondita ?>; cursor: pointer;" id="orderProfondita"><?php print "-" ?></th> 
									<th class="cella45" style="width:<?php echo $wPeso ?>; cursor: pointer;" id="orderPeso"><?php print "-" ?></th>  
									<th class="cella45" style="width:<?php echo $wInfo1 ?>; cursor: pointer;" id="orderInfo1"><?php print "-" ?></th> 
									<th class="cella45" style="width:<?php echo $wInfo2 ?>; cursor: pointer;" id="orderInfo2"><?php print "-" ?></th> 
									<th class="cella45" style="width:<?php echo $wInfo3 ?>; cursor: pointer;" id="orderInfo3"><?php print "-" ?></th> 
									<th class="cella45" style="width:<?php echo $wInfo4 ?>; cursor: pointer;" id="orderInfo4"><?php print "-" ?></th> 
									<th class="cella45" style="width:<?php echo $wInfo5 ?>; cursor: pointer;" id="orderInfo5"><?php print "-" ?></th> 
									<th class="cella45" style="width:<?php echo $wIdUtente ?>; cursor: pointer;" id="orderIdUtente"><?php print "-" ?></th> 
									<th class="cella45" style="width:<?php echo $wIdAzienda ?>; cursor: pointer;" id="orderIdAzienda"><?php print "-" ?></th>
								
								</tr> 
								
							</thead> 
							
							
							<tbody id="myTable">
								<?php
									for ($i = 0; $i<sizeof($elencoColli); ++$i) {
										$resto= $i%2;
										$ind= 47;
										if ($resto > 0) { $ind =46; }
								?> 		  
								<tr class="row <?php echo $ind?>">
									  
									<td class="cella<?php echo $ind?>" style="width:<?php echo $wId ?>" value="<?php echo $elencoColli[$i]->getId()?>" ><?php echo $elencoColli[$i]->getId()?></td>
							
									<td class="cella<?php echo $ind?>" style="width:<?php echo $wCodiceCollo ?>" value="<?php echo $elencoColli[$i]->getCodiceCollo()?>" ><?php echo $elencoColli[$i]->getCodiceCollo()?></td>
									<td class="cella<?php echo $ind?>" style="width:<?php echo $wData ?>" value="<?php echo $elencoColli[$i]->getData()?>" ><?php echo $elencoColli[$i]->getData()?></td>
									<td class="cella<?php echo $ind?>" style="width:<?php echo $wDtAbilitato ?>" value="<?php echo $elencoColli[$i]->getDtAbilitato()?>" ><?php echo $elencoColli[$i]->getDtAbilitato()?></td>
									<td class="cella<?php echo $ind?>" style="width:<?php echo $wAssociato ?>" value="<?php echo $elencoColli[$i]->getAssociato()?>" ><?php echo $elencoColli[$i]->getAssociato()?></td>
									<td class="cella<?php echo $ind?>" style="width:<?php echo $wNumBolla ?>" value="<?php echo $elencoColli[$i]->getNumBolla()?>" ><?php echo $elencoColli[$i]->getNumBolla()?></td>
									<td class="cella<?php echo $ind?>" style="width:<?php echo $wDtBolla ?>" value="<?php echo $elencoColli[$i]->getDtBolla()?>" ><?php echo $elencoColli[$i]->getDtBolla()?></td>
									<td class="cella<?php echo $ind?>" style="width:<?php echo $wAbilitato ?>" value="<?php echo $elencoColli[$i]->getAbilitato()?>" ><?php echo $elencoColli[$i]->getAbilitato()?></td>
									<td class="cella<?php echo $ind?>" style="width:<?php echo $wAltezza ?>" value="<?php echo $elencoColli[$i]->getAltezza()?>" ><?php echo $elencoColli[$i]->getAltezza()?></td>
									<td class="cella<?php echo $ind?>" style="width:<?php echo $wLarghezza ?>" value="<?php echo $elencoColli[$i]->getLarghezza()?>" ><?php echo $elencoColli[$i]->getLarghezza()?></td>
									<td class="cella<?php echo $ind?>" style="width:<?php echo $wProfondita ?>" value="<?php echo $elencoColli[$i]->getProfondita()?>" ><?php echo $elencoColli[$i]->getProfondita()?></td>
									<td class="cella<?php echo $ind?>" style="width:<?php echo $wPeso ?>" value="<?php echo $elencoColli[$i]->getPeso()?>" ><?php echo $elencoColli[$i]->getPeso()?></td>
									<td class="cella<?php echo $ind?>" style="width:<?php echo $wInfo1 ?>" value="<?php echo $elencoColli[$i]->getInfo1()?>" ><?php echo $elencoColli[$i]->getInfo1()?></td>
									<td class="cella<?php echo $ind?>" style="width:<?php echo $wInfo2 ?>" value="<?php echo $elencoColli[$i]->getInfo2()?>" ><?php echo $elencoColli[$i]->getInfo2()?></td>
									<td class="cella<?php echo $ind?>" style="width:<?php echo $wInfo3 ?>" value="<?php echo $elencoColli[$i]->getInfo3()?>" ><?php echo $elencoColli[$i]->getInfo3()?></td>
									<td class="cella<?php echo $ind?>" style="width:<?php echo $wInfo4 ?>" value="<?php echo $elencoColli[$i]->getInfo4()?>" ><?php echo $elencoColli[$i]->getInfo4()?></td>
									<td class="cella<?php echo $ind?>" style="width:<?php echo $wInfo5 ?>" value="<?php echo $elencoColli[$i]->getInfo5()?>" ><?php echo $elencoColli[$i]->getInfo4()?></td>
									<td class="cella<?php echo $ind?>" style="width:<?php echo $wIdUtente ?>" value="<?php echo $elencoColli[$i]->getIdUtente()?>" ><?php echo $elencoColli[$i]->getIdUtente()?></td>
									<td class="cella<?php echo $ind?>" style="width:<?php echo $wIdAzienda ?>" value="<?php echo $elencoColli[$i]->getIdAzienda()?>" ><?php echo $elencoColli[$i]->getIdAzienda()?></td>
								  		
									
									<td class="<?php echo $i ?>" style="width:<?php echo $widOp ?>">
                            			<a name="18" href="tracciabilita_colli_lotti_modifica_collo.php?&idCollo=<?php echo $elencoColli[$i]->getId() ?>">
											<img src="../images/pittogrammi/penna_R.png" class="icone" title="<?php echo $titleModificaCollo ?> "/></a>
										
										<a name="101" href="tracciabilita_colli_lotti_stampa_collo.php?&idCollo=<?php echo $elencoColli[$i]->getId() ?>">
										 	<img src="../images/pittogrammi/stampa_R.png" class="icone"  title="<?php echo $titleStampaCollo ?>"/></a>	 
										
										<a name="101" href="tracciabilita_colli_lotti_stampa_collo_etichetta.php?&idCollo=<?php echo $elencoColli[$i]->getId() ?>">
										 	<img src="../images/pittogrammi/stampa_G.png" class="icone"  title="<?php echo $titleStampaColloEtichetta ?>"/></a>	 
										
										 
                       			 	</td> 
							<?php
									} 
			 					?> 
								</tr>		 
							</tbody>
						</table>
						  
					</div>
				</div>
			</div>
		</div>  
</form> 
	 