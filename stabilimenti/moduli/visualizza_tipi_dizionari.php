<!--Attualmente le funzioni di modifica ed eliminazione sono state disabilitate perch� i tipi di dizionario vengono utilizzati come codici all'interno del software (aggiorna dizionario)-->
    <table class="table3">
    	<tr>
    		<th colspan="6"><?php echo $labelMenuTipoDiz?></th>
    	</tr>
        <tr>
        	<td  colspan="5" style="text-align:center;"> 
            	<p><a href="carica_tipo_dizionario.php"><?php echo $filtroLabNuovo.' '.$labelTipoDiz ?></a></p>
       	    	<p>&nbsp;</p>
            </td>
    	</tr>
        <tr height="40px">
        	<th class="cella3">N</th>
            <th class="cella3"><?php echo $labelTipoDiz?></th>
            <th class="cella3"><?php echo $labelTabDiRif?></th>
            <th class="cella3"><?php echo $filtroAbilitato?></th>
            <th class="cella3"><?php echo $filtroDt?></th>
            <!--<th class="cella3">Operazioni</th>-->
        </tr>
        <?php
			$i = 1;
			$colore = 1;
        	while($row=mysql_fetch_array($sql))
			{
				if($colore==1){
		?>
        <tr height="30px">
        	<td class="cella1"><?php echo($i)?></td>
            <td class="cella1"><?php echo($row['dizionario_tipo'])?></td>
            <td class="cella1"><?php echo($row['tabella'])?></td>
            <td class="cella1"><?php echo($row['abilitato'])?></td>
            <td class="cella1"><?php echo($row['dt_abilitato'])?></td>
            <!--<td class="cella1"style="width:90px">
            	<a href="cancella_tipo_dizionario.php?TipoDizionario=<?php echo($row['id_diz_tipo'])?>"><img src="/CloudFab/images/pittogrammi/patumiera_R.png" class="icone" alt="Elimina" title="Clicca per cancellare il tipo di dizionario"/></a> 
                <a href="modifica_tipo_dizionario.php?TipoDizionario=<?php echo($row['id_diz_tipo'])?>"><img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" alt="Modifica"title="Clicca per modificare il tipo di dizionario"/></a>
            </td>-->
        </tr>
        <?php 
			$colore = 2;
		}else{ ?>
        <tr height="30px">
        	<td class="cella2"><?php echo($i)?></td>
            <td class="cella2"><?php echo($row['dizionario_tipo'])?></td>
            <td class="cella2"><?php echo($row['tabella'])?></td>
            <td class="cella2"><?php echo($row['abilitato'])?></td>
            <td class="cella2"><?php echo($row['dt_abilitato'])?></td>
            <!--<td class="cella1"style="width:90px">
            	<a href="cancella_tipo_dizionario.php?TipoDizionario=<?php echo($row['id_diz_tipo'])?>"><img src="/CloudFab/images/pittogrammi/patumiera_R.png" class="icone" alt="Elimina" title="Clicca per cancellare il tipo di dizionario"/></a> 
                <a href="modifica_tipo_dizionario.php?TipoDizionario=<?php echo($row['id_diz_tipo'])?>"><img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" alt="Modifica"title="Clicca per modificare il tipo di dizionario"/></a>
            </td>-->
        </tr>
        <?php 
			$colore =1;
			}
		 $i=$i+1;
		}?>
    </table>