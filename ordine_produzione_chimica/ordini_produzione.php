<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<?php include('../include/validator.php'); ?>
	<head>
		<?php include('../include/header.php'); 
		
		$visualizzaInfo1 = false; 
		$visualizzaInfo2 = false; 
		$visualizzaInfo3 = false; 
		$visualizzaInfo4 = false; 
		$visualizzaInfo5 = false; 
		$visualizzaUtente = false; 
		$visualizzaAzienda = false; 
		
		?>
		
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
				$('#orderCodicOrdine').text('-');
				$('#orderRespOrdine').text('-');
				$('#orderData').text('-');
				$('#orderAbilitato').text('-');  
				$('#orderDtAbilitato').text('-');
				$('#orderDataEvasionePrevista').text('-');
				$('#orderStatoEvasione').text('-');
				$('#orderDataEvasione').text('-');
				$('#orderRespEvasione').text('-');
				$('#orderAnnullamento').text('-');
				$('#orderDtAnnullamento').text('-');
				$('#orderRespAnnullamento').text('-');
				$('#orderNote').text('-'); 
				$('#orderNoteEvasione').text('-'); 
				$('#orderNoteAnnullamento').text('-'); 
				$('#orderInfo1').text('-');
				$('#orderInfo2').text('-');
				$('#orderInfo3').text('-');
				$('#orderInfo4').text('-');
				$('#orderInfo5').text('-');
				$('#orderIdUtente').text('-');
				$('#orderIdAzienda').text('-');
			 
				 
				if($(this).index()===0) { if (!this.asc){ $('#orderId').text('↑');} else { $('#orderId').text('↓'); } }
				if($(this).index()===1) { if (!this.asc){ $('#orderCodicOrdine').text('↑');} else { $('#orderCodicOrdine').text('↓'); } }
				if($(this).index()===2) { if (!this.asc){ $('#orderRespOrdine').text('↑');} else { $('#orderRespOrdine').text('↓'); } }
				if($(this).index()===3) { if (!this.asc){ $('#orderData').text('↑');} else { $('#orderData').text('↓'); } }
				if($(this).index()===4) { if (!this.asc){ $('#orderAbilitato').text('↑');} else { $('#orderAbilitato').text('↓'); } }
				if($(this).index()===5) { if (!this.asc){ $('#orderDtAbilitato').text('↑');} else { $('#orderDtAbilitato').text('↓'); } }
				if($(this).index()===6) { if (!this.asc){ $('#orderDataEvasionePrevista').text('↑');} else { $('#orderDataEvasionePrevista').text('↓'); } }
				if($(this).index()===7) { if (!this.asc){ $('#orderStatoEvasione').text('↑');} else { $('#orderStatoEvasione').text('↓'); } }
				if($(this).index()===8) { if (!this.asc){ $('#orderDataEvasione').text('↑');} else { $('#orderDataEvasione').text('↓'); } }
				if($(this).index()===9) { if (!this.asc){ $('#orderRespEvasione').text('↑');} else { $('#orderRespEvasione').text('↓'); } }
				if($(this).index()===10) { if (!this.asc){ $('#orderAnnullamento').text('↑');} else { $('#orderAnnullamento').text('↓'); } }
				if($(this).index()===11) { if (!this.asc){ $('#orderDtAnnullamento').text('↑');} else { $('#orderDtAnnullamento').text('↓'); } }
				if($(this).index()===12) { if (!this.asc){ $('#orderRespAnnullamento').text('↑');} else { $('#orderRespAnnullamento').text('↓'); } }
				if($(this).index()===13) { if (!this.asc){ $('#orderNote').text('↑');} else { $('#orderNote').text('↓'); } } 
				if($(this).index()===14) { if (!this.asc){ $('#orderNoteEvasione').text('↑');} else { $('#orderNoteEvasione').text('↓'); } } 
				if($(this).index()===15) { if (!this.asc){ $('#orderNoteAnnullamento').text('↑');} else { $('#orderNoteAnnullamento').text('↓'); } } 
				if($(this).index()===16) { if (!this.asc){ $('#orderInfo1').text('↑');} else { $('#orderInfo1').text('↓'); } }
				if($(this).index()===17) { if (!this.asc){ $('#orderInfo2').text('↑');} else { $('#orderInfo2').text('↓'); } }
				if($(this).index()===18) { if (!this.asc){ $('#orderInfo3').text('↑');} else { $('#orderInfo3').text('↓'); } }
				if($(this).index()===19) { if (!this.asc){ $('#orderInfo4').text('↑');} else { $('#orderInfo4').text('↓'); } }
				if($(this).index()===20) { if (!this.asc){ $('#orderInfo5').text('↑');} else { $('#orderInfo5').text('↓'); } }
				if($(this).index()===21) { if (!this.asc){ $('#orderIdUtente').text('↑');} else { $('#orderIdUtente').text('↓'); } }
				if($(this).index()===22) { if (!this.asc){ $('#orderIdAzienda').text('↑');} else { $('#orderIdAzienda').text('↓'); } }
				  
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
	
		
	
	
	
	
	<body onLoad="<?php echo $actionOnLoad ?>">
		
		<div id="mainContainer">
			<?php 
				include('../include/menu.php');
				include('../Connessioni/serverdb.php');
				include("../ordine_produzione_chimica/include/funzioni.php");
				include("../ordine_produzione_chimica/sql/query.php");
 
				$elencoOrdini = array();
				$elencoOrdini = getElencoOrdini();
		    
			?>  
			<div style="float:none;">
			<table class="table3">
					<th colspan="14"><?php echo $titoloPaginaOrdiniProduzioneChimica ?></th>
					<tr>
						<td colspan="14" style="text-align:center;"> 
							<a id="4" name="4" href="nuovo_ordine.php" ><?php echo $titoloNuovoOrdine ?></a>      
						</td>
					</tr>
			</table>  
			</div> 
			   
		<div class="limiter">
			
			<div class="container-table">
				<div >
			 		<div>
						<br>
						<table id="tableFilter">
							<thead>	
								<tr class="row head" id ="head" style="text-align: center;">
									<th class="cella3" style= "font-size: 12px;" ><?php echo $titelTabOrdine0; ?> </th> 
									<th class="cella3" style= "font-size: 12px;" ><?php echo $titelTabOrdine1; ?> </th> 
									<th class="cella3" style= "font-size: 12px;" ><?php echo $titelTabOrdine2; ?> </th> 
									<th class="cella3" style= "font-size: 12px;" ><?php echo $titelTabOrdine3; ?> </th> 
									<th class="cella3" style= "font-size: 12px;" ><?php echo $titelTabOrdine4; ?> </th>  
									<th class="cella3" style= "font-size: 12px;" ><?php echo $titelTabOrdine5; ?> </th> 
									<th class="cella3" style= "font-size: 12px;" ><?php echo $titelTabOrdine6; ?> </th>  
									<th class="cella3" style= "font-size: 12px;" ><?php echo $titelTabOrdine7; ?> </th>  
									<th class="cella3" style= "font-size: 12px;" ><?php echo $titelTabOrdine8; ?> </th> 
									<th class="cella3" style= "font-size: 12px;" ><?php echo $titelTabOrdine9; ?> </th> 
									<th class="cella3" style= "font-size: 12px;" ><?php echo $titelTabOrdine10; ?> </th> 
									<th class="cella3" style= "font-size: 12px;" ><?php echo $titelTabOrdine11; ?> </th>  
									<th class="cella3" style= "font-size: 12px;" ><?php echo $titelTabOrdine12; ?> </th> 
									<th class="cella3" style= "font-size: 12px;" ><?php echo $titelTabOrdine13; ?> </th> 
									<th class="cella3" style= "font-size: 12px;" ><?php echo $titelTabOrdine14; ?> </th> 
									<th class="cella3" style= "font-size: 12px;" ><?php echo $titelTabOrdine15; ?> </th> 
								<?php if ($visualizzaInfo1) { ?><th class="cella3" style= "font-size: 12px;" ><?php echo $titelTabOrdine16; ?> </th> <?php } ?>
								<?php if ($visualizzaInfo2) { ?><th class="cella3" style= "font-size: 12px;" ><?php echo $titelTabOrdine17; ?> </th> <?php } ?> 
								<?php if ($visualizzaInfo3) { ?><th class="cella3" style= "font-size: 12px;" ><?php echo $titelTabOrdine18; ?> </th> <?php } ?> 
								<?php if ($visualizzaInfo4) { ?><th class="cella3" style= "font-size: 12px;" ><?php echo $titelTabOrdine19; ?> </th> <?php } ?> 
								<?php if ($visualizzaInfo5) { ?><th class="cella3" style= "font-size: 12px;" ><?php echo $titelTabOrdine20; ?> </th> <?php } ?>
								<?php if ($visualizzaUtente) { ?><th class="cella3" style= "font-size: 12px;" ><?php echo $titelTabOrdine21; ?> </th> <?php } ?>
								<?php if ($visualizzaAzienda){ ?><th class="cella3" style= "font-size: 12px;" ><?php echo $titelTabOrdine22; ?> </th> <?php } ?>   
					   				<th class="cella3" rowspan="3"><?php echo $title_strumenti?></th>
								</tr>
								  
								<tr class="row filter" id="head" >
									<th class="cella2" style="text-align:center;"> 
										<input type="text" style="text-align:center; width:30px;" id="searchId" onkeyup="searchTable('myTable','searchId','0');" placeholder=""> </th>
									<th class="cella2" style="text-align:center;"> 
										<input type="text" style="text-align:center; width:100px;" id="searchCodicOrdine" onkeyup="searchTable('myTable','searchCodicOrdine','1');" placeholder=""> </th>
									<th class="cella2" style="text-align:center;"> 
										<input type="text" style="text-align:center; width:100px;" id="searchRespOrdine" onkeyup="searchTable('myTable','searchRespOrdine','2');" placeholder=""> </th>
									<th class="cella2" style="text-align:center;"> 
										<input type="text" style="text-align:center; width:100px;" id="searchData" 	onkeyup="searchTable('myTable','searchData','3');" placeholder=""> </th>
									<th class="cella2" style="text-align:center;"> 
										<input type="text" style="text-align:center; width:30px;" id="searchAbilitato" onkeyup="searchTable('myTable','searchAbilitato','4');" placeholder=""> </th>
									<th class="cella2" style="text-align:center;"> 
										<input type="text" style="text-align:center; width:100px;" id="searchDtAbilitato" onkeyup="searchTable('myTable','searchDtAbilitato','5');" placeholder=""> </th> 
									<th class="cella2" style="text-align:center;"> 
										<input type="text" style="text-align:center; width:30px;" id="searchDataEvasionePrevista" onkeyup="searchTable('myTable','searchDtAbilitato','6');" placeholder=""> </th> 
									<th class="cella2" style="text-align:center;"> 
										<input type="text" style="text-align:center; width:30px;" id="searchStatoEvasione" onkeyup="searchTable('myTable', 'searchStatoEvasione','7');" placeholder=""> </th>
									<th class="cella2" style="text-align:center;"> 
										<input type="text" style="text-align:center; width:100px;" id="searchDataEvasione" onkeyup="searchTable('myTable', 'searchDataEvasione','8');" placeholder=""> </th>
									<th class="cella2" style="text-align:center;"> 
										<input type="text" style="text-align:center; width:120px;" id="searchRespEvasione" onkeyup="searchTable('myTable', 'searchRespEvasione','9');" placeholder="" > </th> 
									<th class="cella2"  style="text-align:center;"> 
										<input type="text" style="text-align:center; width:30px;" id="searchAnnullamento" onkeyup="searchTable('myTable', 'searchAnnullamento','10');" placeholder=""> </th>
									<th class="cella2" style="text-align:center;"> 
										<input type="text" style="text-align:center; width:100px;" id="searchDtAnnullamento" onkeyup="searchTable('myTable', 'searchDtAnnullamento','11');" placeholder="" > </th>
									<th class="cella2" style="text-align:center;"> 
										<input type="text" style="text-align:center; width:100px;" id="searchRespAnnullamento" onkeyup="searchTable('myTable','searchRespAnnullamento','12');" placeholder="."> </th>
									<th class="cella2" style="text-align:center;"> 
										<input type="text" style="text-align:center; width:100px;"id="searchNote" onkeyup="searchTable('myTable', 'searchNote','13');" placeholder=""> </th> 
									<th class="cella2" style="text-align:center;"> 
										<input type="text" style="text-align:center; width:100px;"id="searchNoteEvasione" onkeyup="searchTable('myTable', 'searchNoteEvasione','14');" placeholder=""> </th> 
									<th class="cella2" style="text-align:center;"> 
										<input type="text" id="searchNoteAnnullamento" onkeyup="searchTable('myTable', 'searchNoteAnnullamento','15');" placeholder="" style="width: 90px;"> </th> 
									<?php if ($visualizzaInfo1) { ?>
									<th class="cella2"> 
									<input type="text" id="searchInfo1" onkeyup="searchTable('myTable', 'searchInfo1','16');" placeholder="" style="width: 60px;"> </th><?php } ?>
									<?php if ($visualizzaInfo2) { ?>	
									<th class="cella2"> 
										<input type="text" id="searchInfo2" onkeyup="searchTable('myTable', 'searchInfo2','17');" placeholder="" style="width: 60px;"> </th><?php } ?>
									<?php if ($visualizzaInfo3) { ?>	
									<th class="cella2"> 
									<input type="text" id="searchInfo3" onkeyup="searchTable('myTable', 'searchInfo3','18');" placeholder="" style="width: 60px;"> </th><?php } ?>
									<?php if ($visualizzaInfo4) { ?>	
									<th class="cella2"> 
										<input type="text" id="searchInfo4" onkeyup="searchTable('myTable', 'searchInfo4','19');" placeholder="" style="width: 60px;"> </th><?php } ?>
									<?php if ($visualizzaInfo5) { ?>	
									<th class="cella2"> 
									<input type="text" id="searchInfo5" onkeyup="searchTable('myTable', 'searchInfo5','20');" placeholder="" style="width: 60px;"> </th><?php } ?>
									<?php if ($visualizzaUtente) { ?>	
									<th class="cella2"> 
										<input type="text" id="searchIdUtente" onkeyup="searchTable('myTable', 'searchIdUtente','21');" placeholder="" style="width: 60px;"> </th> <?php } ?>
									<?php if ($visualizzaAzienda) { ?>	
									<th class="cella2"> 
										<input type="text" id="searchIdAzienda" onkeyup="searchTable('myTable', 'searchIdAzienda','22');" placeholder="" > </th> <?php } ?>
								
								  </tr>
								 
								<tr class="row head" id="head">
									<th class="cella45" style="cursor: pointer;" id="orderId" align="center"> <?php print "-" ?> </th> 
									<th class="cella45" style="cursor: pointer;" id="orderCodicOrdine"> <?php print "-" ?></th> 
									<th class="cella45" style="cursor: pointer;" id="orderRespOrdine"><?php print "-" ?></th> 
									<th class="cella45" style="cursor: pointer;" id="orderData"><?php print "-" ?></th> 
									<th class="cella45" style="cursor: pointer;" id="orderAbilitato"><?php print "-" ?> </th>  
									<th class="cella45" style="cursor: pointer;" id="orderDtAbilitato"><?php print "-" ?></th> 
									<th class="cella45" style="cursor: pointer;" id="orderDataEvasionePrevista"><?php print "-" ?></th> 
									<th class="cella45" style="cursor: pointer;" id="orderStatoEvasione"><?php print "-" ?></th> 
									<th class="cella45" style="cursor: pointer;" id="orderDataEvasione"><?php print "-" ?></th> 
									<th class="cella45" style="cursor: pointer;" id="orderRespEvasione"><?php print "-" ?></th>  
									<th class="cella45" style="cursor: pointer;" id="orderAnnullamento"><?php print "-" ?></th> 
									<th class="cella45" style="cursor: pointer;" id="orderDtAnnullamento"><?php print "-" ?></th> 
									<th class="cella45" style="cursor: pointer;" id="orderRespAnnullamento"><?php print "-" ?></th> 
									<th class="cella45" style="cursor: pointer;" id="orderNote"><?php print "-" ?></th>  
									<th class="cella45" style="cursor: pointer;" id="orderNoteEvasione"><?php print "-" ?></th> 
									<th class="cella45" style="cursor: pointer;" id="orderNoteAnnullamento"><?php print "-" ?></th> 
