<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <script language="javascript">

        function disabilitaOperazioni() {

            //Disabilito la conferma dell'eliminazione            
            document.getElementById('Conferma').removeAttribute('href');

        }
    </script>
    <body>
        <div id="mainContainer">

            <?php
            include('../include/menu.php');


            //################### RICHIESTA DI CONFERMA DISABILITAZIONE ##############

            if (!isSet($_GET['Conferma'])) {

                $Tabella = $_GET['Tabella'];
                $IdRecord = $_GET['IdRecord'];
                $RefBack = $_GET['RefBack'];
                ?>

                <table class="table3">
                    <tr>
                        <th class="cella3"><?php echo $msgConfermaDisabilitazione ?></th>
                    </tr>
                    <tr>
                        <td class="cella6">
                            <a href="javascript:history.back();"><img src="/CloudFab/images/icone/no.png" class="images2" /></a>  
                            <a id="Conferma" href="disabilita_record.php?Conferma=SI&Tabella=<?php echo $Tabella ?>&IdRecord=<?php echo $IdRecord ?>&RefBack=<?php echo $RefBack ?>">
                                <img src="/CloudFab/images/icone/si.png" class="images2" /></a>
                        </td>
                    </tr>
                </table>

                <?php
                //######################################################################
                //################### DISABILITAZIONE ##################################
                //######################################################################
            } else {

                include('../Connessioni/serverdb.php');
                include('../sql/script.php');

                $disabilitazioneDato = true;
                $Tabella = $_GET['Tabella'];
                $IdRecord = $_GET['IdRecord'];
                $RefBack = $_GET['RefBack'];

                //Recupero il nome del campo id chiave primaria prendendo il primo campo della tabella
                $strSql1 = "SELECT * FROM " . $Tabella;
                $selectTab = mysql_query($strSql1) or die("ERRORE disabilita_record.php : " . $strSql1 . " " . mysql_error());

                //ATTENZIONE !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                //!!!!!Non si può fare se l'id non è il primo campo
                $NomeId = mysql_field_name($selectTab, 0) . "\n";

////5.	Disabilito il dato dalla tabella corrente 
                $strSql2 = "UPDATE " . $Tabella . " SET abilitato=0 WHERE " . $NomeId . "=" . $IdRecord;
                $disabilitazioneDato = mysql_query($strSql2); //or die("ERRORE disabilita_record.php : ".$strSql2. "" . mysql_error());

                if (!$disabilitazioneDato) {

                    rollback();

                    echo '<div id="msgErr">' . $msgTransazioneFallita . '! ' . $msgErrContactAdmin . '!</div>';
                    echo '<a href='.$RefBack .'>' . $msgOk . '</a><br/>';
                } else {

                    commit();
                    ?>
                    <script type="text/javascript">
                        location.href = "<?php echo $RefBack ?>";
                    </script>

        <?php
    }
}
?>

        </div>
    </body>
</html>
