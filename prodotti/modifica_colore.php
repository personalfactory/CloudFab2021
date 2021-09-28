<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
   
         <script language="javascript">
        function disabilitaOperazioni() {
            document.getElementById('Salva').disabled = true;
        }
    
    </script>

    <?php
  
    if ($DEBUG) ini_set('display_errors', 1);
    
    include('../Connessioni/serverdb.php');
    include('../sql/script_colore.php');

    $IdColore = $_GET['Colore'];

//Visualizzazione del record che si intende modificare all'interno della form
    $sql = findColoreId($IdColore);
    while ($row = mysql_fetch_array($sql)) {
        $CodiceColore = $row['cod_colore'];
        $NomeColore = $row['nome_colore'];
        $Abilitato = $row['abilitato'];
        $Data = $row['dt_abilitato'];
        $IdUtenteProp = $row['id_utente'];
        $IdAzienda = $row['id_azienda'];
    }
    $NomeAzienda = getNomeAziendaById($_SESSION['objUtility'], $IdAzienda);
    //######################################################################
    //#################### GESTIONE UTENTI #################################
    //######################################################################            
    //Si recupera il proprietario del dato e si verifica se l'utente 
    //corrente ha il permesso di editare i dati di quell'utente proprietario 
    //nelle tabelle coinvolte
    //Se non ha il permesso bisogna disabilitare i pulsanti di salvataggio...
    //############# VERIFICA PERMESSO DI SCRITTURA E MODIFICA ##############
    $actionOnLoad = "";
    $viewVerificaPermessi = 0;
    $arrayTabelleCoinvolte = array("colore");
    if ($IdUtenteProp != $_SESSION['id_utente']) {
        $viewVerificaPermessi = 1;
        //Se il proprietario del dato è un utente diverso dall'utente 
        //corrente si verifica il permesso 3
        $actionOnLoad = verificaPermModifica3($_SESSION['objPermessiVis'], $arrayTabelleCoinvolte, $IdUtenteProp, $IdAzienda);
    }

    //############# STRINGHE AZIENDE SCRIVIBILI ################################
    //Stringa contenente l'elenco degli id delle aziende visibili dall'utente loggato    
    $arrayAziendeScrivibili = getAziendeScrivibili($_SESSION['objPermessiVis'], 'colore');
    //##########################################################################
    ?>
    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer">
            <?php include('../include/menu.php'); ?>
            <div id="container" style="width:500px; margin:15px auto;">
                <form id="ModificaColore" name="ModificaColore" method="post" action="modifica_colore2.php">
                    <table style="width:100%;">
                        <input type="hidden" name="IdColore" id="IdColore" value=<?php echo $IdColore; ?>></input>
                        <th class="cella3" colspan="2"><?php echo $titoloModColor ?></th>
                        <tr>
                            <td class="cella2"><?php echo $filtroCodice ?></td>
                            <td class="cella1"><input type="text" name="CodiceColore" id="CodiceColore" value=<?php echo '"' . $CodiceColore . '"'; ?>></input></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroNome ?> </td>
                            <td class="cella1"><input type="text" name="NomeColore" id="NomeColore" value=<?php echo '"' . $NomeColore . '"'; ?>></input></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroAbilitato ?></td>
                            <td class="cella1"><?php echo $Abilitato; ?>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroDt ?></td>
                            <td class="cella1"><?php echo $Data; ?></td>
                        </tr>
                         <tr>
                            <td class="cella4"><?php echo $filtroAzienda ?></td>
                            <td class="cella1">
                                <select name="Azienda" id="Azienda"> 
                                    <option value="<?php echo $IdAzienda . ';' . $NomeAzienda; ?>" selected=""><?php echo $NomeAzienda; ?></option>
                                    <?php
                                    //Si selezionano solo le aziende scrivibili dall'utente
                                    for ($a = 0; $a < count($arrayAziendeScrivibili); $a++) {
                                        $idAz = $arrayAziendeScrivibili[$a]->getIdAzienda();
                                        $nomeAz = $arrayAziendeScrivibili[$a]->getNomeAzienda();
                                        if ($idAz <> $IdAzienda) {
                                            ?>
                                            <option value="<?php echo( $idAz . ';' . $nomeAz); ?>"><?php echo($nomeAz) ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select> 
                            </td>
                        </tr>
                        <?php include('../include/tr_reset_submit.php'); ?>
                    </table>
                </form>
            </div>
<div id="msgLog">
<?php
if ($DEBUG) {
    if ($viewVerificaPermessi)
        echo "</br>Eseguita verifica permesso di tipo 3</br>";
    echo "</br>ActionOnLoad : " . $actionOnLoad;
    echo "</br>Id utente prop del dato: " . $IdUtenteProp;
    echo "</br>Id azienda proprietaria del dato: " . $IdAzienda;
    echo "</br>Tabella colore:Aziende scrivibili: </br>";

    for ($i = 0; $i < count($arrayAziendeScrivibili); $i++) {

        echo $arrayAziendeScrivibili[$i]->getIdAzienda() . " " . $arrayAziendeScrivibili[$i]->getNomeAzienda() . "</br>";
    }
}
?>
                </div>
        </div><!--mainContainer-->

    </body>
</html>
