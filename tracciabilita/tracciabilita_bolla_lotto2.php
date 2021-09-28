<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <div id="tracciabilitaContainer">
            <?php
            include('../include/menu.php');
            include('../include/precisione.php');
            include('../include/gestione_date.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_bolla.php');
            include('../sql/script_lotto.php');

            $errore = false;

            $resultSelectIdBollaServerdb = true;
            $resultUpdateLottoServerdb = true;

            $NumDdt = $_SESSION['Bolla'][0];
            $DataEmi = $_SESSION['Bolla'][1];
            $CodStab = $_SESSION['Bolla'][2];
            $IdMacchina = $_SESSION['Bolla'][3];


            //######################################################################
            //########### SALVATAGGIO SU SERVERDB ##################################
            //######################################################################


            begin();

            //Salvo la bolla nella tabella bolla di serverdb
            $resultInsertBollaServerdb = inserisciDdtInBolla($NumDdt, $DataEmi, $CodStab, $IdMacchina);


//              mysql_query("INSERT INTO serverdb.bolla (num_bolla,dt_bolla,cod_stab,id_macchina) 
//                        VALUES(
//                              '" . $NumDdt . "',
//                              '" . $DataEmi . "',
//                              '" . $CodStab . "',
//                              '" . $IdMacchina . "')")
//              or die("ERRORE 1 INSERT INTO serverdb.bolla : " . mysql_error());
            //Recupero il valore del campo id_bolla dalla tabella bolla
            $resultSelectIdBollaServerdb = findDdtInBolla($NumDdt, $DataEmi);

//              mysql_query("SELECT id_bolla FROM serverdb.bolla
//                                  WHERE 
//                                    num_bolla='" . $NumDdt . "' 
//                                  AND 
//                                    dt_bolla='" . $DataEmi . "'")
//              or die("ERRORE 2 SELECT FROM serverdb.bolla: " . mysql_error());

            while ($rowIdBolla = mysql_fetch_array($resultSelectIdBollaServerdb)) {

                $IdBolla = $rowIdBolla['id_bolla'];
            }

            //ASSOCIO LA BOLLA AI VARI CODICI LOTTO SU SERVERDB            
            for ($i = 0; $i < $_SESSION['NumCodiciLottoTot']; $i++) {

                $CodiceLotto = $_SESSION['CodLotto'][$i];

                $resultUpdateLottoServerdb = updateLottoAssociaDdt($IdBolla, $NumDdt, $DataEmi, $CodiceLotto,$valStatoLottoVenduto);

//                   mysql_query("UPDATE serverdb.lotto 
//                      SET 
//                        id_bolla='" . $IdBolla . "',
//                        num_bolla='" . $NumDdt . "',
//                        dt_bolla='" . $DataEmi . "'
//                      WHERE 
//                        cod_lotto = '" . $CodiceLotto . "'
//                      AND 
//                        id_bolla is null
//                      AND 
//                        num_bolla is null
//                      AND 
//                        dt_bolla is null")
//                  or die(" ERRORE 3 UPDATE serverdb.lotto: " . mysql_error());

                if (!$resultUpdateLottoServerdb) {
                    $errore = true;
                }
            }

            if ($errore
                    OR ! $resultSelectIdBollaServerdb
                    OR ! $resultUpdateLottoServerdb
            ) {

                rollback();
                echo $msgErroreVerificato . " " . $msgErrContactAdmin;

                echo "resultInsertBollaServerdb : " . $resultInsertBollaServerdb . "<br/>";
                echo "resultSelectIdBollaServerdb : " . $resultSelectIdBollaServerdb . "<br/>";
                echo "resultUpdateLottoServerdb : " . $resultUpdateLottoServerdb . "<br/>";
            } else {

                commit();

                echo $msgInfoTransazioneRiuscita . "</br>" . $filtroNumLottiAssociati . ": " . $_SESSION['NumCodiciLottoTot'];

                /* 
                  echo "resultInsertBollaServerdb : ". $resultInsertBollaServerdb;
                  echo "resultSelectIdBollaServerdb : ". $resultSelectIdBollaServerdb;
                  echo "resultUpdateLottoServerdb : ". $resultUpdateLottoServerdb;
                  echo "resultInsertBollaLocaldb : ".$resultInsertBollaLocaldb;
                  echo "resultUpdateLottoLocaldb : ".$resultUpdateLottoLocaldb; */
                ?>
                <a href="/CloudFab/produzionechimica/dettaglio_bolla.php?NumBolla=<?php echo($NumDdt) ?>&DtBolla=<?php echo($DataEmi) ?>"><?php echo $filtroVediDdt ?></a>
            <?php }
            ?>


<!--<script type="text/javascript">
  location.href="/CloudFab/gestione_bolle.php"
</script>-->





        </div>
    </body>
</html>