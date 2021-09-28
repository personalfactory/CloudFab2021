<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <script language="javascript">
        function redirectAvvisoPermessoNegato() {
            location.href = '../permessi/avviso_permessi_visualizzazione.php'
        }
    </script>
    <?php
    //############ STRINGA UTENTI E AZIENDE VIS ########################
    $strUtentiAziendeLabMt = getStrUtAzVisib($_SESSION['objPermessiVis'], 'lab_materie_prime');

    if ($DEBUG)
        ini_set(display_errors, 1);
    include('../Connessioni/serverdb.php');
    include('../sql/script_componente.php');
    include('../include/precisione.php');
    //##########################################################################
    $tipo2 = "";
    $tipo3 = "";

    switch ($_GET['tipo2']) {
        case 1:
            $tipo2 = $valTipo2RawMaterial;
            $tipo3 = $valTipo3Drymix;
            $titoloPagina=$titoloPaginaCaricaComp;
            $labelSelect=$labelOptionSelectCompDrymix;
            break;

        case 2:
            $tipo2 = $valTipo2Pigment;
            $tipo3 = $valTipo3Drymix;            
            $titoloPagina=$linkNuovoColore;
            $labelSelect=$selctOptionSelectPigmento;
            break;
        
        case 3:
            $tipo2 = $valTipo2Additivo;
            $tipo3 = $valTipo3Drymix;            
            $titoloPagina=$linkNuovoAdditivo;
            $labelSelect=$selectOptionSelectAdditivo;
            break;

        default:
            break;
    }

    $sqlComp = findLabMatPrimeNotInComponente($prefissoCodComp, "descri_materia", $strUtentiAziendeLabMt, $tipo2, $tipo3);
    ?>
    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer">

            <?php include('../include/menu.php'); ?>

            <div id="container" style="width:50%; margin:15px auto;">
                <form id="InserisciComponente" name="InserisciComponente" method="post" action="carica_componente2.php">
                    <table width="100%">
                        <tr>
                            <td class="cella3" ><?php echo $titoloPagina ?></td>
                        </tr>
                        <tr>
                            <td class="cella1center" style="width:200px">
                                <select name="Componente" id="Componente" style="width:80%">
                                    <option value="" selected="" ><?php echo $labelSelect ?></option>
                                    <?php
                                    while ($rowComp = mysql_fetch_array($sqlComp)) {
                                        ?>
                                        <option value="<?php echo $rowComp['cod_mat'] . ";" . $rowComp['descri_materia'] ?>"><?php echo $rowComp['cod_mat'] . "  - " . $rowComp['descri_materia'] ?></option>
                                    <?php } ?>
                                </select></td>
                        </tr> 
                        <input type='hidden' id=''
                               <tr>
                                <td class="cella2" style="text-align: right " >
                                    <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"/>
                                    <input type="submit" value="<?php echo $valueButtonAggiungi ?>"/></td>
                            </tr>
                    </table>
                </form>
            </div>
            <div id="msgLog">
                <?php
                if ($DEBUG) {
                    echo "</br>Tabella lab_materie_prime: utenti e aziende visibili " . $strUtentiAziendeLabMt;
                }
                ?>
            </div>
        </div><!--mainContainer-->

    </body>
</html>
