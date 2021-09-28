<table class="table3">
    	
       	<tr>
            <th class="cella3">N</th>
            <td class="cella3">Codice Movimento</td>
            <td class="cella3">Numero Movimento</td>
            <td class="cella3">Data Movimento</td>
            <td class="cella3">Materia Prima</td> 
            <td class="cella3">Operazioni</td>           
       
        </tr>
        <?php
			$i = 1;
			$colore = 1;
        	for ($j = 0; $j < $NumCodiciAggiornati; $j++) {
			
				$CodMov=$_SESSION['codici_mov'][$j];
				list($MateriaPrima,$Movimento,$Dt) = explode ('.',$CodMov);
				//$Data=substr($Data,6)."-".substr($Data,4,-2)."-".substr($Data,0,-4);
				
                               
    
    $Data=inserisciTrattini($Dt);
    $sqlMat = findMatPrimaByCodice($MateriaPrima);
    while ($rowMat = mysql_fetch_array($sqlMat)) {
        $DescriMat = $rowMat['descri_mat'];
    }
				if($colore==1){
		?>
        <tr>
        	<td class="cella1"><?php echo($i)?></td>
            <td class="cella1"><a href="dettaglio_movimento.php?Movimento=<?php echo($CodMov)?>"><?php echo($CodMov)?></a></td>
            <td class="cella1"><?php echo($Movimento)?></a></td>
            <td class="cella1"><?php echo($Dt)?></a></td>
            <td class="cella1"><?php echo($MateriaPrima)?></td>
            <td class="cella1"style="width:90px">
                <a href="genera_cod_mov.php?IdMov=<?php echo $Movimento ?>&CodMat=<?php echo $MateriaPrima ?>&DtDoc=<?php echo $Data ?>&NomeMat=<?php echo $DescriMat ?>">
                    <img src="/CloudFab/images/pittogrammi/stampa_G.png" class="icone"  title="<?php echo $titleGeneraCodiceMov ?>"/></a>
            </td>
           
                       
        </tr>
        <?php 
			$colore = 2;
		}else{ ?>
        <tr>
            <td class="cella2"><?php echo($i)?></td>
            <td class="cella2"><a href="dettaglio_movimento.php?Movimento=<?php echo($CodMov)?>"><?php echo($CodMov)?></a></td>
            <td class="cella2"><?php echo($Movimento)?></a></td>
            <td class="cella2"><?php echo($Dt)?></a></td>
            <td class="cella2"><?php echo($MateriaPrima)?></td>
             <td class="cella2"style="width:90px">
                <a href="genera_cod_mov.php?IdMov=<?php echo $Movimento ?>&CodMat=<?php echo $MateriaPrima ?>&DtDoc=<?php echo $Data ?>&NomeMat=<?php echo $DescriMat ?>">
                    <img src="/CloudFab/images/pittogrammi/stampa_G.png" class="icone"  title="<?php echo $titleGeneraCodiceMov ?>"/></a>
            </td>
           
        </tr>
        <?php 
			$colore =1;
			}
		 $i=$i+1;
		}?>
    </table>
