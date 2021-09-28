<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <?php

    if($DEBUG) ini_set("display_errors","1");
    //NOTA BENE 
    //Tutti i post definiti per ora non vengono utilizzati
    include('../Connessioni/serverdb.php');
    include('../sql/script_chimica.php');
    $erroreCodChimica = false;
    $messaggioChimica = "";

//##############################################################################     
//################ VARIABILI DI SESSIONE #######################################
//##############################################################################

    $Contenitore = $_SESSION['Contenitore'];
    $DataMiscela = $_SESSION['DataMiscela'];
    $IdMiscela = $_SESSION['IdMiscela'];
    $CodFormula = $_SESSION['CodFormula'];
    $DescriFormula = $_SESSION['DescriFormula'];
    $CodFormulaDescri = $_SESSION['CodFormulaDescri'];
    $CodProdotto = substr($CodFormula, 1, 5);

//##############################################################################     
//################ CONTROLLO CODICI CHIMICA ####################################
//##############################################################################

    for ($i = 0; $i < $_SESSION['NumCodiciChimicaTot']; $i++) {

        if (isset($_POST['CodiceChimica' . $i]) AND $_POST['CodiceChimica' . $i] != "") {

            $CodiceChimica = str_replace("'", "''", $_POST['CodiceChimica' . $i]);
//##############################################################################   
//######### CONTROLLO CORRISPONDENZA CODICE CHIMICA E COD PRODOTTO #############
//##############################################################################
            $PrefissoCodChimica = substr($CodiceChimica, 1, 5);

            if ($PrefissoCodChimica != $CodProdotto AND $CodiceChimica != "") {
                $erroreCodChimica = true;
                $messaggioChimica = $messaggioChimica . " " . $msgErrCodChimica . ' <br />' .
                        $filtroCodice . " " . $filtroProdotto . ': ' . $CodProdotto . '<br />' .
                        $filtroPrefCodKit . ': ' . $PrefissoCodChimica . '<br />';
            }
//CONTROLLO PRIMO CARATTERE
            if (substr($CodiceChimica, 0, 1) != "K") {
                $erroreCodChimica = true;
                $messaggioChimica = $messaggioChimica . ' ' . $msgErrCodKitPrimaLettera . '  ' . substr($CodiceChimica, 0, 1) . '<br />';
            }
//CONTROLLO LUNGHEZZA CODICE
            if (strlen($CodiceChimica) != 17) {

                $erroreCodChimica = true;
                $messaggioChimica = $messaggioChimica . ' ' . $msgErrLunghCodiceKit . ' ' . strlen($CodiceChimica) . '<br />';
            }

//##############################################################################   
//######### VERIFICA ESISTENZA CODICE NELLA TABELLA CHIMICA DI SERVERDB ########
//##############################################################################
            
            $sqlCodChimica =findChimicaByCodice($_POST['CodiceChimica' . $i]);

            if (mysql_num_rows($sqlCodChimica) > 0) {
                $erroreCodChimica = true;
                $messaggioChimica = $messaggioChimica . ' ' . $msgErrCodPresenteInServerdb . ' <br />';
            }

//##############################################################################
//##### VERIFICA INSERIMENTO DI DUE CODICI UGUALI ##############################
//##############################################################################      

            for ($j = 0; $j < $_SESSION['NumCodiciChimicaInseriti']; $j++) {

                if ($CodiceChimica == $_SESSION['CodiciChimica'][$j] AND $i != $j) {
//         echo $j."</br>";
//         echo "SESSIONE : ".$CodiceChimica."</br>";
//         echo "CODICE INSERITO :".$_SESSION['CodiciChimica'][$j]."</br>";
                    $erroreCodChimica = true;
                    $messaggioChimica = $messaggioChimica . ' ' . $msgErrCodiciUguali . ' <br />';
                }
            }

            if (!$erroreCodChimica) {
                //SALVO IL CODICE CHIMICA NELL'ARRAY DI SESSIONE
                $_SESSION['CodiciChimica'][$i] = $CodiceChimica;
            }
        }
    }
    if ($erroreCodChimica == false AND $_SESSION['CodiciChimica'][$_SESSION['NumCodiciChimicaInseriti']] != "") {

        $_SESSION['NumCodiciChimicaInseriti'] = $_SESSION['NumCodiciChimicaInseriti'] + 1;
    }
    ?>
    <body onLoad="focusBox();">
        <div id="tracciabilitaContainer">
<?php include('../include/menu.php'); ?>

            <script language="javascript">
        //        function Salva(){
        //          document.forms["AssociaCodLottoCodChimica"].action = "tracciabilita_associa_lotto_chimica2.php";
        //          document.forms["AssociaCodLottoCodChimica"].submit();
        //        }
        function verificaCodice(campo, evento)
        {
            codice_tasto = evento.keyCode ? evento.keyCode : evento.which ? evento.which : evento.charCode;
            if (codice_tasto == 13)
            {
                document.forms["AssociaCodLottoCodChimica"].action = "tracciabilita_associa_lotto_chimica1.php";
                document.AssociaCodLottoCodChimica.submit();
                return false;
            }
            else
            {
                return true;
            }
        }
        function focusBox()
        {
            var box = document.getElementById('CodiceChimica<?php echo $_SESSION["NumCodiciChimicaInseriti"]; ?>');
            box.focus();
        }

            </script>

