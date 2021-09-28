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
    include('../include/precisione.php');
    include('../sql/script.php');
    include('../sql/script_bs_dato.php');
    include('../sql/script_componente.php');
    include('../sql/script_bs_valore_dato.php');
    include('../sql/script_bs_comp_cliente.php');


    $strUtentiAziendeDatiBs = getStrUtAzVisib($_SESSION['objPermessiVis'], 'bs_dato');
    $strUtentiAziendeComp = getStrUtAzVisib($_SESSION['objPermessiVis'], 'componente');

    $insertValoriDati = true;
    $insertPrezziCompCliente = true;
    $erroreInsertDati = false;
    $erroreInsertComp = false;
    $eliminaValori = true;
    $eliminaCompCliente = true;

//    if ($_SESSION['TODO_bs'] == "NEW") {

    begin();

    //########### RECUPERO I VALORI DATI ###################################
    $sqlDati = findValoriDatiByCliente($_SESSION['id_cliente'], "ordine", $_SESSION['lingua']);
    if ($_SESSION['NumSimulazione'] == 1) {
        $sqlDati = "";
        $sqlDati = findDatiDefaultBs("ordine", $strUtentiAziendeDatiBs, "inserito");
    }


    //########### ELIMINAZIONE VALORI ESISTENTI ############################
    //elimino la simulazione precedente 
    $eliminaValori = eliminaValoriDatiByCliente($_SESSION['id_cliente']);

    //########### INSERIMENTO VALORI ESISTENTI #############################
    while ($rowDati = mysql_fetch_array($sqlDati)) {
        $idDato = $rowDati['id_dato'];
        $nomeDato = $rowDati['nome_dato'];
        $valoreDato = $_POST[$nomeDato];
        $nomeDato . ":" . $_SESSION[$nomeDato] = $valoreDato;

        if ($rowDati['tipo1'] == "valuta" && $_SESSION['valutaBs']!=1) {
            //Prima di salvare riporto la valuta in euro
            $valoreDato = $valoreDato / $_SESSION['cambio'];
        }


        $insertValoriDati = inserisciValoriDati($idDato, $valoreDato, $_SESSION['id_cliente'], $_SESSION['Anno']);
        if (!$insertValoriDati)
            $erroreInsertDati = true;
    }



    //########### RECUPERO BS COMPONENTI ###################################        
    $sqlComponente = findCompClienteUnionNewComp("descri_componente", $_SESSION['id_cliente'], $strUtentiAziendeComp, $_SESSION['lingua'], $valAbilitato);
    if ($_SESSION['NumSimulazione'] == 1) {
        $sqlComponente = 0;
        $sqlComponente = findComponentiEPrezzo("descri_componente", $strUtentiAziendeComp);
    }

    //########### ELIMINAZIONE PREZZI COMPONENTI IN ARCHIVIO ###############
    $eliminaCompCliente = eliminaCompBsCliente($_SESSION['id_cliente']);


    //########### INSERIMENTO PREZZI COMPONENTI ############################
    while ($rowMatPrime = mysql_fetch_array($sqlComponente)) {
        if (isSet($_POST['CostoComp' . $rowMatPrime['id_comp']])) {
            $_SESSION['CostoComp' . $rowMatPrime['id_comp']] = $_POST['CostoComp' . $rowMatPrime['id_comp']];
            if($_SESSION['valutaBs']!=1)       
            $_SESSION['CostoComp' . $rowMatPrime['id_comp']] = $_POST['CostoComp' . $rowMatPrime['id_comp']] / $_SESSION['cambio'];
            
            //TO DO : inserire dentro la tabella bs_comp_cliente
            //id_comp,id_cliente,pre_acq,id_utente,id_azienda
            $insertPrezziCompCliente = inserisciPreAcqCompCliente($rowMatPrime['id_comp'], $_SESSION['id_cliente'], $_SESSION['CostoComp' . $rowMatPrime['id_comp']], $_SESSION['Anno']);

            if (!$insertPrezziCompCliente)
                $erroreInsertComp = true;
        }
    }


    if (!$eliminaValori OR $erroreInsertDati OR ! $eliminaCompCliente OR $erroreInsertComp) {

        rollback();
        echo $msgTransazioneFallita . '! ' . $msgErrContattareAdmin . '!';

        echo "<br/>erroreInsertComp" . $erroreInsertComp;
        echo "<br/>erroreInsertDati" . $erroreInsertDati;
    } else {

        commit();
        mysql_close();
        ?>
        <script language="javascript">
            window.location.href = "carica_info_bs1.php";
        </script>
    <?php
}
//    }
?>
        
