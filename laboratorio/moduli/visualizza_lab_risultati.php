	<table class="table3">
    	<tr>
    		<th colspan="8">Risultati Formule</th>
    	</tr>
    	<tr>
        	<td  colspan="8" style="text-align:center;"> 
            	<p><a href="carica_lab_risultati.php">Associa Risultati a Prova di Laboratorio</a></p>
       	    	<p>&nbsp;</p>
            </td>
        </tr>
         <?php include('../include/funzioni.php');
			  formRicerca("cerca_lab_risultato.php"); 
			?>
       	<tr>
        	<th class="cella3">N</th>
            <th class="cella3">Codice Formula</th>
            <th class="cella3">Numero Prova</th>
            <th class="cella3">Data Prova</th>
            <th class="cella3">Operazioni</th>
        </tr>
        <?php
			$i = 1;
			$colore = 1;
        	while($row=mysql_fetch_array($sql))
			{
				if($colore==1){
		?>
        <tr>
        	<td class="cella1"><?php echo($i)?></td>
            <td class="cella1"><a href="dettaglio_lab_risultato.php?IdEsperimento=<?php echo ($row['id_esperimento']); ?>"><?php echo($row['cod_lab_formula'])?></a></td>
            <td class="cella1"><?php echo($row['num_prova'])?></td>
            <td class="cella1"><?php echo($row['dt_prova'])?></td>
                       
            <td class="cella1"style="width:90px">
            	<!--<a href="cancella_risultato.php?IdEsperimento=<?php echo ($row['id_esperimento']); ?>"><img src="/CloudFab/images/pittogrammi/patumiera_R.png" class="icone" alt="Elimina" title="Clicca per cancellare "/></a>&nbsp;-->
                <a href="modifica_lab_risultati.php?IdEsperimento=<?php echo ($row['id_esperimento']); ?>"><img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" alt="Modifica" title="Clicca per modificare"/></a>
            </td>
        </tr>
        <?php 
			$colore = 2;
		}else{ ?>
        <tr>
        	<td class="cella2"><?php echo($i)?></td>
            <td class="cella2"><a href="dettaglio_lab_risultato.php?IdEsperimento=<?php echo ($row['id_esperimento']); ?>"><?php echo($row['cod_lab_formula'])?></a></td>
            <td class="cella2"><?php echo($row['num_prova'])?></td>
            <td class="cella2"><?php echo($row['dt_prova'])?></td>
            
             	
                <td class="cella2"style="width:90px">
            	<!--<a href="cancella_risultato.php?IdEsperimento=<?php echo ($row['id_esperimento']); ?>"><img src="/CloudFab/images/pittogrammi/patumiera_R.png" class="icone" alt="Elimina" title="Clicca per cancellare "/></a>&nbsp;-->
                <a href="modifica_lab_risultati.php?IdEsperimento=<?php echo ($row['id_esperimento']); ?>"><img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" alt="Modifica" title="Clicca per modificare"/></a>
            </td>
            
        </tr>
        <?php 
			$colore =1;
			}
		 $i=$i+1;
		}?>
    </table>