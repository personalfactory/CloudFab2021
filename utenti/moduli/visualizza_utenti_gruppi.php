<table class="table3">
    <tr>
        <th colspan="8"><?php echo $titoloPaginaGestioneGruppiUtenti ?></th>
    </tr>
    <tr>
        <td  colspan="7" style="text-align:center;"> 
            <p><a href="carica_utente_gruppo.php"><?php echo $nuovoGruppoUtenti ?></a></p>
            <p>&nbsp;</p>
        </td>
    </tr>
    <tr>
        <th class="cella3"><?php echo $filtroId ?></th>
        <th class="cella3"><?php echo $filtroGruppoUtente ?></th>
        <th class="cella3"><?php echo $filtroTipoGruppoUtente ?></th>
        <th class="cella3"><?php echo $filtroDescrizione ?></th>            
        <th class="cella3"><?php echo $filtroAbilitato ?></th>
        <th class="cella3"><?php echo $filtroDtAbilitato ?></th>
        <th class="cella3"><?php echo $filtroOperazioni ?></th>
    </tr>
    <?php
  
    $colore = 1;
    while ($row = mysql_fetch_array($sql)) {
        if ($colore == 1) {
            ?>
            <tr>
                <td class="cella1"><?php echo($row['id_gruppo_utente']) ?></td>
                <td class="cella1"><?php echo($row['nome_gruppo_utente']) ?></td>
                <td class="cella1"><?php echo($row['tipo_gruppo_utente']) ?></td>
                <td class="cella1"><?php echo($row['descri_gruppo_utente']) ?></td>
                <td class="cella1"><?php echo($row['abilitato']) ?></td>
                <td class="cella1"><?php echo($row['dt_abilitato']) ?></td>
                <td class="cella1"style="width:90px">
                    <a href="cancella_utente_gruppo.php?IdGruppoUtente=<?php echo($row['id_gruppo_utente']) ?>"><img src="/CloudFab/images/pittogrammi/patumiera_R.png" class="icone" alt="Elimina" title="Clicca per cancellare "/></a> 
                    <a href="modifica_utente_gruppo.php?IdGruppoUtente=<?php echo($row['id_gruppo_utente']) ?>"><img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" alt="Modifica"title="Clicca per modificare la lingua"/></a>
                </td>
            </tr>
            <?php
            $colore = 2;
        } else {
            ?>
            <tr>
                <td class="cella2"><?php echo($row['id_gruppo_utente']) ?></td>
                <td class="cella2"><?php echo($row['nome_gruppo_utente']) ?></td>
                <td class="cella2"><?php echo($row['tipo_gruppo_utente']) ?></td>
                <td class="cella2"><?php echo($row['descri_gruppo_utente']) ?></td>
                <td class="cella2"><?php echo($row['abilitato']) ?></td>
                <td class="cella2"><?php echo ($row['dt_abilitato']) ?></td>
                <td class="cella2"style="width:90px">
                    <a href="cancella_utente_gruppo.php?IdGruppoUtente=<?php echo($row['id_gruppo_utente']) ?>"><img src="/CloudFab/images/pittogrammi/patumiera_R.png" class="icone" alt="Elimina" title="Clicca per cancellare "/></a> 
                    <a href="modifica_utente_gruppo.php?IdGruppoUtente=<?php echo($row['id_gruppo_utente']) ?>"><img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" alt="Modifica"title="Clicca per modificare la lingua"/></a>
                </td>
            </tr>
            <?php
            $colore = 1;
        }
      
    }
    ?>
</table>