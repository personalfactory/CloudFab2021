
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <div id="mainContainer">
            <div id="container" style="margin:50px auto;font-size:20px">
                <div style='width:50%;height:80px'>
                    <div style='float:left;margin:10px;'>

                        <img src='../images/FTP.png' style='height:100px;width:100px' title='HOME'/></div>
                    <?php
                    include('../Connessioni/serverdb.php');
                    include('../sql/script.php');
                    include('../sql/script_macchina.php');
                    include('../sql/script_aggiornamento_config.php');

                    $_SESSION['conn_id'] = '';

                    $ftpServerIp = "";
                    $sql = selectParametroById('id');
                    while ($row = mysql_fetch_array($sql)) {

                        switch ($row['id']) {
                            case 21:
                                $ftpServerIp = $row['valore'];
                                break;
                            default:
                                break;
                        }
                    }


                    if (isSet($_GET['IdMacchina'])) {
                        $_SESSION['IdMacchina'] = $_GET['IdMacchina'];
                    }

                    $sqlMac = findMacchinaById($_SESSION['IdMacchina']);
                    while ($rowMac = mysql_fetch_array($sqlMac)) {
                        $_SESSION['ftp_user'] = $rowMac['ftp_user'];
                        $_SESSION['ftp_pass'] = $rowMac['ftp_password'];
                        $_SESSION['descriStab'] = $rowMac['descri_stab'];
                    }


                    $_SESSION['conn_id'] = ftp_connect($ftpServerIp) or die("Impossibile connettersi a " . $ftpServerIp);

//Prova a connettersi

                    if (ftp_login($_SESSION['conn_id'], $_SESSION['ftp_user'], $_SESSION['ftp_pass'])) {
                        ?>
                        <div style='float:right;color:#008000;padding-top:50px'>
                            <?php
                            echo "Connesso come " . $_SESSION['ftp_user'] . "$ftpServerIp\n";

                            $_SESSION['Dir'] = "";
                            if (isSet($_GET['Dir']) AND $_GET['Dir'] != "") {

                                $_SESSION['Dir'] = $_GET['Dir'];
                                echo "<br/>Directory: " . $_SESSION['Dir'];
                            }

// Ottiene l'elenco dei files 
                            $buff = ftp_nlist($_SESSION['conn_id'], "/" . $_SESSION['Dir']);

                            if (count($buff) == 0) {

                                echo "<br/><br/>Non ci sono file!";
                            } else {
                                sort($buff);


// Chiude la connessione
                            ftp_close($_SESSION['conn_id']);
                                ?>
                            </div>
                        </div>

                        <br/><br/>

                        <table width="70%">
                            <th><?php echo $_SESSION['descriStab'] ?></th>
                            <?php
//Visualizza il contenuto del buffer
//var_dump($buff);
                            for ($i = 0; $i < count($buff); $i++) {

                                //##################################################################
                                //################ PERCORSI INTERNI ################################
                                //##################################################################

                                if (substr($buff[$i], -4, 1) == ".") {
                                    $mtime = exec ('stat -f %m '. escapeshellarg ($buff[$i]));
                                    $nomeFile = basename($buff[$i]);
                                    ?>
                                    <tr>
                                        <td>
                                            <a href="/CloudFab/ftp/gestione_ftp_macchina.php?Dir=<?php echo $buff[$i] ?>"><img src='../images/file_G.png' style='height:50px;width:50px'/></a>  
                                            <?php echo $buff[$i] ?>
                                        </td>

                                        <?php
                                        //#################### FILE ####################################
                                        if (substr($buff[$i], -3) == "zip") {
//                     echo "Ultima modifica: " . date("d/m/Y H:i:s", fileatime($buff[$i]));
//                                             if (file_exists($buff[$i])) {
//                                             echo "il file esite";
//                                             } else { echo "il file non esiste";
//                                             }



                                            $listaDir = array();
                                            $listaDir = explode('/', $buff[$i]);

// "/macchina01/s2m/OUT_1_000001_1448280014662.zip"
// "/macchina01/s2m/old/OUT_1_000001_1448280014662.zip"
                                            if (count($listaDir) == 5) {
                                                //Vuol dire che devo spostare da old in s2m
                                                $titleMove = "sposta il file nella cartella s2m";
                                            } else {

                                                //Vuol dire che devo spostare da s2m in old
                                                $titleMove = "sposta il file nella cartella old";
                                            }
                                            ?>

                                            <td style="align:right">
                                                <nobr>
                                                    <a style="align:right" href="/CloudFab/ftp/download_file.php?NomeFile=<?php echo $buff[$i] ?>">
                                                        <img src="/CloudFab/images/pittogrammi/download_G.png" class="icone" title="scarica file"/></a>
                                                    <a style="align:right" href="/CloudFab/ftp/delete_file.php?NomeFile=<?php echo $buff[$i] ?>&RefBack=gestione_ftp_macchina.php">
                                                        <img src="/CloudFab/images/pittogrammi/patumiera_G.png" class="icone" title="elimina file"/></a>
                                                    <a style="align:right" href="/CloudFab/ftp/sposta_file.php?NomeFile=<?php echo $buff[$i] ?>&RefBack=gestione_ftp_macchina.php">
                                                        <img src="/CloudFab/images/pittogrammi/ripristina_G.png" class="icone" title="<?php echo $titleMove ?>"/></a>
                                                </nobr>
                                            </td>
                                        </tr>
                    <?php
                }
            } else {
                //#################### CARTELLE ################################
                ?>
                                    <tr>
                                        <td> 

                                            <a href="/CloudFab/ftp/gestione_ftp_macchina.php?Dir=<?php echo $buff[$i] ?>"><img src='../images/cartella_G.png' style='height:50px;width:50px'/></a> 
                <?php echo $buff[$i] ?>
                                        </td>
                                        <td style="align:right"></td>
                                    </tr>
                <?php
            }
        }
        ?>

                        </table>
                    </div>
        <?php
    }
} else {
    ?>
                <div style='float:right;color:#CC0000;padding-top:50px'>
                <?php
                echo "Impossibile connettersi come " . $_SESSION['ftp_user'] . "\n";
            }
            ?>
            </div>
        </div>
    </body>
</html>