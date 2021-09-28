<?php
$wid1 = "5%";
$wid2 = "15%";
$wid3 = "5%";
$wid4 = "10%";
$wid5 = "10%";
$wid6 = "15%";
$wid7 = "5%";
$wid8 = "13%";
$wid9 = "5%";
$wid10 = "7%";
$wid11 = "8%";
?>
<form  name="VediUtenti" id="VediUtenti" method="POST">
<table class="table3">
    <tr>
        <th colspan="12"><?php echo $titoloPaginaGestioneUtenti ?></th>
    </tr>
    <tr>
        <td  colspan="12" style="text-align:center;"> 
            <p><a href="carica_utente.php"><?php echo $nuovoUtente ?></a></p>
            <p>&nbsp;</p>
        </td>
    </tr>
     <tr>
            <td ><input type="text" style="width:100%" name="IdUtenteTab" value="<?php echo $_SESSION['IdUtenteTab'] ?>" /></td>
            <td ><input type="text" style="width:100%" name="Gruppo" value="<?php echo $_SESSION['Gruppo'] ?>" /></td>
            <td ><input type="text" style="width:100%" name="Tipo"  value="<?php echo $_SESSION['Tipo'] ?>" /></td>
            <td ><input type="text" style="width:100%" name="Cognome"   value="<?php echo $_SESSION['Cognome'] ?>" /></td>
            <td ><input type="text" style="width:100%" name="Nome"  value="<?php echo $_SESSION['Nome'] ?>" /></td>
            <td ><input type="text" style="width:100%" name="Username"  value="<?php echo $_SESSION['Username'] ?>" /></td>
            <td ><input type="text" style="width:100%" name="Accessi"  value="<?php echo $_SESSION['Accessi'] ?>" /></td>
            <td ><input type="text" style="width:100%" name="UltimoAccesso"  value="<?php echo $_SESSION['UltimoAccesso'] ?>" /></td>
            <td ><input type="text" style="width:100%" name="Abilitato"  value="<?php echo $_SESSION['Abilitato'] ?>" /></td>
            <td ><input type="text" style="width:100%" name="DtAbilitato"  value="<?php echo $_SESSION['DtAbilitato'] ?>" /></td>
            <td ><img src="/CloudFab/images/icone/lente_piccola.png" onClick="document.forms['VediUtenti'].submit();" title="<?php echo $titleRicerca ?>"/></td>
        </tr>
    <tr>       
            <td class="cella3" width="<?php echo $wid1 ?>" ><div id="OrdinaId"><?php echo $filtroId; ?>
                    <button name="Filtro" type="submit" value="id_utente" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid2 ?>" ><div id="OrdinaGruppo"><?php echo $filtroGruppoUtente; ?>
                    <button name="Filtro" type="submit" value="nome_gruppo_utente" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid3 ?>" ><div id="OrdinaGruppo"><?php echo $filtroTipoGruppoUtente; ?>
                    <button name="Filtro" type="submit" value="tipo_gruppo_utente" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid4 ?>" ><div id="OrdinaCognome"><?php echo $filtroCognome; ?>
                    <button name="Filtro" type="submit" value="cognome" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid5 ?>" ><div id="OrdinaNome"><?php echo $filtroNome; ?>
                    <button name="Filtro" type="submit" value="nome" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid6 ?>" ><div id="OrdinaUser"><?php echo $filtroUserName; ?>
                    <button name="Filtro" type="submit" value="username" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid7 ?>" ><div id="OrdinaAccessi"><?php echo $filtroNumAccessi; ?>
                    <button name="Filtro" type="submit" value="num_accesso" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
             <td class="cella3" width="<?php echo $wid8 ?>" ><div id="OrdinaDtLasAcc"><?php echo $filtroDtLastAccess; ?>
                    <button name="Filtro" type="submit" value="dt_ultimo_accesso" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid9 ?>" ><div id="OrdinaAbil"><?php echo $filtroAbilitato; ?>
                    <button name="Filtro" type="submit" value="abilitato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
            <td class="cella3" width="<?php echo $wid10 ?>" ><div id="OrdinaDtAbil"><?php echo $filtroDtAbilitato; ?>
                    <button name="Filtro" type="submit" value="dt_abilitato" class="button3"  title="<?php echo $titleOrdinaCresc; ?>">
                        <img src="/CloudFab/images/arrow3.png" /></button></div>
            </td>
       
       
        <th class="cella3" width="<?php echo $wid11 ?>"><?php echo $filtroOperazioni ?></th>
    </tr>
    <?php
    
    $colore = 1;
    while ($row = mysql_fetch_array($sql)) {
        if ($colore == 1) {
            ?>
            <tr>
                <td class="cella1"><?php echo($row['id_utente']) ?></td>
                <td class="cella1"><?php echo($row['nome_gruppo_utente']) ?></td>
                <td class="cella1"><?php echo($row['tipo_gruppo_utente']) ?></td>
                <td class="cella1"><?php echo($row['cognome']) ?></td>
                <td class="cella1"><?php echo($row['nome']) ?></td>
                <td class="cella1"><?php echo($row['username']) ?></td>
                <td class="cella1"><?php echo($row['num_accesso']) ?></td>
                <td class="cella1"><?php echo($row['dt_ultimo_accesso']) ?></td>
                <td class="cella1"><?php echo($row['abilitato']) ?></td>
                <td class="cella1"><?php echo($row['dt_abilitato']) ?></td>
                
                <td class="cella1"style="width:90px">
                    <a href="cancella_utente.php?Utente=<?php echo($row['id_utente']) ?>"><img src="/CloudFab/images/pittogrammi/patumiera_R.png" class="icone" title="<?php echo $titleElimina ?>"/></a> 
                    <a href="modifica_utente.php?Utente=<?php echo($row['id_utente']) ?>"><img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" title="<?php echo $titleModifica ?>"/></a>
                </td>
            </tr>
            <?php
            $colore = 2;
        } else {
            ?>
            <tr>
                <td class="cella2"><?php echo($row['id_utente']) ?></td>
                <td class="cella2"><?php echo($row['nome_gruppo_utente']) ?></td>
                <td class="cella2"><?php echo($row['tipo_gruppo_utente']) ?></td>
                <td class="cella2"><?php echo($row['cognome']) ?></td>
                <td class="cella2"><?php echo($row['nome']) ?></td>
                <td class="cella2"><?php echo($row['username']) ?></td>
                <td class="cella2"><?php echo($row['num_accesso']) ?></td>
                <td class="cella2"><?php echo($row['dt_ultimo_accesso']) ?></td>
                <td class="cella2"><?php echo($row['abilitato']) ?></td>
                <td class="cella2"><?php echo($row['dt_abilitato']) ?></td>
                
                <td class="cella2"style="width:90px">
                    <a href="cancella_utente.php?Utente=<?php echo($row['id_utente']) ?>"><img src="/CloudFab/images/pittogrammi/patumiera_R.png" class="icone"  title="<?php echo $titleElimina ?>"/></a> 
                    <a href="modifica_utente.php?Utente=<?php echo($row['id_utente']) ?>"><img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" title="<?php echo $titleModifica ?>"/></a>
                </td>
            </tr>
            <?php
            $colore = 1;
        }
      
    }
    ?>
</table>
</form>