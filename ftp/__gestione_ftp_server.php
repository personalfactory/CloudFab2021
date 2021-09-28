
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <div id="mainContainer">
            <div id="container" style="margin:50px auto;font-size:20px">
                <div style='width:45%;height:80px'>
                    <div style='float:left;margin:10px;'><img src='../images/FTP.png' style='height:100px;width:100px'/></div>
                    <?php
                    include('../Connessioni/serverdb.php');
                    include('../sql/script.php');
                    include('../sql/script_aggiornamento_config.php');

                    $_SESSION['agg_pagina'] = 0;
                    $_SESSION['conn_id'] = '';


                    $ftpServerIp = "";
                    $ftpServerUser = "";
                    $ftpServerPass = "";
                    $sql = selectParametroById('id');
                    while ($row = mysql_fetch_array($sql)) {

                        switch ($row['id']) {
                            case 21:
                                $ftpServerIp = $row['valore'];
                                break;

                            case 29:
                                $ftpServerUser = $row['valore'];
                                break;

                            case 30:
                                $ftpServerPass = $row['valore'];
                                break;

                            default:
                                break;
                        }
                    }

                    //TO DO importante : evitare che ad ogni esecuzione dello script venga rieffettuato connessione e login!!!!

                    $_SESSION['ftp_user'] = $ftpServerUser;
                    $_SESSION['ftp_pass'] = $ftpServerPass;

                    $_SESSION['conn_id'] = ftp_connect($ftpServerIp) or die("Impossibile connettersi a " . $ftpServerIp);

//prova a connettersi

                    if (ftp_login($_SESSION['conn_id'], $_SESSION['ftp_user'], $_SESSION['ftp_pass'])) {
                        ?>
                        <div style='float:right;color:#008000;padding-top:50px'>
                            <?php
                            echo "Connesso come " . $_SESSION['ftp_user'] . "$ftpServerIp\n";


                            $_SESSION['Dir'] = "";
                            if (isSet($_GET['Dir'])) {

                                $_SESSION['Dir'] = $_GET['Dir'];
                                echo "<br/>Directory: " . $_SESSION['Dir'];
                            }

// Ottiene l'elenco dei files di 
                            $buff = ftp_nlist($_SESSION['conn_id'], "/" . $_SESSION['Dir']);
                            sort($buff);

// Chiude la connessione
                            ftp_close($_SESSION['conn_id']);
                            ?>
                        </div>
                    </div>

                    <br/><br/>


                    <table  width="70%">

                        <?php
//Visualizza il contenuto del buffer
//var_dump($buff);
                        for ($i = 0; $i < count($buff); $i++) {

//if(is_file($buff[$i])){ echo "si tratta di un file"; }
                            if (substr($buff[$i], -4, 1) == ".") {
                                ?>
                                <tr>
                                    <td>

                                        <a href="/CloudFab/ftp/gestione_ftp_server.php?Dir=<?php echo $buff[$i] ?>"><img src='../images/file_G.png' style='height:50px;width:50px'/></a>  
                                        <?php echo $buff[$i] ?>

                                    </td>

                                    <?php if (substr($buff[$i], -3) == "zip") { ?>


                                        <td style="align:right" >
                                            <a style="align:right" href="/CloudFab/ftp/download_file.php?NomeFile=<?php echo $buff[$i] ?>">
                                                <img src="/CloudFab/images/pittogrammi/download_G.png" class="icone4" title="DOWNLOAD FILE"/></a>
                                            <a style="align:right" href="/CloudFab/ftp/delete_file.php?NomeFile=<?php echo $buff[$i] ?>&RefBack=gestione_ftp_server.php">
                                                <img src="/CloudFab/images/pittogrammi/patumiera_G.png" class="icone4" title="ELIMINA FILE"/></a>
                                            
                                            <?php 
                                            if( !strstr($_SESSION['Dir'],"/log") AND ! strstr($_SESSION['Dir'],"/temp") ){
                                            ?>
                                            
                                            <a style="align:right" href="/CloudFab/ftp/sposta_file.php?NomeFile=<?php echo $buff[$i] ?>&RefBack=gestione_ftp_server.php">
                                                <img src="/CloudFab/images/pittogrammi/ripristina_G.png" class="icone4" title="SPOSTA FILE IN OLD"/></a>
                                            <?php } ?>
                                        </td>

                                    </tr>

                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td > 

                                        <a href="/CloudFab/ftp/gestione_ftp_server.php?Dir=<?php echo $buff[$i] ?>"><img src='../images/cartella_G.png' style='height:50px;width:50px'/></a> 
                                        <?php echo $buff[$i] ?>
                                    </td>
                                    <td style="align:right" ></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </table>
                </div>
                <?php
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