<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <script language="javascript">
            function Aggiorna() {
                document.forms["AggiungiCarMt"].action = "aggiungi_caratteristica_mt.php";
                document.forms["AggiungiCarMt"].submit();
            }
            function Carica() {
                document.forms["AggiungiCarMt"].action = "aggiungi_caratteristica_mt2.php";
                document.forms["AggiungiCarMt"].submit();
            }
            function disabilitaScrittura() {
                //CASO: NESSUN PERMESSO DI SCRITTURA            
                document.getElementById('Salva').disabled = true;

            }
        </script>
        <?php
        include('../Connessioni/serverdb.php');
        include('./sql/script_lab_caratteristica_mt.php');
        include('sql/script_lab_materie_prime.php');

        if($DEBUG) ini_set(display_errors, 1);

        //############# STRINGHE AZIENDE VISIBILI  #################################
        //Stringa contenente l'elenco degli id delle aziende visibili dall'utente loggato
//        $strUtentiVis = getUtentiPropVisib($_SESSION['objPermessiVis'], 'lab_caratteristica_mt');
//        $strAziendeVis = getAziendeVisib($_SESSION['objPermessiVis'], 'lab_caratteristica_mt');
        $strUtentiAziendeLabCar = getStrUtAzVisib($_SESSION['objPermessiVis'], 'lab_caratteristica_mt');

        if (isset($_GET['IdMat']))
            $IdMateria = $_GET['IdMat'];
        else if (isset($_POST['IdMateria']))
            $IdMateria = $_POST['IdMateria'];

        $sqlCar = findAllCaratteristicheMtVis($strUtentiAziendeLabCar);

        //#################### GESTIONE UTENTTI ################################# 
        //Cerco l'utente proprietario della materia prima con allegato
        $sql = findMatPrimaById($IdMateria);
        while ($row = mysql_fetch_array($sql)) {

            $IdUtenteProp = $row['id_utente'];
            $IdAzienda = $row['id_azienda'];
        }
        //############# VERIFICA PERMESSO DI SCRITTURA E MODIFICA ##################
        $actionOnLoad="";
       $viewVerificaPermessi = 0;
        $arrayTabelleCoinvolte = array("lab_materie_prime");
        if ($IdUtenteProp != $_SESSION['id_utente']) {
            $viewVerificaPermessi = 1;
            //Se il proprietario del dato è un utente diverso dall'utente 
            //corrente si verifica il permesso 3
            if ($DEBUG) 
                echo "</br>Eseguita verifica permesso di tipo 3";
            $actionOnLoad = $actionOnLoad . verificaPermModifica3($_SESSION['objPermessiVis'], $arrayTabelleCoinvolte, $IdUtenteProp, $IdAzienda);
        }
    
        //######################################################################
        ?>
        <body onLoad="<?php echo $actionOnLoad ?>">
            <div id="mainContainer">
                <?php
                include('../include/menu.php');
                //################ Inizializzazione variabili ##########################
                $IdCar = "";
                $NomeCar = $labelOptionSelectCar;
                $Dimensione = "";
                $TipoValore = "";
                $UnitaMisura = "";
                $UnitaMisuraDim = "";


                if (isset($_POST['Caratteristica']) AND $_POST['Caratteristica'] != "") {
                    list($IdCar, $NomeCar) = explode(";", $_POST['Caratteristica']);

                    if ($IdCar > 0) {
                        $sqlCaratteristica = findCaratteristicaById($IdCar);
                        while ($rowCaratteristica = mysql_fetch_array($sqlCaratteristica)) {

                            $TipoValore = $rowCaratteristica['tipo_dato'];
                            $UnitaMisura = $rowCaratteristica['uni_mis_car'];
                            $Dimensione = $rowCaratteristica['dimensione'];
                            $UnitaMisuraDim = $rowCaratteristica['uni_mis_dim'];
                        }
                    }
                }
                ?>
                <div id="container" style="width:75%; margin:15px auto;">
                    <form class="form" id="AggiungiCarMt" name="AggiungiCarMt" method="POST"  enctype="multipart/form-data">
                        <table width="100%">
                            <input type="hidden" name="IdMateria" id="IdMateria" value="<?php echo $IdMateria; ?>"/>
                            <input type="hidden" name="TipoValore" id="TipoValore" value="<?php echo $TipoValore; ?>"/>
                            <tr>
                                <td class="cella3" colspan="2"><?php echo $titoloPaginaLabDefinisciCar ?></td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroLabCaratteristica ?></td>
                                <td class="cella1">
                                    <select name="Caratteristica" id="Caratteristica" onChange="Aggiorna();">
                                        <option value="<?php echo $IdCar . ";" . $NomeCar ?>" selected="<?php echo $IdCar . ";" . $NomeCar ?>"><?php echo $NomeCar ?></option>
                                        <?php
                                        mysql_data_seek($sqlCar, 0);
                                        while ($rowCar = mysql_fetch_array($sqlCar)) {
                                            ?>
                                            <option value="<?php echo $rowCar['id_carat'] . ";" . $rowCar['caratteristica'] ?>"><?php echo $rowCar['caratteristica'] ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>  
                                <td class="cella2"><?php echo $filtroLabTipoValore ?></td>
                                <td class="cella1"><?php echo $TipoValore ?></td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroLabValore . " " . $filtroLabOrdinata ?></td>
                                <td class="cella1"><textarea name="ValoreCar" id="ValoreCar" ROWS="1" COLS="30"></textarea><?php echo " " . $UnitaMisura ?></td>

                            </tr>                        
                            <?php if ($Dimensione != "") { ?>                        
                                <tr>        
                                    <td class="cella2"><?php echo $Dimensione . " " . $filtroLabAscissa ?></td>
                                    <td class="cella1"><input type="text" name="ValDimensione" id="ValDimensione" size ="30" value=""/><?php echo " " . $UnitaMisuraDim ?></td>
                                </tr>
                            <?php } ?>
                            <tr>  
                                <td class="cella2"><?php echo $filtroLabNote ?></td>
                                <td class="cella1"><textarea name="Note" id="Note" ROWS="2" COLS="60" title="<?php echo $titleNoteCar ?>"></textarea></td>
                            </tr>
                            <tr>
                                <td class="cella3" colspan="2"><?php echo $filtroLabAllegaDoc ?></td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroLabAllegato ?></td>
                                <td class="cella1" ><input type="file" name="user_file" value=""/></td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroDescriFile ?></td>
                                <td class="cella1" ><textarea name="Descri" id="Descri" ROWS="2" COLS="60"></textarea></td>
                            </tr>
                            <tr>  

                                <td class="cella2"><?php echo $filtroLabNote ?></td>
                                <td class="cella1"><textarea name="NoteFile" id="NoteFile" ROWS="2" COLS="60"></textarea></td>

                            </tr>
                            <tr>
                                <td class="cella2" style="text-align: right " colspan="2">
                                    <input type="reset" value="<?php echo $valueButtonIndietro ?>" onClick="javascript:history.back();"/>
                                    <input type="button" id="Salva" value="<?php echo $valueButtonSalva ?>" onClick="javascript:Carica();"/></td>
                            </tr>

                        </table>
                    </form>
                </div>
<div id="msgLog">
                        <?php
                        if ($DEBUG) {
                            if ($viewVerificaPermessi)
                            echo "</br>Eseguita verifica permesso di tipo 3"; 
                            echo "</br>ActionOnLoad : " . $actionOnLoad;                           
                            echo "</br>Id utente prop del dato: " . $IdUtenteProp;
                            echo "</br>Id azienda proprietaria del dato: " . $IdAzienda;
                            echo "</br>Tabella lab_materie_prime: utenti e aziende vis : ".$strUtentiAziendeLabCar;
                        }
                        ?>
                    </div>
            </div>


        </body>
</html>
