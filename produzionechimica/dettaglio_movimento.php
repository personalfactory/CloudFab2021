<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<?php include('../include/validator.php'); ?>
<head>
<?php include('../include/header.php'); ?>
</head>
<body>

<div id="mainContainer">

<?php 

include('../include/menu.php'); include('../Connessioni/serverdb.php');

$CodiceMovimento=$_GET['Movimento'];

//Visualizzo il record che intendo modificare all'interno della form

$sqlMov = mysql_query("SELECT
							stato,
							dt_inser
						FROM
							mov_magazzino
						WHERE
							cod_mov='".$CodiceMovimento."'")
			or die("Query fallita: " . mysql_error());
	while($rowMov=mysql_fetch_array($sqlMov))
	{		
		list($MateriaPrima,$NumeroMovimento,$DataMovimento) = explode ('.',$CodiceMovimento);
		$DataMovimento=substr($DataMovimento,6)."-".substr($DataMovimento,4,-2)."-".substr($DataMovimento,0,-4);
		
		$Stato=$rowMov['stato'];
		$DataInserimento=$rowMov['dt_inser'];
	}

?>

<div id="container" style="width:600px; margin:15px auto;">
    <form id="DettaglioMiscela" name="DettaglioMiscela">
    <table width="600px">
		<th class="cella3" colspan="7">Dettaglio Movimenti</th>
        <tr>
            <td class="cella2">Codice Movimento</td>
            <td class="cella1"><?php echo $CodiceMovimento;?></td>
        </tr>
         <tr>
            <td class="cella2" >Numero Movimento </td>
            <td class="cella1"><?php echo $NumeroMovimento;?></td>
        </tr>
        <tr>
            <td class="cella2" >Data Movimento </td>
            <td class="cella1"><?php echo $DataMovimento;?></td>
        </tr>
        <tr>
            <td class="cella2" >Materie Prime </td>
            <td class="cella1"><?php echo $MateriaPrima;?></td>
        </tr>
        <tr>
            <td class="cella2" >Data Inserimento </td>
            <td class="cella1"><?php echo $DataInserimento;?></td>
        </tr>
        <tr>
            <td class="cella2" >Stato </td>
            <td class="cella1"><?php echo $Stato;?></td>
        </tr>
  </table>
  
  <table width="600px">   
        
        <tr>
            <td class="cella3">Id Miscela</td>
            <td class="cella3">Data Miscela</td>
            <td class="cella3">Codice Formula</td>
            <td class="cella3">Contenitore</td>
            <td class="cella3">Peso Reale</td>
       </tr>
       <?php  
	   $sqlMiscela = mysql_query("SELECT
									miscela_componente.id_miscela,
									miscela.dt_miscela,
									miscela.cod_formula,
									miscela.cod_contenitore,
									miscela.peso_reale
								FROM
									miscela_componente
								INNER JOIN 
									mov_magazzino 
											ON mov_magazzino.cod_mov = miscela_componente.cod_mov
								INNER JOIN  
									miscela 
											ON miscela.id_miscela = miscela_componente.id_miscela
								WHERE 
										miscela_componente.cod_mov='".$CodiceMovimento."'") 
			or die("Query fallita: " . mysql_error());
		
		$i = 1;
		$colore = 1;
		
		while($rowMiscela=mysql_fetch_array($sqlMiscela))
		{
					
					
			if($colore==1){
				?>
					
				<tr>
					<td class="cella1"><?php echo ($rowMiscela['id_miscela']);?></td>
					<td class="cella1"><?php echo ($rowMiscela['dt_miscela']);?></td>
                    <td class="cella1"><?php echo ($rowMiscela['cod_formula']);?></td>
                    <td class="cella1"><?php echo ($rowMiscela['cod_contenitore']);?></td>
                    <td class="cella1"><?php echo ($rowMiscela['peso_reale']);?></td>
				</tr>
				<?php 
				$colore = 2;
			}else{ ?>
       		<tr>
             	<td class="cella2"><?php echo ($rowMiscela['id_miscela']);?></td>
				<td class="cella2"><?php echo ($rowMiscela['dt_miscela']);?></td>
                <td class="cella2"><?php echo ($rowMiscela['cod_formula']);?></td>
                <td class="cella2"><?php echo ($rowMiscela['cod_contenitore']);?></td>
                <td class="cella2"><?php echo ($rowMiscela['peso_reale']);?></td>
			</tr>
			<?php 			
                $colore =1;
                }
             $i=$i+1;
		
		}//End While chimica?>
        <!--<tr>
            <td><input type="reset" value="Torna alle miscele " onClick="javascript:history.back();"/></td>
        </tr>-->
 	</table>
    </form>

</div>

</div><!--mainContainer-->

</body>
</html>
