<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <div id="mainContainer">
           <div id="container" style="margin:50px auto; ">
            <?php
            include('../include/menu.php');
            
            include('../Connessioni/serverdb.php');
            
            include('../sql/script.php');
            include('../sql/script_persona.php');

            $IdPersona = $_GET['IdPersona'];
            $deletePersona=true;
           
            begin();
            
            $deletePersona = eliminaPersonaById($IdPersona);

            if (!$deletePersona) {

                rollback();
                echo $msgTransazioneFallita . ' <a href="gestione_persona.php">' . $msgErrContactAdmin . '</a><br/>';
            } else {

                commit();
                mysql_close();
                echo $msgModificaCompletata . ' <a href="gestione_persona.php">' . $msgOk . '</a><br/>';
            }
            ?>
</div>
        </div>
    </body>
</html>