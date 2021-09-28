<?php
    $wid1 = "10%";
    $wid2 = "15%";
    $wid3 = "20%";
    $wid4 = "15%";
    $wid5 = "10%";
    $wid6 = "15%";
    $wid7 = "5%";    
    ?>

<table class="table3">
    <tr>
        <th colspan="7"><?php echo $titoloPaginaGestionePersone ?></th>
    </tr>
       		<tr>
        	<td  colspan="9" style="text-align:center;"> 
            	<p><a name="105" href="carica_persona.php?HrefBack=gestione_persona.php"><?php echo $nuovaPersona ?></a></p>
       	    	<p>&nbsp;</p>
            </td>
        </tr>
    <!--################## MOTORE DI RICERCA ###################################-->
</table>
<form  name="VediPersona" id="VediPersona" action="" method="POST">
    <table class="table3">
        <tr>
            <td><input type="text" style="width:100%" name="IdPersona"  value="<?php echo $_SESSION['IdPersona'] ?>" /></td>
            <td><input type="text" style="width:100%" name="Nominativo" value="<?php echo $_SESSION['Nominativo'] ?>" /></td>
            <td><input type="text" style="width:100%" name="Descrizione" value="<?php echo $_SESSION['Descrizione'] ?>" /></td>
            <td><input type="text" style="width:100%" name="Tipo" value="<?php echo $_SESSION['Tipo'] ?>" /></td>
            <td><input type="text" style="width:100%" name="DtAbilitato" value="<?php echo $_SESSION['DtAbilitato'] ?>" /></td>
        </tr>
        <!--################## RICERCA CON LIST BOX ###############################-->
        <tr>
            <td><select style="width:100%" name="IdPersonaList" id="IdPersonaList" onChange="document.forms['VediPersona'].submit();">
                    <option value="<?php echo $_SESSION['IdPersonaList'] ?>" selected="<?php echo $_SESSION['FamigliaList'] ?>"></option>
                    <?php
                    while ($row = mysql_fetch_array($sqlId)) {
                        ?>
                        <option value="<?php echo $rowr['id_persona']; ?>"><?php echo $row['id_persona']; ?></option>
                    <?php } ?>
                </select></td>
            <td><select  style="width:100%"  name="NominativoList" id="CodFormulaList" onChange="document.forms['NominativoList'].submit();">
                    <option value="<?php echo $_SESSION['NominativoList'] ?>" selected="<?php echo $_SESSION['NominativoList'] ?>"></option>
                    <?php
                    while ($row = mysql_fetch_array($sqlNom)) {
                        ?>
                        <option value="<?php echo $row['nominativo']; ?>"><?php echo $row['nominativo']; ?></option>
                    <?php } ?>
                </select></td> 
            <td><select  style="width:100%"  name="DescrizioneList" id="DescrizioneList" onChange="document.forms['VediPersona'].submit();">
                    <option value="<?php echo $_SESSION['DescrizioneList'] ?>" selected="<?php echo $_SESSION['DescrizioneList'] ?>"></option>
                    <?php
                    while ($row = mysql_fetch_array($sqlDes)) {
                        ?>
                        <option value="<?php echo $row['descrizione']; ?>"><?php echo $row['descrizione']; ?></option>
                    <?php } ?>
                </select></td> 
            <td><select  style="width:100%" name="TipoList" id="TipoList" onChange="document.forms['VediPersona'].submit();">
                    <option value="<?php echo $_SESSION['TipoList'] ?>" selected="<?php echo $_SESSION['TipoList'] ?>"></option>
                    <?php
                    while ($row = mysql_fetch_array($sqlTipo)) {
                        ?>
                        <option value="<?php echo $row['tipo']; ?>"><?php echo $row['tipo']; ?></option>
                    <?php } ?>
                </select></td>
                           
            <td><select style="width:100%" name="DtAbilitatoList" id="DtAbilitatoList" onChange="document.forms['VediFormula'].submit();">
                    <option value="<?php echo $_SESSION['DtAbilitatoList'] ?>" selected="<?php echo $_SESSION['DtAbilitatoList'] ?>"></option>
                    <?php
                    while ($rowData = mysql_fetch_array($sqlDt)) {
                        ?>
                        <option value="<?php echo $rowData['dt_abilitato']; ?>"><?php echo $rowData['dt_abilitato']; ?></option>
                    <?php } ?>
                </select></td>          

            <td><input type="button" value="<?php echo $valueButtonCerca ?>" onClick="document.forms['VediFormula'].submit();" style="width: 90px"/></td>
        </tr>

        <!--################## ORDINAMENTO ########################################-->
        <tr>             

            <td class="cella3" width="<?php echo $wid1 ?>"><div id="Ordina1"><?php echo $filtroId; ?>
                    <button name="Filtro" type="submit" value="id_persona" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid2 ?>"><div id="Ordina2"><?php echo $filtroNominativo; ?>
                    <button name="Filtro" type="submit" value="nominativo" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid3 ?>"><div id="Ordina3"><?php echo $filtroDescrizione; ?>
                    <button name="Filtro" type="submit" value="descrizione" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid4 ?>"><div id="Ordina4"><?php echo $filtroTipo; ?>
                    <button name="Filtro" type="submit" value="tipo" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
           
            <td class="cella3" width="<?php echo $wid5 ?>"><div id="Ordina7"><?php echo $filtroDt; ?>
                    <button name="Filtro" type="submit" value="dt_abilitato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid8 ?>"><?php echo $filtroOperazioni; ?></td>

        </tr>
        <?php
        echo "<br/>" . $msgRecordTrovati . $trovati . "<br/>";
        echo "<br/>" . $msgSelectCriteriRicerca . "<br/>";
        //Distinguiamo fra le formule in produzione o meno visualizzandole in colori differenti
        $nomeClasse = "dataRigGray";
        
        while ($row = mysql_fetch_array($sql)) {
            ?>
            <tr>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid1 ?>" ><?php echo $row['id_persona'] ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid2 ?>" ><?php echo $row['nominativo']?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid3 ?>" ><?php echo $row['descrizione'] ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid4 ?>" ><?php echo $row['tipo'] ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid6 ?>" ><?php echo $row['dt_abilitato'] ?></td>
                <td class="<?php echo $nomeClasse; ?>" width="<?php echo $wid7 ?>">    
                    <a name="105" href="cancella_persona.php?IdPersona=<?php echo($row['id_persona']) ?>"><img src="/CloudFab/images/pittogrammi/patumiera_R.png" class="icone" title="<?php echo $titleElimina ?>"/></a>
                    <a name="105" href="modifica_persona.php?IdPersona=<?php echo($row['id_persona']) ?>"><img src="/CloudFab/images/pittogrammi/penna_G.png" class="icone" title="<?php echo $titleModifica ?>"/></a>
                </td>

                </td>
            </tr>
            <?php
        }
        ?>
    </table>
