<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <?php
    if ($DEBUG)
        ini_set('display_errors', 1);
    //############# VERIFICA PERMESSO VISUALIZZAZIONE LISTA ####################
    //La variabile funzione indica il campo id_funzione della tabella funzione del dbutente
    //Vedere valori parametro prodotto relativi alla categoria di ogni sacco
    $elencoFunzioni = array("90", "138");
    //90 vedere dettaglio sacco 
    //138 vedere valori parametro prodotto


    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni, $_SESSION['objPermessiVis']);
    ?>

    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer">
            <?php include('../include/menu.php'); ?>
        </div>
        <?php
        include('../include/precisione.php');
        include('../Connessioni/serverdb.php');
        include('../sql/script.php');
        include('../sql/script_processo.php');
        include('../sql/script_componente_prodotto.php');
        include('../sql/script_dizionario.php');
        include('../sql/script_sacchetto_chimica.php');
        include('../sql/script_ciclo_processo.php');
        
        
        //Calcolo l'anno ed il mese corrente
        $now = getdate();
        $annoCorrente = $now["year"];
        $meseCorrente = $now["mon"];
        if ($meseCorrente < 10) {
            $meseCorrente = "0" . $meseCorrente;
        }
        $dataProdDefault=$annoCorrente . "-" . $meseCorrente;
                      
        $_SESSION['IdMacchina'] = "";
        $_SESSION['DescriStab'] = "";
        $_SESSION['Filtro'] = "";        
               
        if (isset($_GET['IdMacchina']) AND isset($_GET['DescriStab'])) {
            $_SESSION['IdMacchina'] = $_GET['IdMacchina'];
            $_SESSION['DescriStab'] = $_GET['DescriStab'];
            $_SESSION['Filtro'] = $_GET['Filtro'];
        }
        
        
        if (isset($_GET['IdCiclo']) AND $_GET['IdCiclo'] > 0) {

            $_SESSION['IdCiclo'] = $_GET['IdCiclo'];
            $dataProdDefault = "";
                                                         
        }               
        
        if (isset($_GET['strCicli']) AND $_GET['strCicli'] != "(0)") {

            $_SESSION['strCicli'] = $_GET['strCicli'];
            $dataProdDefault="";
        }         

        $_SESSION['IdProcesso'] = "";
        $_SESSION['CodProdotto'] = "";
        $_SESSION['NomeProdotto'] = "";
        $_SESSION['CodChimica'] = "";
        $_SESSION['CodSacco'] = "";
        $_SESSION['DataProd'] = $dataProdDefault;
        
        $_SESSION['PesoReale'] = "";

        $_SESSION['IdProcessoList'] = "";
        $_SESSION['CodProdottoList'] = "";
        $_SESSION['NomeProdottoList'] = "";
        $_SESSION['CodChimicaList'] = "";
        $_SESSION['CodSaccoList'] = "";
        $_SESSION['DataProdList'] = "";
        $_SESSION['PesoRealeList'] = "";


        if (isset($_POST['IdProcesso'])) {
            $_SESSION['IdProcesso'] = trim($_POST['IdProcesso']);
        }
        if (isset($_POST['IdProcessoList']) AND $_POST['IdProcessoList'] != "") {
            $_SESSION['IdProcesso'] = trim($_POST['IdProcessoList']);
        }

        if (isset($_POST['CodProdotto'])) {
            $_SESSION['CodProdotto'] = trim($_POST['CodProdotto']);
        }
        if (isset($_POST['CodProdottoList']) AND $_POST['CodProdottoList'] != "") {
            $_SESSION['CodProdotto'] = trim($_POST['CodProdottoList']);
        }

        if (isset($_POST['NomeProdotto'])) {
            $_SESSION['NomeProdotto'] = trim($_POST['NomeProdotto']);
        }
        if (isset($_POST['NomeProdottoList']) AND $_POST['NomeProdottoList'] != "") {
            $_SESSION['NomeProdotto'] = trim($_POST['NomeProdottoList']);
        }

        if (isset($_POST['CodChimica'])) {
            $_SESSION['CodChimica'] = trim($_POST['CodChimica']);
        }
        if (isset($_POST['CodChimicaList']) AND $_POST['CodChimicaList'] != "") {
            $_SESSION['CodChimica'] = trim($_POST['CodChimicaList']);
        }

        if (isset($_POST['CodSacco'])) {
            $_SESSION['CodSacco'] = trim($_POST['CodSacco']);
        }
        if (isset($_POST['CodSaccoList']) AND $_POST['CodSaccoList'] != "") {
            $_SESSION['CodSacco'] = trim($_POST['CodSaccoList']);
        }

        if (isset($_POST['DataProd'])) {
            $_SESSION['DataProd'] = trim($_POST['DataProd']);
        }
        if (isset($_POST['DataProdList']) AND $_POST['DataProdList'] != "") {
            $_SESSION['DataProd'] = trim($_POST['DataProdList']);
        }

        if (isset($_POST['PesoReale'])) {
            $_SESSION['PesoReale'] = trim($_POST['PesoReale']);
        }
        if (isset($_POST['PesoRealeList']) AND $_POST['PesoRealeList'] != "") {
            $_SESSION['PesoReale'] = trim($_POST['PesoRealeList']);
        }

        //########### VARIABILE DI ORDINAMENTO DELLA QUERY #############################
        $_SESSION['Filtro'] = "id_processo";
        if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
            $_SESSION['Filtro'] = trim($_POST['Filtro']);
        }
        //###########################################################
        begin();


        //if(!isSet($_SESSION['IdCiclo']) && !isset($_SESSION['strCicli'])){

        $sql = selectProcessiByFiltriIdMac($_SESSION['IdMacchina'], $_SESSION['IdProcesso'], $_SESSION['CodProdotto'], $_SESSION['CodChimica'], $_SESSION['CodSacco'], $_SESSION['DataProd'], $_SESSION['NomeProdotto'], $_SESSION['PesoReale'], $_SESSION['Filtro'], 'id_processo');

        $sqlIdProc = selectProcessiByFiltriIdMac($_SESSION['IdMacchina'], $_SESSION['IdProcesso'], $_SESSION['CodProdotto'], $_SESSION['CodChimica'], $_SESSION['CodSacco'], $_SESSION['DataProd'], $_SESSION['NomeProdotto'], $_SESSION['PesoReale'], $_SESSION['Filtro'], 'id_processo');
        $sqlCodProd = selectProcessiByFiltriIdMac($_SESSION['IdMacchina'], $_SESSION['IdProcesso'], $_SESSION['CodProdotto'], $_SESSION['CodChimica'], $_SESSION['CodSacco'], $_SESSION['DataProd'], $_SESSION['NomeProdotto'], $_SESSION['PesoReale'], $_SESSION['Filtro'], 'cod_prodotto');
        $sqlNomeProd = selectProcessiByFiltriIdMac($_SESSION['IdMacchina'], $_SESSION['IdProcesso'], $_SESSION['CodProdotto'], $_SESSION['CodChimica'], $_SESSION['CodSacco'], $_SESSION['DataProd'], $_SESSION['NomeProdotto'], $_SESSION['PesoReale'], $_SESSION['Filtro'], 'nome_prodotto');
        $sqlCodChim = selectProcessiByFiltriIdMac($_SESSION['IdMacchina'], $_SESSION['IdProcesso'], $_SESSION['CodProdotto'], $_SESSION['CodChimica'], $_SESSION['CodSacco'], $_SESSION['DataProd'], $_SESSION['NomeProdotto'], $_SESSION['PesoReale'], $_SESSION['Filtro'], 'cod_chimica');
        $sqlCodSac = selectProcessiByFiltriIdMac($_SESSION['IdMacchina'], $_SESSION['IdProcesso'], $_SESSION['CodProdotto'], $_SESSION['CodChimica'], $_SESSION['CodSacco'], $_SESSION['DataProd'], $_SESSION['NomeProdotto'], $_SESSION['PesoReale'], $_SESSION['Filtro'], 'cod_sacco');
        $sqlPesoReale = selectProcessiByFiltriIdMac($_SESSION['IdMacchina'], $_SESSION['IdProcesso'], $_SESSION['CodProdotto'], $_SESSION['CodChimica'], $_SESSION['CodSacco'], $_SESSION['DataProd'], $_SESSION['NomeProdotto'], $_SESSION['PesoReale'], $_SESSION['Filtro'], 'peso_reale_sacco');
        $sqlNomi = selectProcessiByFiltriIdMac($_SESSION['IdMacchina'], $_SESSION['IdProcesso'], $_SESSION['CodProdotto'], $_SESSION['CodChimica'], $_SESSION['CodSacco'], $_SESSION['DataProd'], $_SESSION['NomeProdotto'], $_SESSION['PesoReale'], $_SESSION['Filtro'], 'dt_produzione_mac');


         //} else 
         if (isSet($_SESSION['strCicli']) && $_SESSION['strCicli'] != "(0)") {
          

            $sql = selectProcessiByFiltriIdMacAndArrayCiclo($_SESSION['IdMacchina'], $_SESSION['IdProcesso'], $_SESSION['CodProdotto'], $_SESSION['CodChimica'], $_SESSION['CodSacco'], $_SESSION['DataProd'], $_SESSION['NomeProdotto'], $_SESSION['PesoReale'], $_SESSION['Filtro'], 'id_processo', $_SESSION['strCicli']);

            $sqlIdProc = selectProcessiByFiltriIdMacAndArrayCiclo($_SESSION['IdMacchina'], $_SESSION['IdProcesso'], $_SESSION['CodProdotto'], $_SESSION['CodChimica'], $_SESSION['CodSacco'], $_SESSION['DataProd'], $_SESSION['NomeProdotto'], $_SESSION['PesoReale'], $_SESSION['Filtro'], 'id_processo', $_SESSION['strCicli']);
            $sqlCodProd = selectProcessiByFiltriIdMacAndArrayCiclo($_SESSION['IdMacchina'], $_SESSION['IdProcesso'], $_SESSION['CodProdotto'], $_SESSION['CodChimica'], $_SESSION['CodSacco'], $_SESSION['DataProd'], $_SESSION['NomeProdotto'], $_SESSION['PesoReale'], $_SESSION['Filtro'], 'cod_prodotto', $_SESSION['strCicli']);
            $sqlNomeProd = selectProcessiByFiltriIdMacAndArrayCiclo($_SESSION['IdMacchina'], $_SESSION['IdProcesso'], $_SESSION['CodProdotto'], $_SESSION['CodChimica'], $_SESSION['CodSacco'], $_SESSION['DataProd'], $_SESSION['NomeProdotto'], $_SESSION['PesoReale'], $_SESSION['Filtro'], 'nome_prodotto', $_SESSION['strCicli']);
            $sqlCodChim = selectProcessiByFiltriIdMacAndArrayCiclo($_SESSION['IdMacchina'], $_SESSION['IdProcesso'], $_SESSION['CodProdotto'], $_SESSION['CodChimica'], $_SESSION['CodSacco'], $_SESSION['DataProd'], $_SESSION['NomeProdotto'], $_SESSION['PesoReale'], $_SESSION['Filtro'], 'cod_chimica', $_SESSION['strCicli']);
            $sqlCodSac = selectProcessiByFiltriIdMacAndArrayCiclo($_SESSION['IdMacchina'], $_SESSION['IdProcesso'], $_SESSION['CodProdotto'], $_SESSION['CodChimica'], $_SESSION['CodSacco'], $_SESSION['DataProd'], $_SESSION['NomeProdotto'], $_SESSION['PesoReale'], $_SESSION['Filtro'], 'cod_sacco', $_SESSION['strCicli']);
            $sqlPesoReale = selectProcessiByFiltriIdMacAndArrayCiclo($_SESSION['IdMacchina'], $_SESSION['IdProcesso'], $_SESSION['CodProdotto'], $_SESSION['CodChimica'], $_SESSION['CodSacco'], $_SESSION['DataProd'], $_SESSION['NomeProdotto'], $_SESSION['PesoReale'], $_SESSION['Filtro'], 'peso_reale_sacco', $_SESSION['strCicli']);
            $sqlNomi = selectProcessiByFiltriIdMacAndArrayCiclo($_SESSION['IdMacchina'], $_SESSION['IdProcesso'], $_SESSION['CodProdotto'], $_SESSION['CodChimica'], $_SESSION['CodSacco'], $_SESSION['DataProd'], $_SESSION['NomeProdotto'], $_SESSION['PesoReale'], $_SESSION['Filtro'], 'dt_produzione_mac', $_SESSION['strCicli']);
        
            
        } else if (isSet($_SESSION['IdCiclo']) && $_SESSION['IdCiclo'] > 0) {

           
            
            $sql = selectProcessiByFiltriIdMacAndCiclo($_SESSION['IdMacchina'], $_SESSION['IdProcesso'], $_SESSION['CodProdotto'], $_SESSION['CodChimica'], $_SESSION['CodSacco'], $_SESSION['DataProd'], $_SESSION['NomeProdotto'], $_SESSION['PesoReale'], $_SESSION['Filtro'], 'id_processo', $_SESSION['IdCiclo']);

            $sqlIdProc = selectProcessiByFiltriIdMacAndCiclo($_SESSION['IdMacchina'], $_SESSION['IdProcesso'], $_SESSION['CodProdotto'], $_SESSION['CodChimica'], $_SESSION['CodSacco'], $_SESSION['DataProd'], $_SESSION['NomeProdotto'], $_SESSION['PesoReale'], $_SESSION['Filtro'], 'id_processo', $_SESSION['IdCiclo']);
            $sqlCodProd = selectProcessiByFiltriIdMacAndCiclo($_SESSION['IdMacchina'], $_SESSION['IdProcesso'], $_SESSION['CodProdotto'], $_SESSION['CodChimica'], $_SESSION['CodSacco'], $_SESSION['DataProd'], $_SESSION['NomeProdotto'], $_SESSION['PesoReale'], $_SESSION['Filtro'], 'cod_prodotto', $_SESSION['IdCiclo']);
            $sqlNomeProd = selectProcessiByFiltriIdMacAndCiclo($_SESSION['IdMacchina'], $_SESSION['IdProcesso'], $_SESSION['CodProdotto'], $_SESSION['CodChimica'], $_SESSION['CodSacco'], $_SESSION['DataProd'], $_SESSION['NomeProdotto'], $_SESSION['PesoReale'], $_SESSION['Filtro'], 'nome_prodotto', $_SESSION['IdCiclo']);
            $sqlCodChim = selectProcessiByFiltriIdMacAndCiclo($_SESSION['IdMacchina'], $_SESSION['IdProcesso'], $_SESSION['CodProdotto'], $_SESSION['CodChimica'], $_SESSION['CodSacco'], $_SESSION['DataProd'], $_SESSION['NomeProdotto'], $_SESSION['PesoReale'], $_SESSION['Filtro'], 'cod_chimica', $_SESSION['IdCiclo']);
            $sqlCodSac = selectProcessiByFiltriIdMacAndCiclo($_SESSION['IdMacchina'], $_SESSION['IdProcesso'], $_SESSION['CodProdotto'], $_SESSION['CodChimica'], $_SESSION['CodSacco'], $_SESSION['DataProd'], $_SESSION['NomeProdotto'], $_SESSION['PesoReale'], $_SESSION['Filtro'], 'cod_sacco', $_SESSION['IdCiclo']);
            $sqlPesoReale = selectProcessiByFiltriIdMacAndCiclo($_SESSION['IdMacchina'], $_SESSION['IdProcesso'], $_SESSION['CodProdotto'], $_SESSION['CodChimica'], $_SESSION['CodSacco'], $_SESSION['DataProd'], $_SESSION['NomeProdotto'], $_SESSION['PesoReale'], $_SESSION['Filtro'], 'peso_reale_sacco', $_SESSION['IdCiclo']);
            $sqlNomi = selectProcessiByFiltriIdMacAndCiclo($_SESSION['IdMacchina'], $_SESSION['IdProcesso'], $_SESSION['CodProdotto'], $_SESSION['CodChimica'], $_SESSION['CodSacco'], $_SESSION['DataProd'], $_SESSION['NomeProdotto'], $_SESSION['PesoReale'], $_SESSION['Filtro'], 'dt_produzione_mac', $_SESSION['IdCiclo']);
        }

        commit();

        $trovati = mysql_num_rows($sql);
        ?>

        <div id="bigMainContainer">
            <table class="table3">
                <tr>
                    <th colspan="8"><?php echo $titoloPaginaProdOrigami ?></th>
                </tr>
                <tr>
                    <th colspan="8"><?php echo $_SESSION['DescriStab'] ?></th>
                </tr>
            </table>
<?php
echo "</br>" . $msgTotProcessi . $trovati . "</br>";
echo "</br>" . $msgSelectListCriteriRicerca . "</br>";
include('./moduli/visualizza_processo.php');
?>
        </div>

    </body>
</html>
