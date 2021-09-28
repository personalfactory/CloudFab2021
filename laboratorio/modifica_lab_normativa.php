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
    if ($DEBUG)
        ini_set(display_errors, "1");
    //###################### GESTIONE UTENTE ###################################
    //1)Si verifica se l'utente ha il permesso di modificare una caratteristica
    $actionOnLoad="";    
    $elencoFunzioni = array("119");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni,$_SESSION['objPermessiVis']);
    
    //############### STRINGHE AZIENDE SCRIVIBILI ##############################
    $arrayAziendeScrivibili = getAziendeScrivibili($_SESSION['objPermessiVis'], 'lab_normativa');
    //############### STRINGHE UTENTI-AZIENDE VISIBILI ############################
    $strUtentiAziendeCar = getStrUtAzVisib($_SESSION['objPermessiVis'], 'lab_caratteristica');

    include('../Connessioni/serverdb.php');
    include('./sql/script.php');
    include('./sql/script_lab_normativa.php');
    include('./sql/script_lab_caratteristica.php');

    $Normativa = $_GET['Normativa'];

    //QUERY AL DB
    begin();
    $sql = findNormativaById($Normativa);
    $sqlCar = findCarVisByNormativa($Normativa, $strUtentiAziendeCar);

    commit();

    while ($row = mysql_fetch_array($sql)) {

        $Descrizione = $row['descri'];
        $Data = $row['dt_abilitato'];
        $IdAzienda = $row['id_azienda'];
        $IdUtenteProp = $row['id_utente'];
    }
    $NomeAzienda = getNomeAziendaById($_SESSION['objUtility'], $IdAzienda);



    //######################################################################
    //#################### GESTIONE UTENTI #################################
    //######################################################################            
    //Si recupera il proprietario del parametro e si verifica se l'utente 
    //corrente ha il permesso di editare  i dati di quell'utente proprietario 
    //nelle tabella lab_parametro
    //Se non ha il permesso bisogna disabilitare i pulsanti di salvataggio...
    //############# VERIFICA PERMESSO DI SCRITTURA E MODIFICA ##############

    $arrayTabelleCoinvolte = array("lab_normativa");
    if ($IdUtenteProp != $_SESSION['id_utente']) {
        //Se il proprietario del dato è un utente diverso dall'utente 
        //corrente si verifica il permesso 3
        if ($DEBUG)
            echo "</br>Eseguita verifica permesso di tipo 3";
        $actionOnLoad = $actionOnLoad . verificaPermModifica3($_SESSION['objPermessiVis'], $arrayTabelleCoinvolte, $IdUtenteProp, $IdAzienda);
    }

    //######################################################################
    ?>
    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="labContainer">

            <?php include('../include/menu.php'); ?>
            <div id="container" style="width:70%; margin:15px auto;">
                <form id="ModificaLabNorma" name="ModificaLabNorma" method="post" action="modifica_lab_normativa2.php">
                    <table width="100%">
                        <input type="hidden" name="Normativa" id="Normativa" value="<?php echo $Normativa; ?>"></input>
                        <input type="hidden" name="PaginaProvenienza" id="PaginaProvenienza" value="<?php echo $PaginaProvenienza; ?>"></input>
                        <tr>
                            <td class="cella3" colspan="2"><?php echo $titoloPaginaLabModNormativa ?></td>
                        </tr>
                        <tr>
                            <td width="250px" class="cella2"><?php echo $filtroLabNorma ?></td>
                            <td class="cella1"><?php echo $Normativa; ?></td>
                        </tr>
                        <tr>
                            <td width="250px" class="cella2"><?php echo $filtroLabDescri ?></td>
                            <td class="cella1"><textarea name="Descrizione" id="Descrizione" ROWS="2" COLS="48" value="<?php echo $Descrizione; ?>"><?php echo $Descrizione; ?></textarea></td>
                        </tr>
                        <tr>
                            <td width="250px" class="cella2"><?php echo $filtroLabData ?></td>
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
                                            if ($idAz != $IdAzienda) {
                                                ?>
                                                <option value="<?php echo( $idAz . ';' . $nomeAz); ?>"><?php echo($nomeAz) ?></option>                                       
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select> 
                                </td>
                            </tr>
                        <table>   
                            <!--####################################################-->
                            <!--################ CARATTERISTICHE ###################-->
                            <!--####################################################-->
                            <table width="100%">
                                <tr>
                                    <td colspan="4" class="cella3" ><?php echo $filtroLabMetodologie ?></td>
                                </tr>
                                <tr>
                                    <td class="cella2"><?php echo $filtroLabMetodologia ?> </td>
                                    <td class="cella2"><?php echo $filtroLabCaratteristica ?> </td>
                                    <td class="cella2"colspan="2"><?php echo $filtroLabData ?></td>
                                 
                                </tr>
                                <?php
                                while ($rowCar = mysql_fetch_array($sqlCar)) {
                                    ?>
                                    <tr>
                                        <td class="cella1">
                                            <?php echo($rowCar['metodologia']); ?></td>
                                        <td class="cella1"><?php echo($rowCar['caratteristica']); ?></td>
                                                    <td class="cella1"><?php echo($rowCar['dt_abilitato']); ?></td>
                                                    <td class="cella1"><a name="119" href="modifica_lab_caratteristica.php?IdCaratteristica=<?php echo($rowCar['id_carat'])?>">
                    <img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone"  title="<?php echo $titleModifica . " ".$filtroLabCaratteristica ?>"/> </a> </td>                
                                    </tr>
                                                    <?php
                                                }
                                                ?> 
                                                <tr>
                                                    <td class="cella2" style="text-align: right " colspan="4">

                                                        <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"/>
                                                        <input type="submit" value="<?php echo $valueButtonSalva ?>" /></td>
                                                </tr>
                                                </table>    
                                                </form>
                                                </div>
                                                <div id="msgLog">
                                                    <?php
                                                    if ($DEBUG) {
                                                        echo "</br>ActionOnLoad : " . $actionOnLoad;
                                                        echo "</br>Id utente prop del dato: " . $IdUtenteProp;
                                                        echo "</br>Id azienda proprietaria del dato: " . $IdAzienda;
                                                        echo "</br>Tabella lab_caratteristica: utenti e aziende vis : " . $strUtentiAziendeCar;
                                                        echo "</br>Tabella lab_normativa: Aziende scrivibili: </br>";
                                                        for ($i = 0; $i < count($arrayAziendeScrivibili); $i++) {
                                                            echo $arrayAziendeScrivibili[$i]->getIdAzienda() . " " . $arrayAziendeScrivibili[$i]->getNomeAzienda() . "</br>";
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                                </div><!--mainContainer-->

                                                </body>
                                                </html>
