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
    include('../sql/script.php');
    include('../sql/script_bs_riepilogo.php');

    $insertRiepilogo = true;
    $eliminaDatiRiepilogo = true;

    begin();
    
    $_SESSION['NoteSimulazione']="";
    if(isSet($_POST['NoteSimulazione'])){
    $_SESSION['NoteSimulazione'] = $_POST['NoteSimulazione'];
    }
    
    
    $eliminaDatiRiepilogo = eliminaDatiRiepilogo($_SESSION['id_cliente'], $_SESSION['Anno']);
    
    $TonnellateVendute=number_format($_SESSION['TonnellateVendute'], '0', '.', '');
    if($_SESSION['valutaBs']==1) {
        
    
    $CostoProduzioneTot=number_format($_SESSION['CostoProduzioneTot'], '0', '.', '');
    $RicaviTot=number_format($_SESSION['RicaviTot'], '0', '.', '');
    $MarginePrimoLivTot=number_format($_SESSION['MarginePrimoLivTot'], '0', '.', '');
    $CostoAmmImpianto=number_format($_SESSION['CostoAmmImpianto'], '0', '.', '');
    $CostoAmmAltriInv=number_format($_SESSION['CostoAmmAltriInv'], '0', '.', '');
    $SecondoMargine=number_format($_SESSION['SecondoMargine'], '0', '.', '');
    $AltreSpese=number_format($_SESSION['AltreSpese'], '0', '.', '');
    $Ebita=number_format($_SESSION['Ebita'], '0', '.', '');
    
    } else {    

   
    $CostoProduzioneTot=number_format($_SESSION['CostoProduzioneTot']/$_SESSION['cambio'], '0', '.', '');
    $RicaviTot=number_format($_SESSION['RicaviTot']/$_SESSION['cambio'], '0', '.', '');
    $MarginePrimoLivTot=number_format($_SESSION['MarginePrimoLivTot']/$_SESSION['cambio'], '0', '.', '');
    $CostoAmmImpianto=number_format($_SESSION['CostoAmmImpianto']/$_SESSION['cambio'], '0', '.', '');
    $CostoAmmAltriInv=number_format($_SESSION['CostoAmmAltriInv']/$_SESSION['cambio'], '0', '.', '');
    $SecondoMargine=number_format($_SESSION['SecondoMargine']/$_SESSION['cambio'], '0', '.', '');
    $AltreSpese=number_format($_SESSION['AltreSpese']/$_SESSION['cambio'], '0', '.', '');
    $Ebita=number_format($_SESSION['Ebita']/$_SESSION['cambio'], '0', '.', '');
    }
            
    $insertRiepilogo = inserisciDatiRiepilogo($TonnellateVendute, $CostoProduzioneTot, $RicaviTot, $MarginePrimoLivTot, $CostoAmmImpianto, $CostoAmmAltriInv, $SecondoMargine, $AltreSpese, $Ebita, $_SESSION['Anno'], $_SESSION['id_cliente'], $_SESSION['id_utente'], $_SESSION['id_azienda'], dataCorrenteInserimento(),$_SESSION['SaturazioneImpianto'],$_SESSION['NoteSimulazione'],$_SESSION['cambio'],$_SESSION['valutaBs']);



    if (!$insertRiepilogo OR !$eliminaDatiRiepilogo) {

        rollback();
        echo $msgTransazioneFallita . '! ' . $msgErrContattareAdmin . '!';

        echo "<br/>eliminaDatiRiepilogo" . $eliminaDatiRiepilogo;
        echo "<br/>insertRiepilogo" . $insertRiepilogo;
        
    } else {

        commit();
        mysql_close();
        ?>
        <script language="javascript">
            window.location.href = "gestione_info_bs.php";
        </script>
        <?php
    }
    ?>
        
