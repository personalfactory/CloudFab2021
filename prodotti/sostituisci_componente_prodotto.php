<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <div id="mainContainer">
        <body>
            <?php
//TO DO : Valutare se inserire il controllo sul permesso dell'utente
            include('../include/menu.php');
            include('../include/precisione.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script_componente.php');


            $IdCompOld = $_GET['IdComponente'];
            $IdProdotto = $_GET['IdProdotto'];


            $sqlDescriComp = findComponenteById($IdCompOld);
            while ($rowDescriComp = mysql_fetch_array($sqlDescriComp)) {

                $DescriCompOld = $rowDescriComp['descri_componente'];
            }
            
            $tipo2 = "";
            $linkRefBack = "";
            $titoloPagina = "";
            $filtroMat = "";
            $labelOptionSelect = "";
            if (isSet($_GET['TipoMateriale']) AND $_GET['TipoMateriale'] != "") {
                $tipoMateriale = $_GET['TipoMateriale'];
                
                switch ($tipoMateriale) {

                    case 1:
                        //Se si sta sostituendo un componente ad un prodotto
                        $tipo2 = $valTipo2RawMaterial; //RAW MATERIAL
                        $linkRefBack = "modifica_prodotto.php?Prodotto=";
                        $titoloPagina = $titoloPaginaSostituisciComp;
                        $filtroMat = $filtroMateriaPrima;
                        $labelOptionSelect = $labelOptionSelectMatPri;
                        break;


                    case 2:
                        //Se si sta sostituendo un pigmento ad una ricetta colore
                        $tipo2 = $valTipo2Pigment; //PIGMENT
                        $linkRefBack = "modifica_colore_new.php?Prodotto=";
                        $titoloPagina = $titoloPaginaSostituisciPigmento;
                        $filtroMat = $filtroPigmento;
                        $labelOptionSelect = $labelOptionSelectPigmento;
                        break;
                    
                    
                     case 3:
                        //Se si sta sostituendo un additivo ad unaricetta additivo
                        $tipo2 = $valTipo2Additivo; //PIGMENT
                        $linkRefBack = "modifica_additivo.php?Prodotto=";
                        $titoloPagina = $titoloPaginaSostituisciAdditivo;
                        $filtroMat = $filtroAdditivo;
                        $labelOptionSelect = $labelOptionSelectAdditivo;
                        break;
                    
                    default:
                        break;
                }
            }
            
            $strUtentiAziendeVisComp = getStrUtAzVisib($_SESSION['objPermessiVis'], 'componente');


            $sqlComp = selectComponentiByTipoVis($strUtentiAziendeVisComp, "descri_componente", $tipo2);
            
            
            
//############ STRINGA UTENTI E AZIENDE VISIBILI #############################
            
            ?>
            <div id="container" style="width:70%; margin:50px auto;">

                <form class="form" id="SostituisciComponente" name="SostituisciComponente" method="post" action="sostituisci_componente_prodotto2.php">
                    <table width="100%">
                        <input type="hidden" name="IdProdotto" id="IdProdotto" value="<?php echo $IdProdotto; ?>"></input>
                        <input type="hidden" name="IdCompOld" id="IdCompOld" value="<?php echo $IdCompOld; ?>"></input>
                         <input type="hidden" name="RefBack" id="RefBack" value="<?php echo $linkRefBack; ?>"></input>
                        <tr>
                            <td class="cella3" colspan="2"><?php echo $titoloPagina . " " . $DescriCompOld; ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroDescrizione ?></td>
                            <td class="cella1">
                                <select name="Componente" id="Componente">
                                    <option value="" selected=""><?php echo $labelOptionSelect ?></option>
                                    <?php
                                    //Visualizzo solo i componenti che attualmente non sono associati alla formula

                                   
                                    while ($rowComp = mysql_fetch_array($sqlComp)) {
                                        ?>
                                        <option value="<?php echo($rowComp['id_comp']) ?>"><?php echo($rowComp['descri_componente']) ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroQuantita . " " . $filtrogBreve ?></td>  
                            <td class="cella1"><input type="text" name="Quantita" id="Quantita" value=""/></td>
                        </tr>  

<?php include('../include/tr_reset_submit.php'); ?>
                    </table>
                </form>
            </div>
            <div id="msgLog">
<?php
if ($DEBUG) {
    echo "</br>Tabella componente : Utenti e aziende visibili : " . $strUtentiAziendeVisComp;
}
?>
            </div>
    </div>
</body>
</html>
