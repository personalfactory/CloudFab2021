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
       if($DEBUG) ini_set(display_errors, "1"); 
       //############### STRINGHE AZIENDE SCRIVIBILI ##############################
    $arrayAziendeScrivibili = getAziendeScrivibili($_SESSION['objPermessiVis'], 'lab_parametro');
       
            include('../Connessioni/serverdb.php');
            include('sql/script_lab_parametro.php');

            $IdParametro = $_GET['IdParametro'];

//Visualizzo il record che intendo modificare all'interno della form
            $sql = findParametroById($IdParametro);
            while ($row = mysql_fetch_array($sql)) {
                $NomeParametro = $row['nome_parametro'];
                $Descrizione = $row['descri_parametro'];
                $UnitaMisura = $row['unita_misura'];
                $Tipo = $row['tipo'];
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
        $actionOnLoad="";
        $arrayTabelleCoinvolte = array("lab_parametro");
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

            <?php
            include('../include/menu.php'); ?>
            <div id="container" style="width:50%; margin:15px auto;">
                <form id="ModificaParametro" name="ModificaParametro" method="post" action="modifica_lab_parametro2.php">
                    <table style="width:100%;">
                        <input type="hidden" name="IdParametro" id="IdParametro" value="<?php echo $IdParametro; ?>"/>
                        <th class="cella3" colspan="2"><?php echo $titoloPaginaLabModificaParametro ?></th>

                        <tr>
                            <td class="cella2"><?php echo $filtroLabNome ?></td>
                            <td class="cella1"><input type="text" name="NomeParametro" id="NomeParametro" size="49" value="<?php echo $NomeParametro; ?>"></input></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroLabDescri ?></td>
                            <td class="cella1"><textarea name="Descrizione" id="Descrizione" ROWS="2" COLS="48" value="<?php echo $Descrizione; ?>"><?php echo $Descrizione; ?></textarea></td>
                        </tr>
                        <tr>
                            <td  class="cella2"><?php echo $filtroLabUnMisura ?></td>
                            <td class="cella1"><input type="text" name="UnitaMisura" id="UnitaMisura" value="<?php echo $UnitaMisura; ?>"></input></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroLabTipo ?></td>
                            <td class="cella1">
                                <select name="Tipo" id="Tipo">
                                    <optgroup>
                                        <?php if ($Tipo == 'PercentualeSI') { ?>
                                            <option  value="<?php echo $Tipo; ?>" selected="selected"><?php echo $filtroLabPercSi ?></option>
                                            <option value="PercentualeNO"><?php echo $filtroLabPercNo ?></option>
                                        <?php } if ($Tipo == 'PercentualeNO') { ?>
                                            <option  value="<?php echo $Tipo; ?>" selected="selected"><?php echo $filtroLabPercNo ?></option>
                                            <option value="PercentualeSI"><?php echo $filtroLabPercSi ?></option>
                                        <?php } ?>
                                    </optgroup>
                                </select>
                            </td>
                        </tr>        
                        <tr>
                            <td class="cella2"><?php echo $filtroLabData ?></td>
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
                        <?php include('../include/tr_reset_submit.php'); ?>
                    </table>
                </form>
            </div>
<div id="msgLog">
                        <?php
                        if ($DEBUG) {
                           
                           
                           
                            echo "</br>Tabella lab_parametro: Aziende scrivibili: </br>";

                            for ($i = 0; $i < count($arrayAziendeScrivibili); $i++) {

                                echo $arrayAziendeScrivibili[$i]->getIdAzienda() . " " . $arrayAziendeScrivibili[$i]->getNomeAzienda() . "</br>";
                            }
                            
                        }
                        ?>
                    </div>
        </div><!--mainContainer-->

    </body>
</html>
