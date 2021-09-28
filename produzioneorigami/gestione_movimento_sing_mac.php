<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    
    <?php
    
    //##########################################################################            
    //####################  GESTIONE UTENTI ####################################
    //1) Si verifica se l'utente ha il permesso di creare un nuovo movimento di magazzino
    
    //############# VERIFICA PERMESSO VISUALIZZAZIONE LISTA ####################
    $actionOnLoad = "";
    $elencoFunzioni = array("143");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni, $_SESSION['objPermessiVis']);
    //############# STRINGHE UTENTI - AZIENDE VISIBILI###########################
    //Stringa contenente l'elenco degli id degli utenti e delle aziende prop visibili 
    //dall'utente loggato   
    $strUtentiAziende = getStrUtAzVisib($_SESSION['objPermessiVis'], 'macchina');
    ?>
    
    <body onLoad="<?php echo $actionOnLoad ?>">
           <div id="mainContainer">     
            <?php
            include('../include/menu.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script_movimento_sing_mac.php');
            include('../sql/script.php');
            include('../include/precisione.php');
            include('../sql/script_parametro_glob_mac.php');

            if ($DEBUG)
                ini_set("display_errors", "1");

            //Calcolo l'anno ed il mese corrente
            $now = getdate();
            $annoCorrente = $now["year"];
            $meseCorrente = $now["mon"];
            if ($meseCorrente < 10) {
                $meseCorrente = "0" . $meseCorrente;
            }

            if (isset($_GET['IdMacchina']) AND isset($_GET['DescriStab'])) {
                $_SESSION['IdMacchina'] = $_GET['IdMacchina'];
                $_SESSION['DescriStab'] = $_GET['DescriStab'];
            }
            
            

            $_SESSION['IdMov'] = "";
            $_SESSION['CodMateriale'] = "";
            $_SESSION['DescriMateriale'] = "";
            $_SESSION['TipoMateriale'] = "";
            $_SESSION['Quantita'] = "";
            $_SESSION['PesoTeo'] = "";
            $_SESSION['CodIngresso'] = "";
            $_SESSION['NumDoc'] = "";
            $_SESSION['DtDoc'] = "";
            $_SESSION['TipoMov'] = "";
            $_SESSION['DescriMov'] = "";
            $_SESSION['DtMov'] = $annoCorrente . "-" . $meseCorrente;

            $_SESSION['IdMovList'] = "";
            $_SESSION['CodMaterialeList'] = "";
            $_SESSION['DescriMaterialeList'] = "";
            $_SESSION['TipoMaterialeList'] = "";
            $_SESSION['QuantitaList'] = "";
            $_SESSION['PesoTeoList'] = "";
            $_SESSION['CodIngressoList'] = "";
            $_SESSION['NumDocList'] = "";
            $_SESSION['DtDocList'] = "";
            $_SESSION['TipoMovList'] = "";
            $_SESSION['DescriMovList'] = "";
            $_SESSION['DtMovList'] = "";

            
            if(isset($_GET['CodIngresso'])) {
               $_SESSION['CodIngresso'] = trim($_GET['CodIngresso']);
                $_SESSION['DtMov']="";
            }
            
            
                      
            

            if (isset($_POST['IdMov'])) {
                $_SESSION['IdMov'] = trim($_POST['IdMov']);
            }
            if (isset($_POST['IdMovList']) AND $_POST['IdMovList'] != "") {
                $_SESSION['IdMov'] = trim($_POST['IdMovList']);
            }
            if (isset($_POST['CodMateriale'])) {
                $_SESSION['CodMateriale'] = trim($_POST['CodMateriale']);
            }
            if (isset($_POST['CodMaterialeList']) AND $_POST['CodMaterialeList'] != "") {
                $_SESSION['CodMateriale'] = trim($_POST['CodMaterialeList']);
            }
            if (isset($_POST['DescriMateriale'])) {
                $_SESSION['DescriMateriale'] = trim($_POST['DescriMateriale']);
            }
            if (isset($_POST['DescriMaterialeList']) AND $_POST['DescriMaterialeList'] != "") {
                $_SESSION['DescriMateriale'] = trim($_POST['DescriMaterialeList']);
            }
            if (isset($_POST['TipoMateriale'])) {
                $_SESSION['TipoMateriale'] = trim($_POST['TipoMateriale']);
            }
            if (isset($_POST['TipoMaterialeList']) AND $_POST['TipoMaterialeList'] != "") {
                $_SESSION['TipoMateriale'] = trim($_POST['TipoMaterialeList']);
            }
            if (isset($_POST['Quantita'])) {
                $_SESSION['Quantita'] = trim($_POST['Quantita']);
            }
            if (isset($_POST['QuantitaList']) AND $_POST['QuantitaList'] != "") {
                $_SESSION['Quantita'] = trim($_POST['QuantitaList']);
            }
            if (isset($_POST['PesoTeo'])) {
                $_SESSION['PesoTeo'] = trim($_POST['PesoTeo']);
            }
            if (isset($_POST['PesoTeoList']) AND $_POST['PesoTeoList'] != "") {
                $_SESSION['PesoTeo'] = trim($_POST['PesoTeoList']);
            }
            if (isset($_POST['CodIngresso'])) {
                $_SESSION['CodIngresso'] = trim($_POST['CodIngresso']);
            }
            if (isset($_POST['CodIngressoList']) AND $_POST['CodIngressoList'] != "") {
                $_SESSION['CodIngresso'] = trim($_POST['CodIngressoList']);
            }
            if (isset($_POST['NumDoc'])) {
                $_SESSION['NumDoc'] = trim($_POST['NumDoc']);
            }
            if (isset($_POST['NumDocList']) AND $_POST['NumDocList'] != "") {
                $_SESSION['NumDoc'] = trim($_POST['NumDocList']);
            }
            if (isset($_POST['DtDoc'])) {
                $_SESSION['DtDoc'] = trim($_POST['DtDoc']);
            }
            if (isset($_POST['DtDocList']) AND $_POST['DtDocList'] != "") {
                $_SESSION['DtDoc'] = trim($_POST['DtDocList']);
            }
            if (isset($_POST['TipoMov'])) {
                $_SESSION['TipoMov'] = trim($_POST['TipoMov']);
            }
            if (isset($_POST['TipoMovList']) AND $_POST['TipoMovList'] != "") {
                $_SESSION['TipoMov'] = trim($_POST['TipoMovList']);
            }
            if (isset($_POST['DescriMov'])) {
                $_SESSION['DescriMov'] = trim($_POST['DescriMov']);
            }
            if (isset($_POST['DescriMovList']) AND $_POST['DescriMovList'] != "") {
                $_SESSION['DescriMov'] = trim($_POST['DescriMovList']);
            }
            if (isset($_POST['DtMov'])) {
                $_SESSION['DtMov'] = trim($_POST['DtMov']);
            }
            if (isset($_POST['DtMovList']) AND $_POST['DtMovList'] != "") {
                $_SESSION['DtMov'] = trim($_POST['DtMovList']);
            }

            //########### VARIABILE DI ORDINAMENTO DELLA QUERY #################
            $_SESSION['Filtro'] = "id_mov_inephos";
            if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
                $_SESSION['Filtro'] = trim($_POST['Filtro']);
            }

            //##################################################################

            begin();
            $sql = selectMovimentoSingMacOriByFiltri($_SESSION['Filtro'], "id_mov_inephos", $_SESSION['IdMacchina'],$_SESSION['IdMov'], $_SESSION['CodMateriale'], $_SESSION['DescriMateriale'], $_SESSION['TipoMateriale'], $_SESSION['Quantita'], $_SESSION['PesoTeo'], $_SESSION['CodIngresso'], $_SESSION['NumDoc'], $_SESSION['DtDoc'], $_SESSION['TipoMov'], $_SESSION['DescriMov'], $_SESSION['DtMov']);
            $sqlId = selectMovimentoSingMacOriByFiltri("id_mov_inephos", "id_mov_inephos", $_SESSION['IdMacchina'], $_SESSION['IdMov'], $_SESSION['CodMateriale'], $_SESSION['DescriMateriale'], $_SESSION['TipoMateriale'], $_SESSION['Quantita'], $_SESSION['PesoTeo'], $_SESSION['CodIngresso'], $_SESSION['NumDoc'], $_SESSION['DtDoc'], $_SESSION['TipoMov'], $_SESSION['DescriMov'], $_SESSION['DtMov']);
            $sqlCodMat = selectMovimentoSingMacOriByFiltri("cod_componente", "cod_componente",$_SESSION['IdMacchina'], $_SESSION['IdMov'], $_SESSION['CodMateriale'], $_SESSION['DescriMateriale'], $_SESSION['TipoMateriale'], $_SESSION['Quantita'], $_SESSION['PesoTeo'], $_SESSION['CodIngresso'], $_SESSION['NumDoc'], $_SESSION['DtDoc'], $_SESSION['TipoMov'], $_SESSION['DescriMov'], $_SESSION['DtMov']);
            $sqlDescriMat = selectMovimentoSingMacOriByFiltri("descri_componente", "descri_componente",$_SESSION['IdMacchina'], $_SESSION['IdMov'], $_SESSION['CodMateriale'], $_SESSION['DescriMateriale'], $_SESSION['TipoMateriale'], $_SESSION['Quantita'], $_SESSION['PesoTeo'], $_SESSION['CodIngresso'], $_SESSION['NumDoc'], $_SESSION['DtDoc'], $_SESSION['TipoMov'], $_SESSION['DescriMov'], $_SESSION['DtMov']);
            $sqlTipoMat = selectMovimentoSingMacOriByFiltri("tipo_materiale", "tipo_materiale",$_SESSION['IdMacchina'], $_SESSION['IdMov'], $_SESSION['CodMateriale'], $_SESSION['DescriMateriale'], $_SESSION['TipoMateriale'], $_SESSION['Quantita'], $_SESSION['PesoTeo'], $_SESSION['CodIngresso'], $_SESSION['NumDoc'], $_SESSION['DtDoc'], $_SESSION['TipoMov'], $_SESSION['DescriMov'], $_SESSION['DtMov']);
            $sqlQuanti = selectMovimentoSingMacOriByFiltri("quantita", "quantita",$_SESSION['IdMacchina'], $_SESSION['IdMov'], $_SESSION['CodMateriale'], $_SESSION['DescriMateriale'], $_SESSION['TipoMateriale'], $_SESSION['Quantita'], $_SESSION['PesoTeo'], $_SESSION['CodIngresso'], $_SESSION['NumDoc'], $_SESSION['DtDoc'], $_SESSION['TipoMov'], $_SESSION['DescriMov'], $_SESSION['DtMov']);
            $sqlPesoTeo = selectMovimentoSingMacOriByFiltri("peso_teorico", "peso_teorico",$_SESSION['IdMacchina'], $_SESSION['IdMov'], $_SESSION['CodMateriale'], $_SESSION['DescriMateriale'], $_SESSION['TipoMateriale'], $_SESSION['Quantita'], $_SESSION['PesoTeo'], $_SESSION['CodIngresso'], $_SESSION['NumDoc'], $_SESSION['DtDoc'], $_SESSION['TipoMov'], $_SESSION['DescriMov'], $_SESSION['DtMov']);
            $sqlCodIngresso = selectMovimentoSingMacOriByFiltri("cod_ingresso_comp", "cod_ingresso_comp",$_SESSION['IdMacchina'], $_SESSION['IdMov'], $_SESSION['CodMateriale'], $_SESSION['DescriMateriale'], $_SESSION['TipoMateriale'], $_SESSION['Quantita'], $_SESSION['PesoTeo'], $_SESSION['CodIngresso'], $_SESSION['NumDoc'], $_SESSION['DtDoc'], $_SESSION['TipoMov'], $_SESSION['DescriMov'], $_SESSION['DtMov']);
            $sqlNumDoc = selectMovimentoSingMacOriByFiltri("num_doc", "num_doc",$_SESSION['IdMacchina'], $_SESSION['IdMov'], $_SESSION['CodMateriale'], $_SESSION['DescriMateriale'], $_SESSION['TipoMateriale'], $_SESSION['Quantita'], $_SESSION['PesoTeo'], $_SESSION['CodIngresso'], $_SESSION['NumDoc'], $_SESSION['DtDoc'], $_SESSION['TipoMov'], $_SESSION['DescriMov'], $_SESSION['DtMov']);
            $sqlDtDoc = selectMovimentoSingMacOriByFiltri("dt_doc", "dt_doc",$_SESSION['IdMacchina'], $_SESSION['IdMov'], $_SESSION['CodMateriale'], $_SESSION['DescriMateriale'], $_SESSION['TipoMateriale'], $_SESSION['Quantita'], $_SESSION['PesoTeo'], $_SESSION['CodIngresso'], $_SESSION['NumDoc'], $_SESSION['DtDoc'], $_SESSION['TipoMov'], $_SESSION['DescriMov'], $_SESSION['DtMov']);
            $sqlTipoMov = selectMovimentoSingMacOriByFiltri("tipo_mov", "tipo_mov", $_SESSION['IdMacchina'],$_SESSION['IdMov'], $_SESSION['CodMateriale'], $_SESSION['DescriMateriale'], $_SESSION['TipoMateriale'], $_SESSION['Quantita'], $_SESSION['PesoTeo'], $_SESSION['CodIngresso'], $_SESSION['NumDoc'], $_SESSION['DtDoc'], $_SESSION['TipoMov'], $_SESSION['DescriMov'], $_SESSION['DtMov']);
            $sqlDescriMov = selectMovimentoSingMacOriByFiltri("descri_mov", "descri_mov",$_SESSION['IdMacchina'], $_SESSION['IdMov'], $_SESSION['CodMateriale'], $_SESSION['DescriMateriale'], $_SESSION['TipoMateriale'], $_SESSION['Quantita'], $_SESSION['PesoTeo'], $_SESSION['CodIngresso'], $_SESSION['NumDoc'], $_SESSION['DtDoc'], $_SESSION['TipoMov'], $_SESSION['DescriMov'], $_SESSION['DtMov']);
            $sqlDtMov = selectMovimentoSingMacOriByFiltri("dt_mov", "dt_mov", $_SESSION['IdMacchina'],$_SESSION['IdMov'], $_SESSION['CodMateriale'], $_SESSION['DescriMateriale'], $_SESSION['TipoMateriale'], $_SESSION['Quantita'], $_SESSION['PesoTeo'], $_SESSION['CodIngresso'], $_SESSION['NumDoc'], $_SESSION['DtDoc'], $_SESSION['TipoMov'], $_SESSION['DescriMov'], $_SESSION['DtMov']);
            
            $sqlParGlob=findParGlobMacById("120");
            $strDescriMovLoadPurchase="";
            while ($rowParGlob = mysql_fetch_array($sqlParGlob)) {
                
                $strDescriMovLoadPurchase=$rowParGlob['valore_variabile'];
            }
                
            commit();

            $trovati = mysql_num_rows($sql);
            include('./moduli/visualizza_movimento_sing_mac.php'); 
            ?>
            
               <div id="msgLog">
                <?php                
                if ($DEBUG) {
                    echo "</br>actionOnLoad : " . $actionOnLoad;
                    echo "</br>Tab macchina : Utenti e aziende visibili " . $strUtentiAziende;
                }
                ?>
            </div>
        </div>
    </body>
</html>




