<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <?php
    if ($DEBUG)
        ini_set('display_errors', '1');

    include('../Connessioni/serverdb.php');
    include('../include/gestione_date.php');
    include('../include/precisione.php');
    include('../sql/script.php');
    include('../sql/script_bs_dato.php');
    include('../sql/script_bs_prodotto.php');
    include('../sql/script_bs_prodotto_cliente.php');
    include('../sql/script_bs_altri_prodotti_cliente.php');
    include('../sql/script_componente.php');

    //Divido per il cambio per inviare alla pagina successiva (riepilogo_bs) sempre il valore in euro
    if (isset($_POST['CostoProduzioneTot'])) {
        $_SESSION['CostoProduzioneTot'] = trim($_POST['CostoProduzioneTot']);
    }
    if (isset($_POST['TonnellateVendute'])) {
        $_SESSION['TonnellateVendute'] = trim($_POST['TonnellateVendute']);
    }
    if (isset($_POST['RicaviTot'])) {
        $_SESSION['RicaviTot'] = trim($_POST['RicaviTot']);
    }
    if (isset($_POST['MarginePrimoLivTot'])) {
        $_SESSION['MarginePrimoLivTot'] = trim($_POST['MarginePrimoLivTot']);
    }
    if (isset($_POST['CostoAmmImpianto'])) {
        $_SESSION['CostoAmmImpianto'] = trim($_POST['CostoAmmImpianto']);
    }
    if (isset($_POST['CostoAmmAltriInv'])) {
        $_SESSION['CostoAmmAltriInv'] = trim($_POST['CostoAmmAltriInv']);
    }
    if (isset($_POST['SecondoMargine'])) {
        $_SESSION['SecondoMargine'] = trim($_POST['SecondoMargine']);
    }
    if (isset($_POST['AltreSpese'])) {
        $_SESSION['AltreSpese'] = trim($_POST['AltreSpese']);
    }
    if (isset($_POST['Ebita'])) {
        $_SESSION['Ebita'] = trim($_POST['Ebita']);
    }
    if (isset($_POST['SaturazioneImpianto'])) {
        $_SESSION['SaturazioneImpianto'] = trim($_POST['SaturazioneImpianto']);
    }    
    

    $strUtentiAziendesPr = getStrUtAzVisib($_SESSION['objPermessiVis'], 'bs_prodotto');

    $insertProd = true;
    $erroreInsert = false;
    $eliminaBsProd = true;

    $sqlProdotti = "";

    //#####RECUPERO PRODOTTI BS ################################################
    if ($_SESSION['TODO_bs'] == "NEW" ) {
        
         $sqlProdotti = findBSProdottiUnion($strUtentiAziendesPr);
            
    } else if ($_SESSION['TODO_bs'] == "MODIFY") {
        // TODO : aggiungere altri prodotti
        $sqlProdotti =findBSProdottiByClienteUnion($_SESSION['Anno'], $_SESSION['id_cliente']);
    }
    
    
    begin();
//########## ELIMINAZIONE INFO VECCHI PRODOTTI VENDUTI #################
    //Si eliminano le informazioni relative allo stesso anno eventualmente 
        //registrate in precedenza
        $eliminaBsProd = eliminaBsProdottiCliente($_SESSION['id_cliente'], $_SESSION['Anno']);
        
        $eliminaBsAltriProd = eliminaBsAltriProdottiCliente($_SESSION['id_cliente'], $_SESSION['Anno']);
   
    //########## INSERIMENTO NUOVE INFO PRODOTTI VENDUTI #######################
    while ($row = mysql_fetch_array($sqlProdotti)) {

        $vendutoPrivato = $_POST['SacchiVenPrivato' . $row['cod_prodotto']];
        $vendutoImpresa = $_POST['SacchiVenImpresa' . $row['cod_prodotto']];
        $vendutoRivenditore = $_POST['SacchiVenRivenditore' . $row['cod_prodotto']];
        $generatoreListino = $_POST['GeneratoreListino' . $row['cod_prodotto']];

        
        if($row['tipo']==$valBsTipoProdPf){
            $insertProd = inserisciProdottiCliente($row['id_prodotto'], $_SESSION['id_cliente'], $_SESSION['Anno'], $vendutoPrivato, $vendutoImpresa, $vendutoRivenditore,$generatoreListino,dataCorrenteInserimento());
        } else {
            $insertProd = inserisciAltriProdottiCliente($row['id_prodotto'], $_SESSION['id_cliente'], $_SESSION['Anno'], $vendutoPrivato, $vendutoImpresa, $vendutoRivenditore,$generatoreListino,dataCorrenteInserimento());
            
        }
                
        if (!$insertProd)
            $erroreInsert = true;
    }

    if ($erroreInsert OR !$eliminaBsProd) {

        rollback();
        echo $msgTransazioneFallita . '! ' . $msgErrContattareAdmin . '!';

        echo "<br/>eliminaBsProd" . $eliminaBsProd;
        echo "<br/>erroreInsert" . $errorInsert;
    } else {

        commit();
        mysql_close();
        ?>
        <script language="javascript">
            window.location.href = "riepilogo_info_bs.php";
        </script>
        <?php
    }

    ?>
        
