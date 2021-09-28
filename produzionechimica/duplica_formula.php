<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<?php include('../include/validator.php'); ?>
<head>
<?php include('../include/header.php'); ?>
</head>
<body>


<div id="mainContainer">
<script language="javascript" src="../js/visualizza_elementi.js"></script>
<?php include('../include/menu.php'); ?>
<?php //include('../js/visualizza_elementi.js');?>
<?php include('../Connessioni/serverdb.php');?>
<?php include('../include/gestione_date.php');?>
<?php $Pagina="modifica_formula";?>

<script language="javascript">
	function Carica(){
		document.forms["DuplicaFormula"].action = "duplica_formula2.php";
		document.forms["DuplicaFormula"].submit();
	}
</script>

<?php
//La variabile CodiceFormula si riferisce al codice della formula vecchia ovvero la formula dalla quale parte la duplicazione
//La variabile CodiceFormulaNew è il codice della nuova formula che verrà mandata in post alla pagina duplica_formula_2 per essere salvata
$CodiceFormula=$_POST['CodiceFormula'];
//visualizzo il record che intendo duplicare all'interno della form
//Estraggo i dati della formula da duplicare dalle tabelle formula, accessorio_formula e generazione_formula
$sqlFormula= mysql_query("SELECT
							formula.dt_formula,
							formula.descri_formula,
							formula.num_sac,
							formula.qta_sac,
							formula.abilitato,
							formula.dt_abilitato
						FROM
							formula
						WHERE 
							cod_formula='".$CodiceFormula."'") 

			or die("Errore 90: " . mysql_error());
			
	while($rowFormula=mysql_fetch_array($sqlFormula))
	{
		$DataFormula=$rowFormula['dt_formula'];
		$DescriFormula=$rowFormula['descri_formula'];
		$NumSacchetti=$rowFormula['num_sac'];
		$QtaSacchetto=$rowFormula['qta_sac'];
		$Abilitato=$rowFormula['abilitato'];
		$Data=$rowFormula['dt_abilitato'];
		}
	
mysql_close();
?>

 <div id="container" style="width:850px; margin:15px auto;">
  <form id="DuplicaFormula" name="DuplicaFormula" method="post" >
	<table width="100%" >
	  <tr>
		<td  colspan="6" class="cella3">Duplica Formula</td>
	  </tr>
      <input type="hidden" name="CodiceFormula" id="CodiceFormula" value=<?php echo $CodiceFormula;?>></input>
      <tr>
      	<td class="cella4">Data Formula:</td>
             <?php  $DataFormula=dataCorrenteVisualizza();?>
		<td class="cella1"><?php echo $DataFormula;?></td>
      </tr>
      <tr>
	     <td width="200" class="cella4">Codice Formula:</td>
	     <td class="cella1">
          	<select name="CodiceFormulaNew" id="CodiceFormulaNew">
            	<option value="" selected>Selezionare il tipo di Codice</option>
                    <?php
						$sqlCodice = mysql_query("SELECT tipo_codice FROM serverdb.codice ORDER BY tipo_codice") 
                          or die("Errore 112: " . mysql_error());
                       while($rowCodice=mysql_fetch_array($sqlCodice)){
                        ?>
                <option value="<?php echo ("K".$rowCodice['tipo_codice']);?>"><?php echo ("K".$rowCodice['tipo_codice']);?></option>
                  <?php }?>
              </select>
             </td>
          </tr>
	  <tr>
		<td class="cella4">Descrizione:</td>
		<td class="cella1"><input type="text" name="DescriFormula" id="DescriFormula" /> </td>
	  </tr>
      <tr>
	    <td class="cella4">Numero Sacchetti:</td>
	    <td class="cella1"><input type="text" name="NumSacchetti" id="NumSacchetti" value="<?php echo $NumSacchetti;?>"/></td>
      </tr>
      <tr>
	    <td class="cella4">Quantità Sacchetto:</td>
	    <td class="cella1"><input type="text" name="QtaSacchetto" id="QtaSacchetto" value="<?php echo $QtaSacchetto;?>"/></td>
      </tr>
	  <tr>
	     <td colspan="6" class="cella3">Imballaggio</td>
      </tr>
<?php 
 
  //Recupero gli accessori trattati separatamente tramite delle select in acessorio_formula 
  include('../include/select_accessori_singoli.php');?>
        
   <tr>
          <td class="cella4">Scatola x Lotto 43x30x30</td>
          <td class="cella1"><input type="text" name="ScatolaPerLotto" id="ScatolaPerLotto" value="<?php echo $ScatolaPerLotto;?>"/>&nbsp; qt</td>
       </tr>
       <tr>
          <td class="cella4">Etichetta Lotto 20x20</td>
          <td class="cella1"><input type="text" name="EtichettaLotto" id="EtichettaLotto" value="<?php echo $EtichettaLotto;?>"/>&nbsp; qt</td>
       </tr>
       <tr>
          <td class="cella4">Etichetta Chimica</td>
          <td class="cella1"><input type="text" name="EtichettaChimica" id="EtichettaChimica" value="<?php echo $EtichettaChimica;?>"/>&nbsp; qt</td>
       </tr>
       <tr>
          <td class="cella4">Sacchetto Polietilene</td>
          <td class="cella1"><input type="text" name="SacchettoPolietilene" id="SacchettoPolietilene" value="<?php echo $SacchettoPolietilene;?>"/>&nbsp; qt</td>
       </tr>
       <tr>
          <td class="cella4">Operatore</td>
          <td class="cella1"><input type="text" name="Operatore" id="Operatore" value="<?php echo $Operatore;?>"/>&nbsp; min</td>
       </tr>
   <?php
	//Visualizzo l'elenco degli accessori presenti nella tabella accessorio_formula ma diversi da quelli già esplicitati nella form
   $NAcc = 1;
   $sqlAccessori = mysql_query("SELECT 
									accessorio_formula.accessorio,
									accessorio_formula.quantita,
									gaz_001artico.descri
								FROM 
									serverdb.accessorio_formula 
								INNER JOIN 
									gazie.gaz_001artico 
								ON 	
									accessorio_formula.accessorio=gaz_001artico.codice
								WHERE 
									cod_formula='".$CodiceFormula."'
								AND
									accessorio<>'scatLot'
								AND 
									accessorio<>'eticCh'
								AND 
									accessorio<>'sacCh'
								AND 
									accessorio<>'eticLot'
								AND 
									accessorio<>'OPER'
								ORDER BY descri") 
		          or die("Errore 23: " . mysql_error());
	while($rowAccessori=mysql_fetch_array($sqlAccessori)){?>
		<tr>
			<td  class="cella4"><?php echo($rowAccessori['accessorio'])?></td>
			<td class="cella1"><input type="text" name="QtaAcc<?php echo($NAcc);?>" id="QtaAcc<?php echo($NAcc);?>" value="<?php echo($rowAccessori['quantita']);?>" />&nbsp; qt</td>
         </tr>
         <?php 
		 $NAcc++;
	}
	 //Visualizzo l'elenco degli accessori NON PRESENTI nella tabella accessorio_formula
	$NAccNp = $NAcc;
   	$sqlAccessoriNp = mysql_query("SELECT codice,descri 
										FROM 
											gazie.gaz_001artico 
										WHERE 
												catmer =4 
											AND 
												descri IS NOT NULL
											AND 
												codice<>'scatLot'
											AND 
												codice<>'eticCh'
											AND 
												codice<>'sacCh'
											AND 
												codice<>'eticLot'
											AND 
												codice<>'OPER'
											AND 
												codice NOT IN (SELECT accessorio 
																FROM 
																	serverdb.accessorio_formula 
																WHERE 
																	cod_formula='".$CodiceFormula."')
										ORDER BY descri") 
		          or die("Errore 23: " . mysql_error());
	while($rowAccessoriNp=mysql_fetch_array($sqlAccessoriNp)){?>
		<tr>
			<td  class="cella4"><?php echo($rowAccessoriNp['descri'])?></td>
			<td class="cella1"> <input type="text" name="QtaAcc<?php echo($NAccNp);?>" id="QtaAcc<?php echo($NAccNp);?>" value="0"/>&nbsp; qt</td>
         </tr>
         <?php 
		 $NAccNp++;
	}
	?>
</table>
				                
<table>
<tr>
	     <td  colspan="6" class="cella3">ATTENZIONE: Per poter aggiornare i Costi occorre prima SALVARE e poi andare in MODIFICA</td>
      </tr>
	<tr>
       	<td colspan="7" width="850px" class="cella3">Materie Prime</td>
   	</tr>
    <tr>
	     <td class="cella3">Materie Prima</td>
         <td width="80px" class="cella3">Costo <br/> Unitario</td>
         <td class="cella3">Quantità <br/> per <br/> Quintale</td>           
         <td class="cella3">Costo <br/> per <br/> Quintale</td>
         <td class="cella3">Quantità <br/> per<br/> Miscela</td>
         <td class="cella3">Costo <br/> Per <br/> Miscela</td>
    </tr> 
    <?php 
	//Inizializzo le variabili numeriche
	$CostoQuintaleTotale=0;
	$CostoMiscelaTotale=0;
	$TotaleQtaQuintale=0;
	$TotaleQtaMiscela=0;
		
	//Visualizzo l'elenco delle materie prime presenti nella tabella generazione_formula
	$NMatPri = 1;
	$sqlMatPrime = mysql_query("SELECT 
							   		generazione_formula.quantita AS quantitaMt,
									generazione_formula.cod_mat,
									materia_prima.descri_mat
							   	FROM 
							   		serverdb.generazione_formula 
							   	LEFT JOIN 
									serverdb.materia_prima 
									ON 
										generazione_formula.cod_mat=materia_prima.cod_mat
								WHERE
									 	cod_formula='".$CodiceFormula."'
								ORDER BY descri_mat") 
	or die("Errore 24: " . mysql_error());
	while($rowMatPrime=mysql_fetch_array($sqlMatPrime)){?>
		<tr>
			<td width="300px"class="cella4"><?php echo($rowMatPrime['descri_mat'])?></td>
	          
		<?php //Inizio prezzo
			include('../Connessioni/gazie.php'); 
			$sqlPrezzo= mysql_query("SELECT preacq/100000 AS prezzo 
										FROM 
											gazie.gaz_001artico 
										WHERE 
												catmer=2 
											AND 
												codice='".$rowMatPrime['cod_mat']."'") 
					or die("Errore 25: " . mysql_error());
					while($rowPrezzo=mysql_fetch_array($sqlPrezzo)){
						
								$CostoUnitario=number_format($rowPrezzo['prezzo'],4);
								$CostoQuintale=number_format($rowMatPrime['quantitaMt']*$CostoUnitario,4);
								$CostoQuintaleTotale=number_format($CostoQuintaleTotale+$CostoQuintale,2);
							    $QuantitaMiscela=$rowMatPrime['quantitaMt']*$NumSacchetti;
								$CostoMiscela=number_format($QuantitaMiscela*$CostoUnitario,2);
								$CostoMiscelaTotale=number_format($CostoMiscelaTotale+$CostoMiscela,2);
							  ?>
				  		<?php 
					}//End While Prezzo ?>
			<td class="cella1" >&nbsp;<?php echo $CostoUnitario;?>&nbsp; &euro;</td>
            <td class="cella1"><input type="text" style="width: 70px;"name="Qta<?php echo($NMatPri);?>" id="Qta<?php echo($NMatPri);?>" value="<?php echo ($rowMatPrime['quantitaMt']);?>"/>&nbsp;gr</td>
			<td class="cella1" width="100px">&nbsp;<?php echo $CostoQuintale;?>&nbsp; &euro;</td>
            <td class="cella1" width="100px">&nbsp;<?php echo $QuantitaMiscela;?>&nbsp;gr</td>	      
			<td class="cella1" width="100px">&nbsp;<?php echo $CostoMiscela;?>&nbsp; &euro;</td>
            
		</tr>
		<?php 
		$TotaleQtaQuintale=$TotaleQtaQuintale+$rowMatPrime['quantitaMt'];
		$TotaleQtaMiscela=$TotaleQtaMiscela+$QuantitaMiscela;
		$NMatPri++;
	}//End While Materie Prima
	
	
	////////Visualizzo l'elenco delle materie prime NON presenti nella tabella generazione_formula ma PRESENTI nella tabella materia_prima
	
	$NMatPriNp = $NMatPri;
	$sqlMatPrimeNp = mysql_query("SELECT * FROM serverdb.materia_prima WHERE cod_mat NOT IN 
								 (SELECT 
							   			cod_mat
								   	FROM 
							   			serverdb.generazione_formula 
							   		WHERE
									 	cod_formula='".$CodiceFormula."')
								ORDER BY descri_mat") 
	or die("Errore 24: " . mysql_error());
	while($rowMatPrimeNp=mysql_fetch_array($sqlMatPrimeNp)){?>
		<tr>
			<td width="300px"class="cella4"><?php echo($rowMatPrimeNp['descri_mat'])?></td>
	          
		<?php //Inizio prezzo
			include('../Connessioni/gazie.php'); 
			$sqlPrezzo= mysql_query("SELECT preacq/100000 AS prezzo 
										FROM 
											gazie.gaz_001artico 
										WHERE 
												catmer=2 
											AND 
												codice='".$rowMatPrimeNp['cod_mat']."'") 
					or die("Errore 25: " . mysql_error());
					while($rowPrezzo=mysql_fetch_array($sqlPrezzo)){
						
								$CostoUnitario=number_format($rowPrezzo['prezzo'],4);
								
					}//End While Prezzo ?>
			<td class="cella1" >&nbsp;<?php echo $CostoUnitario;?>&nbsp; &euro;</td>
            <td class="cella1"><input type="text" style="width: 70px;"name="Qta<?php echo($NMatPriNp);?>" id="Qta<?php echo($NMatPriNp);?>" value="0"/>&nbsp;gr</td>
			<td class="cella1" width="100px">&nbsp; 0 &nbsp; &euro;</td>
            <td class="cella1" width="100px">&nbsp; 0 &nbsp;gr</td>	      
			<td class="cella1" width="100px">&nbsp; 0 &nbsp; &euro;</td>
            
		</tr>
		<?php 
		
		$NMatPriNp++;
	}//End While Materie Prime NON PRESENTI
	///////////////////////////////////////7
		
	mysql_close();?>
     	<tr>
          	<td width="100px" class="cella3" colspan="2">Totali</td>
          	<td width="100px" class="cella3"> Quantità <br/> Totale <br/> per <br/> Quintale </td></td>
          	<td width="70px" class="cella3"> Costo <br/>Totale <br/> per <br/> Quintale</td>
            <td width="100px" class="cella3">Quantità <br/> Totale <br/> per <br/> Miscela </td>
            <td width="70px" class="cella3">Costo <br/> Totale <br/> per <br/> Miscela</td>
         </tr>	
         <tr>
            <td width="100px"  colspan="2">  </td>
            <td width="100px" class="cella3"><?php echo $TotaleQtaQuintale; ?>&nbsp;gr</td>
            <td width="70px"  class="cella3"><?php echo $CostoQuintaleTotale; ?>&nbsp; &euro;</td>
            <td width="100px" class="cella3"><?php echo $TotaleQtaMiscela; ?>&nbsp;gr</td>
            <td width="70px"  class="cella3"><?php echo $CostoMiscelaTotale; ?>&nbsp; &euro;</td>
         </tr>	
	</table>
         
    <table>       
          <tr>
           	  <td><input type="button" onclick="javascript:Carica();" value="Salva" /></td>
              <td><input type="reset" value="Annulla" onClick="javascript:history.back();"></td>
          </tr>
    </table>
    
   </form>
 </div>
 
</div><!--mainContainer-->

</body>
</html>

  
  
  
  
  
  
  
  
  
  
  
  
  
