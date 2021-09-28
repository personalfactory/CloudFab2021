
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <div id="mainContainer">
            <div id="container" style="margin:50px auto;font-size:20px;">
                <div style='width:50%;height:80px;'>
                    <div style='float:left;margin:10px;'><img src='../images/FTP.png' style='height:100px;width:100px'/></div>

                    <?php
                    //TO DO importante : evitare che ad ogni esecuzione dello script venga rieffettuato connessione e login!!!!
                    //Questo file consente di spostare un file sul server ftp dalla cartella s2m alla cartella old e viceversa

                    $ftp_server = "195.110.124.133";

                    if (isSet($_GET['NomeFile'])) {
                        $source_file = $_GET['NomeFile'];
                        $refBack = $_GET['RefBack'];
                    }

                    $_SESSION['conn_id'] = ftp_connect($ftp_server) or die("Impossibile connettersi a " . $ftp_server);
                    ?>
                    <div style='float:right;color:#008000;padding-top:50px;'>
                        <?php
                        // Prova a connettersi 
                        if (ftp_login($_SESSION['conn_id'], $_SESSION['ftp_user'], $_SESSION['ftp_pass'])) {

                            echo "Connesso come " . $_SESSION['ftp_user'] . "@$ftp_server\n";
                            echo "<br/>";
                        } else {

                            echo "Impossibile connettersi come " . $_SESSION['ftp_user'] . "\n";
                            echo "<br/>";
                        }
                        ?>
                    </div>
                </div>
                <br/>
                <br/>

                <?php
                $nomeFile = substr($source_file, -30);

                $listaDir = array();
                $listaDir = explode('/', $source_file);


                switch (count($listaDir)) {
                    case 3:
                        //da cartella agg in old
                        $dir1 = $listaDir[1]; // agg
                        $dir2 = $listaDir[2]; //nome del file oppure cartella "old"

                        $dest_file = "/" . $dir1 . "/old/" . $dir2;

                        break;

                    case 4:

                        $dir1 = $listaDir[1];
                        $dir2 = $listaDir[2];
                        $dir3 = $listaDir[3];



                        if ($_SESSION['Dir'] == '/agg' OR $_SESSION['Dir'] =="/agg/old") {
                            //dir1=agg
                            //dir2=old
                            //dir3=nome file
                            //Vuol dire che sposto da /agg/old in /agg
                            $dest_file = "/" . $dir1 . "/" . $dir3;
                        } else {

                            //Sposto da /s2m in /s2m/old
                            //dir1=macchina01,02,02...
                            //dir2=s2m
                            //dir3=nome file
                            $dest_file = "/" . $dir1 . "/" . $dir2 . "/old/" . $dir3;
                        }


                        break;

                    case 5:

                        // "/macchina01/s2m/OUT_1_000001_1448280014662.zip"
// "/macchina01/s2m/old/OUT_1_000001_1448280014662.zip"
//                print_r($listaDir);

                        $dir1 = $listaDir[1]; // macchina01,02,03...
                        $dir2 = $listaDir[2]; //s2m
                        $dir3 = $listaDir[3]; // nome del file oppure cartella "old"
//Vuol dire che devo spostare da old in s2m
                        $dir4 = $listaDir[4];
                        $dest_file = "/" . $dir1 . "/" . $dir2 . "/" . $dir4;



                        break;
                    default:
                        break;
                }



// "/macchina01/s2m/OUT_1_000001_1448280014662.zip"
// "/macchina01/s2m/old/OUT_1_000001_1448280014662.zip"

                ?>
                <table width="70%">
                    <tr>
                        <td> 
                <?php
                if (ftp_rename($_SESSION['conn_id'], $source_file, $dest_file)) {
                    echo "File : <br/>" . $source_file . "<br/> moved to :<br/>" . $dest_file;
                    ?>
                                <script type="text/javascript">
                                    location.href = "<?php echo $refBack ?>?Dir=<?php echo $_SESSION['Dir'] ?>"
                                </script>
                                <?php
                            } else {
                                echo "ERRORE!!! Il file :<br/>" . $source_file . "<br/> non può essere spostato in : <br/> " . $dest_file;
                            }
// close the connection
//    ftp_close($conn_id);
                            ?>
                        </td>
                    </tr>
                </table>


            </div>
        </div>
    </body>
</html>