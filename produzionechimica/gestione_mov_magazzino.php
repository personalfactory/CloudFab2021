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
            include('../sql/script.php');
            include('../sql/script_mov_magazzino.php');
            include('../sql/script_materia_prima.php');
            
            begin();
            $sql = findAllCodMovimento();
            commit();
            
            include('./moduli/visualizza_movimenti.php');
            ?> 

        </div>
    </body>
</html>
