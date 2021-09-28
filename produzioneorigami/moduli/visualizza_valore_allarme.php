<?php
//Larghezza colonne
//TOTALE container 1170px
$widId = "5%";
$widNom = "10%";
$widDes = "30%";
$widVal = "30%";
$widAb = "5%";
$widDt = "15%";
$widOp = "5%";
?>
<table class="table3">
    <tr>
        <th colspan="7"><?php echo $titoloPaginaGestioneAllarmi ?></th>
    </tr>
    <tr>
        <th colspan="7"><?php echo $_SESSION['DescriStab'] ?></th>
    </tr>
    
    <!--################## MOTORE DI RICERCA ###################################-->
    <form  name="VediParGlob" id="VediParGlob" action="" method="POST">
        <table class="table3">
            <tr>
                <td><input style="width:100%"  type="text" name="IdAllarme" value="<?php echo $_SESSION['IdAllarme'] ?>" /></td>
                <td><input style="width:100%" type="text" name="Nome" value="<?php echo $_SESSION['Nome'] ?>" /></td>
                <td><input style="width:100%" type="text" name="Descrizione" value="<?php echo $_SESSION['Descrizione'] ?>" /></td>
                <td><input style="width:100%" type="text" name="Valore" value="<?php echo $_SESSION['Valore'] ?>" /></td>
                <td><input style="width:100%" type="text" name="IdCiclo" value="<?php echo $_SESSION['IdCiclo'] ?>" /></td>
                <td><input style="width:100%"  type="text" name="Abilitato"  value="<?php echo $_SESSION['Abilitato'] ?>" /></td>
                <td><input style="width:100%"  type="text" name="DtAbilitato" value="<?php echo $_SESSION['DtAbilitato'] ?>" /></td>
                <td><input type="button" value="<?php echo $valueButtonCerca ?>" onClick="document.forms['VediParGlob'].submit();"/></td>
            </tr>
            <!--################## ORDINAMENTO ########################################-->
            <tr>              
                <td class="cella3" style="width:<?php echo $widId ?>" ><div id="OrdinaIdPar"><?php echo $filtroIdAllarme; ?>
                        <button name="Filtro" type="submit" value="a.id_allarme" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" style="width:<?php echo $widNom ?>"><div id="OrdinaNomeVar"><?php echo $filtroNome; ?>
                        <button name="Filtro" type="submit" value="nome" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" style="width:<?php echo $widDes ?>"><div id="Ordinadescri"><?php echo $filtroDescrizione; ?>
                        <button name="Filtro" type="submit" value="descrizione" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" style="width:<?php echo $widVal ?>"><div id="OrdinaVal"><?php echo $filtroValore; ?>
                        <button name="Filtro" type="submit" value="valore" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" style="width:<?php echo $widAb ?>"><div id="OrdinaIdCiclo"><?php echo $filtroIdCiclo; ?>
                        <button name="Filtro" type="submit" value="id_tabella_rif" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" style="width:<?php echo $widAb ?>"><div id="OrdinaAbilitato"><?php echo $filtroAbilitato; ?>
                        <button name="Filtro" type="submit" value="v.abilitato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                            <img src="/CloudFab/images/arrow3.png" /></button></div>
                </td>
                <td class="cella3" style="width:<?php echo $widDt ?>"><div id="OrdinaDtabil"><?php echo $filtroDt; ?>
                        <button name="Filtro" type="submit" value="v.dt_abilitato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
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
    $strFineVal = "";

    if (strlen($row['nome']) > 30) {
        $strFineNom = $filtroPuntini;
    }
    if (strlen($row['descrizione']) > 50) {
        $strFineDes = $filtroPuntini;
    }
    if (strlen($row['valore']) > 50) {
        $strFineVal = $filtroPuntini;
    }
    
    //Seleziono i processi collegati al ciclo produttivo di riferimento
    $arrayProcessi=array();
    $p=0;
    $sqlProcessi=findProcessiByIdCiloIdMacchina("id_processo",$row['id_tabella_rif'],$row['id_macchina']);
    while ($rowProc = mysql_fetch_array($sqlProcessi)) {
        $arrayProcessi[$p]=$rowProc['id_processo'];
       
        $p++;
    }
    
    if ($colore == 1) {
        ?>
                    <tr>
                        <td class="cella1" style="width:<?php echo $widId ?>"><?php echo($row['id_allarme']) ?></td>
                        <td class="cella1" style="width:<?php echo $widNom ?>" title="<?php echo $row['nome'] ?>"><?php echo $row['nome'] ?></td>
                        <td class="cella1" style="width:<?php echo $widDes ?>" title="<?php echo $row['descrizione'] ?>"><?php echo $row['descrizione'] ?></td>
                        <td class="cella1" style="width:<?php echo $widVal ?>" title="<?php echo $row['valore'] ?>"><?php echo $row['valore'] ?></td>
                        <td class="cella1" style="width:<?php echo $widAb ?>"><?php echo ($row['id_tabella_rif']) ?></td>
                        <td class="cella1" style="width:<?php echo $widAb ?>"><?php echo($row['abilitato']) ?></td>
                        <td class="cella1" style="width:<?php echo $widDt ?>"><?php echo($row['dt_abilitato']) ?></td>
                        <td class="cella1" style="width:<?php echo $widOp ?>">
                           <a href="../stabilimenti/gestione_processo.php?IdMacchina=<?php echo($row['id_macchina']) ?>&DescriStab=<?php echo $_SESSION['DescriStab'] ?>&Filtro=id_processo&IdCiclo=<?php echo $row['id_tabella_rif']?>">
                            <img src="/CloudFab/images/pittogrammi/lente-G.png" class="icone"  title="<?php echo $titleVediProc ?>"/></a>
                            </a>
                        </td>
                    </tr>
                    <?php
                    $colore = 2;
                } else {
                    ?>
                    <tr>
                       <td class="cella2" style="width:<?php echo $widId ?>"><?php echo ($row['id_allarme']) ?></td>
                        <td class="cella2" style="width:<?php echo $widNom ?>" title="<?php echo $row['nome'] ?>"><?php echo $row['nome'] ?></td>
                        <td class="cella2" style="width:<?php echo $widDes ?>" title="<?php echo $row['descrizione'] ?>"><?php echo $row['descrizione'] ?></td>
                        <td class="cella2" style="width:<?php echo $widVal ?>" title="<?php echo $row['valore'] ?>"><?php echo $row['valore'] ?></td>
                        <td class="cella2" style="width:<?php echo $widAb ?>"><?php echo($row['id_tabella_rif']) ?></td>
                        <td class="cella2" style="width:<?php echo $widAb ?>"><?php echo($row['abilitato']) ?></td>
                        <td class="cella2" style="width:<?php echo $widDt ?>"><?php echo($row['dt_abilitato']) ?></td>
                        <td class="cella2" style="width:<?php echo $widOp ?>">
                           <a href="../stabilimenti/gestione_processo.php?IdMacchina=<?php echo($row['id_macchina']) ?>&DescriStab=<?php echo $_SESSION['DescriStab'] ?>&Filtro=id_processo&IdCiclo=<?php echo $row['id_tabella_rif']?>">
                            <img src="/CloudFab/images/pittogrammi/lente-G.png" class="icone"  title="<?php echo $titleVediProc ?>"/></a>
                            </a>
                        </td>
                        </td>
                    </tr>
                    <?php
                    $colore = 1;
                }
                $i = $i + 1;
            }
            ?>
        </table>