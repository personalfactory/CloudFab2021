<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>  
        <div id="mainContainer">
            <?php
            include('../include/menu.php');
            include('../include/funzioni.php');
            include('../include/precisione.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_gaz_movmag.php');


            //################### RICHIESTA DI CONFERMA ELIMINAZIONE ##############
            if (!isSet($_GET['Conferma'])) {

                $NumDoc = $_GET['NumDoc'];
                $DatDoc = $_GET['DatDoc'];
              ?>
                <table class="table3">
                    <tr>
                        <th class="cella3"><?php echo $msgConfermaCancellazione ?></th>
                    </tr>
                    <tr>
                        <td class="cella6">
                            <a href="javascript:history.back();">
                                <img src="/CloudFab/images/icone/no.png" class="images2" /></a>  
                            <a href="elimina_ddt_vendita.php?Conferma=SI&NumDoc=<?php echo $NumDoc ?>&DatDoc=<?php echo $DatDoc ?>">
                                <img src="/CloudFab/images/icone/si.png" class="images2" /></a>
                        </td>
                    </tr>
                </table>

                <?php
                //################### ELIMINAZIONE ##################################
            } else {

                $NumDoc = $_GET['NumDoc'];
                $DatDoc = $_GET['DatDoc'];
                

                $deleteDdt = true;
                $GiacenzaAttuale = "";
                $resultAggLotto = true;
                $erroreTransazione = false;

                //Attenzione verificare ke se l'id è un intero la query non dia errore
                begin();

                $sqlMov = findMovimentiByDdt($NumDoc, $DatDoc);
                while ($row = mysql_fetch_array($sqlMov)) {
                                        
                    $deleteDdt = eliminaMovimento($row['id_mov']);

                    $GiacenzaAttuale = calcolaGiacenzaArticolo($row['artico'], $row['cat_mer'], $valCarico, $valScarico, $valDataDefault, $valCatMerLotti, $valCatMerMatPrime);

                    $resultAggLotto = aggiornaGiacLotto($row['artico'], $GiacenzaAttuale);

                    if (!$deleteDdt OR $GiacenzaAttuale = "" OR !$resultAggLotto) {
                        $erroreTransazione = true;
                    }
                }
                if ($erroreTransazione) {

                    rollback();
                    echo $msgErroreVerificato . " " . $msgErrContactAdmin;
                } else {
                    commit();
                    ?>
                    <script type="text/javascript">
                        location.href = "gestione_bolle.php";
                    </script>

    <?php }
}
?>

        </div>
    </body>
</html>

