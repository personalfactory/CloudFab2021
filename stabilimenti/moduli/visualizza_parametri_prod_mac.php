<?php
//Larghezza colonne 
//TOTALE container 1170px
$widId = "5%";
$widNom = "10%";
$widDes = "40%";
$widVal = "10%";
$widAb = "5%";
$widDt = "20%";
$widOp = "5%";
?>
<table class="table3">
    <tr>
        <th colspan="7"><?php echo $titoloPaginaParProdMac ?></th>
    </tr>
    <tr>
        <td  colspan="7" style="text-align:center;"> 
            <p><a href="carica_parametro_prod_mac.php"><?php echo $nuovoParametro ?> </a></p>
            <p>&nbsp;</p>
        </td>
    </tr>

    <!--################## MOTORE DI RICERCA #######################################-->
    <form  name="VediParComp" id="VediParComp" action="" method="POST">
        <table class="table3">
            <tr>
                <td><input style="width:100%" type="text" name="IdParPM" value="<?php echo $_SESSION['IdParPM'] ?>" /></td>
                <td><input style="width:100%" type="text" name="NomeVariabile"  value="<?php echo $_SESSION['NomeVariabile'] ?>" /></td>
                <td><input style="width:100%" type="text" name="DescriVariabile"  value="<?php echo $_SESSION['DescriVariabile'] ?>" /></td>
                <td><input style="width:100%" type="text" name="Valore" value="<?php echo $_SESSION['Valore'] ?>" /></td>
                <td><input style="width:100%" type="text" name="Abilitato"  value="<?php echo $_SESSION['Abilitato'] ?>" /></td>
                <td><input style="width:100%" type="text" name="DtAbilitato" value="<?php echo $_SESSION['DtAbilitato'] ?>" /></td>
                <td><input type="button" value="<?php echo $valueButtonCerca ?>" onClick="document.forms['VediParComp'].submit();"/></td>
            </tr>
            <!--################## ORDINAMENTO ########################################-->
            <tr>              
                <td class="cella3" style="width:<?php echo $widId ?>" ><div id="OrdinaIdPar"><?php echo $filtroIdPar; ?>
                        <button name="Filtro" type="submit" value="id_par_pm" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" style="width:<?php echo $widNom ?>"><div id="OrdinaNomeVar"><?php echo $filtroPar; ?>
                        <button name="Filtro" type="submit" value="nome_variabile" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" style="width:<?php echo $widDes ?>"><div id="Ordinadescri"><?php echo $filtroDescrizione; ?>
                        <button name="Filtro" type="submit" value="descri_variabile" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" style="width:<?php echo $widVal ?>"><div id="OrdinaVal"><?php echo $filtroValoreBase; ?>
                        <button name="Filtro" type="submit" value="valore_base" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" style="width:<?php echo $widAb ?>"><div id="OrdinaAbilitato"><?php echo $filtroAbilitato; ?>
                        <button name="Filtro" type="submit" value="abilitato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" style="width:<?php echo $widDt ?>"><div id="OrdinaDtabil"><?php echo $filtroDt; ?>
                        <button name="Filtro" type="submit" value="dt_abilitato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" style="width:<?php echo $widOp ?>"><?php echo $filtroOperazioni; ?></td>
            </tr>
            <?php
            echo "<br/>" . $msgRecordTrovati . $trovati . "<br/>";
            echo "<br/>" . $msgSelectCriteriRicerca . "<br/>";

            $i = 1;
            $colore = 1;
            while ($row = mysql_fetch_array($sql)) {

                $strFineNom = "";
                $strFineDes = "";


                if (strlen($row['nome_variabile']) > 30) {
                    $strFineNom = $filtroPuntini;
                }
                if (strlen($row['descri_variabile']) > 90) {
                    $strFineDes = $filtroPuntini;
                }

                
                    ?>
                    <tr>
                        <td class="cella1" style="width:<?php echo $widId ?>"><?php echo($row['id_par_pm']) ?></td>
                        <td class="cella1" style="width:<?php echo $widNom ?>" title="<?php echo $row['nome_variabile'] ?>"><?php echo(substr($row['nome_variabile'], 0, 30) . $strFineNom) ?></td>
                        <td class="cella1" style="width:<?php echo $widDes ?>" title="<?php echo $row['descri_variabile'] ?>"><?php echo(substr($row['descri_variabile'], 0, 90) . $strFineDes) ?></td>
                        <td class="cella1" style="width:<?php echo $widVal ?>"><nobr><?php echo($row['valore_base'])?> <span class="uniMisStyle"><?php echo $row['uni_mis']  ?></span></nobr></td>
                        <td class="cella1" style="width:<?php echo $widAb ?>"><?php echo($row['abilitato']) ?></td>
                        <td class="cella1" style="width:<?php echo $widDt ?>"><?php echo($row['dt_abilitato']) ?></td>
                        <td class="cella1" style="width:<?php echo $widOp ?>">
                           
                        </td>
                    </tr>
                   
              <?php
            }
            ?>
        </table>