<?php if ($visualizzaInfo1) { ?>	<th class="cella45" style="cursor: pointer;" id="orderInfo1"><?php print "-" ?></th> <?php } ?>
<?php if ($visualizzaInfo2) { ?>	<th class="cella45" style="cursor: pointer;" id="orderInfo2"><?php print "-" ?></th> <?php } ?>
<?php if ($visualizzaInfo3) { ?>	<th class="cella45" style="cursor: pointer;" id="orderInfo3"><?php print "-" ?></th> <?php } ?>
<?php if ($visualizzaInfo4) { ?>	<th class="cella45" style="cursor: pointer;" id="orderInfo4"><?php print "-" ?></th> <?php } ?>
<?php if ($visualizzaInfo5) { ?>	<th class="cella45" style="cursor: pointer;" id="orderInfo5"><?php print "-" ?></th> <?php } ?>
<?php if ($visualizzaUtente) { ?>	<th class="cella45" style="cursor: pointer;" id="orderIdUtente"><?php print "-" ?></th> <?php } ?>
<?php if ($visualizzaAzienda) { ?>	<th class="cella45" style="cursor: pointer;" id="orderIdAzienda"><?php print "-" ?></th> <?php } ?> 
								</tr>  
							</thead>  
							
							
							<tbody id="myTable"> 
								<?php 
									for ($i=0; $i<count($elencoOrdini); $i++) {
				  				?>
								<tr class="row <?php echo $ind?>" > 
									<td class="cella1" style="text-align:center; font-size: 12px;"><?php echo $elencoOrdini[$i][0]; ?></td>
									<td class="cella1" style="text-align:center; font-size: 12px;" ><?php echo $elencoOrdini[$i][1];  ?></td>
									<td class="cella1" style="text-align:center; font-size: 12px;" ><?php echo $elencoOrdini[$i][2]; ?></td>
									<td class="cella1" style="text-align:center; font-size: 12px;" ><?php echo $elencoOrdini[$i][3]; ?></td>
									<td class="cella1" style="text-align:center; font-size: 12px;" ><?php echo $elencoOrdini[$i][4]; ?></td>
									<td class="cella1" style="text-align:center; font-size: 12px;" ><?php echo $elencoOrdini[$i][5]; ?></td>
									<td class="cella1" style="text-align:center; font-size: 12px;" ><?php echo $elencoOrdini[$i][6]; ?></td>
									<td class="cella1" style="text-align:center; font-size: 12px;" ><?php echo $elencoOrdini[$i][7]; ?></td>
									<td class="cella1" style="text-align:center; font-size: 12px;" ><?php echo $elencoOrdini[$i][8]; ?></td>
									<td class="cella1" style="text-align:center; font-size: 12px;" ><?php echo $elencoOrdini[$i][9]; ?></td>
									<td class="cella1" style="text-align:center; font-size: 12px;" ><?php echo $elencoOrdini[$i][10]; ?></td>
									<td class="cella1" style="text-align:center; font-size: 12px;" ><?php echo $elencoOrdini[$i][11]; ?></td>
									<td class="cella1" style="text-align:center; font-size: 12px;" ><?php echo $elencoOrdini[$i][12]; ?></td>
									<td class="cella1" style="text-align:center; font-size: 12px;" ><?php echo $elencoOrdini[$i][13]; ?></td>
									<td class="cella1" style="text-align:center; font-size: 12px;" ><?php echo $elencoOrdini[$i][14]; ?></td>
									<td class="cella1" style="text-align:center; font-size: 12px;" ><?php echo $elencoOrdini[$i][15]; ?></td>
<?php if ($visualizzaInfo1) { ?>	<td class="cella1" style="text-align:center; font-size: 12px;" ><?php echo $elencoOrdini[$i][16]; ?></td><?php } ?> 
<?php if ($visualizzaInfo2) { ?>	<td class="cella1" style="text-align:center; font-size: 12px;" ><?php echo $elencoOrdini[$i][17]; ?></td><?php } ?> 
<?php if ($visualizzaInfo2) { ?>	<td class="cella1" style="text-align:center; font-size: 12px;" ><?php echo $elencoOrdini[$i][18]; ?></td><?php } ?> 
<?php if ($visualizzaInfo4) { ?>	<td class="cella1" style="text-align:center; font-size: 12px;" ><?php echo $elencoOrdini[$i][19]; ?></td><?php } ?> 
<?php if ($visualizzaInfo5) { ?>	<td class="cella1" style="text-align:center; font-size: 12px;" ><?php echo $elencoOrdini[$i][20]; ?></td><?php } ?> 
<?php if ($visualizzaUtente) { ?> 	<td class="cella1" style="text-align:center; font-size: 12px;" ><?php echo $elencoOrdini[$i][21]; ?></td><?php } ?>  
<?php if ($visualizzaAzienda) { ?> 	<td class="cella1" style="text-align:center; font-size: 12px;" ><?php echo $elencoOrdini[$i][22]; ?></td><?php } ?> 
 								
									<td class="<?php echo $i ?>">
										
                            			<a href="evasione_ordine.php?&ordine=<?php echo $elencoOrdini[$i][0]; ?>" <?php if ($elencoOrdini[$i][7]!="0" || $elencoOrdini[$i][10]!="0"){ ?>  style="pointer-events: none;  cursor: default;"<?php } ?>>
											<img src="../images/pittogrammi/ok.png" class="icone" title="<?php echo $titelStrumentoOrdine0 ?>" /></a>
										 
										<a href="annulla_ordine.php?&ordine=<?php echo $elencoOrdini[$i][0]; ?>" <?php if ($elencoOrdini[$i][10]!="0" || $elencoOrdini[$i][7]!="0"){ ?>  style="pointer-events: none;  cursor: default;"<?php } ?>> 
										 	<img src="../images/pittogrammi/lucchetto_R.png" class="icone"  title="<?php echo $titelStrumentoOrdine1; ?>"/></a>	 
										
										<a href="visualizza_ordine.php?&ordine=<?php echo $elencoOrdini[$i][0]; ?>">
										 	<img src="../images/pittogrammi/stampa_R.png" class="icone"  title="<?php echo $titelStrumentoOrdine2; ?>"/></a>	
										
										<a href="disabilita_ordine.php?&ordine=<?php echo $elencoOrdini[$i][0]; ?>" > 
										 	<img src="../images/pittogrammi/patumiera_G.png" class="icone"  title="<?php echo $titelStrumentoOrdine3; ?>"</a>	
											
										<a href="visualizza_ordine_stampa.php?&ordine=<?php echo $elencoOrdini[$i][0]; ?>" > 
										 	<img src="../images/pittogrammi/stampa_G.png" class="icone"  title="<?php echo $titelStrumentoOrdine3; ?>"</a>	
										 
                       			 	</td> 
									
									 
								
								<?php } ?>
							</tbody>
						</table>
						  
					</div>
				</div>
			</div>
		</div>  
		 
			</div>		
			  
	</body>
</html> 