<?php
if ($erroreCodChimica == true) {
    echo "<div id=msg>" . $msgErrBreveCodKit . " </br>" . $messaggioChimica = $messaggioChimica . "</div>";
}
?>



            <div id="tracciabilitaContainer" style=" width:700px; margin:15px auto;">

                <form class="form" id="AssociaCodLottoCodChimica" name="AssociaCodLottoCodChimica" method="post" >
                    <table width="700px">
                        <tr>
                            <td class="cella33" colspan="2"><?php echo $titoloPaginaInserCodKit ?></td>
                        </tr>

<?php
for ($i = 0; $i < $_SESSION['NumCodiciChimicaTot']; $i++) {
    if (isset($_POST['CodiceChimica' . $i]) AND $_POST['CodiceChimica' . $i] != "") {
        ?>
                                <tr>
                                    <td class="cella22"><?php echo $filtroCodKit . " " . ($i + 1); ?> </td>
                                    <td class="cella111"><input class="inputTracc" onkeypress="verificaCodice(this, event);" type="text" name="CodiceChimica<?php echo $i; ?>" id="CodiceChimica<?php echo $i; ?>" size="40" value="<?php echo $_SESSION['CodiciChimica'][$i]; ?>"/></td>

                                </tr>

    <?php } else { ?>
                                <tr>
                                    <td class="cella22"><?php echo $filtroCodKit . " " . ($i + 1); ?> </td>
                                    <td class="cella111"><input class="inputTracc" onkeypress="verificaCodice(this, event);" type="text" name="CodiceChimica<?php echo $i; ?>" id="CodiceChimica<?php echo $i; ?>" size="40" /></td>
                                </tr>

    <?php }
}
?>

                        <tr>
                            <td class="cella22"><?php echo $filtroCodLotto ?> </td>
                            <td  class="cella22"><?php echo $_SESSION['CodiciLotto'][$_SESSION['NumLottiSalvati']]; ?></td>
                            <input type="hidden" name="CodLotto" id="CodLotto" size="40" value="<?php echo $_SESSION['CodiciLotto'][$_SESSION['NumLottiSalvati']]; ?>"/>
                        </tr>
                        <tr>
                            <td class="cella22"><?php echo $filtroKitDaInser ?></td>
                            <td  class="cella22"><?php echo $_SESSION['NumCodiciChimicaTot'] - $_SESSION['NumCodiciChimicaInseriti']; ?></td>
                            <input type="hidden" name="NumCodiciChimica" id="NumCodiciChimica" size="20" value="<?php echo $_SESSION['NumCodiciChimicaTot'] - $_SESSION['NumCodiciChimicaInseriti']; ?>"/>
                        </tr> 
                        <tr>
                            <td class="cella22"><?php echo $filtroLottiDaInser ?></td>
                            <td  class="cella22"><?php echo $_SESSION['NumLottiTot'] - $_SESSION['NumLottiSalvati']; ?></td>
                            <input type="hidden" name="NumLotti" id="NumLotti" size="40" value="<?php echo $_SESSION['NumLottiTot'] - $_SESSION['NumLottiSalvati']; ?>"/>
                        </tr>
                        <tr>
                            <td class="cella22"><?php echo $filtroContenitore ?></td>
                            <td class="cella22"><?php echo $Contenitore; ?></td>
                            <input type="hidden" name="Contenitore" id="Contenitore" value="<?php echo $Contenitore; ?>"/>
                        </tr>
                        <tr>
                            <td class="cella22"><?php echo $filtroDt . " " . $filtroMiscela ?></td>
                            <td class="cella22"><?php echo $DataMiscela; ?></td>
                            <input type="hidden" name="DataMiscela" id="DataMiscela" value="<?php echo $DataMiscela; ?>"/>
                            <input type="hidden" name="IdMiscela" id="IdMiscela" value="<?php echo $IdMiscela; ?>"/>
                        </tr>
                        <tr>
                            <td class="cella22"><?php echo $filtroMiscela ?></td>
                            <td class="cella22"><?php echo $CodFormulaDescri; ?></td>
                            <input type="hidden" name="CodFormulaDescri" id="CodFormulaDescri" value="<?php echo $CodFormulaDescri; ?>"/>
                        </tr>
                        <?php
                        if ($_SESSION['NumCodiciChimicaInseriti'] == $_SESSION['NumCodiciChimicaTot']) {
                            ?>
                <!--   <tr>
                              <td class="cella2" style="text-align: right" colspan="2">
                                    <input type="button" onclick="javascript:Aggiorna();" value="Aggiorna" />
                                <input type="reset" value="INDIETRO" onClick="javascript:history.back();"/>
                                <input type="button" onclick="javascript:Salva();" value="SALVA" />
                              </td>
                            </tr>  -->
                            <script type="text/javascript">
            location.href = "tracciabilita_associa_lotto_chimica2.php"
                            </script>
<?php }
?>


                    </table>
                </form>
            </div>     
<?php
echo "</br> NumLottiTot : " . $_SESSION['NumLottiTot'];
echo "</br> NumLottiSalvati : " . $_SESSION['NumLottiSalvati'];

echo "</br> NumCodiciChimicaTot : " . $_SESSION['NumCodiciChimicaTot'];
echo "</br> NumCodiciChimicaInseriti : " . $_SESSION['NumCodiciChimicaInseriti'];
echo "</br> #####################################################</br>";
echo "</br> CodiciChimica : " . print_r($_SESSION['CodiciChimica']);
echo "</br> #####################################################</br>";
echo "</br> CodiciLotto : " . print_r($_SESSION['CodiciLotto']);
?>
        </div><!--mainConatainer-->
    </body>
</html>
