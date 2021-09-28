<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body onload="document.getElementById('CodLotto').focus()">
        <div id="tracciabilitaContainer">
            <script language="javascript">
            function VerificaMiscela() {
                document.forms["AssociaCodLottoCodChimica"].action = "tracciabilita_associa_lotto.php";
                document.forms["AssociaCodLottoCodChimica"].submit();
            }
            </script>            
            <?php
            include('../include/menu.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script_miscela.php');
            include('../sql/script_miscela_contenitore.php');
            include('../sql/script_produzione_miscela.php');
            include('../sql/script_accessorio_formula.php');
            include('../sql/script_formula.php');
            include('../sql/script_lotto.php');
            
            $errore = false;
            $messaggio = "";

            //##################################################################     
            //####################### SCELTA CONTENITORE ####################### 
            //################################################################## 

            if (!isset($_POST['Contenitore']) || $_POST['Contenitore'] == "") {

//Inizializzo le due variabili di sessione relative        

                $_SESSION['NumLottiTot'] = 0;
                $_SESSION['NumLottiSalvati'] = 0;

                $_SESSION['NumCodiciChimicaTot'] = 0;
                $_SESSION['NumCodiciChimicaInseriti'] = 0;

                $_SESSION['CodiciChimica'] = array();
                $_SESSION['CodiciLotto'] = array();

                $_SESSION['Contenitore'] = "0";
                $_SESSION['IdMiscela'] = 0;
                $_SESSION['DataMiscela'] = "0";
                $_SESSION['CodFormula'] = "0";
                $_SESSION['DescriFormula'] = "0";
                $_SESSION['CodFormulaDescri'] = "0";
                ?>        
                <div id="tracciabilitaContainer" style=" width:700px; margin:15px auto;">

                    <form class="form" id="AssociaCodLottoCodChimica" name="AssociaCodLottoCodChimica" method="post" >
                        <table width="700px">
                            <tr>
                                <td class="cella33" colspan="2"><?php echo $titoloPaginaAssLottoKit ?></td>
                            </tr>
                            <tr>
                                <td class="cella22"><?php echo $filtroContenitore ?></td>
                                <td class="cella111">
                                    <select  class="inputTracc" name="Contenitore" id="Contenitore" onchange="VerificaMiscela()" >
                                        <option  value="0" selected=""><?php echo $labelOptionSelectContenitore ?></option>
    <?php
    //Viene data la possibilità di scelta tra i contenitori impegnati
    $sqlContenitore = selectContenitoreByStato("0");
      while ($rowContenitore = mysql_fetch_array($sqlContenitore)) {
        ?>
                                            <option value="<?php echo($rowContenitore['cod_contenitore']) ?>" size="40"><?php echo("Contenitore " . $rowContenitore['cod_contenitore']) ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>

    <?php
} else if (isset($_POST['Contenitore']) AND $_POST['Contenitore'] != "") {
    //INIZIALIZZAZIONE VARIABILI
    $IdMiscela = 0;
    $DataMiscela = "0";
    $CodFormula = "0";
    $DescriFormula = "0";
    $CodFormulaDescri = "0";
    $NumLottiTot = 0;
    $NumCodiciChimicaTot = 0;
    $PesoLotto=0;

    $Contenitore = $_POST['Contenitore'];

    $sqlMiscela = selectProdMiscelaByContenitore($Contenitore);

    //##########################################################################
    //############ CONTROLLO ESISTENZA MISCELA #################################
    //##########################################################################

    if (mysql_num_rows($sqlMiscela) == 0) {
        //Se entro nell'if vuol dire che la miscela non esiste
        $errore = true;
        $messaggio = $messaggio . ' ' . $msgErrMiscelaNotAssCont . ' <br />';
    }

    //Recupero i dati della miscela 
    while ($rowMiscela = mysql_fetch_array($sqlMiscela)) {
        $IdMiscela = $rowMiscela['id_miscela'];
        $DataMiscela = $rowMiscela['dt_miscela'];
        $CodFormula = $rowMiscela['cod_formula'];
        $DescriFormula = $rowMiscela['descri_formula'];
        $CodFormulaDescri = $CodFormula . ":" . $DescriFormula;
    }
    
    
    //##########################################################################
    //############ RECUPERO IL PESO DI UN LOTTO ################################
    //##########################################################################
    //15-12-2014 prima il num di lotti e di kit veniva selezionato dalla tabella formula
//    $sqlPesoLotto=findAnFormulaByCodice($CodFormula);
    //09-07-2015 ora il numero di lotti e di kit viene selezionato dalla tabella miscela
    //ovviamente dopo che la miscela è stata sincronizzata dal tablet
    $sqlPesoLotto=  findMiscelaById($IdMiscela);
    
    //Controllo esistenza
    if (mysql_num_rows($sqlPesoLotto) == 0) {
        $errore = true;
        $messaggio = $messaggio . ' ' . $msgErrImpSelectNumKitTot . '<br />' . $msgErrImposSelectNumLotti . '<br />'. $msgErrSelectPesoLotto . ' <br />';
    }
    while ($rowPesoLot = mysql_fetch_array($sqlPesoLotto)) {
        $NumCodiciChimicaTot = $rowPesoLot['num_sac_in_lotto'];
        $PesoLotto = $rowPesoLot['qta_lotto'];  
        $NumLottiTot = $rowPesoLot['num_lotti'];        
    }

    if ($errore) {

        echo $messaggio;
    } else {

        $_SESSION['NumCodiciChimicaTot'] = $NumCodiciChimicaTot;
        for ($j = 0; $j < $_SESSION['NumCodiciChimicaTot']; $j++) {
            $_SESSION['CodiciChimica'][$j] = "";
        }

        $_SESSION['NumLottiTot'] = $NumLottiTot;
        for ($i = 0; $i < $_SESSION['NumLottiTot']; $i++) {
            $_SESSION['CodiciLotto'][$i] = "";
        }
        //######################################################################
        //############ RECUPERO NUM LOTTI GIA SALVATI ##########################
        //######################################################################
        $k = 0;
        $selectNumLottiSalvati = findLottiByIdMiscela($IdMiscela);
        while ($rowNumLottiSalvati = mysql_fetch_array($selectNumLottiSalvati)) {

            $_SESSION['CodiciLotto'][$k] = $rowNumLottiSalvati['cod_lotto'];
            $k++;
            $_SESSION['NumLottiSalvati'] = $_SESSION['NumLottiSalvati'] + 1;
        }

        $_SESSION['Contenitore'] = $Contenitore;
        $_SESSION['IdMiscela'] = $IdMiscela;
        $_SESSION['DataMiscela'] = $DataMiscela;
        $_SESSION['CodFormula'] = $CodFormula;
        $_SESSION['DescriFormula'] = $DescriFormula;
        $_SESSION['CodFormulaDescri'] = $CodFormulaDescri;
        $_SESSION['PesoLotto']=$PesoLotto;
        ?>

                    <script type="text/javascript">
                location.href = "tracciabilita_associa_lotto_chimica.php"
                    </script>

                    <?php
                }
            }
            ?>
        </div><!--mainConatainer-->
    </body>
</html>

