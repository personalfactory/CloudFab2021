<?php
    $wid1 = "10%";
    $wid2 = "50%";
    $wid3 = "5%";
    $wid4 = "15%";
    $wid5 = "10%";
      
    ?>
<table class="table3">

    <tr>
        <th colspan="4"><?php echo $titoloPaginaMessaggiMacchina ?></th>
    </tr>
    <tr>
        <td  colspan="4" style="text-align:center;"> 
            <p><a href="carica_messaggio.php"><?php echo $nuovoMessaggio ?></a></p>
            <p>&nbsp;</p>
        </td>
    </tr>
</table>
    <!--################## MOTORE DI RICERCA ###################################-->
    <form  name="VediMessaggi" id="VediMessaggi" action="" method="POST">
        <table class="table3">
            <tr>
                <td><input type="text" style="width:100%" name="IdMessaggio"  value="<?php echo $_SESSION['IdMessaggio'] ?>" /></td>
                <td><input type="text" style="width:100%" name="Messaggio"  value="<?php echo $_SESSION['Messaggio'] ?>" /></td>
                <td><input type="text" style="width:100%" name="Abilitato"  value="<?php echo $_SESSION['Abilitato'] ?>" /></td>
                <td><input type="text" style="width:100%" name="DtAbilitato"  value="<?php echo $_SESSION['DtAbilitato'] ?>" /></td>
                <td><img src="/CloudFab/images/icone/lente_piccola.png" onClick="document.forms['VediMessaggi'].submit();" title="<?php echo $titleRicerca ?>"/></td>
            </tr>
            <!--################## ORDINAMENTO ########################################-->
            <tr>              
                <td class="cella3" width="<?php echo $wid1 ?>" ><div id="OrdinaIdMes"><?php echo $filtroId; ?>
                        <button name="Filtro" type="submit" value="id_messaggio" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3"  width="<?php echo $wid2 ?>"><div id="OrdinaMessaggio"><?php echo $filtroMessaggio; ?>
                        <button name="Filtro" type="submit" value="messaggio" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $wid3 ?>"><div id="OrdinaAbilitato"><?php echo $filtroAbilitato; ?>
                        <button name="Filtro" type="submit" value="abilitato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3"  width="<?php echo $wid4 ?>"><div id="OrdinaDtabil"><?php echo $filtroDt; ?>
                        <button name="Filtro" type="submit" value="dt_abilitato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" width="<?php echo $wid5 ?>"><?php echo $filtroOperazioni; ?></td>
            </tr>
            <?php
            echo "<br/>" . $msgRecordTrovati . $trovati . "<br/>";
             echo "<br/>".$msgSelectCriteriRicerca."<br/>";

            $colore = 1;
            while ($row = mysql_fetch_array($sql)) {
                if ($colore == 1) {
                    ?>
                    <tr>
                        <td class="cella1" width="<?php echo $wid1 ?>"><?php echo($row['id_messaggio']) ?></td>
                        <td class="cella1" width="<?php echo $wid2 ?>"><?php echo($row['messaggio']) ?></td>
                        <td class="cella1" width="<?php echo $wid3 ?>"><?php echo($row['abilitato']) ?></td>
                        <td class="cella1" width="<?php echo $wid4 ?>"><?php echo($row['dt_abilitato']) ?></td>
                        <td class="cella1" width="<?php echo $wid5 ?>">
            <!--            	<a href="cancella_messaggio.php?Messaggio=<?php echo($row['id_messaggio']) ?>">
                            <img src="/CloudFab/images/pittogrammi/patumiera_R.png" class="icone" title="<?php echo $titleElimina ?>"/></a> -->
                            <a href="modifica_messaggio.php?Messaggio=<?php echo($row['id_messaggio']) ?>">
                                <img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" title="<?php echo $titleModifica ?>"/></a>
                        </td>
                    </tr>
                    <?php
                    $colore = 2;
                } else {
                    ?>
                    <tr>
                        <td class="cella2" width="<?php echo $wid1 ?>"><?php echo($row['id_messaggio']) ?></td>
                        <td class="cella2" width="<?php echo $wid2 ?>"><?php echo($row['messaggio']) ?></td>
                        <td class="cella2" width="<?php echo $wid3 ?>"><?php echo($row['abilitato']) ?></td>
                        <td class="cella2" width="<?php echo $wid4 ?>"><?php echo($row['dt_abilitato']) ?></td>
                        <td class="cella2" width="<?php echo $wid5 ?>">
            <!--            	<a href="cancella_messaggio.php?Messaggio=<?php echo($row['id_messaggio']) ?>">
                            <img src="/CloudFab/images/pittogrammi/patumiera_R.png" class="icone" title="<?php echo $titleElimina ?>"/></a> -->
                            <a href="modifica_messaggio.php?Messaggio=<?php echo($row['id_messaggio']) ?>">
                                <img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" title="<?php echo $titleModifica ?>"/></a>
                        </td>
                    </tr>
                    <?php
                    $colore = 1;
                }
               
            }
            ?>
        </table>