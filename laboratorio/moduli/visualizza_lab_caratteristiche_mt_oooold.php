	<table class="table3">
    	<tr>
    		<th colspan="8"><?php echo $titoloPaginaLabProprietaMt ?></th>
    	</tr>
    	<tr>
        	<td  colspan="8" style="text-align:center;"> 
            	<a href="carica_lab_caratteristica_mt.php"><?php echo $nuovaLabProprieta ?></a>
            </td>
        </tr>
        <tr>
        	<td > <?php echo $msgLabProprietaTrovate ." ". mysql_num_rows($sql) ?>
            </td>
        </tr>
         
       	<tr>
            <th class="cella3"><?php echo $filtroLabId ?></th>
            <th class="cella3"><?php echo $filtroLabProprietaMt ?></th>
            <th class="cella3"><?php echo $filtroLabUnMisura ?></th>
	    <!--<th class="cella3"><?php echo $filtroLabTipoDato ?></th>-->
            <th class="cella3"><?php echo $filtroLabDimensione ?></th>
            <th class="cella3"><?php echo $filtroLabUnMisura." ".$filtroLabDimensione ?></th>
            <th class="cella3"><?php echo $filtroLabMetodologia ?></th>
	    <th class="cella3"><?php echo $filtroLabData ?></th>
            <th class="cella3"><?php echo $filtroOperazioni ?></th>
        </tr>
        <?php
			$i = 1;
			$colore = 1;
        	while($row=mysql_fetch_array($sql))
			{
				if($colore==1){
		?>
        <tr>
            <td class="cella1"><?php echo($row['id_carat'])?></td>
            <td class="cella1"><?php echo($row['caratteristica'])?></td>
            <td class="cella1"><?php echo($row['uni_mis_car'])?></td>
            <!--<td class="cella1"><?php echo($row['tipo_dato'])?></td>-->
            <td class="cella1"><?php echo($row['dimensione'])?></td>
            <td class="cella1"><?php echo($row['uni_mis_dim'])?></td>
            <td class="cella1"><?php echo($row['metodologia'])?></td>
            <td class="cella1"><?php echo($row['dt_abilitato'])?></td>
            <td class="cella1"style="width:90px">
                <a href="modifica_lab_caratteristica_mt.php?IdCaratteristica=<?php echo($row['id_carat'])?>"><img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" alt="Modifica" title="Clicca per modificare"/></a>
            </td>
        </tr>
        <?php 
			$colore = 2;
		}else{ ?>
        <tr>
            <td class="cella2"><?php echo($row['id_carat'])?></td>
            <td class="cella2"><?php echo($row['caratteristica'])?></td>
            <td class="cella2"><?php echo($row['uni_mis_car'])?></td>
            <!--<td class="cella2"><?php echo($row['tipo_dato'])?></td>-->
            <td class="cella2"><?php echo($row['dimensione'])?></td>
            <td class="cella2"><?php echo($row['uni_mis_dim'])?></td>
            <td class="cella2"><?php echo($row['metodologia'])?></td>
            <td class="cella2"><?php echo($row['dt_abilitato'])?></td>
             <td class="cella2"style="width:90px">
                <a href="modifica_lab_caratteristica_mt.php?IdCaratteristica=<?php echo($row['id_carat'])?>"><img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" alt="Modifica" title="Clicca per modificare"/></a>
            </td>
            
        </tr>
        <?php 
			$colore =1;
			}
		 $i=$i+1;
		}?>
    </table>