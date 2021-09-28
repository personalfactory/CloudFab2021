<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>  
   
    <?php
  
    include('../Connessioni/serverdb.php');
    include('../sql/script_mazzetta.php');
    
    $IdMazzetta = $_GET['IdMazzetta'];
    $NomeMazzetta = $_GET['NomeMazzetta'];

    
    
//Visualizzo il record che intendo modificare all'interno della form
//Estraggo i dati  da modificare 
    $sqlMazzettaCol = innerJoinMazzettaColore($IdMazzetta);
    while ($rowMazzettaCol = mysql_fetch_array($sqlMazzettaCol)) {

        $IdMazzetta = $rowMazzettaCol['id_mazzetta'];
        $CodiceMazzetta = $rowMazzettaCol['cod_mazzetta'];
        $NomeMazzetta = $rowMazzettaCol['nome_mazzetta'];
        $IdColore = $rowMazzettaCol['id_colore'];
        $CodiceColore = $rowMazzettaCol['cod_colore'];
        $NomeColore = $rowMazzettaCol['nome_colore'];
        $DataAbilitato = $rowMazzettaCol['dt_abilitato'];
        $IdAzienda = $rowMazzettaCol['id_azienda'];
        $IdUtenteProp = $rowMazzettaCol['id_utente'];
        
    }
    
    //######################################################################
    //#################### GESTIONE UTENTI #################################
    //######################################################################            
    //Si recupera il proprietario del dato e si verifica se l'utente 
    //corrente ha il permesso di editare  i dati di quell'utente proprietario 
    //nelle tabelle coinvolte
    //Se non ha il permesso bisogna disabilitare i pulsanti di salvataggio...
    //############# VERIFICA PERMESSO DI SCRITTURA E MODIFICA ##############
    $actionOnLoad = "";
    $viewVerificaPermessi = 0;
    $arrayTabelleCoinvolte = array("mazzetta");
   if ($IdUtenteProp != $_SESSION['id_utente']) {
        $viewVerificaPermessi = 1;
        //Se il proprietario del dato è un utente diverso dall'utente 
        //corrente si verifica il permesso 3
        $actionOnLoad = verificaPermModifica3($_SESSION['objPermessiVis'], $arrayTabelleCoinvolte, $IdUtenteProp, $IdAzienda);
    }
    ?>
<script language="javascript">
        
        function SalvaMazzetta() {
            document.forms["AssociaMazzettaCol"].action = "modifica_mazzetta_colorata2.php";
            document.forms["AssociaMazzettaCol"].submit();
        }
        function AssociaNuovoColore() {
            document.forms["AssociaMazzettaCol"].action = "associa_mazzetta_colore.php?IdMazzetta=<?php echo $IdMazzetta ?>&NomeMazzetta=<?php echo $NomeMazzetta ?>";
            document.forms["AssociaMazzettaCol"].submit();
        }
        function disabilitaOperazioni() {

            document.getElementById('DefinisciColore').disabled = true;
            document.getElementById('ModificaMazzettaCol').disabled = true;
        }

    </script>
    <body onLoad="<?php  echo $actionOnLoad ?>">
    <body>
        <div id="mainContainer">
            <?php include('../include/menu.php'); ?>
            <div id="container" style=" width:700px; margin:15px auto;">
                <form class="form" id="AssociaMazzettaCol" name="AssociaMazzettaCol" method="post" >
                    <table width="100%">
                        <tr>
                            <td class="cella3" colspan="2"><?php echo $filtroColoriMazzetta ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroMazzetta ?> </td>
                            <td class="cella1"><?php echo $NomeMazzetta; ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"> <?php echo $filtroCodice ?> </td>
                            <input type="hidden" name="IdMazzetta" id="IdMazzetta" value="<?php echo $IdMazzetta; ?>"/>
                            <td class="cella1"><?php echo $CodiceMazzetta; ?></td>
                        </tr>
                        <tr>
                            <td class="cella3" ><?php echo $filtroColori ?> </td>
                            <td class="cella3" ><?php echo $filtroComposizione ?> </td>
                        </tr>
                        <tr>
                            <?php
//Inizio visualizzazione dell'elenco dei colori associati alla mazzetta in modifica
                            $NCol = 1; //Contatore dei Colori
                            $NColBase = 1; //Contatore dei colori base

                            $sqlColore = innerJoinColoreMazzettaColorata($IdMazzetta);
                            
                            while ($rowColore = mysql_fetch_array($sqlColore)) {
                                ?>
                                <tr>
                                    <td class="cella2" width="20%"><?php echo($rowColore['nome_colore']); ?></td>
                                    <input type="hidden" name="IdColore<?php echo($NCol); ?>" id="IdColore<?php echo($NCol); ?>" value="<?php echo($rowColore['id_colore']); ?>"/>
                                    <?php
                                    //Inizio visualizzazione dell'elenco dei colori base presenti nella tabella mazzetta_colorata
                                    $sqlColoreBase = innerJoinColoreBaseMazzettaColorata($IdMazzetta, $rowColore['id_colore']);
                                   
                                    ?>
                                    <td >
                                        <table width="100%">
                                            <?php
                                            while ($rowColoreBase = mysql_fetch_array($sqlColoreBase)) {
                                                ?>
                                                <tr>
                                                    <td class="cella1" width="30%"><?php echo($rowColoreBase['nome_colore_base']); ?></td>
                                                    <td class="cella1" width="30%"><input type="text" name="Qta<?php echo $NColBase; ?>" id="Qta<?php echo $NColBase; ?>" value="<?php echo($rowColoreBase['quantita']); ?>"/><?php echo $filtrogBreve ?></td>
                                                    <td class="cella1" width="30%"><?php echo ($rowColoreBase['dt_abilitato']) ?></td>

                                                    <?php
                                                    $NColBase++;
                                                }//fine while colori base
                                                ?> 
                                            </tr>
                                        </table> 
                                    </td>
                                </tr>
                                <?php
                                $NCol++;
                            }//fine while colori
                            ?>
                            <tr>
                                <td class="cella2" style="text-align: right " colspan="2">
                                    <input type="reset"  onClick="javascript:history.back();" value="<?php echo $valueButtonAnnulla ?>"/>
                                    <input type="button" id="DefinisciColore" onClick="javascript:AssociaNuovoColore();" value="<?php echo $valueButtonNewColor ?>"/>
                                    <input type="button" id="ModificaMazzettaCol" onClick="javascript:SalvaMazzetta();" value="<?php echo $valueButtonSalva ?>"/>
                                </td>
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
                }
                ?>
            </div>

        </div><!--mainContainer-->

    </body>
</html>
