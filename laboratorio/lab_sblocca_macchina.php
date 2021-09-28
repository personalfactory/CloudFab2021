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
            include('../include/gestione_date.php');
            include('../Connessioni/serverdb.php');
            include('../include/precisione.php');
            include('sql/script.php');
            include('sql/script_lab_macchina.php');

            if($DEBUG) ini_set(display_errors, "1");
            
            $IdLabMacchina = $_GET['IdLabMacchina'];
            $updateRosetta = true;
            $deleteUser= true;

            begin();
            //Sblocco la macchina selezionata nel db
            $updateRosetta = modificaStatoRosetta($IdLabMacchina, $valRosetLibera);
            $deleteUser=modificaUtenteMacchina($IdLabMacchina,'');
            
            if (!$updateRosetta OR !$deleteUser) {
                
                rollback();
                echo "</br>" . $msgTransazioneFallita . "! " . '<a href="gestione_lab_macchine.php"> ' . $valueButtonIndietro . '</a>';
            
                
            } else {
                
                //Se l'utente vuole sbloccare la propria macchina oltre a modificare 
                //il campo disponibile della tabella lab_macchina bisogna distruggere 
                //la variabile di sessione che memorizza l'id della macchina
                //Se invece l'utente vuole sbloccare la rosetta di un altro operatore 
                //quest'ultimo dovrà cmq eseguire prima il logout per poter usare una nuova rosetta.

                if (isset($_SESSION['lab_macchina']) && $_SESSION['lab_macchina'] == $IdLabMacchina) {

                    //In questo modo un utente può sbloccare solo una macchina diversa 
                    //da quella che sta utilizzando senza modificare la sua sessione

                    unset($_SESSION['lab_macchina']);
                    session_write_close();
                    
                }
                commit();
                ?>
                    <script type="text/javascript">
                        location.href = "gestione_lab_macchine.php";
                    </script>

                <?php
            }
            ?>
        </div>
    </body>
</html>