
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
                        <a href="gestione_ftp_admin.php" >
                        <img src='../images/FTP.png' style='height:100px;width:100px' title='HOME'/></a></div>
                    <?php
                    include('../Connessioni/serverdb.php');
                    include('../sql/script.php');
                    include('../sql/script_aggiornamento_config.php');

                   
                    $_SESSION['conn_id'] = '';


                    $ftpServerIp = "";
//                    $ftpServerUser = "";
//                    $ftpServerPass = "";
                    $sql = selectParametroById('id');
                    while ($row = mysql_fetch_array($sql)) {

                        switch ($row['id']) {
                            case 21:
                                $ftpServerIp = $row['valore'];
                                break;

//                            case 29:
//                                $ftpServerUser = $row['valore'];
//                                break;
//
//                            case 30:
//                                $ftpServerPass = $row['valore'];
//                                break;

                            default:
                                break;
                        }
                    }

                    //TO DO importante : evitare che ad ogni esecuzione dello script venga rieffettuato connessione e login!!!!

                    $_SESSION['ftp_user'] = "francesco.tassone";
                    $_SESSION['ftp_pass'] = "924W56fra_";

                    $_SESSION['conn_id'] = ftp_connect($ftpServerIp) or die("Impossibile connettersi a " . $ftpServerIp);

//Prova a connettersi

                    if (ftp_login($_SESSION['conn_id'], $_SESSION['ftp_user'], $_SESSION['ftp_pass'])) {
                        ?>
                        <div style='float:right;color:#008000;padding-top:50px'>
                            <?php
                            echo "Connesso come " . $_SESSION['ftp_user'] . "$ftpServerIp\n";

                            $_SESSION['Dir'] = "";
                            if (isSet($_GET['Dir']) AND $_GET['Dir']!="" ) {

                                $_SESSION['Dir'] = $_GET['Dir'];
                                echo "<br/>Directory: " . $_SESSION['Dir'];
                            }

// Ottiene l'elenco dei files 
                            $buff = ftp_nlist($_SESSION['conn_id'], "/" . $_SESSION['Dir']);
                             if(count($buff)==0){ 
                                
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

                        <?php
//Visualizza il contenuto del buffer
//var_dump($buff);
                        for ($i = 0; $i < count($buff); $i++) {

                            //####################################################################
                            //################ CARTELLA HOME ADMIN ###############################
                            //####################################################################
                            if (!isSet($_GET['Dir']) AND $_SESSION['Dir'] == "") {
                                //Visualizzo solo le cartelle gestite dal software SyncOrigami
                                if (substr($buff[$i], 0, 9) == "/macchina" OR $buff[$i] == '/aggiornamento') {
                                    ?>
                                    <tr>
                                        <td> 

                                            <a href="/CloudFab/ftp/gestione_ftp_admin.php?Dir=<?php echo $buff[$i] ?>"><img src='../images/cartella_G.png' style='height:50px;width:50px'/></a> 
                                            <?php echo $buff[$i] ?>
                                        </td>
                                        <td style="align:right"></td>
                                    </tr>
                                    <?php
                                }
                            } else {

                                //##################################################################
                                //################ PERCORSI INTERNI ################################
                                //##################################################################

                                if (substr($buff[$i], -4, 1) == ".") {
                                    $nomeFile=basename($buff[$i]);
                                    ?>
                                    <tr>
                                        <td>
                                            <a href="/CloudFab/ftp/gestione_ftp_admin.php?Dir=<?php echo $buff[$i] ?>"><img src='../images/file_G.png' style='height:50px;width:50px'/></a>  
                                            <?php echo $buff[$i] ?>
                                        </td>

                                        <?php
                                        
                                        //#################### FILE ####################################
                                        if (substr($buff[$i], -3) == "zip") {

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
                                                <a style="align:right" href="/CloudFab/ftp/delete_file.php?NomeFile=<?php echo $buff[$i] ?>&RefBack=gestione_ftp_admin.php">
                                                    <img src="/CloudFab/images/pittogrammi/patumiera_G.png" class="icone" title="elimina file"/></a>
                                                    
                                                     <?php 
                                            if( !strstr($_SESSION['Dir'],"/log") AND ! strstr($_SESSION['Dir'],"/temp") AND $_SESSION['Dir']!="/bkp" AND ! strstr($_SESSION['Dir'],"/ripristino" AND ! strstr($_SESSION['Dir'],"/test"))){
                                            ?>
                                                <a style="align:right" href="/CloudFab/ftp/sposta_file.php?NomeFile=<?php echo $buff[$i] ?>&RefBack=gestione_ftp_admin.php">
                                                    <img src="/CloudFab/images/pittogrammi/ripristina_G.png" class="icone" title="<?php echo $titleMove ?>"/></a>
                                            
                                            <?php } ?>
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

                                            <a href="/CloudFab/ftp/gestione_ftp_admin.php?Dir=<?php echo $buff[$i] ?>"><img src='../images/cartella_G.png' style='height:50px;width:50px'/></a> 
                <?php echo $buff[$i] ?>
                                        </td>
                                        <td style="align:right"></td>
                                    </tr>
                                            <?php
                                        }
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