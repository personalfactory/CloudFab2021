	<table class="table3">
    	<tr>
    		<th colspan="11"><?php echo $labelMenuRifGeo?></th>
    	</tr>
        <tr>
        	<td  colspan="11" style="text-align:center;"> 
            	<p><a href="carica_comune.php"><?php echo $linkNuovoRif?></a></p>
       	    	<p>&nbsp;</p>
            </td>
    	</tr>
        <tr>
        	<th class="cella3">N</th>
            <th class="cella3"><?php echo $filtroCap?></th>
            <th class="cella3"><?php echo $filtroIstat?></th>
            <th class="cella3"><?php echo $filtroComune?></th>
            <th class="cella3"><?php echo $filtroProvincia?></th>
            <th class="cella3"><?php echo $filtroRegione?></th>
            <th class="cella3"><?php echo $filtroStato?></th>
            <th class="cella3"><?php echo $filtroContinente?></th>
            <th class="cella3"><?php echo $filtroAbilitato?></th>
            <th class="cella3"><?php echo $filtroDt?></th>
            <th class="cella3"><?php echo $filtroOperazioni?></th>
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
            <td class="cella1"><?php echo($row['cap'])?></td>
            <td class="cella1"><?php echo($row['cod_istat'])?></td>
            <td class="cella1"><?php echo($row['comune'])?></td>
            <td class="cella1"><?php echo($row['provincia'])?></td>
            <td class="cella1"><?php echo($row['regione'])?></td>
            <td class="cella1"><?php echo($row['stato'])?></td>
            <td class="cella1"><?php echo($row['continente'])?></td>
            <td class="cella1"><?php echo($row['abilitato'])?></td>
            <td class="cella1"><?php echo($row['dt_abilitato'])?></td>
            <td class="cella1"style="width:90px">
            	<!--<a href="cancella_comune.php?Comune=<?php echo($row['id_comune'])?>"><img src="/CloudFab/images/pittogrammi/patumiera_R.png" class="icone" alt="Elimina" title="Clicca per cancellare il comune"/></a> -->
                <a href="modifica_comune_provincia.php?Comune=<?php echo($row['id_comune'])?>"><img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" title="<?php echo $titleModifica?>"/></a>
            </td>
        </tr>
        <?php 
			$colore = 2;
		}else{ ?>
        <tr>
        	<td class="cella2"><?php echo($i)?></td>
            <td class="cella2"><?php echo($row['cap'])?></td>
            <td class="cella2"><?php echo($row['cod_istat'])?></td>
            <td class="cella2"><?php echo($row['comune'])?></td>
            <td class="cella2"><?php echo($row['provincia'])?></td>
            <td class="cella2"><?php echo($row['regione'])?></td>
            <td class="cella2"><?php echo($row['stato'])?></td>
            <td class="cella2"><?php echo($row['continente'])?></td>
            <td class="cella2"><?php echo($row['abilitato'])?></td>
            <td class="cella2"><?php echo($row['dt_abilitato'])?></td>
            <td class="cella2" style="width:90px">
            	<!--<a href="cancella_comune.php?Comune=<?php echo($row['id_comune'])?>"><img src="/CloudFab/images/pittogrammi/patumiera_R.png" class="icone" alt="Elimina" title="Clicca per cancellare il comune"/></a>--> 
                <a href="modifica_comune_provincia.php?Comune=<?php echo($row['id_comune'])?>"><img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" title="<?php echo $titleModifica?>"/></a>
            </td>
        </tr>
        <?php 
			$colore =1;
			}
		 $i=$i+1;
		}?>
    </table>