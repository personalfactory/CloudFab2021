<?php
//Larghezza colonne 
//TOTALE container 1170px
$wid1 = "15%";
$wid2 = "15%";
$wid3 = "15%";
$wid4 = "15%";
$wid5 = "15%";
$wid6 = "5%";
$wid7 = "5%";
$wid8 = "15%";
?>
<form  name="VediGruppi" id="VediGruppi" action="" method="POST">
<table class="table3">
    	<tr>
    		<th colspan="10"><?php echo $titoloGruppiAcq ?></th>
    	</tr>
        <tr> 
        	<td  colspan="10" style="text-align:center;"> 
            	<p><a href="carica_gruppo.php"><?php echo $linkNuovoGruppo?></a></p>
       	    	<p>&nbsp;</p>
            </td>
    	</tr>
        <tr>
                <td><input style="width:100%" type="text" name="Livello1" value="<?php echo $_SESSION['Livello1'] ?>" /></td>
                <td><input style="width:100%" type="text" name="Livello2" value="<?php echo $_SESSION['Livello2'] ?>" /></td>
                <td><input style="width:100%" type="text" name="Livello3" value="<?php echo $_SESSION['Livello3'] ?>" /></td>
                <td><input style="width:100%" type="text" name="Livello4" value="<?php echo $_SESSION['Livello4'] ?>" /></td>
                <td><input style="width:100%" type="text" name="Livello5" value="<?php echo $_SESSION['Livello5'] ?>" /></td>
                <td><input style="width:100%" type="text" name="Livello6" value="<?php echo $_SESSION['Livello6'] ?>" /></td>
                <td><input style="width:100%" type="text" name="Abilitato"  value="<?php echo $_SESSION['Abilitato'] ?>" /></td>
                <td><input style="width:100%" type="text" name="DtAbilitato" value="<?php echo $_SESSION['DtAbilitato'] ?>" /></td>
                <td><input type="button" value="<?php echo $valueButtonCerca ?>" onClick="document.forms['VediGruppi'].submit();"/></td>
            </tr>
            
            <!--################## ORDINAMENTO ########################################-->
            <tr>              
                <td class="cella3" style="width:<?php echo $wid1 ?>" ><div id="OrdinaLiv1"><?php echo $filtroLivello. " 1"; ?>
                        <button name="Filtro" type="submit" value="livello_1" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" style="width:<?php echo $wid2 ?>"><div id="OrdinaLiv2"><?php echo $filtroLivello." 2"; ?>
                        <button name="Filtro" type="submit" value="livello_2" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" style="width:<?php echo $wid3 ?>"><div id="OrdinaLiv3"><?php echo $filtroLivello." 3"; ?>
                        <button name="Filtro" type="submit" value="livello_3" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" style="width:<?php echo $wid4 ?>"><div id="OrdinaLiv4"><?php echo $filtroLivello." 4"; ?>
                        <button name="Filtro" type="submit" value="livello_4" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" style="width:<?php echo $wid5 ?>"><div id="OrdinaLiv5"><?php echo $filtroLivello." 5"; ?>
                        <button name="Filtro" type="submit" value="livello_5" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" style="width:<?php echo $wid6 ?>"><div id="OrdinaLiv5"><?php echo $filtroLivello." 6"; ?>
                        <button name="Filtro" type="submit" value="livello_6" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" style="width:<?php echo $wid7 ?>"><div id="OrdinaAbilitato"><?php echo $filtroAbilitato; ?>
                        <button name="Filtro" type="submit" value="abilitato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" style="width:<?php echo $wid8 ?>"><div id="OrdinaDtabil"><?php echo $filtroDt; ?>
                        <button name="Filtro" type="submit" value="dt_abilitato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" style="width:<?php echo $wid8 ?>"><?php echo $filtroOperazioni; ?></td>
            </tr>

        
        <?php
			
			$colore = 1;
        	while($row=mysql_fetch_array($sql))
			{
				if($colore==1){
		?>
        <tr>
        	
            <td class="cella1"><?php echo($row['livello_1'])?></td>
            <td class="cella1"><?php echo($row['livello_2'])?></td>
            <td class="cella1"><?php echo($row['livello_3'])?></td>
            <td class="cella1"><?php echo($row['livello_4'])?></td>
            <td class="cella1"><?php echo($row['livello_5'])?></td>
            <td class="cella1"><?php echo($row['livello_6'])?></td>
            <td class="cella1"><?php echo($row['abilitato'])?></td>
            <td class="cella1"><?php echo($row['dt_abilitato'])?></td>
            <td class="cella1"style="width:90px">
            	<!--<a href="cancella_gruppo.php?Gruppo=<?php echo($row['id_gruppo'])?>"><img src="/CloudFab/images/pittogrammi/patumiera_R.png" class="icone" alt="Elimina" title="Clicca per cancellare il gruppo"/></a>--> 
                <a href="modifica_gruppo_livello.php?Gruppo=<?php echo($row['id_gruppo'])?>"><img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" title="<?php echo $titleModifica?>"/></a>
            </td>
        </tr>
        <?php 
			$colore = 2;
		}else{ ?>
        <tr>
        	
            <td class="cella2"><?php echo($row['livello_1'])?></td>
            <td class="cella2"><?php echo($row['livello_2'])?></td>
            <td class="cella2"><?php echo($row['livello_3'])?></td>
            <td class="cella2"><?php echo($row['livello_4'])?></td>
            <td class="cella2"><?php echo($row['livello_5'])?></td>
            <td class="cella2"><?php echo($row['livello_6'])?></td>
            <td class="cella2"><?php echo($row['abilitato'])?></td>
            <td class="cella2"><?php echo($row['dt_abilitato'])?></td>
            <td class="cella2" style="width:90px">
            	<!--<a href="cancella_gruppo.php?Gruppo=<?php echo($row['id_gruppo'])?>"><img src="/CloudFab/images/pittogrammi/patumiera_R.png" class="icone" alt="Elimina" title="Clicca per cancellare il gruppo" /></a>--> 
                <a href="modifica_gruppo_livello.php?Gruppo=<?php echo($row['id_gruppo'])?>"><img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" title="<?php echo $titleModifica?>"/></a>
            </td>
        </tr>
        <?php 
			$colore =1;
			}
		 $i=$i+1;
		}?>
    </table>
</form>