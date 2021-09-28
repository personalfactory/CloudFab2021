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
    include('../sql/script_componente.php');
    

    $Componente = $_GET['Componente'];

//Visualizzo il record che intendo modificare all'interno della form
    $sql = findComponenteById($Componente);
//            mysql_query("SELECT * FROM serverdb.componente WHERE id_comp=" . $Componente) or die("Query fallita: " . mysql_error());
    while ($row = mysql_fetch_array($sql)) {
        $CodiceComponente = $row['cod_componente'];
        $DescriComponente = $row['descri_componente'];
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
    $actionOnLoad = "";
    $viewVerificaPermessi = 0;
    $arrayTabelleCoinvolte = array("componente");
    if ($IdUtenteProp != $_SESSION['id_utente']) {
        $viewVerificaPermessi = 1;
        //Se il proprietario del dato è un utente diverso dall'utente 
        //corrente si verifica il permesso 3
        $actionOnLoad = verificaPermModifica3($_SESSION['objPermessiVis'], $arrayTabelleCoinvolte, $IdUtenteProp, $IdAzienda);
    }


    //############# STRINGHE AZIENDE SCRIVIBILI ################################
    //Stringa contenente l'elenco degli id delle aziende visibili dall'utente loggato    
    $arrayAziendeScrivibili = getAziendeScrivibili($_SESSION['objPermessiVis'], 'componente');


    //##########################################################################
    ?>
    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer">
<?php include('../include/menu.php'); ?>
            <div id="container" style="width:600px; margin:15px auto;">
                <form id="ModificaComponente" name="ModificaComponente" method="post" action="modifica_componente2.php">
                    <table style="width:600px;">
                        <input type="hidden" name="Componente" id="Componente" value="<?php echo $Componente; ?>"></input>
                        <input type="hidden" name="DescrizioneOld" id="DescrizioneOld" value="<?php echo $DescriComponente; ?>"></input>
                        <th class="cella3" colspan="2"><?php echo $titoloPaginaModificaComponente?></th>

                        <tr><!-- E' possibile visualizzare il codice ma non modificarlo-->
                            <td class="cella2"><?php echo $filtroCodice ?></td>
                            <td class="cella1"><?php echo $CodiceComponente; ?></td>
                                <input type="hidden" name="CodiceComponente" id="CodiceComponente" value="<?php echo $CodiceComponente; ?>"></input>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroDescrizione ?></td>
                            <td class="cella1"><input type="text" size="50" name="DescriComponente" id="DescriComponente" value="<?php echo $DescriComponente; ?>"></input></td>
                        </tr>
                        <!--                       Momentaneamente l'azienda del componente non è modificabile
                        <tr>
                                                        <td class="cella4"><?php echo $filtroAzienda ?></td>
                                                        <td class="cella1">
                                                            <select name="Azienda" id="Azienda"> 
                                                                <option value="<?php echo $IdAzienda . ';' . $NomeAzienda; ?>" selected=""><?php echo $NomeAzienda; ?></option>
                        <?php
                        //TODO : selezionare solo le aziende che l'utente ha il permesso di editare
                        while ($rowAz = mysql_fetch_array($sqlAz)) {
                            ?>
                                                                    <option value="<?php echo($rowAz['id_azienda'] . ';' . $rowAz['nome']); ?>"><?php echo($rowAz['nome']) ?></option>
<?php } ?>                    </select> 
                                                        </td>
                                                    </tr>
                                                <tr>-->
                        <td class="cella2"><?php echo $filtroAbilitato ?></td>
                        <td class="cella1"><?php echo $Abilitato; ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroDtAbilitato ?></td>
                            <td class="cella1"><?php echo $Data; ?></td>
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
    echo "</br>Tabella componente: Aziende scrivibili: </br>";

    for ($i = 0; $i < count($arrayAziendeScrivibili); $i++) {

        echo $arrayAziendeScrivibili[$i]->getIdAzienda() . " " . $arrayAziendeScrivibili[$i]->getNomeAzienda() . "</br>";
    }
}
?>
                </div>
        </div><!--mainContainer-->

    </body>
</html>

