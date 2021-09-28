<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <?php
    if ($DEBUG)
        ini_set(display_errors, "1");
    //############# STRINGHE UTENTI - AZIENDE VISIBILI##########################
    //Stringa contenente l'elenco degli id degli utenti e delle aziende prop visibili 
    //dall'utente loggato   
    $strUtentiAziendeNorm = getStrUtAzVisib($_SESSION['objPermessiVis'], 'lab_normativa');
    $strUtentiAziendeCar = getStrUtAzVisib($_SESSION['objPermessiVis'], 'lab_caratteristica');
    ?>
    <body>
        <div id="mainContainer">
            <script language="javascript">
                function Aggiorna() {
                    document.forms["AggiungiCar"].action = "aggiungi_caratteristica1.php";
                    document.forms["AggiungiCar"].submit();
                }
                function Salva() {
                    document.forms["AggiungiCar"].action = "aggiungi_caratteristica2.php";
                    document.forms["AggiungiCar"].submit();
                }
                function AllegaFile() {
                    document.forms["AggiungiCar"].action = "carica_lab_allegato.php";
                    document.forms["AggiungiCar"].submit();
                }
            </script>
            <?php
            include('../include/menu.php');
            include('../Connessioni/serverdb.php');
            include('sql/script_lab_caratteristica.php');
            include('sql/script_lab_normativa.php');



            //Al primo caricamento della pagina l'id dell'esperimento lo si recupera dall'url
            if (isset($_GET['IdEsperimento']))
                $IdEsperimento = $_GET['IdEsperimento'];
            else
            //Nei successivi caricamenti l'id dell'esperimento si prende dal form 
                $IdEsperimento = $_POST['IdEsperimento'];

            //########## Inizializzazione variabili ##########################
            $Normativa = $labelOptionSelectNormativa;
            $DescriNormativa = "";
            $IdCar = "";
            $NomeCar = $labelOptionSelectCar;
            $Dimensione = "";
            $TipoValore = "";
            $UnitaMisura = "";
            $UnitaMisuraDim = "";

            $sqlNorma = findAllNormativeVis($strUtentiAziendeNorm);

            if (isset($_POST['Normativa']) AND $_POST['Normativa'] != "") {

                list($Normativa, $DescriNormativa) = explode(";", $_POST['Normativa']);

                $sqlCar = findCarVisByNormativa($Normativa, $strUtentiAziendeCar);

                if (isset($_POST['Caratteristica']) AND $_POST['Caratteristica'] != "") {

                    list($IdCar, $NomeCar) = explode(";", $_POST['Caratteristica']);

                    //Verifico se la caratteristica che viene visualizzata appartiene 
                    //alla normativa scelta, nel caso in cui si fosse cambiata 
                    //la scelta della normativa e bisogna quindi riselezionare 
                    //anche la caratteristica
                    $azzeraCar = true;
                    while ($rowCarat = mysql_fetch_array($sqlCar)) {
                        if ($rowCarat['id_carat'] == $IdCar)
                            $azzeraCar = false;
                    }
                    if ($azzeraCar) {
                        $IdCar = "";
                        $NomeCar = $labelOptionSelectCar;
                        $Dimensione = "";
                        $TipoValore = "";
                        $UnitaMisura = "";
                        $UnitaMisuraDim = "";
                    }
                }
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
            <div id="container" style="width:80%;margin:15px auto;">
                <form class="form" id="AggiungiCar" name="AggiungiCar" method="POST" enctype="multipart/form-data">
                    <table width="100%">
                        <input type="hidden" name="IdEsperimento" id="IdEsperimento" value="<?php echo $IdEsperimento; ?>"/>
                        <input type="hidden" name="TipoValore" id="TipoValore" value = "<?php echo $TipoValore; ?>" />
                        <input type="hidden" name="Normativa" id="Normativa" value = "<?php echo $Normativa . ";" . $DescriNormativa; ?>" />
                        <tr>
                            <td class = "cella3" colspan = "2" ><?php echo $titoloPaginaLabDefinisciCar ?> </td>
                        </tr>
                        <tr>
                            <td class = "cella2" style = "width:150px" ><?php echo $filtroLabNorma ?> </td>

                            <td class = "cella1" >
                                <select style = "width:600px" name = "Normativa" id = "Normativa" onChange = "Aggiorna();" >
                                    <option value = "<?php echo $Normativa . ";" . $DescriNormativa ?>" selected = "<?php echo $Normativa . ";" . $DescriNormativa ?>" ><?php echo $Normativa . " " . $DescriNormativa ?> </option>
                                    <?php
                                    while ($rowNorma = mysql_fetch_array($sqlNorma)) {
                                        ?>
                                        <option value = "<?php echo $rowNorma['normativa'] . ";" . $rowNorma['descri'] ?>" ><?php echo $rowNorma['normativa'] . " - " . $rowNorma['descri'] ?> </option>
<?php } ?>
                                </select>
                            </td>
                        </tr>      
                        <tr>
                            <td class = "cella2" ><?php echo $filtroLabCaratteristica ?> </td>
                            <td class = "cella1" >
                                <select name = "Caratteristica" id = "Caratteristica" onChange = "Aggiorna();">
                                    <option value = "<?php echo $IdCar . ";" . $NomeCar ?>" selected = "<?php echo $IdCar . ";" . $NomeCar ?>" ><?php echo $NomeCar ?> </option>
                                    <?php
                                    mysql_data_seek($sqlCar, 0);
                                    while ($rowCarat = mysql_fetch_array($sqlCar)) {
                                        ?>
                                        <option value = "<?php echo $rowCarat['id_carat'] . ";" . $rowCarat['caratteristica'] ?>" ><?php echo $rowCarat['caratteristica'] ?> </option>
<?php } ?>
                                </select>
                            </td>       
                        </tr>
                        <tr>
                            <td class = "cella2" ><?php echo $filtroLabTipoValore ?> </td>
                            <td class = "cella1" ><?php echo $TipoValore ?> </td>
                        </tr>
                        <tr>
                            <td class = "cella2" ><?php echo $filtroLabValore . " " .$filtroLabOrdinata  ?> </td>
                            <td class = "cella1" ><textarea name = "ValoreCar" id = "ValoreCar" ROWS = "1" COLS = "30" ></textarea><?php echo " " . $UnitaMisura ?></td>
                        </tr>                        
<?php if ($Dimensione != "") { ?>
                            <tr>
                                <td class = "cella2" ><?php echo $Dimensione . " " . $filtroLabAscissa ?> </td>
                                <td class = "cella1" > <input type = "text" name = "ValDimensione" id = "ValDimensione" size = "30" value = "" /><?php echo " " . $UnitaMisuraDim ?></td>
                            </tr>
<?php } ?>
                        <tr>
                            <td class = "cella2" ><?php echo $filtroLabNote ?> </td>
                            <td class = "cella1" ><textarea name = "Note" id = "Note" ROWS = "2" COLS = "60" title = "<?php echo $titleNoteCar ?>"></textarea></td>
                        </tr>
                        <tr>
                            <td class = "cella3" colspan = "2" ><?php echo $filtroLabAllegaDoc ?> </td>
                        </tr>
                        <tr>
                            <td class = "cella2" ><?php echo $filtroLabAllegato ?> </td>
                            <td class = "cella1" ><input type = "file" name = "user_file" value = "" /></td>
                        </tr>
                        <tr>
                            <td class = "cella2" ><?php echo $filtroDescriFile ?> </td>
                            <td class = "cella1" ><textarea name = "Descri" id = "Descri" ROWS = "2" COLS = "60"></textarea></td >
                        </tr>
                        <tr>
                            <td class = "cella2" ><?php echo $filtroLabNote ?> </td>
                            <td class = "cella1" ><textarea name = "NoteFile" id = "NoteFile" ROWS = "2" COLS = "60"></textarea></td >
                        </tr>
                        <tr>
                            <td class = "cella2" style = "text-align: right " colspan = "2" >
                                <input type = "reset" value = "<?php echo $valueButtonIndietro ?>" onClick = "javascript:history.back();" />
                                <input type = "button" value = "<?php echo $valueButtonSalva ?>" onClick = "javascript:Salva();" /> </td>
                        </tr>
                    </table>
                </form>
            </div>
            <div id="msgLog">
                <?php
                if ($DEBUG) {
//                        echo "actionOnLoad :" . $actionOnLoad;
                    echo "</br>Tab lab_normativa : Nuova stringa unica utenti e aziende visibili : " . $strUtentiAziendeNorm;
                    echo "</br>Tab lab_caratteristica : Nuova stringa unica utenti e aziende visibili : " . $strUtentiAziendeCar;
                }
                ?>
            </div>
        </div>
    </body>
</html>
