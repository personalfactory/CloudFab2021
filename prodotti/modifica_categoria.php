<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <script language="javascript">
        function Carica() {
            document.forms["ModificaCategoria"].action = "modifica_categoria2.php";
            document.forms["ModificaCategoria"].submit();
        }

        function NuovaSoluzione() {
            document.forms["ModificaCategoria"].action = "aggiungi_soluzione_sacchetto.php";
            document.forms["ModificaCategoria"].submit();
        }
        function disabilitaOperazioni() {

            document.getElementById('NuovaSol').disabled = true;
            document.getElementById('Salva').disabled = true;
            for (i = 0; i < document.getElementsByName('ModificaSoluzione').length; i++) {
            document.getElementsByName('ModificaSoluzione')[i].style.display = "none";
        }
        
        }
    </script>
    <?php
   
    if($DEBUG) ini_set("display_errors", "1");
    //############# STRINGHE AZIENDE SCRIVIBILI  ###############################
    //Stringa contenente l'elenco degli id delle aziende visibili dall'utente loggato    
    $arrayAziendeScrivibili = getAziendeScrivibili($_SESSION['objPermessiVis'], 'categoria');

    include('../Connessioni/serverdb.php');
    include('../sql/script_categoria.php');
//Se l'id_categoria proviene dalla pagina di gestione delle categorie 
    if (!isset($_POST['IdCategoria']) && isset($_GET['IdCategoria'])) {

    $IdCategoria = $_GET['IdCategoria'];

    //Visualizzo le informazioni della categoria che intendo modificare all'interno della form
    $sql = findCategoriaByID($IdCategoria);
    while ($row = mysql_fetch_array($sql)) {
    $NomeCategoria = $row['nome_categoria'];
    $DescriCategoria = $row['descri_categoria'];
    $Abilitato = $row['abilitato'];
    $Data = $row['dt_abilitato'];
    $IdAzienda = $row['id_azienda'];
    $IdUtenteProp = $row['id_utente'];
    }
    $NomeAzienda = getNomeAziendaById($_SESSION['objUtility'], $IdAzienda);

    //Conto il numero di soluzioni sacchetto già 
    //previste per questa categoria nella tab num_sacchetto
    $sqlSolSac = countNumSacchetti($IdCategoria);
    while ($rowSolSac = mysql_fetch_array($sqlSolSac)) {
    $SoluzioniTot = $rowSolSac['sol_sacchetti'];
    }

    //######################################################################
    //#################### GESTIONE UTENTI #################################
    //######################################################################            
    //Si recupera il proprietario della categoria e si verifica se l'utente 
    //corrente ha il permesso di editare  i dati di quell'utente proprietario 
    //nella tabella categoria
    //Se non ha il permesso bisogna disabilitare i pulsanti di salvataggio...
    //############# VERIFICA PERMESSO DI SCRITTURA E MODIFICA ##############
    $actionOnLoad = "";
    $arrayTabelleCoinvolte = array("categoria");
    if ($IdUtenteProp != $_SESSION['id_utente']) {
    //Se il proprietario del dato è un utente diverso dall'utente 
    //corrente si verifica il permesso 3
    if ($DEBUG)
    echo "</br>Eseguita verifica permesso di tipo 3";
    $actionOnLoad = verificaPermModifica3($_SESSION['objPermessiVis'], $arrayTabelleCoinvolte, $IdUtenteProp, $IdAzienda);
    }

    //######################################################################
    ?>
    <body onLoad="<?php echo $actionOnLoad ?>"> 
        
        
        <div id="mainContainer">
            <?php include('../include/menu.php'); ?>
            <div id="container" style="width:60%; margin:15px auto;">
                <form id="ModificaCategoria" name="ModificaCategoria" method="post" >
                    <table style="width:100%;">
                        <input type="hidden" name="IdCategoria" id="IdCategoria" value="<?php echo $IdCategoria; ?>"></input>
                        <tr>
                            <th colspan="2" class="cella3"><?php echo $titoloModCateg ?></th>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroNome ?></td>
                            <td class="cella1"><input style="width:80%" type="text" name="NomeCategoria" id="NomeCategoria" value="<?php echo $NomeCategoria; ?>"></input></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroDescrizione ?></td>
                            <td class="cella1">
                                <textarea name="DescriCategoria" id="DescriCategoria" ROWS="4" COLS="50" value="<?php echo $DescriCategoria; ?>"><?php echo $DescriCategoria; ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td class="cella4"><?php echo $filtroAzienda ?></td>
                            <td class="cella1">
                                <select name="Azienda" id="Azienda"> 
                                    <option value="<?php echo $IdAzienda . ';' . $NomeAzienda; ?>" selected=""><?php echo $NomeAzienda; ?></option>
                                    <?php
                                    //Si selezionano solo le aziende scrivibili dall'utente
                                    for ($a = 0;
                                    $a < count($arrayAziendeScrivibili);
                                    $a++) {
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
                        <tr>
                            <td class="cella2"><?php echo $filtroDt ?></td>
                            <input type="hidden" name="Data" id="Data" value="<?php echo $Data; ?>"/>
                            <td class="cella1"><?php echo $Data; ?></td>
                        </tr>
                        <tr>
                            <td class="cella2" ><?php echo $filtroSolNumSacchetti ?> </td>
                            <td class="cella1"><?php echo $SoluzioniTot; ?>
                                <input type="hidden"  name="SoluzioniTot" id="SoluzioniTot" value="<?php echo $SoluzioniTot; ?>"/>
                            </td>
                        </tr>
                        <?php
                        $NSac = 1;
                        $sqlSac = findNumSacByIdCat($IdCategoria);
                        while ($rowSac = mysql_fetch_array($sqlSac)) {
                        ?>
                        <tr>
                            <td class="cella2"><?php echo $filtroNumSacchettiPerSol . ' ' . $NSac; ?></td>
                            <td>
                                <table width="100%">
                                    <td class="cella1"><?php echo ($rowSac['num_sacchetti']); ?></td>
                                    <td class="cella1" style="text-align:right"><a name="ModificaSoluzione" href="../stabilimenti/manage_val_par_sacco.php?IdCategoria=<?php echo $IdCategoria?>&NumSacchetti=<?php echo $rowSac['num_sacchetti']?> "> <?php echo $titleDettaglio ?></a></td>
                                        <input type="hidden" name="Soluzione<?php echo $NSac; ?>" id="Soluzione<?php echo $NSac; ?>" value="<?php echo ($rowSac['num_sacchetti']); ?>"></input>
                                </table>
                            </td>
                        </tr>
                        <?php
                        $NSac++;
                        }
                        ?>
                        <tr>
                            <td class="cella2" style="text-align: right " colspan="2">
                                <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"/>
                                <input type="button" id="NuovaSol" onclick="javascript:NuovaSoluzione();" value="<?php echo $valueButtonNewSolution ?>" />
                                <input type="button" id="Salva" onclick="javascript:Carica();" value="<?php echo $valueButtonSalva ?>" />
                            </td>
                        </tr>   
                    </table> 
                    </table>
                </form>
            </div>
            <?php
            } 
          
                ?>

            <div id="msgLog">
                <?php
                if ($DEBUG) {

                echo "</br>ActionOnLoad : ".$actionOnLoad;
                echo "</br>Id utente prop del dato: " . $IdUtenteProp;
                echo "</br>Id azienda proprietaria del dato: " . $IdAzienda;
                echo "</br>##################################</br>Tabella categoria:Aziende scrivibili: ";

                for ($i = 0;
                $i < count($arrayAziendeScrivibili);
                $i++) {

                echo $arrayAziendeScrivibili[$i]->getIdAzienda() . " " . $arrayAziendeScrivibili[$i]->getNomeAzienda() . "</br>";
                }
                }
                ?>
            </div>




        </div><!--mainContainer-->

    </body>
</html>
