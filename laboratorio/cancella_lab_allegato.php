
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
            include('../include/precisione.php');
            include('../Connessioni/serverdb.php');
            include('sql/script.php');
            include('sql/script_lab_allegato.php');


            if($DEBUG) ini_set(display_errors, "1");
            
            $deleteFileDb = true;
            $deleteFile = true;

            $file = $_GET['nome_file'];
            $idRif = $_GET['idRif'];
            $idCar = $_GET['idCar'];
            $tipoRif = $_GET['tipoRif'];
            $RefBack = $_GET['RefBack'];


            $deleteFile = rename($destLabUploadDir . $file, $destLabUploadDirOld . $file) 
                    or die($msgErrRenameFile);

//Elimina l'associazione file nella tabella lab_allegato
            $deleteFileDb = deleteAllegatoByIdRifCar($idRif, $idCar, $tipoRif);

            if (!$deleteFileDb) {

                rollback();
                echo "</br>" . $msgTransazioneFallita;
            } else {

                commit();
                ?>

                <script type="text/javascript">
                    location.href = "<?php echo $RefBack ?>";
                </script>
            <?php }
            ?> 

        </div>
    </body>
</html>